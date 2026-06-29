<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Concerns;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Erp\Accounting\Enums\AccountType;
use JeffersonGoncalves\Erp\Accounting\Support\ModelResolver as AccountingModelResolver;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Projects\Models\Timesheet;
use JeffersonGoncalves\Erp\Projects\Services\TimesheetService;

/**
 * The "Create Sales Invoice" record action for a submitted timesheet. It
 * collects the receivable (debit_to) and income accounts in a modal — both are
 * required because the sales invoice's debit_to is a non-nullable foreign key
 * and the income account drives revenue recognition — then hands off to
 * {@see TimesheetService::createSalesInvoice()} which drafts a sales invoice
 * with one line per billable detail and flags the timesheet as billed. Any
 * failure is surfaced as a Filament danger notification.
 */
trait CreatesSalesInvoiceFromTimesheet
{
    public static function createSalesInvoiceAction(): Action
    {
        return Action::make('createSalesInvoice')
            ->label('Create Sales Invoice')
            ->icon(Heroicon::OutlinedDocumentText)
            ->color('primary')
            ->visible(fn (Model $record): bool => $record->getAttribute('docstatus') === DocStatus::Submitted)
            ->schema([
                Select::make('debit_to_id')
                    ->label('Receivable Account')
                    ->options(self::accountOptions(AccountType::Receivable))
                    ->searchable()
                    ->required(),
                Select::make('income_account_id')
                    ->label('Income Account')
                    ->options(self::accountOptions(AccountType::Income))
                    ->searchable()
                    ->required(),
            ])
            ->action(function (Model $record, array $data): void {
                if (! $record instanceof Timesheet) {
                    return;
                }

                $debitToId = isset($data['debit_to_id']) ? (int) $data['debit_to_id'] : null;
                $incomeAccountId = isset($data['income_account_id']) ? (int) $data['income_account_id'] : null;

                try {
                    $invoice = app(TimesheetService::class)
                        ->createSalesInvoice($record, $debitToId, $incomeAccountId);

                    Notification::make()
                        ->title('Sales invoice created')
                        ->body('Drafted sales invoice #'.$invoice->getKey().'.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to create sales invoice')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /** @return array<int|string, string> */
    protected static function accountOptions(AccountType $type): array
    {
        $accountModel = AccountingModelResolver::account();

        /** @var array<int|string, string> $options */
        $options = $accountModel::query()
            ->where('account_type', $type->value)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();

        return $options;
    }
}

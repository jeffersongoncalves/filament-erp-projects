<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Projects\Enums\ProjectStatus;
use JeffersonGoncalves\Erp\Projects\Support\ModelResolver;

/**
 * A snapshot of delivery and billing: how many projects are still open, and the
 * value captured on submitted timesheets that is ready to be billed.
 */
class ProjectStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $projectModel = ModelResolver::project();
        $timesheetModel = ModelResolver::timesheet();

        $openProjects = $projectModel::query()
            ->where('status', ProjectStatus::Open->value)
            ->count();

        $submittedTimesheets = $timesheetModel::query()
            ->where('docstatus', DocStatus::Submitted->value);

        $billableAmount = (float) (clone $submittedTimesheets)->sum('total_billable_amount');
        $submittedCount = (clone $submittedTimesheets)->count();

        return [
            Stat::make('Open Projects', (string) $openProjects)
                ->description('in progress')
                ->color($openProjects > 0 ? 'primary' : 'gray'),
            Stat::make('Submitted Timesheets', (string) $submittedCount)
                ->description('ready to bill')
                ->color('info'),
            Stat::make('Billable Amount', number_format($billableAmount, 2))
                ->description('on submitted timesheets')
                ->color('success'),
        ];
    }
}

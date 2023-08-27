<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        
        //Super Admin Classes
        Commands\SAdminEmployeePerformance::class,
        Commands\SAdminTaskPendingEmployee::class,
        Commands\SAdminTaskPendingFranchise::class,
		Commands\SAdminFranchisePayments::class,
		Commands\SAdminFranchiseInsurance::class,
		//Commands\SAdminFranchiseLocalAdvertisements::class,
		//Commands\SAdminFranchiseAudit::class,
		Commands\SAdminFDDExpiration::class,
		Commands\SAdminEmployeeSatisfactionSurvey::class,
		Commands\SAdminEmployeeBackgroundCheck::class,
		Commands\SAdminEmployeeAddPerformance::class,
		
		//Franchise Class
		Commands\FranchiseTaskPendingEmployee::class,
		Commands\FranchiseEmployeeCprExp::class,
		Commands\FranchiseEmployeeBacbExp::class,
		
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Super Admin Classes
        $schedule->command('SA:EmployeePerformance')->daily();
        $schedule->command('SA:TaskPendingFranchise')->cron('0 0 */2 * *');
        $schedule->command('SA:TaskPendingEmployee')->cron('0 0 */2 * *');
		$schedule->command('SA:FranchisePayments')->cron('* * * * *');
		$schedule->command('SA:FranchiseInsurance')->cron('0 0 */2 * *');
		//$schedule->command('SA:FranchiseLocalAdvertisements')->cron('0 0 */2 * *');
		//$schedule->command('SA:FranchiseAudit')->cron('0 0 */2 * *');
		$schedule->command('SA:fdd_expiration_renewed')->cron('0 0 */2 * *');
		$schedule->command('SA:employee_satisfaction_survey')->daily();
		$schedule->command('SA:employee_background_check')->daily();
		$schedule->command('SA:EmployeeAddPerformance')->daily();
		
		//Franchise Classes
		$schedule->command('FR:TaskPendingEmployee')->cron('0 0 */2 * *');
		$schedule->command('FR:EmployeeExpCpr')->daily();
		$schedule->command('FR:EmployeeExpBacb')->daily();
		
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

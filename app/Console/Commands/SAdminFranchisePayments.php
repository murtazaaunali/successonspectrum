<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

//Models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Franchise_payments;

class SAdminFranchisePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:FranchisePayments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for checking franchise remaining payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		$fdd_signed_to_day = 31;
		//$fdd_signed_to_day = date('d');
		$fdd_signed_to_year = date('Y');
		$fdd_signed_to_month = date('m');
		$fdd_signed_to_date = date('Y-m-d 00:00:00');

        //Getting records of franchises
        $Franchises = Franchise::get();
        if(!$Franchises->isEmpty()){
			foreach($Franchises as $Franchise){
				$fdd_signed_from_date = $Franchise->fdd_signed_date." 00:00:00";
				$fdd_signed_from_date = Carbon::createFromFormat('Y-m-d H:i:s', $fdd_signed_from_date);
				
				//$fdd_signed_from_day = 1;
				$fdd_signed_from_day = $fdd_signed_from_date->day;
				$fdd_signed_from_year = $fdd_signed_from_date->year;
				$fdd_signed_from_month = $fdd_signed_from_date->month;
				$fdd_signed_from_month_name = Carbon::parse($fdd_signed_from_date)->format('F');
				
				//Getting total number records of franchises fees
				$Franchise_franchise_fees = $Franchise->franchise_fees;
				$fee_due_date = $Franchise_franchise_fees->fee_due_date;
				//$fdd_payment_due_date = Carbon::parse($fdd_signed_from_year.'-'.$fdd_signed_from_month."-".($fdd_signed_from_day+$fee_due_date_days));
				
				//Getting total number records of franchises payments
				$Franchise_franchise_payments = $Franchise->payments;
				$Franchise_payments_renewal_fee = $Franchise->payments->where('invoice_name','Renewal Fee');
				$Franchise_payments_renewal_fee_array = array_values($Franchise_payments_renewal_fee->toArray());
				$Franchise_payments_monthly_royalty_fee = $Franchise->payments->where('invoice_name','Monthly Royalty Fee');
				$Franchise_payments_monthly_royalty_fee_array = array_values($Franchise_payments_monthly_royalty_fee->toArray());
				$Franchise_payments_monthly_system_advertising_fee = $Franchise->payments->where('invoice_name','Monthly System Advertising Fee');
				$Franchise_payments_monthly_system_advertising_fee_array = array_values($Franchise_payments_monthly_system_advertising_fee->toArray());
								
				/*$fdd_signed_to_date = Carbon::parse($fdd_signed_to_year.'-'.$fdd_signed_to_month."-".$fdd_signed_to_day);
				$fdd_signed_from_date = Carbon::parse($fdd_signed_from_year.'-'.$fdd_signed_from_month."-".$fdd_signed_from_day);
				
				$fdd_signed_days = $fdd_signed_to_date->diffInDays($fdd_signed_from_date);
				$fdd_signed_years = $fdd_signed_to_date->diffInYears($fdd_signed_from_date);
				$fdd_signed_months = $fdd_signed_to_date->diffInMonths($fdd_signed_from_date);*/
				
				$fdd_signed_years_count = 0;
				$fdd_signed_years_array = [];
				foreach (CarbonPeriod::create($fdd_signed_from_date, '1 year', Carbon::today()) as $year) {
					$year = $year->format('Y');
					$Franchise_payments = new Franchise_payments();
					//$fdd_signed_years_array[$year->format('Y')] = $year->format('Y');
					if(isset($Franchise_payments_renewal_fee_array[$fdd_signed_years_count]))
					{
						$Franchise_payments = Franchise_payments::find($Franchise_payments_renewal_fee_array[$fdd_signed_years_count]['id']);
						if(empty($Franchise_payments_renewal_fee_array[$fdd_signed_years_count]['year']))
						{
							$Franchise_payments->year = $fdd_signed_from_year;
						}
						
						if(empty($Franchise_payments_renewal_fee_array[$fdd_signed_years_count]['month']))
						{
							$Franchise_payments->month = $fdd_signed_from_month_name;
						}
						
						if(empty($Franchise_payments_renewal_fee_array[$fdd_signed_years_count]['amount']))
						{
							$Franchise_payments->amount = $Franchise_franchise_fees->renewal_fee;
						}
						
						if(empty($Franchise_payments_renewal_fee_array[$fdd_signed_years_count]['invoice_name']))
						{
							$Franchise_payments->invoice_name = "Renewal Fee";
						}
						
						$fdd_payment_due_date = Carbon::parse($year.'-'.$fdd_signed_from_month."-".$fee_due_date);
						if(strtotime($fdd_payment_due_date) < strtotime($fdd_signed_to_date))
						{
							$Franchise_payments->action = 'Overdue';								
						}
					}
					else
					{
						//array_search($fdd_signed_from_year,$Franchise_payments_renewal_fee_array);
						if(array_search($fdd_signed_from_year,array_column($Franchise_payments_renewal_fee_array, 'year')) == "")
						{
							$Franchise_payments->year = $fdd_signed_from_year;
							$Franchise_payments->franchise_id = $Franchise->id;	
							$Franchise_payments->invoice_name = "Renewal Fee";
							$Franchise_payments->month = $fdd_signed_from_month_name;
							$Franchise_payments->amount = $Franchise_franchise_fees->renewal_fee;
						}
					}
					$Franchise_payments->save();
					$fdd_signed_years_count++;
				}
				
				$fdd_signed_months_count = 0;
				$fdd_signed_months_array = [];
				foreach (CarbonPeriod::create($fdd_signed_from_date, '1 month', Carbon::today()) as $month) {
					$year = $month->format('Y');
					$month_key = $month->format('m');
					$month_name = $month->format('F');
					$fdd_signed_months_array[$month->format('m')]['year'] = $year;
					$fdd_signed_months_array[$month->format('m')]['month'] = $month_key;
					$fdd_signed_months_array[$month->format('m')]['month_name'] = $month_name;
					//$fdd_signed_months_array[$month->format('m-Y')] = $month->format('F Y');
					$Franchise_payments = new Franchise_payments();
					if(isset($Franchise_payments_monthly_royalty_fee_array[$fdd_signed_months_count]))
					{
						$Franchise_payments = Franchise_payments::find($Franchise_payments_monthly_royalty_fee_array[$fdd_signed_months_count]['id']);
						
						if(empty($Franchise_payments_monthly_royalty_fee_array[$fdd_signed_months_count]['year']))
						{
							$Franchise_payments->year = $year;
						}
						
						if(empty($Franchise_payments_monthly_royalty_fee_array[$fdd_signed_months_count]['month']))
						{
							$Franchise_payments->month = $month_name;
						}
						
						if(empty($Franchise_payments_monthly_royalty_fee_array[$fdd_signed_months_count]['amount']))
						{
							$Franchise_payments->amount = $Franchise_franchise_fees->monthly_royalty_fee;
						}
						
						if(empty($Franchise_payments_monthly_royalty_fee_array[$fdd_signed_months_count]['invoice_name']))
						{
							$Franchise_payments->invoice_name = "Monthly Royalty Fee";
						}
						
						$fdd_payment_due_date = Carbon::parse($year.'-'.$month_key."-".$fee_due_date);
						if(strtotime($fdd_payment_due_date) < strtotime($fdd_signed_to_date))
						{
							$Franchise_payments->action = 'Overdue';
							$Franchise_payments->late_fee =  '100';
						}
					}
					else
					{
						if(array_search($month_name,array_column($Franchise_payments_monthly_royalty_fee_array, 'month')) == "")
						{
							$Franchise_payments->year = $year;
							$Franchise_payments->month = $month_name;
							$Franchise_payments->franchise_id = $Franchise->id;	
							$Franchise_payments->invoice_name = "Monthly Royalty Fee";
							$Franchise_payments->amount = $Franchise_franchise_fees->monthly_royalty_fee;
						}
					}
					$Franchise_payments->save();
					
					$Franchise_payments = new Franchise_payments();
					if(isset($Franchise_payments_monthly_system_advertising_fee_array[$fdd_signed_months_count]))
					{
						$Franchise_payments = Franchise_payments::find($Franchise_payments_monthly_system_advertising_fee_array[$fdd_signed_months_count]['id']);
						
						if(empty($Franchise_payments_monthly_system_advertising_fee_array[$fdd_signed_months_count]['year']))
						{
							$Franchise_payments->year = $year;
						}
						
						if(empty($Franchise_payments_monthly_system_advertising_fee_array[$fdd_signed_months_count]['month']))
						{
							$Franchise_payments->month = $month_name;
						}
						
						if(empty($Franchise_payments_monthly_system_advertising_fee_array[$fdd_signed_months_count]['amount']))
						{
							$Franchise_payments->amount = $Franchise_franchise_fees->monthly_advertising_fee;
						}
						
						if(empty($Franchise_payments_monthly_system_advertising_fee_array[$fdd_signed_months_count]['invoice_name']))
						{
							$Franchise_payments->invoice_name = "Monthly System Advertising Fee";
						}
						
						$fdd_payment_due_date = Carbon::parse($year.'-'.$month_key."-".$fee_due_date);
						if(strtotime($fdd_payment_due_date) < strtotime($fdd_signed_to_date))
						{
							$Franchise_payments->action = 'Overdue';
							$Franchise_payments->late_fee =  '100';
						}
					}
					else
					{
						if(array_search($month_name,array_column($Franchise_payments_monthly_system_advertising_fee_array, 'month')) == "")
						{
							$Franchise_payments->year = $year;
							$Franchise_payments->month = $month_name;
							$Franchise_payments->franchise_id = $Franchise->id;	
							$Franchise_payments->invoice_name = "Monthly System Advertising Fee";
							$Franchise_payments->amount = $Franchise_franchise_fees->monthly_advertising_fee;
						}
					}					
					$Franchise_payments->save();
					
					$fdd_signed_months_count++;
				}
				//echo "<pre>";print_r($Franchise_payments_renewal_fee_array);
			}
		}
		//echo "<pre>";print_r($Franchises);
		\Log::info("Franchise Payments Updated");
    }
}

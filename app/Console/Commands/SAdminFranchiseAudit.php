<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

//Models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Franchise_audit;

class SAdminFranchiseAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:FranchiseAudit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for checking franchise audit';

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
        $Franchises = Franchise::get();
        if(!$Franchises->isEmpty()){
			$current_date = \Carbon\Carbon::today()->format('Y-m-d');
			$expiration_upcoming_date = \Carbon\Carbon::createFromFormat('Y-m-d', $current_date)->addMonth()->format('Y-m-d');
			foreach($Franchises as $Franchise){
				//echo "<pre>";print_r($Franchise->franchise_insurance()->get()->toArray());
				//$Franchise_insurances = $Franchise->franchise_insurance()->get();
				$Franchise_insurances = Franchise_insurance::where('status','!=','Received')->where('franchise_id',$Franchise->id)->whereBetween('expiration_date',[$current_date, $expiration_upcoming_date])->get();
				//echo "<pre>";print_r($Franchise_insurances->toArray());
				if(!$Franchise_insurances->isEmpty()){
					foreach($Franchise_insurances as $Franchise_insurance){
						$insurance_type = $Franchise_insurance->insurance_type;
						$date_difference = strtotime($Franchise_insurance->expiration_date) - strtotime($current_date);
						$message = $insurance_type;
						$days = round($date_difference / (60 * 60 * 24));	
						if($days > 0)
						{
							$message = ' will be expire with in '.($days > 1 ? $days.' days.' : $days.' day.');
		
						}elseif($days == 0)
						{
							$message = ' will be expire today.';
						
						}else
						{
							$message = ' is expired.';
						}
						
						/*$data = array("name" => $Franchise->Location, "email" => $Franchise->email, "Message" => $message);
						\Mail::send('email.email_template', ["name" => $Franchise->Location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'Message' => $message], function ($message) use ($data) {
							$message->from(['address' => 'sos@testing.com', 'name' => 'SOS']);
							$message->to($data['email'])->subject("Your Insurance Expiration Notice");
						});
						
						$message = $Franchise->Location." ".$message;
						$Admin = Admin::where(array('type'=>'Super Admin'))->first();
						$data = array("name" => $Admin->fullname, "email" => $Admin->email, "Message" => $message);
						\Mail::send('email.email_template', ["name" => $Admin->fullname, "email" => $Admin->email, "link"=>url('admin/login'), 'Message' => Message], function ($message) use ($data) {
							$message->from('sos@testing.com', 'SOS');
							$message->to($data['email'])->subject("Franchise Insurance Expiration Notice");
						});*/
						
						\Log::info($Franchise->Location." Franchise Insurance Expiration Cron Running.");
					}
				}
			}
		}
    }
}

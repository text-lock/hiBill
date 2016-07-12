<?php
class BillingController
{
	public $BillingModel;
	public $BillingView;
	
	
	function __construct()
	{
		$this->BillingView = new BillingView();
		$this->BillingModel = new BillingModel();
		$this->action_index(PERIOD);
	}
	
	function action_index($period = 8)
	{
		$dates = '';
		
		$today = new DateTime('now');
		$i = 1;
		
		
		if ($today->format("j") > 16)	
			$period_date = new DateTime(date('Y').'-'.date('m').'-16');
		elseif ($today->format("j") > 1 AND $today->format("j") < 16)
			$period_date = new DateTime(date('Y').'-'.date('m').'-1');
		
		elseif ($today->format("j") == 1){
			$period_date = clone $today;
			$period_date->modify('-1 month');
			$period_date->modify('+15 day');
		}
		elseif  ($today->format("j") == 16){
			$period_date = clone $today;
			$period_date->modify('-15 day');
		}
		
		$i = 1;
		while($i<=$period){
			$dates[$i]['end'] = $period_date->format("Y-m-d");		
			$billing_data['weeks']['end'][$i] = $dates[$i]['end'];
						
			if ($period_date->format("j") == 16)
				$period_date->modify('-15 day');
				
			elseif($period_date->format("j") == 1){
				$period_date->modify('-1 month');
				$period_date->modify('+15 day');
			}
			$dates[$i]['start'] = $period_date->format("Y-m-d");
			$billing_data['weeks']['start'][$i] = $dates[$i]['start'];
			++$i;	
		}
		
		
		$users = $this->BillingModel->getUserData();	
		
		foreach($users as $key => $user){
			$billing_data['users'][$key]["hold_type"] = $user['hold_rule'];
			$billing_data['users'][$key]["total_payments"] = $user['paid'];
			$billing_data['users'][$key]["total_earnings"] = $user['earned'];
			$billing_data['users'][$key]["ballance"] = $user['earned'] - $user['paid'];
			$billing_data['users'][$key]["next_payment"] = 0;
			$billing_data['users'][$key]["to_payment"] = 0;
				
			if ( ($user['hold_rule'] == 1) and (date('j') == 1 or date('j') == 16) )
				$billing_data['users'][$key]["to_payment"] = $billing_data['users'][$key]["ballance"];	
			elseif ( ($user['hold_rule'] == 2) and date('j') == 16)
				$billing_data['users'][$key]["to_payment"] = $billing_data['users'][$key]["ballance"];
			elseif ( ($user['hold_rule'] == 2) and date('j') > 16)	
				$billing_data['users'][$key]["next_payment"] = 0;
			else
				$billing_data['users'][$key]["next_payment"] = $billing_data['users'][$key]["ballance"];
		}
		
		
		$billing_data['earnings'] = $this->BillingModel->getEarningsByPeriod($dates);	
		
		
		$this->BillingView->generate('tempelate_bw.php',$billing_data);
	}
}
<?php
class BillingModel
{   
	private $db;
	
	function __construct(){
        try {
			$this->db = new PDO(SERVER, USERNAME, PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		} catch (PDOException $e) {
		echo 'Failed connection: ' . $e->getMessage();
		exit;
		}   
	}
	
	public function getUserData(){
		$sql = "SELECT u.user_id, u.hold_rule, p.paid, e.earned FROM users u LEFT JOIN (SELECT user_id, SUM(paid_amount) paid FROM payments GROUP BY user_id) p ON (u.user_id = p.user_id)
		LEFT JOIN (SELECT user_id, SUM(earned) earned FROM earnings GROUP BY user_id) e ON (u.user_id = e.user_id)";
		foreach ($this->db->query($sql) as $row){
			
			$array[$row['user_id']]["hold_rule"] = $row["hold_rule"];
			$array[$row['user_id']]["paid"] = $row["paid"];
			$array[$row['user_id']]["earned"] = $row["earned"];
		}
		return($array);
		
	}
		
	public function getEarningsByPeriod($dates) {
			
		$sql = "SELECT";			//
		$var = " u.user_id";		// SQL 
		$join = "";					//
		
		foreach($dates as $i => $date){
			$var .= ", e$i.amount";
			$join .= "LEFT JOIN (SELECT user_id, SUM(earned) amount FROM earnings WHERE date >= '".$date['start']."' AND date<'".$date['end']."' GROUP BY user_id) e$i ON (u.user_id = e$i.user_id) ";		
		}
		$sql = $sql.$var." FROM users u ".$join." ";
		$result = $this->db->query($sql);
		
		foreach ($this->db->query($sql) as $rows) 
			for($i = 1; $i <= count($dates);++$i) 
				$array[$rows[0]][$i] = $rows[$i];
			
		return $array;
	}	 		
	
	
}
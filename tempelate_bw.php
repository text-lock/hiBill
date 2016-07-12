<html><title>User payment data</title>
<head>
	  <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<style>td{text-align: center;}
			.small{font-size:10px;}
	</style>
</head>
<body>
  <div class="table-responsive">
  <table class="table table-striped" border="1">
  <thead>
	  <caption><?echo date('Y-m-d');?></caption>
	  <tr>
		   <th rowspan="2">ID</th>
		   <th rowspan="2">Total payments</th>
		   <th rowspan="2">Total earnings</th>
		   <th colspan = <?echo PERIOD;?>>Last payments</th>
		   <th rowspan="2">To payment</th>
		   <th rowspan="2">Balance</th>
		   <th rowspan="2">Next payment</th>
	   </tr>
	   
	   <tr><?
	   for ($i = 1; $i<= PERIOD; ++$i)
		   echo "<td class='small'>".$data['weeks']["end"][$i]."//".$billy['weeks']["start"][$i]."</td>";
	   ?>
	   </tr>
   </thead>
   <tbody>
<?
  foreach ($data['users'] as $id => $user){
	  echo "<tr><td>".$id."</td>".
	  "<td>".$user["total_payments"]."</td>".
	  "<td>".$user["total_earnings"]."</td>";
	    
	  for ($i = 1; $i<=PERIOD; ++$i){
		  echo "<td><i><small>".$data['earnings'][$id][$i]."</small></i></td>";
	  }
	  
	  echo "<td>".$user["to_payment"]."</td>".
	  "<td>".$user["ballance"]."</td>".
	  "<td>".$user["next_payment"]."</td></tr>";
  }  
?>
</tbody>
</body>

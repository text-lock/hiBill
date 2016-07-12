<? 
/*Application config section*/
  $period = 8;	
  
  //Database connection configuratuion
  $server = "localhost";
  $user = "root";
  $rassword = "";
  $dbname = "test_bill";
  $dsn = "mysql:dbname=$dbname;host=$server";
/*End config */


  define('PERIOD', $period);
  define('USERNAME', $user);
  define('PASSWORD', $rassword);
  define('SERVER', $dsn);
  
  
  $hey_billy = new BillingController;
  unset($hey_billy);
 
  function __autoload($class_name) {
    include $class_name . '.php';
  }
 
?>
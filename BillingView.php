<?class BillingView
{
	//public $template_view; // здесь можно указать общий вид по умолчанию.
	
	function generate($template_view, $data = null)
	{
		
		include $template_view;
	}
}
?>
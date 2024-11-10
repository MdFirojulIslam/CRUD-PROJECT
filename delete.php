<?php
	spl_autoload_register(function($class){
		include $class .'.php';
	});
	$person = new Person();

	if (isset($_GET['action']) && $_GET['action']=='delete') 
	{
		$id = (int)$_GET['id'];
		
		if ($person->delete($id)) 
		{
			echo "<script>
					alert('deleted successfully');
					window.location.href = 'show.php';
			</script>";
		}
	}
?>

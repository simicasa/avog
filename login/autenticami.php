<?php session_start();
@require_once("../class.db.php");

if(isset($_POST['username']) && isset($_POST['password'])){
	$db = new database();
	$username = $db->pulisciStringa($_POST['username']);
	$password = $db->pulisciStringa($_POST['password']);
	
	$sql = "SELECT * FROM ".$db->tb_login." WHERE utente='".$username."' AND password='".$password."' LIMIT 1";
	$db->executeQuery($sql);

	if($db->getNumRowsStored() == 1){
		$_SESSION['loggedinas']=$username;
		header("location: ../inserimento/");
		exit;
	}else{
		header("location: index.php?error=2");
		exit;
	}
}else{
	header("location: index.php?error=1");
	exit;
}
?>
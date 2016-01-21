<?php session_start();
@require_once("../class.db.php");
$db = new database();
if(!isset($_SESSION['loggedinas']) || empty($_SESSION['loggedinas']) || !$db->loginCheckMe($_SESSION['loggedinas'])){
	header("location: ../logout/");
	exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>lavoro1</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/simple-sidebar.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <?php @require('../sidebar.php');?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
						<a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="margin-bottom:20px;">Nascondi Menu</a>
                        <h1>Opzioni</h1>
<?php
	if(isset($_POST['update'])){
		$db->update("esaminandiGiornalieri", "".$_POST['numero'], "opzioni", "1=1");
		echo "<h4>- Opzioni salvate con Successo</h4>";
	}
	$opzioni = $db->getOpzioni();
	$rows = $db->getNumRowsStored();
	if($rows!=false){
		$numero = $opzioni[0]['esaminandiGiornalieri'];
	}else{
		$db->insert("esaminandiGiornalieri", "0", "opzioni");
		$numero = 0;
	}
?>
                        <h3>Numero esaminandi giornalieri</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">
							  <input name="numero" type="text" class="form-control input-lg" value="<?php echo $numero; ?>">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Salva</button>
							<!--
							  <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span>
							-->
							</div>
						</form>
					</div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>
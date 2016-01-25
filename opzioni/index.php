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
		if(is_int(intval($_POST['postiMattina'])) && is_int(intval($_POST['postiPomeriggio']))){
			$postiMattina = $db->pulisciStringa($_POST['postiMattina']);
			$postiPomeriggio = $db->pulisciStringa($_POST['postiPomeriggio']);
			$orarioMattinaOre = $db->pulisciStringa($_POST['orarioMattinaOre']);
			$orarioMattinaMinuti = $db->pulisciStringa($_POST['orarioMattinaMinuti']);
			$orarioPomeriggioOre = $db->pulisciStringa($_POST['orarioPomeriggioOre']);
			$orarioPomeriggioMinuti = $db->pulisciStringa($_POST['orarioPomeriggioMinuti']);
			$numero = intval($postiMattina)+intval($postiPomeriggio);
			$db->update("esaminandiGiornalieri", "".$numero, "opzioni", "1=1");
			$db->update("postiMattina", "".$postiMattina, "opzioni", "1=1");
			$db->update("postiPomeriggio", "".$postiPomeriggio, "opzioni", "1=1");
			$db->update("orarioMattina", "'".$orarioMattinaOre.":".$orarioMattinaMinuti."'", "opzioni", "1=1");
			$db->update("orarioPomeriggio", "'".$orarioPomeriggioOre.":".$orarioPomeriggioMinuti."'", "opzioni", "1=1");
			echo "<h4>- Opzioni salvate con Successo</h4>";
		}else{
			echo "<h4>- Opzioni non salvate, riprovare</h4>";
		}
	}
	$opzioni = $db->getOpzioni();
	$rows = $db->getNumRowsStored();
	if($rows!=false){
		$numero = $opzioni[0]['esaminandiGiornalieri'];
		$postiMattina = $opzioni[0]['postiMattina'];
		$postiPomeriggio = $opzioni[0]['postiPomeriggio'];
		$orarioMattina = explode(":",$opzioni[0]['orarioMattina']);
		$orarioPomeriggio = explode(":",$opzioni[0]['orarioPomeriggio']);
		$orarioMattinaOre = $orarioMattina[0];
		$orarioMattinaMinuti = $orarioMattina[1];
		$orarioPomeriggioOre = $orarioPomeriggio[0];
		$orarioPomeriggioMinuti = $orarioPomeriggio[1];
	}else{
		$db->insert("esaminandiGiornalieri, postiMattina, postiPomeriggio, orarioMattina, orarioPomeriggio", "0, 0, 0, '09:00', '14:00'", "opzioni");
		$numero = 0;
		$postiMattina = 0;
		$postiPomeriggio = 0;
		$orarioMattinaOre = "09";
		$orarioMattinaMinuti = "00";
		$orarioPomeriggioOre = "14";
		$orarioPomeriggioMinuti = "00";
		echo "asd";
	}
?>
                        <h3>Numero esaminandi giornalieri</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">Totale
							  <input name="numero" type="text" disabled class="form-control input-lg" value="<?php echo $numero; ?>">
							</div>
							<div class="form-group">Mattina
							  <input name="postiMattina" type="text" class="form-control input-lg" value="<?php echo $postiMattina; ?>">
							</div>
							<div class="form-group">Pomeriggio
							  <input name="postiPomeriggio" type="text" class="form-control input-lg" value="<?php echo $postiPomeriggio; ?>">
							</div>
							<div class="form-group"><br />Orario Mattina
							<table style="width:100%;"><tr><td style="width:50%;">Ore
							  <input name="orarioMattinaOre" type="text" class="form-control input-lg" value="<?php echo $orarioMattinaOre; ?>">
							  </td><td>Minuti
							  <input name="orarioMattinaMinuti" type="text" class="form-control input-lg" value="<?php echo $orarioMattinaMinuti; ?>">
							  </td></tr></table><br />
							</div>
							<div class="form-group">Orario Pomeriggio<br />
							<table style="width:100%;"><tr><td style="width:50%;">Ore
							  <input name="orarioPomeriggioOre" type="text" class="form-control input-lg" value="<?php echo $orarioPomeriggioOre; ?>">
							  </td><td>Minuti
							  <input name="orarioPomeriggioMinuti" type="text" class="form-control input-lg" value="<?php echo $orarioPomeriggioMinuti; ?>">
							  </td></tr></table>
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
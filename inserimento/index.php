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
                        <h1>Inserimento nuovo esaminando</h1>
<?php
	$esami = $db->getEsami();
	$nesami = count($esami);
	for($i=0;$i<$nesami;$i++){
		$esami[$i]['dataInizio']=str_replace("-", "/", $esami[$i]['dataInizio']);
		$esami[$i]['dataInizio'] = strtotime($esami[$i]['dataInizio']);
	}
	$db->executeQuery("SELECT codiceEsame, COUNT(*) AS niscritti FROM {$db->tb_personaesame} GROUP BY codiceEsame");
	$contoesami = $db->fetchAssocStored();
	for($i=0;$i<count($contoesami);$i++){
		$arrayContoEsami[intval($contoesami['codiceEsame'])] = $contoesami['niscritti'];
	}
?>
                        <h3>Aggiungi Progetto</h3>
						<form class="form col-md-12 center-block" action="Stampa.php" method="post">
							<input name="insert" type="hidden">
							<!-- PERSONA -->
							Persona<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nome">
							</div>
							<div class="form-group">
							  <input name="cognome" type="text" class="form-control input-lg" placeholder="Cognome">
							</div>
							<div class="form-group">
							  <input name="DataNascita" type="date" class="form-control input-lg" placeholder="Data di nascita">
							</div>
							<div class="form-group">
							  <input name="cf" type="text" class="form-control input-lg" placeholder="Codice Fiscale">
							</div>
							<!-- ESAME -->
							<div class="form-group">
							  Esame <select name="esame" type="text" class="form-control input-lg">
							  <?php
								$oldCodice = "NotACode";
								for($i=0;$i<$nesami;$i++){
									$newCodice = $esami[$i]['codiceProgetto'];
									if(strcmp($oldCodice, $newCodice)!=0){
										$oldCodice = $esami[$i]['codiceProgetto'];
										echo "<optgroup label='[{$esami[$i]['codiceProgetto']}] {$esami[$i]['progettoNome']}'>";
									}
									echo "<option value='".$esami[$i]['codice']."'>[{$esami[$i]['codiceSede']}] ".$esami[$i]['sedeNome']." [".date("d/m/Y",$esami[$i]['dataInizio'])."] [";
									if(!empty($arrayContoEsami[intval($esami[$i]['codice'])])){echo $arrayContoEsami[intval($esami[$i]['codice'])];}else{echo "0";}
									echo "/".$esami[$i]['limitePartecipanti']." Partecipanti]</option>";
									if(strcmp($oldCodice, $newCodice)!=0){
										echo "</optgroup>";
									}
								for($i=0;$i<$nesami;$i++){
echo "<option value='[".$esami[$i]['codice']."] [Cod.Sede ".$esami[$i]['codiceSede']."] [Cod.Progetto ".$esami[$i]['codiceProgetto']."]'>[Sede ".$esami[$i]['sedeNome']."] Progetto ".$esami[$i]['progettoNome']." [".date("d/m/Y",$esami[$i]['dataInizio'])."] [";
if(!empty($arrayContoEsami[intval($esami[$i]['codice'])])){echo $arrayContoEsami[intval($esami[$i]['codice'])];}else{echo "0";}
echo "/".$esami[$i]['limitePartecipanti']." Partecipanti]</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Salva e stampa</button>
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
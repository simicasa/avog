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
                        <h1>Gestione Esami</h1>
<?php
	if(isset($_POST['insert'])){
		if(!empty($_POST['progetto']) && !empty($_POST['dataInizio']) && !empty($_POST['limitePartecipanti'])){
			$project = explode("[", $db->pulisciStringa($_POST['progetto']));
			$sede = explode("]", $project[2]);
			$project = explode("]", $project[1]);
			$db->insert("codiceProgetto, codiceSede, dataInizio, limitePartecipanti", "'".$project[0]."', '".$sede[0]."', STR_TO_DATE('".$db->pulisciStringa($_POST['dataInizio'])."', '%d/%m/%Y'), ".$db->pulisciStringa($_POST['limitePartecipanti']), "esame");
			echo "<h4>- Esame Aggiunto con Successo</h4>";
		}else{
			echo "<h4>- Esame Non Aggiunto, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['update'])){
		if(!empty($_POST['progetto']) && !empty($_POST['dataInizio']) && !empty($_POST['limitePartecipanti'])){
			$old = explode("[", $db->pulisciStringa($_POST['progetto']));
			$old = explode("]", $old[1]);
			$db->update("dataInizio", "STR_TO_DATE('".$db->pulisciStringa($_POST['dataInizio'])."', '%d/%m/%Y')", "esame", "codice='".$old[0]."'");
			$db->update("limitePartecipanti", "'".$db->pulisciStringa($_POST['limitePartecipanti'])."'", "esame", "codice='".$old[0]."'");
			echo "<h4>- Esame Modificato con Successo</h4>";
		}else{
			echo "<h4>- Esame Non Modificato, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['delete'])){
		$old = explode("[", $db->pulisciStringa($_POST['progetto']));
		$old = explode("]", $old[1]);
		$db->delete("esame", "codice='".$old[0]."'");
		echo "<h4>- Esame Eliminato con Successo</h4>";
	}
	
	$esami = $db->getEsami();
	$nesami = count($esami);
	for($i=0;$i<$nesami;$i++){
		$esami[$i]['dataInizio']=str_replace("-", "/", $esami[$i]['dataInizio']);
	}
	
	$progetti = $db->getSediProgettiNomi();
	$nprogetti = count($progetti);
?>
                        <h3>Aggiungi Esame</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="insert" type="hidden">
							<div class="form-group">
							  Progetto <select name="progetto" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nprogetti;$i++){
									echo "<option>[".$progetti[$i]['codiceProgetto']."] Cod.Sede[".$progetti[$i]['codiceSede']."] ".$progetti[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <input name="dataInizio" type="text" class="form-control input-lg" placeholder="Data Inizio in GG/MM/AAAA">
							</div>
							<div class="form-group">
							  <input name="limitePartecipanti" type="text" class="form-control input-lg" placeholder="Limite Partecipanti">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Aggiungi</button>
							</div>
						</form>
					</div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Modifica Esame</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">
							  Esame <select name="progetto" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nesami;$i++){
									echo "<option>[".$esami[$i]['codice']."] [Cod.Sede ".$esami[$i]['codiceSede']."] [Cod.Progetto ".$esami[$i]['codiceProgetto']."] DataInizio ".$esami[$i]['dataInizio']." - Partecipanti ".$esami[$i]['limitePartecipanti']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <input name="dataInizio" type="text" class="form-control input-lg" placeholder="Data Inizio in GG/MM/AAAA">
							</div>
							<div class="form-group">
							  <input name="limitePartecipanti" type="text" class="form-control input-lg" placeholder="Limite Partecipanti">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Modifica</button>
							</div>
						</form>
                    </div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Elimina Esame</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="delete" type="hidden">
							<div class="form-group">
							  Esame <select name="progetto" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nesami;$i++){
									echo "<option>[".$esami[$i]['codice']."] [Cod.Sede ".$esami[$i]['codiceSede']."] [Cod.Progetto ".$esami[$i]['codiceProgetto']."] DataInizio ".$esami[$i]['dataInizio']." - Partecipanti ".$esami[$i]['limitePartecipanti']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Elimina</button>
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
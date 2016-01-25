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
                        <h1>Gestione Persone</h1>
<?php
	if(isset($_POST['insert'])){
		if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['cf'])){
			$nome = $db->pulisciStringa($_POST['nome']);
			$cognome = $db->pulisciStringa($_POST['cognome']);
			$cf = $db->pulisciStringa($_POST['cf']);
            $DataNascita = $_POST['dataNascita'];
			$db->insert("nome, cognome, cf, DataNascita", "'".$nome."', '".$cognome."', '".$cf."' , '". $DataNascita . "'", "persona");
			echo "<h4>- Persona Aggiunta con Successo</h4>";
		}else{
			echo "<h4>- Persona Non Aggiunta, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['update'])){
		if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['cf'])){
			$nome = $db->pulisciStringa($_POST['nome']);
			$cognome = $db->pulisciStringa($_POST['cognome']);
			$cf = $db->pulisciStringa($_POST['cf']);
			$old = explode("[", $db->pulisciStringa($_POST['oldone']));
			$old = explode("]", $old[1]);
			$db->update("cf", "'".$cf."'", "persona", "cf='".$old[0]."'");
			$db->update("nome", "'".$nome."'", "persona", "cf='".$cf."'");
			$db->update("cognome", "'".$cognome."'", "persona", "cf='".$cf."'");
			echo "<h4>- Persona Modificata con Successo</h4>";
		}else{
			echo "<h4>- Persona Non Modificata, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['delete'])){
		$old = explode("[", $db->pulisciStringa($_POST['oldone']));
		$old = explode("]", $old[1]);
		$db->delete("persona", "cf='".$old[0]."'");
		echo "<h4>- Persona Eliminata con Successo</h4>";
	}
	
	$persone = $db->getPersone();
	$npersone = count($persone);
?>
                        <h3>Aggiungi Persona</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="insert" type="hidden">
							<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nome">
							</div>
							<div class="form-group">
							  <input name="cognome" type="text" class="form-control input-lg" placeholder="Cognome">
							</div>
							<div class="form-group">
							  <input name="cf" type="text" class="form-control input-lg" placeholder="Codice Fiscale">
							</div>
                         	<div class="form-group">
							  <input name="dataNascita" type="date" class="form-control input-lg" placeholder="Data di nascita">
							</div>   
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Aggiungi</button>
							</div>
						</form>
					</div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Modifica Persona</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$npersone;$i++){
									echo "<option>[".$persone[$i]['cf']."] ".$persone[$i]['cognome']." ".$persone[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nome">
							</div>
							<div class="form-group">
							  <input name="cognome" type="text" class="form-control input-lg" placeholder="Cognome">
							</div>
							<div class="form-group">
							  <input name="cf" type="text" class="form-control input-lg" placeholder="Codice Fiscale">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Modifica</button>
							</div>
						</form>
                    </div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Elimina Persona</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="delete" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$npersone;$i++){
									echo "<option>[".$persone[$i]['cf']."] ".$persone[$i]['cognome']." ".$persone[$i]['nome']."</option>";
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
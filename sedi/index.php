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
                        <h1>Gestione Sedi</h1>
<?php
	if(isset($_POST['insert'])){
		if(!empty($_POST['codice']) && !empty($_POST['nome'])){
			$codice = $db->pulisciStringa($_POST['codice']);
			$nome = $db->pulisciStringa($_POST['nome']);
			$db->insert("codice, nome", "'".$codice."', '".$nome."'", "sede");
			echo "<h4>- Sede Aggiunta con Successo</h4>";
		}else{
			echo "<h4>- Sede Non Aggiunta, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['update'])){
		if(!empty($_POST['codice']) && !empty($_POST['nome'])){
			$codice = $db->pulisciStringa($_POST['codice']);
			$nome = $db->pulisciStringa($_POST['nome']);
			$old = explode("[", $db->pulisciStringa($_POST['oldone']));
			$old = explode("]", $old[1]);
			$db->update("codice", "'".$codice."'", "sede", "codice='".$old[0]."'");
			$db->update("nome", "'".$nome."'", "sede", "codice='".$codice."'");
			echo "<h4>- Sede Modificata con Successo</h4>";
		}else{
			echo "<h4>- Sede Non Modificata, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['delete'])){
		$old = explode("[", $db->pulisciStringa($_POST['oldone']));
		$old = explode("]", $old[1]);
		$db->delete("sede", "codice='".$old[0]."'");
		echo "<h4>- Sede Eliminata con Successo</h4>";
	}
	
	$sedi = $db->getSedi();
	$nsedi = count($sedi);
?>
                        <h3>Aggiungi Sede</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="insert" type="hidden">
							<div class="form-group">
							  <input name="codice" type="text" class="form-control input-lg" placeholder="Codice">
							</div>
							<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nome">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Aggiungi</button>
							<!--
							  <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span>
							-->
							</div>
						</form>
					</div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Modifica Sede</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nsedi;$i++){
									echo "<option>[".$sedi[$i]['codice']."] ".$sedi[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <input name="codice" type="text" class="form-control input-lg" placeholder="Nuovo Codice">
							</div>
							<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nuovo Nome">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Modifica</button>
							<!--
							  <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span>
							-->
							</div>
						</form>
                    </div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Elimina Sede</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="delete" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nsedi;$i++){
									echo "<option>[".$sedi[$i]['codice']."] ".$sedi[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Elimina</button>
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
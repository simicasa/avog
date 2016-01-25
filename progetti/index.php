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
                        <h1>Gestione Progetti</h1>
<?php
	if(isset($_POST['insert'])){
		if(!empty($_POST['codice']) && !empty($_POST['nome'])){
			$codice = $db->pulisciStringa($_POST['codice']);
			$nome = $db->pulisciStringa($_POST['nome']);
			$db->insert("codice, nome", "'".$codice."', '".$nome."'", "progetto");
			echo "<h4>- Progetto Aggiunto con Successo</h4>";
		}else{
			echo "<h4>- Progetto Non Aggiunto, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['update'])){
		if(!empty($_POST['codice']) && !empty($_POST['nome'])){
			$old = explode("[", $db->pulisciStringa($_POST['oldone']));
			$old = explode("]", $old[1]);
			$db->update("codice", "'".$codice."'", "progetto", "codice='".$old[0]."'");
			$db->update("nome", "'".$nome."'", "progetto", "codice='".$codice."'");
			echo "<h4>- Progetto Modificato con Successo</h4>";
		}else{
			echo "<h4>- Progetto Non Modificato, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['delete'])){
		$old = explode("[", $db->pulisciStringa($_POST['oldone']));
		$old = explode("]", $old[1]);
		$db->delete("progetto", "codice='".$old[0]."'");
		echo "<h4>- Progetto Eliminata con Successo</h4>";
	}else if(isset($_POST['associate'])){
		if(!empty($_POST['progetto']) && !empty($_POST['sede'])){
			$project = explode("[", $db->pulisciStringa($_POST['progetto']));
			$project = explode("]", $project[1]);
			$place = explode("[", $db->pulisciStringa($_POST['sede']));
			$place = explode("]", $place[1]);
			if(isset($_POST['posti']) && $_POST['posti']!=0){$posti=$db->pulisciStringa($_POST['posti']);}else{$posti=0;}
			$db->insert("codiceSede, codiceProgetto, posti", "'".$place[0]."', '".$project[0]."', ".$posti, "sede_progetto");
			echo "<h4>- Progetto Associato con Successo ad una Sede</h4>";
		}else{
			echo "<h4>- Progetto Non Associato, riempire tutti i campi</h4>";
		}
	}else if(isset($_POST['deassociate'])){
		if(!empty($_POST['oldone'])){
		$old = explode("[", $db->pulisciStringa($_POST['oldone']));
			$old = explode("]", $old[1]);
			$db->delete("sede_progetto", "codiceSede='".$old[0]."'");
			echo "<h4>- Progetto Deassociato con Successo da una Sede</h4>";
		}else{
			echo "<h4>- Progetto Non Deassociato, riempire tutti i campi</h4>";
		}
	}
	
	$progetti = $db->getProgetti();
	$nprogetti = count($progetti);
	
	$sedi = $db->getSedi();
	$nsedi = count($sedi);
	
	$sediprogetti = $db->getSediProgetti();
	$nsediprogetti = count($sediprogetti);
?>
                        <h3>Aggiungi Progetto</h3>
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
						<h3 style="margin-top:40px;">Modifica Progetto</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nprogetti;$i++){
									echo "<option>[".$progetti[$i]['codice']."] ".$progetti[$i]['nome']."</option>";
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
						<h3 style="margin-top:40px;">Elimina Progetto</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="delete" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nprogetti;$i++){
									echo "<option>[".$progetti[$i]['codice']."] ".$progetti[$i]['nome']."</option>";
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
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Associa Progetto ad una Sede</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="associate" type="hidden">
							<div class="form-group">
							  Progetto <select name="progetto" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nprogetti;$i++){
									echo "<option>[".$progetti[$i]['codice']."] ".$progetti[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  Sede <select name="sede" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nsedi;$i++){
									echo "<option>[".$sedi[$i]['codice']."] ".$sedi[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <input name="posti" type="text" class="form-control input-lg" placeholder="Numero Posti">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Associa</button>
							</div>
						</form>
                    </div>
					
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Deassocia Progetto da una Sede</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="deassociate" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nsediprogetti;$i++){
									echo "<option>Sede [".$sediprogetti[$i]['codiceSede']."] - Progetto [".$sediprogetti[$i]['codiceProgetto']."] - Posti ".$sediprogetti[$i]['posti']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Deassocia</button>
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
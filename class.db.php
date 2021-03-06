<?php
class database{
	/* PARAMETRI DATABASE */
	private $dbHost;
	private $dbUser;
	private $dbPwd;
	private $dbConn;
	private $dbConnAttiva = false;
	private $dbNome;
	
	/* TABELLE DATABASE */
	public $tb_sede = "sede";
	public $tb_progetto = "progetto";
	public $tb_sedeprogetto = "sede_progetto";
	public $tb_esame = "esame";
	public $tb_persona = "persona";
	public $tb_personaesame = "persona_esame";
	public $tb_opzioni = "opzioni";
	public $tb_login = "login";
	
	/* VARIABILI INTERNE */
	private $localhost = array('127.0.0.1','::1');
	
	private $lastQuery = "";
	private $lastResult;
	private $lastRow;
	
	/* COSTRUTTORE E DISTRUTTORE */
	public function __construct(){
		$this->dbHost = "62.149.150.178";
		$this->dbUser = "Sql935096";
		$this->dbPwd = "eneaz3t7nm";
		$this->dbNome = "Sql935096_1";
		/*
		$this->dbHost = "localhost";
		$this->dbUser = "angelotm";
		$this->dbPwd = "olegnatm";
		$this->dbNome = "lavoro1";
		*/
		if(!($this->connetti())){ // NON CONNESSO
			echo "<script type=\"text/javascript\">alert(\"Errore nella connessione al database, contattare un amministratore.\");</script>";
		}
	}
	public function __destruct(){
		$this->disconnetti();
	}
	
	/* CONNESSIONE E DISCONNESSIONE */
	public function connetti(){
		if(!($this->isConnesso())){
			$this->dbConn = @mysql_connect($this->dbHost,$this->dbUser,$this->dbPwd);
			if($this->dbConn){
				$this->dbConnAttiva = true;
				if(mysql_select_db($this->dbNome)){return true;}
			}
		}
		return false;
	}
	public function isConnesso(){return $this->dbConnAttiva;}
	public function disconnetti(){
		if($this->isConnesso()){
			if(mysql_close()){
				$this->dbConnAttiva = false;
				return true;
			}
		return false;
		}
	}
	
	/* QUERY */
	public function executeQuery($query){return ($this->lastResult = mysql_query($query));}
	public function executeQueryStored(){return ($this->lastResult = mysql_query($this->lastQuery));}
	
	public function update($cosa, $come, $dove, $quando){
		$this->executeQuery("UPDATE ".$dove." SET ".$cosa."=".$come." WHERE ".$quando);
		//echo "UPDATE ".$dove." SET ".$cosa."=".$come." WHERE ".$quando;
	}
	public function insert($dove, $valori, $tabella){
		$this->executeQuery("INSERT INTO ".$tabella." (".$dove.") VALUES (".$valori.")");
		//echo "INSERT INTO ".$tabella." (".$dove.") VALUES (".$valori.")";
	}
	public function delete($tabella, $quando){
		$this->executeQuery("DELETE FROM ".$tabella." WHERE (".$quando.")");
		//echo "DELETE FROM ".$tabella." WHERE (".$quando.")";
	}
	
	/* FETCH */
	public function fetchRow($result){return ($this->lastRow = mysql_fetch_row($result));}
	public function fetchRowStored(){return ($this->lastRow = mysql_fetch_row($this->lastResult));}
	public function fetchAssoc($result){return ($this->lastRow = mysql_fetch_assoc($result));}
	public function fetchAssocStored(){return ($this->lastRow = mysql_fetch_assoc($this->lastResult));}
	
	/* CONTEGGIO NUMERO RIGHE */
	public function getNumRows($result){return (mysql_num_rows($result));}
	public function getNumRowsStored(){return (mysql_num_rows($this->lastResult));}
	public function getNumFields($result){return (mysql_num_fields($result));}
	public function getNumFieldsStored(){return (mysql_num_fields($this->lastResult));}
	
	/* GET FROM DATABASE */
	private $orderby = "ORDER BY nome ASC, codice ASC";
	public function getGeneric($query){
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			for($i=0;$i<$rows;$i++){
				$persone[$i] = $this->fetchAssocStored();
			}
			if(!empty($persone)){
				return ($persone);
			}
		}
		return $persone=array();
	}
	public function getProject($residential, $collaboration, $competition){
		return $this->getGeneric("SELECT * FROM {$this->tb_project} WHERE residential={$residential} AND collaboration={$collaboration} AND competition={$competition} ".$this->orderby);
	}
	public function getSedi(){
		return $this->getGeneric("SELECT * FROM {$this->tb_sede} ".$this->orderby);
	}
	public function getProgetto($id){
		return $this->getGeneric("SELECT * FROM {$this->tb_progetto} WHERE codice={$id} ".$this->orderby);
	}
	public function getProgetti(){
		return $this->getGeneric("SELECT * FROM {$this->tb_progetto} ".$this->orderby);
	}
	public function getSediProgetti(){
		return $this->getGeneric("SELECT * FROM {$this->tb_sedeprogetto}");
	}
	public function getEsami(){
		return $this->getGeneric("SELECT te.codice AS codice, te.codiceSede AS codiceSede, te.codiceProgetto AS codiceProgetto, te.dataInizio AS dataInizio, te.limitePartecipanti AS limitePartecipanti, ts.nome AS sedeNome, tp.nome AS progettoNome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice ORDER BY tp.codice ASC");
	}
	public function getEsame($id){
		$query = "SELECT te.dataInizio AS tedatainizio, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice WHERE te.codice={$id}";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getEsamePersona($id, $cf){
		$query = "SELECT tpe.seMattina AS semattina, tpe.dataConsegna AS tpedataconsegna, te.dataInizio AS tedatainizio, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice AND tpe.cf='{$cf}' AND tpe.codiceEsame={$id} WHERE te.codice={$id}";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getEsamePersonaByID($id, $idPersona){
		$query = "SELECT tpe.protocollo AS protocollo, tpe.seMattina AS semattina, tpe.dataConsegna AS tpedataconsegna, te.dataInizio AS tedatainizio, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome, tpe.dataEsame AS dataEsame FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe JOIN {$this->tb_persona} tpp ON tpe.cf=tpp.cf AND te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice AND tpe.codiceEsame={$id} WHERE te.codice={$id} AND tpp.id={$idPersona}";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getPersonaIdFromCf($cf){
		$query = "SELECT * FROM {$this->tb_persona} WHERE cf='{$cf}'";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getPersone(){
		return $this->getGeneric("SELECT * FROM {$this->tb_persona}");
	}
	public function getPersoneEsami(){
		return $this->getGeneric("SELECT * FROM {$this->tb_personaesame}");
	}
	public function getOpzioni(){
		return $this->getGeneric("SELECT * FROM {$this->tb_opzioni}");
	}
	public function getPrenotazioni(){
		$query = "SELECT tpp.cf AS cf, tpp.nome AS nome, tpp.cognome AS cognome, tpe.seMattina AS semattina, tpe.dataConsegna AS tpedataconsegna, tpe.dataEsame AS dataEsame, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe JOIN {$this->tb_persona} tpp ON tpe.codiceEsame=te.codice AND tpe.personaID=tpp.id AND tpe.cf=tpp.cf AND te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice";
		return $this->getGeneric($query);
	}
	public function getPrenotazioniDate($dd, $mm, $yy, $projectID){
        $data = "{$yy}-{$mm}-{$dd}";
		$query = "SELECT tpe.protocollo AS protocollo, te.codiceProgetto AS tecodprogetto, tpp.cf AS cf, tpp.nome AS nome, tpp.cognome AS cognome, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe JOIN {$this->tb_persona} tpp ON te.codice=tpe.codiceEsame AND te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice AND te.codiceProgetto={$projectID} AND tpe.personaID=tpp.id WHERE tpe.dataEsame='{$data}' ORDER BY ts.codice ASC, tpe.protocollo ASC";
        //WHERE tpe.dataEsame='{$data}' AND tp.codice={$projectID} AND te.codiceProgetto={$projectID}
        //echo $query;
		return $this->getGeneric($query);
	}
	
	public function checkInserimento($tabella, $quando){
		$this->executeQuery("SELECT * FROM ".$tabella." WHERE ".$quando);
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return (true);
		}
		return (false);
	}
	
	public function calcolaDataEsame($cf, $codiceEsame){
		$quantiGiornalieri = $this->quantiEsaminandiGiornalieri();
		$query = "SELECT COUNT(*) AS quanti, dataEsame FROM {$this->tb_personaesame} WHERE dataEsame IS NOT NULL AND dataEsame > (SELECT dataInizio FROM {$this->tb_esame} WHERE codice={$codiceEsame}) AND dataEsame > DATE_ADD(NOW(), INTERVAL -1 DAY) GROUP BY dataEsame HAVING quanti<{$quantiGiornalieri} ORDER BY dataEsame asc";
        /*
		$query = "
            SELECT COUNT(*) AS quanti, dataEsame
            FROM persona_esame
            WHERE
                dataEsame IS NOT NULL
                AND dataEsame > (SELECT dataInizio FROM esame WHERE codice=7)
                AND dataEsame > DATE_ADD(NOW(), INTERVAL -1 DAY)
            GROUP BY dataEsame
            HAVING quanti<2
            ORDER BY dataEsame asc
        ";
        */
		//echo $query;
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false || $rows==0){
			for($i=0;$i<$rows;$i++){
				$res[$i] = $this->fetchAssocStored();
			}
			if($rows==0){
                $query = "SELECT COUNT(*) AS quanti, dataEsame FROM {$this->tb_personaesame} WHERE dataEsame IS NOT NULL AND dataEsame > (SELECT dataInizio FROM {$this->tb_esame} WHERE codice={$codiceEsame}) AND dataEsame > DATE_ADD(NOW(), INTERVAL -1 DAY) GROUP BY dataEsame ORDER BY dataEsame DESC LIMIT 1";
                /*
                $query = "
                    SELECT COUNT(*) AS quanti, dataEsame
                    FROM persona_esame
                    WHERE
                        dataEsame IS NOT NULL
                        AND dataEsame > (SELECT dataInizio FROM esame WHERE codice=7)
                        AND dataEsame > DATE_ADD(NOW(), INTERVAL -1 DAY)
                    GROUP BY dataEsame
                    ORDER BY dataEsame DESC LIMIT 1
                ";
                */
				$this->executeQuery($query);
				$rows = $this->getNumRowsStored();
                if($rows==0){
                    $query = "SELECT DATE_FORMAT(GREATEST((SELECT dataInizio FROM {$this->tb_esame} AS dataEsame WHERE codice={$codiceEsame}), NOW()), '%Y-%m-%d') AS dataEsame";
                    $this->executeQuery($query);
				    $rows = $this->getNumRowsStored();
				    $quanti=0;
                }
				$res[0] = $this->fetchAssocStored();
			}
            //else{}
            if(!isset($quanti)){
                $quanti = $res[0]['quanti'];
            }
			$dataEsamePrevista = $res[0]['dataEsame'];
            
			/*
			$arr = array(
				"quanti " => $quanti,
				"dataEsamePrevista " => $dataEsamePrevista,
				"quantiGiornalieri " => $quantiGiornalieri
			);
			print_r($arr);
            */
                
			if($quanti<$quantiGiornalieri){
				//echo "dataEsame = {$dataEsamePrevista}";
				//$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL 0 DAY)";
				$intervalDays = 0;
			}else{
				if($this->isWeekend(date("Y-m-d", strtotime($dataEsamePrevista . " +1 days")))){
					//echo "dataEsame = ".date("Y-m-d", strtotime($dataEsamePrevista . " +3 days"));
					//$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL 3 DAY)";
					$intervalDays = 3;
				}else{
					//echo "dataEsame = ".date("Y-m-d", strtotime($dataEsamePrevista . " +1 days"));
					//$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL 1 DAY)";
					$intervalDays = 1;
				}
			}
			$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL {$intervalDays} DAY)";
			$this->update("dataEsame", $queryCome, $this->tb_personaesame, "cf='".$cf."' AND codiceEsame=".$codiceEsame);
			if($quanti<$this->quantiEsaminandiMattina()){
				$this->update("seMattina","1",$this->tb_personaesame,"cf='".$cf."' AND codiceEsame=".$codiceEsame);
			}else{
				$this->update("seMattina","0",$this->tb_personaesame,"cf='".$cf."' AND codiceEsame=".$codiceEsame);
			}
			return (true);
		}
		return (false);
	}
	public function isWeekend($date){
		//$weekDay = date('w', strtotime($date));
		$weekDay = date('w', strtotime($date));
		return ($weekDay == 0 || $weekDay == 6);
	}
	public function quantiEsaminandiGiornalieri(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['esaminandiGiornalieri']);
		}
		return (0);
	}
	public function quantiEsaminandiMattina(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['postiMattina']);
		}
		return (0);
	}
	public function quantiEsaminandiPomeriggio(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['postiPomeriggio']);
		}
		return (0);
	}
	
	/* INJECTION AND KEYS CONTROL */
	public function pulisciStringa($str){
		return ($str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
	}
	public function pulisciCaratteri($str){
		//$str = str_replace(array("&apos;", "'"), array("'", "&apos;"), $str);
		$str = str_replace(array("'","°"), array("&apos;","&#42;"), $str);
		return ($this->pulisciStringa($str));
	}
	
	/* LOGIN */
    public function loginCheckMe($username){
        $sql = "SELECT * FROM ".$this->tb_login." WHERE utente='".$username."' LIMIT 1";
        $this->executeQuery($sql);
        if($this->getNumRowsStored() == 1){return (true);}
        return (false);
    }
	
	public function addEsame($codiceProgetto, $dataInizio, $limitePartecipanti){
		$codiceProgetto = $this->pulisciCaratteri($codiceProgetto);
		$sql = "SELECT codiceSede FROM ".$this->tb_sedeprogetto." WHERE codiceProgetto='".$codiceProgetto."' AND codiceSede NOT IN (SELECT codiceSede FROM ".$this->tb_esame." WHERE codiceProgetto='".$codiceProgetto."')";
		$this->executeQuery($sql);
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			for($i=0;$i<$rows;$i++){
				$esamii[$i] = $this->fetchAssocStored();
			}
			for($i=0;$i<$rows;$i++){
				$this->insert("codiceProgetto, codiceSede, dataInizio, limitePartecipanti", "'".$codiceProgetto."', '".$esamii[$i]['codiceSede']."', STR_TO_DATE('".$this->pulisciStringa($dataInizio)."', '%d/%m/%Y'), ".$this->pulisciStringa($limitePartecipanti), "esame");
			}
		}
	}
    public function checkPersona($dato, $isCFnotID){
		$sql = "SELECT * FROM {$this->tb_persona} WHERE ";
		if($isCFnotID){$sql.="cf='{$dato}'";}
		else{$sql.="id={$dato}";}
        $this->executeQuery($sql);
        if($this->getNumRowsStored() == 1){return (true);}
        return (false);
    }
    public function getEsamiProgettiSedi(){
        echo "SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp ON te.codiceProgetto=tsp.codiceProgetto ORDER BY codice ASC";
        return $this->getGeneric("SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp ON te.codiceProgetto=tsp.codiceProgetto ORDER BY codice ASC");
 }
	public function getSediProgettiNomi(){
		return $this->getGeneric("SELECT tsp.codiceProgetto AS codiceProgetto, tsp.codiceSede AS codiceSede, tp.nome AS nome FROM {$this->tb_sedeprogetto} tsp JOIN {$this->tb_progetto} tp ON tsp.codiceProgetto=tp.codice");
	}
	/*
	public function getEsamiSediProgettiNomi(){
		return $this->getGeneric("SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp JOIN {$this->tb_progetto} tp ON te.codiceSede=tsp.codiceSede AND te.codiceProgetto=tsp.codiceProgetto AND tsp.codiceProgetto=tp.codice");
	}
	*/
}
?>
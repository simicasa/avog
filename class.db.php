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
		$this->dbHost = "localhost";
		$this->dbUser = "root";
		$this->dbPwd = "";
		$this->dbNome = "avog";
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
	//	echo "UPDATE ".$dove." SET ".$cosa."=".$come." WHERE ".$quando;
	}
	public function insert($dove, $valori, $tabella){
		$this->executeQuery("INSERT INTO ".$tabella." (".$dove.") VALUES (".$valori.")");
	//	echo "INSERT INTO ".$tabella." (".$dove.") VALUES (".$valori.")";
	}
	public function delete($tabella, $quando){
		$this->executeQuery("DELETE FROM ".$tabella." WHERE (".$quando.")");
//		echo "DELETE FROM ".$tabella." WHERE (".$quando.")";
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
	public function getProgetti(){
		return $this->getGeneric("SELECT * FROM {$this->tb_progetto} ".$this->orderby);
	}
	public function getSediProgetti(){
		return $this->getGeneric("SELECT * FROM {$this->tb_sedeprogetto}");
	}
	public function getEsami(){
		return $this->getGeneric("SELECT * FROM {$this->tb_esame} ORDER BY codice ASC");
	}
	public function getPersone(){
		return $this->getGeneric("SELECT * FROM {$this->tb_persona} ");
	}
	public function getPersoneEsami(){
		return $this->getGeneric("SELECT * FROM {$this->tb_personaesame} ");
	}
	public function getOpzioni(){
		return $this->getGeneric("SELECT * FROM {$this->tb_opzioni} ");
	}
	public function getPrenotazioni(){
		return $this->getGeneric("SELECT * FROM {$this->tb_personaesame} ");
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
		$query = "SELECT te.limitePartecipanti, te.dataInizio, COUNT(*) AS quanti, tpe.dataEsame FROM ".$this->tb_personaesame." tpe JOIN ".$this->tb_esame." te ON tpe.codiceEsame=te.codice WHERE tpe.codiceEsame=".$codiceEsame." AND dataEsame IS NOT NULL GROUP BY tpe.dataEsame ORDER BY tpe.dataEsame ASC";
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false || $rows==0){
			for($i=0;$i<$rows;$i++){
				$giorni[$i] = $this->fetchAssocStored();
			}
			$i=0;
			if($rows==0){
				$query = "SELECT dataInizio FROM ".$this->tb_esame." WHERE codice=".$codiceEsame;
				$this->executeQuery($query);
				$esame = $this->fetchAssocStored();
				$queryCome="DATE_ADD('".$esame['dataInizio']."', INTERVAL 0 DAY)";
			}else{
				$quantiGiornalieri = $this->quantiEsaminandiGiornalieri();
				while(isset($giorni[$i]['quanti']) && $giorni[$i]['quanti']>=$quantiGiornalieri){$i++;}
				if(!isset($giorni[$i]['quanti'])){
					$i--;
					$queryCome="DATE_ADD('".$giorni[$i]['dataInizio']."', INTERVAL ".($i+1)." DAY)";
				}else{
					$queryCome="DATE_ADD('".$giorni[$i]['dataInizio']."', INTERVAL ".$i." DAY)";
				}
			}
			$this->update("dataEsame", $queryCome, $this->tb_personaesame, "cf='".$cf."' AND codiceEsame=".$codiceEsame);
			return (true);
		}
		return (false);
	}
	public function quantiEsaminandiGiornalieri(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['esaminandiGiornalieri']);
		}
		return (0);
	}
	
	/* INJECTION AND KEYS CONTROL */
	public function pulisciStringa($str){
		return (mysql_real_escape_string($str));
	}
	
	/* LOGIN */
    public function loginCheckMe($username){
        $sql = "SELECT * FROM ".$this->tb_login." WHERE utente='".$username."' LIMIT 1";
        $this->executeQuery($sql);
        if($this->getNumRowsStored() == 1){return (true);}
        return (false);
    }
    public function getEsamiProgettiSedi(){
        echo "SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp ON te.codiceProgetto=tsp.codiceProgetto ORDER BY codice ASC";
        return $this->getGeneric("SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp ON te.codiceProgetto=tsp.codiceProgetto ORDER BY codice ASC");
 }
     public function getSediProgettiNomi(){
  return $this->getGeneric("SELECT * FROM {$this->tb_sedeprogetto} tsp JOIN {$this->tb_progetto} tp ON tsp.codiceProgetto=tp.codice");
 }
    
    public function getEsame($id){
  $query = "SELECT tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice WHERE te.codice={$id}";
  $this->executeQuery($query);
  return $this->fetchAssocStored();
 }
    
}
?>
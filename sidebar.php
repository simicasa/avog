		<div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"><a>Avog</a></li>
<?php
$names = array('Home', 'Inserimento', 'Prenotazioni', 'Stampe', 'Gestione Sedi', 'Gestione Progetti', 'Gestione Esami', 'Gestione Persone', 'Opzioni', 'Logout');
$links = array('#', 'inserimento/', 'prenotazioni/', 'stampe/', 'sedi/', 'progetti/', 'esami/', 'persone/', 'opzioni/', 'logout/');

for($i=0;$i<count($names);$i++){
?>
                <li><a href="<?php if(!isset($home) || $home!=true){echo "../";} echo $links[$i]; ?>"><?php echo $names[$i]; ?></a></li>
<?php
}
?>
            </ul>
        </div>
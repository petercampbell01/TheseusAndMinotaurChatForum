<?php
$host = 'localhost' ;
$dbUser ='theseus';
$dbPass ='minotaur';
$dbName ='theseus';
 
$db = new MySQL( $host, $dbUser, $dbPass, $dbName ) ;
$db->selectDatabase();
?>

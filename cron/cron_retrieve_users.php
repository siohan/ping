<?php
/**
 * Generates a backup of the database and sends it in an email
 *
 * @author Elijah Lofgren < elijahlofgren [at] elijahlofgren.com>
 * @version $Id: backup-database-cron.php 2135 2005-08-07 13:43:29Z elijahlofgren $
 */
require_once('../../../config.php');
$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));


$query = "TRUNCATE demo_module_ping_joueurs";
$result = $link->query($query); 
if($result)
{
	echo "<p>table vidée.</p>";
}
else
{
	echo "<p>Erreur</p>";
	//echo $db->ErrorMsg();
}

SET foreign_key_checks = 0;
TRUNCATE TABLE `demo_module_ping_adversaires`;
TRUNCATE TABLE `demo_module_ping_calendrier`;
TRUNCATE TABLE `demo_module_ping_classement`;
TRUNCATE TABLE `demo_module_ping_comm`;
TRUNCATE TABLE `demo_module_ping_equipes`;
TRUNCATE TABLE `demo_module_ping_joueurs`;
TRUNCATE TABLE `demo_module_ping_participe`;
TRUNCATE TABLE `demo_module_ping_parties`;
TRUNCATE TABLE `demo_module_ping_parties_spid`;
TRUNCATE TABLE `demo_module_ping_poules_rencontres`;
TRUNCATE TABLE `demo_module_ping_recup`;
TRUNCATE TABLE `demo_module_ping_recup_parties`;
TRUNCATE TABLE `demo_module_ping_seq`;
TRUNCATE TABLE `demo_module_ping_sit_mens`;


?>

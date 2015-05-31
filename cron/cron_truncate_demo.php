#!/usr/local/bin/php
<?php
/**
 * Generates a backup of the database and sends it in an email
 *
 * @author Elijah Lofgren < elijahlofgren [at] elijahlofgren.com>
 * @version $Id: backup-database-cron.php 2135 2005-08-07 13:43:29Z elijahlofgren $
 */
require_once('../../../config.php');
$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));


$query1 = "TRUNCATE `demo_module_ping_joueurs`";
$result1 = $link->query($query1); 
if($result1)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}

$query2 = "DELETE FROM `demo_module_ping_adversaires`";
$result2 = $link->query($query2); 
if($result2)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query3 = "DELETE FROM `demo_module_ping_calendrier`";
$result3 = $link->query($query3); 
if($result3)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query4 = "DELETE FROM `demo_module_ping_classement`";
$result4 = $link->query($query4); 
if($result4)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query5 = "DELETE FROM `demo_module_ping_comm`";
$result5 = $link->query($query5); 
if($result5)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query6 = "DELETE FROM `demo_module_ping_equipes`";
$result6 = $link->query($query6); 
if($result6)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query7 = "DELETE FROM `demo_module_ping_participe`";
$result7 = $link->query($query7); 
if($result7)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query8 = "DELETE FROM `demo_module_ping_parties`";
$result8 = $link->query($query8); 
if($result8)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query9 = "DELETE FROM `demo_module_ping_parties_spid`";
$result9 = $link->query($query9); 
if($result9)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query10 = "DELETE FROM `demo_module_ping_poules_rencontres`";
$result10 = $link->query($query10); 
if($result10)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query11 = "DELETE FROM `demo_module_ping_recup`";
$result11 = $link->query($query11); 
if($result11)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}
$query12 = "DELETE FROM `demo_module_ping_recup_parties`";
$result12 = $link->query($query12); 
if($result12)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}

$query13 = "DELETE FROM `demo_module_ping_sit_mens`";
$result13 = $link->query($query13); 
if($result13)
{
	echo "<p>table joueurs vidée.</p>";
}
else
{
	echo "<p>Erreur table joueurs</p>";
	//echo $db->ErrorMsg();
}


?>

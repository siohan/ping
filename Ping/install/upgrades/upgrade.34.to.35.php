<?php
$gCms = cmsms();
echo '<p>Ajout persmission &quot;Reorder Content&quot; ... ';
$nid = $db->GenId(cms_db_prefix().'permissions_seq');
$db->Execute('Insert INTO '.cms_db_prefix()."permissions (permission_id,permission_name,permission_text,create_date,modified_date)
              VALUES (?,?,?,NOW(),NOW())",array($nid,'Reorder Content','Reorder Content'));
echo '[fait]</p>';

$dbdict = NewDataDictionary($db);
echo '<p>Ajout nouveaux &eacute;v&eacute;nements ...';
$query = 'INSERT INTO '.cms_db_prefix().'events (originator,event_name,event_id) VALUES (?,?,?)';

$new_id = $db->GenId( cms_db_prefix().'events_seq');
$db->Execute($query,array('Core','StylesheetPreCompile',$new_id));
$new_id = $db->GenId( cms_db_prefix().'events_seq');
$db->Execute($query,array('Core','StylesheetPostCompile',$new_id));
$new_id = $db->GenId( cms_db_prefix().'events_seq');
$db->Execute($query,array('Core','LoginFailed',$new_id));

echo '<p>Ajout colonne à la table adminlog ...';
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'adminlog','ip_addr C(20)');
$return = $dbdict->ExecuteSQLArray($sqlarray);
echo "[fait]</p>";

echo '<p>Ajout colonnes aux tables modules ... ';
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'modules','allow_fe_lazyload I1,allow_admin_lazyload I1');
$return = $dbdict->ExecuteSQLArray($sqlarray);
echo "[fait]</p>";

echo '<p>S\'assurer que tous les modules (sauf nuSOAP) sont actif ...';
$query = 'UPDATE '.cms_db_prefix().'modules SET active = 1 WHERE module_name != ?';
$return = $db->Execute($query,array('nuSOAP'));
echo "[fait]</p>";

echo '<p>Désactivation du module Nusoap ...';
$query = 'UPDATE '.cms_db_prefix().'modules SET active = 0 WHERE module_name = ?';
$return = $db->Execute($query,array('nuSOAP'));
echo "[fait]</p>";

echo '<p>Ajout colonnes &agrave; la table userplugins ... ';
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'userplugins','description X');
$return = $dbdict->ExecuteSQLArray($sqlarray);
echo "[fait]</p>";

echo '<p>Ajout index &agrave; la table content ...';
$sqlarray = $dbdict->CreateIndexSQL(cms_db_prefix().'index_content_by_hierarchy', cms_db_prefix()."content", 'hierarchy');
$return = $dbdict->ExecuteSQLArray($sqlarray);
echo "[fait]</p>";

$sqlarray = $dbdict->CreateIndexSQL(cms_db_prefix().'event_id', cms_db_prefix()."events", 'event_id');
$return = $dbdict->ExecuteSQLArray($sqlarray);
$ado_ret = ($return == 2) ? ilang('fait') : ilang('failed');
echo ilang('install_creating_index', 'events', $ado_ret);
echo "[fait]</p>";

echo '<p>Upgrade au sch&eacute;ma version ... ';
$query = "UPDATE ".cms_db_prefix()."version SET version = 35";
$db->Execute($query);
echo '[fait]</p>';


?>

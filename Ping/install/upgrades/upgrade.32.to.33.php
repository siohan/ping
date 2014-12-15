<?php
$gCms = cmsms();

echo '<p>Ajout nouveau champ &agrave; la table content ... ';
$dbdict = NewDataDictionary($db);
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'content','secure I1');
$dbdict->ExecuteSQLArray($sqlarray);
$query = 'UPDATE '.cms_db_prefix().'content SET secure = 0';
$db->Execute($query);
echo '[fait]</p>';

echo '<p>Upgrade au sch&eacute;ma version ... ';
$query = "UPDATE ".cms_db_prefix()."version SET version = 33";
$db->Execute($query);
echo '[fait]</p>';

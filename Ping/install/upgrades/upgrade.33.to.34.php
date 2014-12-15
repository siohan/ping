<?php
$gCms = cmsms();
$dbdict = NewDataDictionary($db);

echo '<p>Ajout nouveau champ &agrave; la table content ... ';
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'content','page_url C(255)');
$dbdict->ExecuteSQLArray($sqlarray);
echo '[fait]</p>';

echo '<p>Ajout nouveaux champs &agrave; la table htmlblobs ... ';
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'htmlblobs','description X,use_wysiwyg I1');
$dbdict->ExecuteSQLArray($sqlarray);
echo '[fait]</p>';

echo '<p>Upgrade au sch&eacute;ma version ... ';
$query = "UPDATE ".cms_db_prefix()."version SET version = 34";
$db->Execute($query);
echo '[fait]</p>';

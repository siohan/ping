<?php
$gCms = cmsms();

echo '<p>Ajout de nouvelle permission ...';

cms_mapi_create_permission($gCms, 'Manage All Content', 'Manage All Content');
echo '[fait]</p>';

echo '<p>Suppression de permission ...';
cms_mapi_remove_permission('Modify Page Structure');
echo '[fait]</p>';

echo '<p>Upgrade au sch&eacute;ma version ... ';

$query = "UPDATE ".cms_db_prefix()."version SET version = 32";
$db->Execute($query);

echo '[fait]</p>';

?>

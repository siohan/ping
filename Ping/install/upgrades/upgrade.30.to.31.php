<?php
$gCms = cmsms();

echo '<p>Ajout de nouvelle permission ...';

cms_mapi_create_permission($gCms, 'View Tag Help', 'View Tag Help');
echo '[fait]</p>';

echo '<p>Upgrade au sch&eacute;ma version ... ';

$query = "UPDATE ".cms_db_prefix()."version SET version = 31";
$db->Execute($query);

echo '[fait]</p>';

?>

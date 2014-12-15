<?php  
$gCms = cmsms();

echo '<p>Ajout TemplatePreFetch event... ';
Events::CreateEvent('Core','TemplatePreFetch');
echo '[fait]</p>';

echo '<p>Upgrade au sch&eacute;ma version ... ';
$query = "UPDATE ".cms_db_prefix()."version SET version = 37";
$db->Execute($query);
echo '[fait]</p>';

?>

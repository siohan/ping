<?php
$gCms = cmsms();

echo '<p>Installation du nouveau module FileManager ... ';

$modops =& $gCms->GetModuleOperations();
$result = $modops->InstallModule('FileManager',false);
if( $result[0] == false )
{
    echo '[failed]</p>';
}
else
{
    echo '[fait]</p>';
    echo '<p class="okmessage">'.$gCms->modules['FileManager']['object']->InstallPostMessage().'</p>';
}

echo '<p>Installation du nouveau module Printing ... ';

$modops =& $gCms->GetModuleOperations();
$result = $modops->InstallModule('Printing',false);
if( $result[0] == false )
{
    echo '[failed]</p>';
}
else
{
    echo '[fait]</p>';
    echo '<p class="okmessage">'.$gCms->modules['Printing']['object']->InstallPostMessage().'</p>';
}

echo '<p>Upgrade au sch&eacute;ma version ... ';
$query = 'UPDATE '.cms_db_prefix().'version SET version = 29';
$db->Execute($query);
echo '[fait]</p>';  

?>

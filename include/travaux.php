<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
$travaux = $this->GetPreference('travaux');
if($travaux =='true')
{
	debug_display($params, 'Parameters');
}
#
#EOF
#
?>
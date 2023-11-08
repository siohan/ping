<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping '))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
global $themeObject;
$ret_ops = new retrieve_ops;

$ret_ops->organismes();







//echo $this->ProcessTemplate('test.tpl');


#
# EOF
#
?>

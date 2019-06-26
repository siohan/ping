<?php
#################################################################################
###                                                                           ###
#################################################################################
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$s_ops = new spid_ops;
//echo 'cool !';
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
	$recalcul = $s_ops->recalcul_spid($record_id);
}
else
{
	$db = cmsms()->GetDb();
	$query = "SELECT id FROM ".cms_db_prefix()."module_ping_parties_spid";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$record_id = $row['id'];
				$recalcul = $s_ops->recalcul_spid($record_id);
			}
		}
	}
	else
	{
		echo $db->ErrorMsg();
	}
}
$this->RedirectToAdminTab('spid');

#
# EOF
#
?>
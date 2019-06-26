<?php
#################################################################################
###           SUPPRESSION DES PARTIES SPID ET DES ADVERSAIRES                 ###
#################################################################################
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$spid_ops = new spid_ops;
$delete_spid = $spid_ops->delete_spid();
if(true === $delete_spid)
{
	$this->SetMessage('parties spid obsoletes supprimées');
	$delete_adversaires = $spid_ops->delete_adversaires();
}
$this->RedirectToAdminTab('spid');

#
# EOF
#
?>
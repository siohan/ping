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
debug_display($params, 'Parameters');

$c_ops = new asso_contests;			

	
	$db = cmsms()->GetDb();
	$query = "SELECT name, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE indivs = 0";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$idepreuve = $row['idepreuve'];//$name, $description, $active,$home_club)
				//checking if the team belongs to the default club
				$name = $row['name'];				
				$active = 1;
				
				$add_contest = $c_ops->add_contest_from_ping($idepreuve,$name, $active);
				
			}
			
		}
	}
	else
	{
		echo $db->ErrorMsg();
	}


//$this->RedirectToAdminTab('spid');

#
# EOF
#
?>
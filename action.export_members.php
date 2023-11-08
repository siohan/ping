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
$s_ops = new spid_ops;
//echo 'cool !';
if(isset($params['exportsubmit']) && $params['exportsubmit'] != '')
{
	
	$db = cmsms()->GetDb();
	$query = "SELECT licence, nom, prenom, actif, sexe FROM ".cms_db_prefix()."module_ping_joueurs";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			//on instancie la classe Asso_adherents
			$asso_ops = new Asso_adherents;
			while($row = $dbresult->FetchRow())
			{
				$licence = $row['licence'];
				$exists = $asso_ops->already_exists($licence);
				if(false === $exists)
				{
					$genid = $asso_ops->random_int(9);
					$add = $asso_ops->add_adherent_from_ping($genid,$actif, $nom, $prenom, $sexe, $licence );
					/*if(true === $add)
					{
						//on insère dans le groupe par défaut
						$gp_ops = new groups;
						$id_group = $gp_ops->assign_to_adherent();
						$gp_ops->assign_to_group($id_group, $genid);
					}
					* */
				}
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

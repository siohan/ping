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
$message = '';
//echo 'cool !';
$db = cmsms()->GetDb();
$saison_en_cours = $this->GetPreference('saison_en_cours');

if(isset($params['obj']) && $params['obj'] == 'export_members')
{
	
	$adherents = 'Adherents';
	$module = \cms_utils::get_module($adherents);
	$result = 0;
	if( is_object( $module ) ) $result = 1;//on vérifie que le module adhérents est bien installé et activé
	//var_dump( $result);
	if(false == $result)
	{
		$message.= 'Module non installé ou non activé !';
	}
	else
	{
		$query = "SELECT licence, nom, prenom, actif, sexe FROM ".cms_db_prefix()."module_ping_joueurs";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				//on instancie la classe Asso_adherents
				$asso_ops = new Asso_adherents;
				$gp_ops = new groups;
				while($row = $dbresult->FetchRow())
				{
					$licence = $row['licence'];
					$exists = $asso_ops->already_exists($licence);
					if(false === $exists)
					{
						$genid = $asso_ops->random_int(9);
						$actif = $row['actif'];
						$nom = $row['nom'];
						$prenom = $row['prenom'];
						$sexe = $row['sexe'];
						$add = $asso_ops->add_adherent_from_ping($genid,$actif, $nom, $prenom, $sexe, $licence );
						if(true == $add)
						{
							//on ajoute le nouveau au groupe par défaut
							$assign = $gp_ops->assign_to_adherent($genid);
							
						}
					}
				}
			}
			$this->SetMessage('Export effectué');

		}
		else
		{
			$message = $db->ErrorMsg();
			$this->SetMessage($message);
		}
	}
	
	$this->RedirectToAdminTab('spid');
}
#
# EOF
#
?>
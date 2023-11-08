<?php
if (!isset($gCms)) exit;
$db = cmsms()->GetDb();
//debug_display($params, 'Parameters');
$equipes_ops = new equipes_ping;
$ping_admin_ops = new ping_admin_ops();
$spid_ops = new spid_ops;
$ren = new rencontres;
require_once('include/prefs.php');
if (!$this->CheckPermission('Ping Delete'))
{
	$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
	$this->Redirect($id, 'defaultadmin','', $params);
}
/* on fait un petit formulaire pour choisir quelle saison, on souhaite supprimer	*/
				
//var_dump($saisondropdown);				
					
	if (!empty($_POST))
	{				
		debug_display($_POST);
		if(!isset($_POST['saison']) || $_POST['saison'] == '')
		{
			
		}
		else
		{
			$saison = $_POST['saison'];
			if($saison == $this->GetPreference('saison_en_cours'))
			{
				$this->SetMessage('Impossible de supprimer les données de la saison en cours ');
			}
			else
			{
				$tables = array('classement', 'divisions', 'div_classement','div_parties', 'div_tours', 'equipes', 'parties', 'parties_spid', 'poules_rencontres', 'recup_parties', 'sit_mens');
				foreach( $tables as $value)
				{
					if($value == 'poules_rencontres')
					{
						$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison = ?";
						//echo $query;
						$dbresult = $db->Execute($query, array($saison));
						if($dbresult && $dbresult->RecordCount()>0)
						{
							while($row = $dbresult->FetchRow())
							{
								$fk_id = $row['renc_id'];
								$query1 = "DELETE FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
								//echo $query1;
								$dbresult = $db->Execute($query1, array($fk_id));
								
								$query2 = "DELETE FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ?";
								//echo $query2;
								$dbresult = $db->Execute($query2, array($fk_id));
							}
						}
						$query = "DELETE FROM ".cms_db_prefix()."module_ping_".$value." WHERE saison = ?";
						//echo $query;
						$dbresult = $db->Execute($query, array($saison));
					}
					else
					{
						$query = "DELETE FROM ".cms_db_prefix()."module_ping_".$value." WHERE saison = ?";
						//echo $query;
						$dbresult = $db->Execute($query, array($saison));
					}
				}
				$this->SetMessage('Saison supprimée !');
			}
		}	
		$this->Redirect($id, 'nettoyage', $returnid);
				
	}
	else
	{
		//on prépare un formulaire pour la suppression des données obsolètes
		$ep = new ping_admin_ops;
		$liste_saisons = $ep->seasons_list();
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('nettoyage.tpl'), null, null, $smarty);
		$tpl->assign('saisondropdown', $liste_saisons);
		$tpl->display();
	}
?>

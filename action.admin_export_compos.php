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
$db = cmsms()->GetDb();
$saison_en_cours = $this->GetPreference('saison_en_cours');
$message = '';
if(isset($params['exportsubmitbutton2']) && $params['exportsubmitbutton2'] != '')
{
	
	$compositions = 'Compositions';
	$module = \cms_utils::get_module($compositions);
	$result = 0;
	if( is_object( $module ) ) $result = 1;
	//var_dump( $result);
	if(false == $result)
	{
		$message.= 'Module non installé ou non activé !';
	}
	else
	{
	
		$query = "SELECT name, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions WHERE indivs = '0'";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$compo_ops = new compositionsbis;
			while($row = $dbresult->FetchRow())
			{
				$nom = $row['name'];
				$idepreuve = $row['idepreuve'];
				$add_epreuve = $compo_ops->add_epreuve_from_ping( $idepreuve, $nom);			
			}
		}
	
		$query = "SELECT libequipe, idepreuve, friendlyname FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
		$dbresult = $db->Execute($query, array($saison_en_cours));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$compo_ops = new compositionsbis;
			while($row = $dbresult->FetchRow())
			{
		
				$libequipe = $row['libequipe'];
				$idepreuve = $row['idepreuve'];
				$friendlyname = $row['friendlyname'];
				$nb_joueurs = 4;
			
				//les éléments nécessaires dans le modules compositions
				/*
				une référence équipe qui peut être modifiée ensuite
				un libellé officiel(ici nom)
				un friendlyname si dispo (nom court)
				un idepreuve
				nb joueurs minimum
				capitaine (genid)-> absent ds le module Ping
				phase
				saison
				*/
				$add_epreuve = $compo_ops->add_teams_from_ping($libequipe, $friendlyname,$nb_joueurs, $idepreuve);			
			}
		}
		$this->SetMessage('Export effectué');
		
	}
	$this->RedirectToAdminTab('spid');
}
#
# EOF
#
?>
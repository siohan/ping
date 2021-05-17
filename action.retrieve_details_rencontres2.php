<?php
########################################################################################
## Cette page récupère le détail des parties ds une compétition par équipes          ###
## 
########################################################################################
if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
//a faire 
//mettre les autorisations
debug_display($params, 'Parameters');

$designation = '';
$ren_ops = new rencontres;
$eq_id = 0; //on instancie donc le parametre de l'équipe

	$record_id = '';
	if(isset($params['record_id']) && $params['record_id'] != '')
	{
		$record_id = $params['record_id'];
		
			$del_feuil = $ren_ops->delete_details_rencontre($record_id);
			if(true == $del_feuil)
			{
				$del_parties = $ren_ops->delete_rencontre_parties($record_id);
				$ren_ops->not_uploaded($record_id);
			}
		
		
		if(isset($params['eq_id']) && $params['eq_id'] != '')
		{
			$eq_id = $params['eq_id'];
		}
		$query = "SELECT saison, lien,idpoule, iddiv, date_event, tour FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$renc = $ren_ops->feuille_parties($record_id);
			}//fin du while
		}
		
	}
$this->SetMessage('Retrouvez les infos dans le journal');
$this->Redirect($id,'admin_details_rencontre',$returnid, array("record_id"=>$record_id));


#
# EOF
#

?>
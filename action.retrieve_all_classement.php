<?php
if( !isset($gCms) ) exit;
require_once(dirname(__FILE__).'/include/travaux.php');
//debug_display($params,'Parameters');
// les préférences nécessaires
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
$now = trim($db->DBTimeStamp(time()), "'");
$nom_equipes = $this->GetPreference('nom_equipes');
$error = 0;//on instancie un compteur d'erreurs
$designation = '';
$idepreuve = '';
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	$error++;
}
$tour = '';
if(isset($params['tour']) && $params['tour'] !='')
{
	$tour = $params['tour'];
}
else
{
	$error++;
}
$date_debut = '';
if(isset($params['date_debut']) && $params['date_debut'] !='')
{
	$date_debut = $params['date_debut'];
}
else
{
	$error++;
}
if($error == 0)
{
	//on fait une requete pour extraire toutes les infos afin de préparer une boucle
	$query1 = "SELECT id AS tour_id FROM ".cms_db_prefix()."module_ping_div_tours WHERE idepreuve = ? AND date_debut = ? AND tour = ? AND saison = ? AND uploaded_classement IS NULL";
	$dbresult1 = $db->Execute($query1,array($idepreuve,$date_debut,$tour,$saison));

		if ($dbresult1 && $dbresult1->RecordCount() > 0)
	  	{


			$service = new retrieve_ops();
	    		while ($dbresult1 && $row = $dbresult1->FetchRow())
	      		{

				$tour_id = $row['tour_id'];
				$retrieve = $service->retrieve_div_classement($tour_id);


			}//fin du while
		}
		else 
		{
			$this->SetMessage('Pas de tours trouvés ou classements déjà mis à jour');
			$this->RedirectToAdminTab('calendrier');
		}//fin du if dbresult
}






	
	$this->SetMessage("Retrouvez les infos dans le journal");
	$this->RedirectToAdminTab('resultats');
	
#
# EOF
#
?>
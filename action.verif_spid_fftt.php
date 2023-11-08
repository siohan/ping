<?php
if(!isset($gCms)) exit;
$db = cmsms()->GetDb();
$ep_ops = new EpreuvesIndivs;
global $themeObject;
$saison_courante = $this->GetPreference('saison_en_cours');
$query = "SELECT DISTINCT sp.id AS record_id,p.date_event AS date_fftt,p.codechamp,sp.date_event AS date_spid,sp.licence as licence_spid,sp.epreuve, p.licence as licence_fftt,sp.nom as nom_spid, p.advnompre AS nom_fftt, sp.numjourn AS numjourn_spid, p.numjourn AS numjourn_fftt, sp.victoire AS victoire_spid, p.vd AS victoire_fftt, sp.coeff AS coeff_spid, p.coefchamp AS coeff_fftt, sp.pointres AS points_spid, p.pointres AS points_fftt FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_parties AS p WHERE sp.idpartie = p.idpartie  AND sp.saison = ? ORDER BY sp.id ASC";
$dbresult = $db->Execute($query, array($saison_courante));
$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	
	while($row = $dbresult->FetchRow())
	{
		//on va faire les corrections directement
		//l'important est de corriger la table des épreuves
		$codechamp = $row['codechamp'];
		$coefchamp = $row['coeff_fftt'];
		$epreuve = $row['epreuve'];
		//on vérifie si la compet est déjà en base
		$det = $ep_ops->details_epreuve_by_name($row['epreuve'], $saison_courante);
		
		if(false != $det)
		{
			$update = $ep_ops->update_epreuve($epreuve, $codechamp, $coefchamp, $saison_courante);
		}
		else
		{
			//on ajoute qqs trucs par défaut
			$indivs = 0;
			$idepreuve = 0;
			$tag = 0;
			$idorga = 0;
			$add = $ep_ops->add_competition($epreuve, $indivs,$idepreuve, $tag, $idorga,$saison_courante);
			/* */
		}
		
	}
}
$this->RedirectToAdminTab('spid');
#EOF
#
?>

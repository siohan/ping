<?php


if( !isset($gCms) ) exit;

debug_display($params, 'Parameters');
//if (isset($params['cancel'])) { $this->Redirect($id, 'defaultadmin', $returnid); }
require_once(dirname(__FILE__).'/function.calculs.php');
$designation = '';
//echo $params['irecord_id'];
/*
		if (!$this->CheckPermission('Manage Comments'))
		{
			echo '<p class="error">'.$this->Lang('needpermission', array('Manage Comments')).'</p>';
			return;
		}
*/
		/*$id_user = '';*/
		if ( isset($params['record_id'] ))
		{
			$record_id = $params['record_id'];
		}
		if (isset($params['epreuve'])) {
			$epreuve = $params['epreuve'];
			$coefficient = coeff($epreuve);
			/*
			$query ="SELECT coefficient FROM ".cms_db_prefix()."module_ping_competitions WHERE code_compet = ?";
			$dbretour = $db->Execute($query, array($type_compet));
			if ($dbretour && $dbretour->RecordCount() > 0)
			  {
			    while ($row= $dbretour->FetchRow())
			      {
				$coeff = $row['coefficient'];
				}
			}
			*/
		}
		
			
		if (isset($params['numjourn']))
		{
			$numjourn = $params['numjourn'];
		}
		if (isset($params['nom']))
		{
			$nom = $params['nom'];
		}
		
		if (isset($params['classement']))
		{
			$classement = $params['classement'];
		}
		if (isset($params['ecart']))
		{
			$ecart = $params['ecart'];
		}
		if (isset($params['coeff']))
		{
			$coeff = $params['coeff'];
		}
		if (isset($params['victoire']))
		{
			$victoire = $params['victoire'];
		}
		//on vérifie le coeff de l'épreuve : 
			if ($coefficient !=$coeff){
				$designation.="Le coefficient et l'épreuve ne correspondent pas !";
			}
		//on fait les calculs nécessaires
		
		//tout d'abord, y a t-il eu forfait ?
		//Si oui, inutile de calculer les points
		
			if($forfait ==1){
				$pointres = 0;
			}
			else{
				//on détermine le type d'écart entre les deux joueurs
				$type_ecart = CalculEcart($ecart);
				$points1 = CalculPointsIndivs($type_ecart, $victoire);
				$pointres = $points1*$coeff; 
				
			}
		
		
		$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET nom = ?, numjourn = ?, classement = ?, victoire = ?, ecart = ?, coeff = ?, pointres = ? WHERE id = ?";
		$dbresult = $db->Execute($query, array($nom, $numjourn, $classement, $victoire, $ecart, $coeff,$pointres, $record_id));
		if (!$dbresult) {
			$designation.=$db->ErrorMsg();
		}
		else {
			
			$designation.="Enregistrement modifié.";
		}
		
		$this->SetMessage($designation);
		$this->RedirectToAdminTab('results');

?>
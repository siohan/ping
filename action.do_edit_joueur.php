<?php


if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if (isset($params['cancel'])) { $this->Redirect($id, 'defaultadmin', $returnid); }
$now = trim($db->DBTimeStamp(time()), "'");
$saison = $this->GetPreference('saison_en_cours');
$db =& $this->GetDb();
require_once(dirname(__FILE__).'/include/travaux.php');
$designation = '';
//echo $params['record_id'];
/*
		if (!$this->CheckPermission('Manage Comments'))
		{
			echo '<p class="error">'.$this->Lang('needpermission', array('Manage Comments')).'</p>';
			return;
		}
*/
		/*On récupère les variable et on les traite */
		if ( isset($params['licence'] ))
		{
			$licence = $params['licence'];
			
		}
		if (isset($params['actif']))
		{
			$actif = $params['actif'];
		}
		if (isset($params['nom']))
		{
			$nom = strtoupper($params['nom']);
		}
		if (isset($params['prenom']))
		{
			$prenom = $params['prenom'];
		}
		if (isset($params['birthday']))
		{
			$birthday = $params['birthday'];
		}
		if (isset($params['sexe']))
		{
			$sexe = $params['sexe'];
		}
		
		if (isset($params['adresse']))
		{
			$adresse = $params['adresse'];
		}
		
		if ( isset( $params['ville'] ))
		{
			$ville = $params['ville'];
		}
		if ( isset( $params['codepostal'] ))
		{
			$codepostal = $params['codepostal'];
		}
		//on regarde si le joueur existe déjà si oui UPDATE si non INSERT INTO
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		$count = $dbresult->RecordCount();
		if ($count>0){
			$ajout = 1;
			$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET  actif = ?, nom = ?, prenom = ?, birthday = ?, sexe = ?, adresse = ?, ville = ?, codepostal = ? WHERE licence = ?";
			$dbresult = $db->Execute($query, array($actif,$nom,$prenom,$birthday, $sexe, $adresse, $ville, $codepostal, $licence));
			$designation.="Mise à jour de".$nom. " ".$prenom;
		}
		else{
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id,actif,licence,nom, prenom, birthday, sexe, adresse, ville, codepostal) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$dbresult = $db->Execute($query, array($actif, $licence, $nom, $prenom, $birthday, $sexe, $adresse, $ville, $codepostal));
			
			if(!$dbresult){
				$designation.= $db->ErrorMsg();
			}
			else
			{
				$designation.="Ajout de ".$nom." ".$prenom;
			}
			
			//il faut aussi insérer le joueur dans la table des situations mensuelles
			//est-il déjà présent ?
			$query = "SELECT licence FROM".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
			$dbresult = $db->Execute($query, array($licence));
			$compteur = $dbresult->RecordCount();
			if($compteur ==0)
			{			
				$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens, fftt, spid) VALUES ('', ?, ?, ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($saison, $now, $licence, 'Janvier 2000', '0','0'));
			
				if(!$dbresult){
					$designation.= $db->ErrorMsg();
				}
			}
			
		}
		
		
		

		
	
			//on a pas de modification du coeff, on change simplement les données sans recalculer
		
			
		
		// la table points est modifié, on passe à la table rencontres
		$status = 'Ok';
		//$designation = 'Ajout/modification de '.$nom.' '.$prenom;
		$action = 'do_edit_joueur';
		ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
		
$this->SetMessage("$designation");

$this->RedirectToAdminTab('Joueurs');


?>
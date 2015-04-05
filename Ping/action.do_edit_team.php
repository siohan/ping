<?php


if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if (isset($params['cancel'])) { $this->Redirect($id, 'defaultadmin', $returnid); }
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
//echo $params['record_id'];
$designation = '';
/*
		if (!$this->CheckPermission('Manage Comments'))
		{
			echo '<p class="error">'.$this->Lang('needpermission', array('Manage Comments')).'</p>';
			return;
		}
*/
		/*On récupère les variable et on les traite */
		$record_id = '';
		if( !isset( $params['record_id'] ) || $params['record_id'] == '')    
		{

			$message = $this->Lang('error_insufficientparams');
			$this->SetMessage("$message");
			$this->RedirectToAdminTab('equipes');
		}
		$id = $params['record_id'];
		if (isset($params['saison']))
		{
			$saison = $params['saison'];
		}
		if (isset($params['phase']))
		{
			$phase = $params['phase'];
		}
		if (isset($params['libequipe']))
		{
			$libequipe = $params['libequipe'];
		}
		
		if (isset($params['libdivision']))
		{
			$libdivision = $params['libdivision'];
		}
		if (isset($params['friendlyname']))
		{
			$friendlyname = $params['friendlyname'];
		}
		if (isset($params['type_compet']))
		{
			$type_compet = $params['type_compet'];
		}
		if (isset($params['iddiv']))
		{
			$iddiv = $params['iddiv'];
		}
		if (isset($params['idpoule']))
		{
			$idpoule = $params['idpoule'];
		}
		if (isset($params['organisme']))
		{
			$organisme = $params['organisme'];
		}
		$liendivision = "cx_poule=".$idpoule."&D1=".$iddiv."&organisme_pere=".$organisme;
		//echo "le lien est : ".$lien;
		if(isset($params['Ajouter']))
		{
			
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_equipes (id, saison, phase, libequipe, libdivision,friendlyname, liendivision, idpoule, iddiv, type_compet) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$dbresult = $db->Execute($query,array($saison, $phase, $libequipe, $libdivision,$friendlyname, $liendivision, $idpoule, $iddiv, $type_compet));
			$designation.="Equipe ajoutée avec succès";
		}
		else
		{
			//on a pas de modification du coeff, on change simplement les données sans recalculer
			$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET  saison = ?, phase = ?, libequipe = ?, libdivision = ? , friendlyname = ? , liendivision = ?, type_compet = ? WHERE id = ?";
			$dbresult = $db->Execute($query, array($saison,$phase,$libequipe, $libdivision,$friendlyname,$liendivision, $type_compet,$id));
			//echo $query;
			$designation.="Equipe mise à jour avec succès";
		}
			
	
		if (!$dbresult) {
			$designation.=  $db->ErrorMsg();
		//	echo $db->sql."<br/>";
		//	    echo $db->ErrorMsg();
				
		}
		else {
			$designation.= 'Equipe mise à jour';
		}
		
		
		$this->SetMessage("$designation");

		$this->RedirectToAdminTab('equipes');
		
?>
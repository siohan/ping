<?php


if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//if (isset($params['cancel'])) { $this->Redirect($id, 'defaultadmin', $returnid); }
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
//echo $params['record_id'];
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
		
			//on a pas de modification du coeff, on change simplement les données sans recalculer
			$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET  saison = ?, phase = ?, libequipe = ?, libdivision = ? , friendlyname = ? WHERE id = ?";
			$dbresult = $db->Execute($query, array($saison,$phase,$libequipe, $libdivision,$friendlyname,$id));
			//echo $query;
	
		if (!$dbresult) {
			$message =  $db->ErrorMsg();
		//	echo $db->sql."<br/>";
		//	    echo $db->ErrorMsg();
				
		}
		else {
			$message = 'Equipe mise à jour';
		}
		
		
		$this->SetMessage("$message");

		$this->RedirectToAdminTab('equipes');
?>
<?php


if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if (isset($params['cancel'])) { $this->Redirect($id, 'defaultadmin', $returnid); }
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/function.calculs.php');
//echo $params['record_id'];
$designation = '';
$error =0;
/*
		if (!$this->CheckPermission('Manage Comments'))
		{
			echo '<p class="error">'.$this->Lang('needpermission', array('Manage Comments')).'</p>';
			return;
		}
*/
		/*On récupère les variable et on les traite */
		$record_id = ''; 
		if( isset( $params['record_id'] ) && $params['record_id'] != '')    
		{
			$id = $params['record_id'];
			
		}
		else
		{
			$error++;
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
	
		if($error>0)
		{
			$this->SetMessage('Paramètres manquants !');
			$this->RedirectToAdminTab('equipes');
		}
	
			$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET  libequipe = ?, libdivision = ? , friendlyname = ?  WHERE id = ?";
			$dbresult = $db->Execute($query, array($libequipe, $libdivision,$friendlyname,$id));					
	
			if (!$dbresult) 
			{
				$designation.=  $db->ErrorMsg();				
			}
			else 
			{
				$designation.= 'Equipe mise à jour';
			}
		
		
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('equipes');
		
?>
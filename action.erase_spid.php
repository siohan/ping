<?php
		if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
		$db = cmsms()->GetDb();
		if (!$this->CheckPermission('Ping Manage'))
		{
			$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
			$this->Redirect($id, 'defaultadmin','', $params);		
		}
			
			$month = date('m')-1;
			$day = '31';
			$year = date('Y');
			$date_echeance = $year.'-'.$month.'-'.$day;
			
			//on supprime tous les enregistrements ?
			$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE date_event < ?";
			$dbresult = $db->Execute($query, array($date_echeance));
			
			if($dbresult)
			{
				$this->SetMessage('Table spid nettoyée');
			}
			else
			{
				$this->SetMessage('Une erreur s\'est produite');
			}

$this->RedirectToAdminTab('spid');

?>

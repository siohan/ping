<?php
		if (!isset($gCms)) exit;


		if (!$this->CheckPermission('Ping Manage'))
		{
		$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
		$this->Redirect($id, 'defaultadmin','', $params);
		/*echo $this->ShowErrors($this->Lang('needpermission'));
		return;*/
		}

		$record_id = '';
		if (isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		else
		{
			$designation = 'Paramètres manquants';
			$this->SetMessage("");
			$this->RedirectToAdminTab('Calendrier');
			
			
		}
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_calendrier WHERE id = ?";
		$dbresult = $db->Execute($query,array($record_id));
		

$this->SetMessage('Date supprimée');
$this->RedirectToAdminTab('calendrier');
?>
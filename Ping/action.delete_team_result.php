<?php
		if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

		if (!$this->CheckPermission('Ping Manage'))
		{
		$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
		$this->Redirect($id, 'defaultadmin','', $params);
		/*echo $this->ShowErrors($this->Lang('needpermission'));
		return;*/
		}

		$record_id = '';
		if (isset($params['record_id']))
		{
			$record_id = $params['record_id'];
		}
		
		//Now remove the article
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE id = ?";
		$db->Execute($query, array($record_id));
		
/*
$this->SetMessage('Résultat supprimé');
$this->RedirectToAdminTab('results');
*/
?>
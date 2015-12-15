<?php
		if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
		$db =& $this->GetDb();
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
		$coefchamp = '';
		if(isset($params['coefchamp']))
		{
			$coefchamp = $params['coefchamp'];
		}
		$numjourn = '';
		if(isset($params['numjourn']))
		{
			$numjourn = $params['numjourn'];
		}
		$vd = '';
		if(isset($params['vd']))
		{
			$vd = $params['vd'];
		}
		$pointres = '';
		if(isset($params['pointres']))
		{
			$pointres = $params['pointres'];
		}
		
		
		//Now remove the article
		$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET numjourn = ?, coeff = ?, pointres = ?, victoire = ? WHERE id = ?";
		$dbresult = $db->Execute($query, array($numjourn, $coefchamp,$pointres,$vd, $record_id));
		
			if(!$dbresult)
			{
				echo $db->ErrorMsg();
				
			}
		
		

$this->SetMessage('Résultat modifié');
$this->RedirectToAdminTab('results');

?>
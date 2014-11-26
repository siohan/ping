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
$error = 0;
$designation = '';
	$record_id = '';
	if (isset($params['record_id']) && $params['record_id'] != '')
	{
		$record_id = $params['record_id'];
	}
	else
	{
			$error++;
	}
	$type_compet = '';
	if(isset($params['type_compet']) && $params['type_compet'] !='')
	{
			 $type_compet = $params['type_compet'];
	}
	else
	{
			$error++;
	}
		
		if ($error==0)
		{
			switch($type_compet)
			{
				case  "spid" :

					$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
					$dbresult = $db->Execute($query, array($record_id));
					
					if(!$dbresult)
					{
						$designation.= $db->ErrorMsg();
						
					}
					else
					{
						$designation.="Résultat supprimé";
						$this->SetMessage("$designation");
						$this->RedirectToAdminTab('results');
					}			

				break;
				case "fftt" :


					//Now remove the article
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Résultat supprimé');
					$this->RedirectToAdminTab('results');
				break;
				case "type_compet" :


					//Now remove the article
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Type de compétition supprimée');
					$this->RedirectToAdminTab('compets');
				break;
			}
		}
		
		

?>
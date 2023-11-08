<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping use'))
{
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

if(!empty($_POST))
{
	if( isset($_POST['cancel']) )
	{
    	$this->RedirectToAdminTab('compte');
    	return;
	}
	if(isset($_POST['action_choisie']) && $_POST['action_choisie'] != '')
	{
		$action_choisie = $_POST['action_choisie'];
	}	
	if(isset($_POST['record_id']) && $_POST['record_id'] != '')
	{
		$record_id = (int) $_POST['record_id'];
	}	
	if(isset($_POST['nombre']) && $_POST['nombre'] >0)
	{
		$nombre = (int) $_POST['nombre'];
	}	
	//on fait le traitement
	if($action_choisie == "Reculer")
	{
		$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET date_event = DATE_ADD(date_event, INTERVAL ? DAY) WHERE eq_id= ?";
		$dbresult = $db->Execute($query, array($nombre, $record_id));
		if($dbresult)
		{
			$this->SetMessage("dates modifiées !");
		}
		else
		{
			$this->SetMessage("dates non modifiées !");
		}
	}
	
	if($action_choisie == "Avancer")
	{
		$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET date_event = DATE_SUB(date_event, INTERVAL ? DAY) WHERE eq_id= ?";
		$dbresult = $db->Execute($query, array($nombre, $record_id));
		if($dbresult)
		{
			$this->SetMessage( "dates modifiées !");
		}
		else
		{
			$this->SetMessage( "dates non modifiées !");
		}
	}
	$this->Redirect($id, "admin_poules_tab3", $returnid, array("record_id"=>$record_id));
}
else
{
	//debug_display($params, 'Post Parameters');
	if(isset($params['record_id']) && $params['record_id'] >0)
	{
		$record_id = (int) $params['record_id'];
	}
	$actions = array("Reculer"=>"Reculer", "Avancer"=>"Avancer");
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('change_all_dates.tpl'), null, null, $smarty);
	$tpl->assign('actions', $actions);
	$tpl->assign('record_id', $record_id);
	$tpl->display();

}	

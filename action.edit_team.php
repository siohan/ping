<?php

if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$db = cmsms()->GetDb();
$eq_ops = new equipes_ping;
$ren = new rencontres;
if(!empty($_POST))
{
	//debug_display($_POST, 'Parameters');
	if(isset($_POST['record_id']) && $_POST['record_id'] >0)
	{
		$record_id = (int) $_POST['record_id'];
	}
	if(isset($_POST['friendlyname']))
	{
		$friendlyname = $_POST['friendlyname'];
	}
	if(isset($_POST['hor_Hour']) && $_POST['hor_Hour'] != '')
	{
		$hor_Hour = $_POST['hor_Hour'];
	}
	
		$hor_Minute = '00';
	
	$horaire = $hor_Hour.':'.$hor_Minute;
	if(isset($_POST['class_mini']) && $_POST['class_mini'] != '')
	{
		$class_mini = (int) $_POST['class_mini'];
	}
	$update_team = $eq_ops->update_team($record_id, $friendlyname, $horaire, $class_mini);
	if(true == $update_team)
	{
		//on modifie les horaires des rencontres pour la poule de cette équipe
		$ren->update_fixture($record_id, $horaire);
	}
	$this->RedirectToAdminTab('equipes');
	
}
else
{
	
	
	
	if( isset( $params['record_id'] ) && $params['record_id'] >0)    
	{
		$record_id = (int) $params['record_id'];
		//on va chercher les détails de cette équipe
		$details = $eq_ops->details_equipe($record_id);
		
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('editteam.tpl'), null, null, $smarty);
		$tpl->assign('record_id', $record_id);
		$tpl->assign('phase', $details['phase']);
		$tpl->assign('numero_equipe', $details['numero_equipe']);
		$tpl->assign('libequipe', $details['libequipe']);
		$tpl->assign('libdivision', $details['libdivision']);
		$tpl->assign('friendlyname', $details['friendlyname']);
		$tpl->assign('liendivision', $details['liendivision']);
		$tpl->assign('idpoule', $details['idpoule']);
		$tpl->assign('iddiv', $details['iddiv']);
		$tpl->assign('type_compet', $details['type_compet']);
		$tpl->assign('idepreuve', $details['idepreuve']);
		$tpl->assign('calendrier', $details['calendrier']);
		$tpl->assign('horaire', $details['horaire']);
		$tpl->assign('class_mini', $details['class_mini']);
		$tpl->display();  
	}
	else
	{
		echo 'Aucune équipe valable choisie';
	}
	
	
	
}
#
# EOF
#
?>

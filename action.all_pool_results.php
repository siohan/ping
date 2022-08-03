<?php
/*
 * Cette page va chercher tous les détails des rencontres d'une seule poule
 * 
 */ 
if(isset($params['eq_id']) && $params['eq_id'] >0)
{
	
}
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}

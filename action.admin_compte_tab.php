<?php
if(!isset($gCms) ) exit;
//on établit les permissions
if(!$this->CheckPermission('Ping Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
$db = cmsms()->GetDb();
$ping_ops = new ping_admin_ops;

if(!empty($_POST))
{
	//debug_display($_POST, 'Post Parameters');
	$error = 0;
	if(isset($_POST['idAppli']) && $_POST['idAppli'] !='')
	{
		$idAppli = $_POST['idAppli'];	
	}
	else
	{
		$error++;
		$designation.="Il manque l'Id de l'application.";
	}
	if(isset($_POST['motdepasse']) && $_POST['motdepasse'] !='')
	{
		$motdepasse = $_POST['motdepasse'];
		//on crypte le mot de passe 
		$cde = hash('md5', $motdepasse, FALSE);		
	}
	else
	{
		$error++;
		$designation.=" Votre mot de passe est manquant.";	
	}


	if($this->GetPreference('serie') =='')
	{	
		$serie = $ping_ops->random_serie(15);
	}
	else
	{
			$serie = $this->GetPreference('serie');		
	}
	if($error>0)
	{
		$this->SetMessage($designation);
		$this->RedirectToAdminTab('compte');
	}
	else
	{
		//tt est ok, on peut commencer...
		//on met l'id de l'application et le mot de passe en préférence
		$this->SetPreference('idAppli',$idAppli);
		$this->SetPreference('motdepasse',$cde);
		$this->SetPreference('serie',$serie);
		$this->Redirect($id, 'getInitialisation',$returnid, array("install"=>"1", "step"=>"1"));
	
	}
}
else
{	
	//debug_display($parms, 'params Parameters');
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('compte.tpl'), null, null, $smarty);
	$tpl->assign('idAppli', $this->GetPreference('idAppli'));
	$tpl->assign('motdepasse', $this->GetPreference('motdepasse'));
	$tpl->assign('serie', $this->GetPreference('serie'));	
	$tpl->display();
}

#
#EOF
#
?>
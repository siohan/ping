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
	$aujourdhui = date('Y-m-d ');
	$error = 0;
	$message = '';
		
		
		if (isset($_POST['club_number']) && $_POST['club_number'] !='')
		{
			$club_number = $_POST['club_number'];
		}
		else
		{
			$error++;
		}
		if (isset($_POST['zone']) && $_POST['zone'] !='')
		{
			$zone = $_POST['zone'];
		}
		else
		{
			$error++;
		}
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('compte');
		}
		else // pas d'erreurs on continue
		{
			$ops = new adherents_spid;
			$verifyClub = $ops->VerifyClub($club_number);
			//var_dump($verifyClub);

			if(true === $verifyClub)
			{
				$this->SetPreference('club_number', $club_number);
				$this->SetPreference('zone', $zone);
				
				$message.=" Le numéro de club est correct";
				$this->SetMessage($message);
				$this->Redirect($id,'getInitialisation', $returnid, array("step"=>"2"));
			}
			else
			{
				$message.=" Le numéro de club est incorrect ou la connexion est instable : Veuillez Recommencez";
				//on supprime le numéro du club !!
			//	$this->SetPreference('club_number', '0');
				$this->SetMessage($message);
				$this->Redirect($id,'add_edit_club_number',$returnid);
			}
		}		
}
else
{
	//debug_display($params, 'Parameters');
	$orga_ops = new fftt_organismes;
	$liste_zones = $orga_ops->liste_zones();
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_club_number.tpl'), null, null, $smarty);
	$tpl->assign('club_number', $this->GetPreference('club_number'));
	$tpl->assign('zone', $this->GetPreference('zone'));
	$tpl->assign('liste_zones', $liste_zones);
	$tpl->display();
}


#
# EOF
#
?>

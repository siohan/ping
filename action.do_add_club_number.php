<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

	if (!$this->CheckPermission('Adherents use'))
	{
		$designation .=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('adherents');
	}
	if (isset($params['cancel']))
	{
		$this->SetMessage('Installation stoppée !');
		$this->Redirect($id, 'defaultadmin', $returnid, $params);
	}

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$message = '';
		
		
		if (isset($params['club_number']) && $params['club_number'] !='')
		{
			$club_number = $params['club_number'];
		}
		else
		{
			$error++;
		}
		if (isset($params['zone']) && $params['zone'] !='')
		{
			$zone = $params['zone'];
		}
		else
		{
			$error++;
		}
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('adherents');
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

?>
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
	//debug_display($_POST, 'Post Parameters');
	$eq_ops = new equipes_ping;
	$ren_ops = new rencontres;
	$aujourdhui = date('Y-m-d ');
	$error = 0;
	$message = '';
	if(isset($_POST['sels']) && $_POST['sels'] != '')
	{
		$sels = $_POST['sels'];
	}	
		
	if(isset($_POST['hor_Hour']) && $_POST['hor_Hour'] != '')
	{
		$hor_Hour = $_POST['hor_Hour'];
	}
	if(isset($_POST['hor_Minute']) && $_POST['hor_Minute'] != '')
	{
		$hor_Minute = $_POST['hor_Minute'];
	}
	$hor = $hor_Hour.':'.$hor_Minute;
		
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			
			$this->Setmessage('Parametres requis manquants !');
			
		}
		else // pas d'erreurs on continue
		{
			$eq_ops = new equipes_ping;
			$tab = explode('-', $sels);
			foreach($tab as $record_id)
			{
				$new_hor = $eq_ops->change_horaire($record_id, $hor);
				if(true == $new_hor)
				{
					$ren_ops->update_fixture($record_id, $hor);
				}
			}
			$this->Setmessage('horaires modifiés');
		}
		$this->RedirectToAdminTab('equipes');	
}
else
{
	//debug_display($params, 'Parameters');
	
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('change_horaire.tpl'), null, null, $smarty);
	$tpl->assign('sels', $params['sels']);
	$tpl->display();
}


#
# EOF
#
?>

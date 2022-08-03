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
	
	$aujourdhui = date('Y-m-d ');
	$error = 0;
	$message = '';
	if(isset($_POST['sels']) && $_POST['sels'] != '')
	{
		$sels = $_POST['sels'];
	}	
	$new_date = $_POST['start_Year'].'-'.$_POST['start_Month'].'-'.$_POST['start_Day'] ;	
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
			$ren_ops = new rencontres;
			$tab = explode('-', $sels);
			foreach($tab as $record_id)
			{
				$ren_ops->change_date_event($record_id, $new_date, $hor);
			}
			$this->Setmessage('Dates et horaires modifiés');
		}
		$this->RedirectToAdminTab('rencontres');	
}
else
{
	//debug_display($params, 'Parameters');
	
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('change_date_event.tpl'), null, null, $smarty);
	$tpl->assign('sels', $params['sels']);
	$tpl->display();
}


#
# EOF
#
?>

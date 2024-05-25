<?php
class TeamsNotifTask implements CmsRegularTask
{

	public function get_name()
	{
		return get_class();
	}

	public function get_description()
	{
		return 'Notification des nouvelles équipes.';
	}

   
	public function test($time = '')
	{

		// Instantiation du module
		$ping = \cms_utils::get_module('Ping');

		// Récupération de la dernière date d'exécution de la tâche
		if (!$time)
		{
			$time = time();
		}

		$last_execute = (int) $ping->GetPreference('LastRecupTeams');
		$interval = (int) $ping->GetPreference('interval_equipes');
     	

		// Définition de la périodicité de la tâche 
      	if( $time - $last_execute >= 300)// $interval)  
		{
			return TRUE; 
		}
		else
		{
			return FALSE;
		}      
	}


	public function execute($time = '')
	{
		$db = \CmsApp::get_instance()->GetDb();
		if (!$time)
		{
			$time = time();
		}

      $ping = \cms_utils::get_module('Ping');
    
		// Ce qu'il y a à exécuter ici
		$rowarray = array();	
		$last_updated = $ping->GetPreference('LastRecupTeams');
		$admin_email = $ping->GetPreference('admin_email');
	
		$query = "SELECT libequipe, libdivision, date_created FROM ".cms_db_prefix()."module_ping_equipes WHERE date_created > ?";
		$dbresult = $db->Execute($query, array($last_updated));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				
				while($row = $dbresult->FetchRow())
				{
					$onerow= new StdClass();						
					$onerow->libequipe = $row['libequipe'];						
					$onerow->libdivision = $row['libdivision'];						
					$onerow->timbre = date('d-m-Y H:i:s',$row['date_created']);
					$rowarray[]= $onerow;
				}
				$subject = "Equipes ajoutées automatiquement";
				$montpl = $ping->GetTemplateResource('liste_teams_notifs.tpl');						
				$smarty = cmsms()->GetSmarty();
				// do not assign data to the global smarty
				$tpl = $smarty->createTemplate($montpl);
				$tpl->assign('items',$rowarray);
				$tpl->assign('itemcount',count($rowarray));
				$output = $tpl->fetch();
	
				//et on envoie
				$cmsmailer = new \cms_mailer();
				$cmsmailer->reset();
				$cmsmailer->SetFrom('webmaster@agi-webconseil.fr');
				$cmsmailer->AddAddress('claude.siohan@gmail.com',$name='');
				$cmsmailer->IsHTML(true);
				$cmsmailer->SetPriority('1');
				$cmsmailer->SetBody($output);
				$cmsmailer->SetSubject($subject);
							
				if( !$cmsmailer->Send() ) 
				{			
					//$mess_ops->not_sent_emails($message_id, $recipients);
					$this->Audit('',$this->GetName(),'Problem sending email to '.$item);
				}
				return true;
			}
			else
			{
				return false;
			}
			
					
				
		}
		else
		{
			return false;
		}//maintenant on va chercher s'il y a des nouvelles réponses
						
	}  
	

	public function on_success($time = '')
	{

		if (!$time)
		{
			$time = time();
		}
      
		$ping = cms_utils::get_module('Ping');
		$ping->SetPreference('LastRecupTeams', $time);
		$ping->Audit('','Ping','Liste équipes récupérées');
		//$pong = cms_utils::get_module
      
	}

   public function on_failure($time = '')
   {
		$ping = \cms_utils::get_module('Ping');
		$ping->Audit('','Ping','Pas de notifs d\'équipes disponible');
   }

}
?>

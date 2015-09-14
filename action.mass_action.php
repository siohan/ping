<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db =& $this->GetDb();
if (isset($params['submit_massaction']) && isset($params['actiondemasse']) )
  {
     if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      	{
        	switch($params['actiondemasse'])
		{
			case "unable" :
			foreach( $params['sel'] as $licence )
	  		{
	    			ping_admin_ops::unable_player( $licence );
	  		}
			$this->SetMessage('Joueurs désactivés');
			$this->RedirectToAdminTab('joueurs');
			break;
	
			case "situation" :
			//les licences collectées sont supposées être actives
			//que fait-on si elles ne le sont pas en réalité ?
			//bonne question
			//on prend les variables nécessaires
	
			$message='Retrouvez toutes les infos dans le journal';
			foreach( $params['sel'] as $licence )
	  		{
	
	    			ping_admin_ops::retrieve_sit_mens( $licence );
	  		}
			//$message.='</ul>';
			$this->SetMessage("$message");
			$this->RedirectToAdminTab("situation");
			break;
	
			case "delete_team_result" :
			//les licences collectées sont supposées être actives
			//que fait-on si elles ne le sont pas en réalité ?
			//bonne question
			//on prend les variables nécessaires
	

			foreach( $params['sel'] as $record_id )
	  		{
	
	    			ping_admin_ops::delete_team_result( $record_id );
	  		}
			//$message.='</ul>';
	
			$this->RedirectToAdminTab("poules");
			break;
	
			case "display_on_frontend" :
	
			foreach( $params['sel'] as $id )
	  		{
	
	    			ping_admin_ops::display_on_frontend( $id );
	  		}
	
			$this->RedirectToAdminTab("poules");
			break;
	
			case "do_not_display" :
	
			foreach( $params['sel'] as $record_id )
	  		{
	
	    			ping_admin_ops::do_not_display( $record_id );
	  		}
	
			$this->RedirectToAdminTab("poules");
			break;
	
			case "fftt" :
			foreach( $params['sel'] as $journalid )
	  		{
	    			ping_admin_ops::delete_journal( $journalid );
	  		}
			break;
	
			case "spid" :
			//$saison_courante = $this->GetPreference('saison_en_cours');
			$message='Retrouvez toutes les infos dans le journal';
			foreach( $params['sel'] as $licence )
	  		{
	    			retrieve_ops::retrieve_parties_spid( $licence );
	  		}
			$this->SetMessage("$message");
			$this->RedirectToAdminTab("recup");
			break;
	
			case "fftt_parties" :
			//$saison_courante = $this->GetPreference('saison_en_cours');
			$message='Retrouvez toutes les infos dans le journal';
			foreach( $params['sel'] as $licence )
	  		{
	    			ping_admin_ops::retrieve_parties_fftt( $licence );
	  		}
			$this->SetMessage("$message");
			$this->RedirectToAdminTab("recuperation");
			break;
	
			case "coeff05" :
			foreach( $params['sel'] as $record_id)
			{
				ping_admin_ops::coeff_ops( $record_id, $coeff= '0.50' );
			}
			$this->RedirectToAdminTab('spid');
			break;
	
			case "coeff075" :
			foreach( $params['sel'] as $record_id)
			{
				ping_admin_ops::coeff_ops( $record_id, $coeff= '0.75' );
			}
			$this->RedirectToAdminTab('spid');
			break;
	
			case "coeff1" :
			foreach( $params['sel'] as $record_id)
			{
				ping_admin_ops::coeff_ops( $record_id, $coeff='1.00' );
			}
			$this->RedirectToAdminTab('spid');
			break;
	
			case "coeff125" :
			foreach( $params['sel'] as $record_id)
			{
				ping_admin_ops::coeff_ops( $record_id, $coeff='1.25');
			}
			$this->RedirectToAdminTab('spid');
			break;
	
			case "coeff15" :
			$message='Retrouvez toutes les infos dans le journal';
			foreach( $params['sel'] as $record_id)
			{
				ping_admin_ops::coeff_ops( $record_id, $coeff= '1.50' );
			}
			$this->SetMessage("$message");
			$this->RedirectToAdminTab('spid');
			break;
	
			case "supp_spid" :
			foreach( $params['sel'] as $record_id)
			{
				ping_admin_ops::supp_spid( $record_id );
			}
			$message = 'Parties(s) SPID supprimée(s)';
			$this->SetMessage("$message");
			$this->RedirectToAdminTab('spid');
			break;

	
			
			case "supp_div" :
			foreach( $params['sel'] as $record_id )
	  		{
	    			$query = "DELETE FROM ".cms_db_prefix()."module_ping_div_poules WHERE id = ?";
				$db->Execute($query, array($record_id));
	  		}
			$this->RedirectToAdminTab('joueurs');
			break;
			
			case "dater" :
				$id_sel = implode("-",$params['sel']);
				$this->Redirect($id,'dater',$returnid, array("sel"=>$id_sel));
			
			break;
			case "supp_fftt" : 
			$i = 0;
			foreach($params['sel'] as $record_id)
			{
				$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties WHERE id = ?";
				$db->Execute($query, array($record_id));
				$i++;
			}
			$message = $i." matches supprimés";
			$this->SetMessage($message);
			$this->RedirectToAdminTab('fftt');
	
      		}//fin du switch
  	}
	else
	{
		$this->SetMessage('PB de sélection de masse !!');
		$this->RedirectToAdminTab('recuperation');
	}
}
/**/
#
# EOF
#
?>
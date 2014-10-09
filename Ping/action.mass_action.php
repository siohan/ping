<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
if (isset($params['submit_massaction']) && isset($params['actiondemasse']) )
  {
     if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      {
        switch($params['actiondemasse']){
	case "unable" :
	foreach( $params['sel'] as $licence )
	  {
	    	//$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='0'  WHERE licence = ?";
		//$dbresult = $db->Execute($query, array( $licence ));
		
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
	    ping_admin_ops::retrieve_parties_spid( $licence );
	  }
	$this->SetMessage("$message");
	$this->RedirectToAdminTab("recuperation");
	break;
	case "change_coeff" :
	foreach( $params['sel'] as $record_id)
	{
		//action à définir
	}
	$this->RedirectToAdminTab('joueurs');
	break;
	case "masculin" :
	foreach( $params['sel'] as $licence )
	  {
	    ping_admin_ops::masculin( $licence );
	  }
	
	$this->RedirectToAdminTab('joueurs');
	break;
	case "feminin" :
	foreach( $params['sel'] as $licence )
	  {
	    ping_admin_ops::feminin( $licence );
	  }
	break;
		$this->RedirectToAdminTab('joueurs');
	
      }//fin du switch
  }
else
	{
		$this->SetMessage('PB !!');
		$this->RedirectToAdminTab('recuperation');
	}
}
#
# EOF
#
?>
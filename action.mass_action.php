<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
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
	
						
			case "status" :
				$id_sel = implode("-",$params['sel']);
				$this->Redirect($id,'change_status',$returnid, array("sel"=>$id_sel));
			
			break;
			case "dater2" :
				$id_sel = implode("-",$params['sel']);
				$this->Redirect($id,'dater',$returnid, array("sel"=>$id_sel,"methode"=>"tableau"));
			
			break;
			
	
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
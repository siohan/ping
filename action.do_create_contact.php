<?php
 if (!isset($gCms)) exit;
debug_display($params,'Parameters');
$db =& $this->GetDb();
$now = trim($db->DBTimeStamp(time()), "'");
$message = '';
   
   if (isset($params['cancel'])) 
	{
	$this->Redirect($id,'default', $returnid);
	}
	
	// 1 - on vérifie les champs passés
	$id_user = '';
	/*if (isset($params['id_user']))
		{
			$id_user = $params['id_user'];
		}
	*/
	$licence = '';
	if (isset ($params['licence']))
		{
			$licence = $params['licence'];
		}
	$type_contact = '';
	if (isset($params['type_contact']))
	{
	  $type_contact = $params['type_contact'];
	}
	
	if (isset($params['contact']) && !empty($params['contact']))
		{
			if($type_contact=='email'){
				if(!is_email($params['contact'])){
					$message.="L\'adresse email est incorrecte";
					$this->SetMessage("$message");
					$this->RedirectToAdminTab('joueurs');
				}
				else{
					$contact = $params['contact'];
				}
			}
			else{
				$contact = $params['contact'];
			}
		}
		else{
			//le contact est vide, c'est pas bon.
		}
		
		
	$description = '';
	if (isset ($params['description']))
		{
			$description = $params['description'];
		}
//le contact est-il déjà présent ?
//on vérifie
$query= "SELECT contact FROM ".cms_db_prefix()."module_ping_comm WHERE contact = ?";
$dbresult = $db->Execute($query, array($contact));
if($dbresult->RecordCount() >0)	{
	$message.="Contact déjà présent !";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('joueurs');
}
$query = "INSERT INTO ".cms_db_prefix()."module_ping_comm (id, datecreated, datemaj,licence, type_contact, contact, description) VALUES (?,?,?,?,?,?,?)";	
$dbresult = $db->Execute($query, array($id,$now, $now, $licence, $type_contact, $contact, $description));
if(!$dbresult){
	$message.=$db->ErrorMsg();
}
else
{
	$message.= "Contact ajouté";
}
//si le type de contact ajouté est email, on va pouvoir l'ajouter dans FEU si non déjà présent
// on va inscrire le joueur dans FEU si présent
if($type_contact=='email'){
$contact = 	
$feu = $gCms->GetModuleInstance('FrontEndUsers');
//on teste si le module est présent ou non
if(!$feu){
	$message.="Module FEU absent";
}
else {
	$name = $params['contact'];
	$contact = $params['contact'];
	//l'utilisateur existe-t-il déjà ?
	$query="SELECT * FROM ".cms_db_prefix()."module_feusers_users WHERE username = ?";
	//echo $query;
	$dbresult = $db->Execute($query, array($contact));
	//$countage = $dbresult->RecordCount();
	if($dbresult->RecordCount() == 0){
	$pseudo = 'UxzqsUIM';
	$expires = mktime(0,0,0,date("m"),date("d"),date("Y")+5);
	$do_md5 = '';
	$query = $feu->AddUser($name, $pseudo, $expires,$do_md5 = true);
	$dflt_group = $feu->GetPreference('default_group');
	$feu->Audit('',$feu->GetName(), $name);
	
	$uid = $feu->GetUserId($name);
	//$uid = $user[1];

	// set his groups.
	if( $dflt_group > 0 ) {
	 $feu->AssignUserToGroup( $uid, $dflt_group );
	}
	$message.="Nouvel utilisateur dans FEU";
	}
	else{
		$message.="Utilisateur déjà inscrit dans FEU";
	}
}//fin de l'instanciation de FEU


//on va essayer de l'inclure dans la newsletter
$nms = $gCms->GetModuleInstance('NMS');
if(!$nms){
	$message.=" Module Newsletter indisponible";
}
else{
	//le module est disponible, on va voir si l'utilisateur est déjà inscrit
	$message.=" Le module est Ok, on peut continuer";
	$query = "SELECT * FROM ".cms_db_prefix()."module_nms_users WHERE email = ?";
	$dbresult = $db->Execute($query, array($contact));
	
	if($dbresult->RecordCount()>0){
		// l'utilisateur est déjà ds NMS
		$message.="Adresse email déjà dans la newsletter";
	}
	else{
		//$message.=" On peut inclure.";
		//l'utilisateur n'est pas encore ds NMS, on l'inclut
		$email = $contact;
		$lists = array("1");
		$username = 'Top';
		$disabled = 0;
		$confirmed = 1;//on peut aussi appeler une préférence dans les options de config
		//du style, on envoie un email pour confirmer la demande ou pas
		
		$query = $nms->AddUser($email,$lists,$username,$disabled,$confirmed);
		if(!$query){
			$message.=$db->ErrorMsg();
		}
		else{
			$message.="Utilisateur ajouté à la newsletter";
		}
	}
}
}//fin du if contact = email
$this->SetMessage("$message");
$this->RedirectToAdminTab('joueurs');
	

       ?>
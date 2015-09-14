<?php
#################################################################
#    Première étape de récupération des équipes                 #
#################################################################



if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
if(!isset($club_number) && $club_number =='')
{
	$message = "Votre numéro de club n'est pas configuré !!";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
$now = trim($db->DBTimeStamp(time()), "'");
//on instancie la classe service
$service = new Servicen();
$type = '';
$result = '';
if(isset($params['type']) && $params['type'] !='')
{
	$type = $params['type'];
}

$page = "xml_equipe";
$var = "numclu=".$club_number;

	if (isset($type) && $type == '')
	{
		//$result = $service->getEquipesByClub("$club_number");
		
		$chpt = "A"; //pour autres championnat
		$type_compet = 'U';//pour undefined
		$var.="";
	}
	elseif($type =='M')
	{
		
		$type_compet = '1';
		$idepreuve = '1073';
		$var.="&type=M";
	}
	elseif($type == 'F')
	{
		$var.="&type=F";
		$type_compet = '1';
		$idepreuve = '2012';
	}
	$lien = $service->GetLink($page,$var);
	$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
	if($xml === FALSE)
	{
		$this->SetMessage("Le service est coupé");
		$this->RedirectToAdminTab('equipes');
	}
	else
	{
		$array = json_decode(json_encode((array)$xml), TRUE);
	}
//var_dump($xml);
/**/
//on va tester si la variable est bien un tableau   
	

///on initialise un compteur général $i
$i=0;
//on initialise un deuxième compteur
$compteur=0;
foreach($xml as $cle =>$tab)
{
	
	$i++;
	$libequipe = (isset($tab->libequipe)?"$tab->libequipe":"");
	$newphase = explode ("-",$libequipe);
	//echo "la phase est ".$newphase[1];
	$phase = substr($newphase[1], -1);
	$new_equipe = $newphase[0];
	//echo "la phase est ".$phase;
	
	$libdivision = (isset($tab->libdivision)?"$tab->libdivision":"");
	$liendivision = (isset($tab->liendivision)?"$tab->liendivision":"");
	$tableau = parse_str($liendivision, $output);
	//echo $tableau;
	$idpoule = $output['cx_poule'];
	$iddiv = $output['D1'];
	
	
	
	//$type_compet = $type;
	
	
	$query = "SELECT phase, saison, liendivision FROM ".cms_db_prefix()."module_ping_equipes WHERE liendivision = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($liendivision, $saison));
	
		if($dbresult  && $dbresult->RecordCount() == 0) 
		{
			//On va essayer de créer un tag pour aider à afficher les équipes
			//On récupère le mast_insert_id d'abord
			$query1 = "SHOW TABLE STATUS LIKE '".cms_db_prefix()."module_ping_equipes' ";
			$dbresult = $db->Execute($query1);
			$row = $dbresult->FetchRow();
			$record_id = $row['Auto_increment'];
			$tag = ping_admin_ops::tag_equipe($record_id);
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_equipes (id, saison, phase, libequipe, libdivision, liendivision, idpoule, iddiv, type_compet, tag) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			//echo $query;
			$compteur++;
			$dbresultat = $db->Execute($query,array($saison, $phase, $new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag));
		
			if(!$dbresultat)
			{
				$designation .= $db->ErrorMsg();			
			}

		}//fin du if $dbresult
	
	
}// fin du foreach

$designation .= "Récupération de ".$compteur." équipes";

	if($compteur >0)
	{
		$designation.="<br />Indiquez le type de compétition des équipes récupérées.";
	}
	
$status = 'Ok';
$action = 'retrieve_teams';
//ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('equipes');

#
# EOF
#

?>
<?php
if( !isset ( $gCms ) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//on vérifie les permissions d'abord
if(! $this->CheckPermission('Ping Use')) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
$error = 0;
$designation = '';
$full = '';
$record_id = '';
$lignes = 0;
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	$full = 0;
}
$saison = $this->GetPreference('saison_en_cours');
//on fait une requete générale et on affine éventuellement
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE  saison = ?";
$parms['saison'] = $saison;
if($full == 0)
{
	//on récupère ts les classements
	$query.=" AND id = ?";
	$parms['id'] = $record_id;
}
$dbresult = $db->Execute($query, $parms);

//bon tt va bien, tt est Ok
//on fait la boucle
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$iddiv = $row['iddiv'];
		$idpoule = $row['idpoule'];
		//$idequipe = $row['id']
		$service = new Servicen();
		$page = 'xml_result_equ';
		$var = "action=classement&auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$lien = $service->GetLink($page, $var);
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		if($xml === FALSE)
		{
			$this->SetMessage("Le service est coupé");
			$this->RedirectToAdminTab('equipes');
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['classement']);
		}
		//var_dump($xml);//$result = $service->getPouleClassement($iddiv, $idpoule);
		//var_dump($result);

		//on vérifie que le resultat est bien un array

		//tt va bien, on continue
		//on supprime tt ce qui était ds la bdd pour cette poule
		if($lignes > 0)
		{
			$query = "DELETE FROM ".cms_db_prefix()."module_ping_classement WHERE iddiv = ? AND idpoule= ? AND idequipe = ? AND saison = ?";
			$dbresult = $db->Execute($query, array($iddiv, $idpoule, $record_id,$saison_courante));
			$i=0;//on initialise un compteur 
			//on récupère le résultat et on fait le foreach
			foreach($xml as $cle =>$tab)
			{
				$poule = (isset($tab->poule)?"$tab->poule":"");
				$clt = (isset($tab->clt)?"$tab->clt":"");
				$equipe = (isset($tab->equipe)?"$tab->equipe":"");
				$joue = (isset($tab->joue)?"$tab->joue":"");
				$pts = (isset($tab->pts)?"$tab->pts":"");

				$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_classement (id,idequipe, saison, iddiv, idpoule, poule, clt, equipe, joue, pts) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $query2;
				$dbresultat = $db->Execute($query2, array($record_id,$saison_courante, $iddiv, $idpoule,$poule, $clt, $equipe, $joue,$pts));

				if(!$dbresultat)
				{
					$designation.= $db->ErrorMsg();
					$status = 'Ko';

				}
				else
				{
					$designation.="Récupération du classement de la poule : ".$poule;
					$status = "Ok";
				}

			}
			$action = 'getPouleclassement';
			$this->SetMessage("$designation");
			ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
			$this->SetMessage("$designation");
			$this->Redirect($id, 'admin_poules_tab3',$returnid, array("record_id"=>$record_id));
		}
		
	}
}




#
#EOF
#
?>
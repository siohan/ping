<?php
if( !isset($gCms) ) exit;
$db =& $this->GetDb();
//a faire 
if(!$this->CheckPermission('Ping Use'))
{
	$this-SetMessage('missingpermission');
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($params, 'Parameters');
//mettre les autorisations
//si pas de record_id redirection
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
$idepreuve = '';
$iddivision = '';
$direction = '';
$now = trim($db->DBTimeStamp(time()), "'");
$indivs = isset($params['indivs'])?$params['indivs']:1;
//echo "le tour est individuel ? : ".$indivs;
$error = 0; //on instancie un compteur d'erreurs


if(isset($params['all']) && $params['all'] !='')
{
	$all = $params['all'];
	//on récupère tous les tours possibles
	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_divisions WHERE saison = ? AND uploaded IS NULL";
	$dbresult = $db->Execute($query,array($saison));
	
	if($dbresult &&$dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			$idepreuve = $row['idepreuve'];
			$iddivision = $row['iddivision'];
			$service = new retrieve_ops();
			$retrieve_ops = $service->retrieve_div_tours($idepreuve,$iddivision);
		}
	}
}
else
{
	if(isset($params['idepreuve']) && $params['idepreuve'] != '')
	{
		$idepreuve = $params['idepreuve'];
	}
	else
	{
		$error++;
	}
	if(isset($params['iddivision']) && $params['iddivision'] != '')
	{
		$iddivision = $params['iddivision'];
	}
	else
	{
		$error++;
	}
	if(isset($params['direction']) && $params['direction'] != '')
	{
		$direction = $params['direction'];
	}
	else
	{
		$error++;
	}
	if(isset($params['idorga']) && $params['idorga'] != '')
	{
		$idorga = $params['idorga'];
	}
	
	
	if($error >0)
	{
		$designation.= "Paramètres manquants";
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('indivs');
	}
	
	//on instancie la classe servicen
	$service = new Servicen();

		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision;

	
			//on doit récupérer le lien du groupe depuis la FFTT


			$var.="&action=poule";

			$lien = $service->GetLink($page, $var);
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			//var_dump($xml);
			if($xml === FALSE)
			{
				//le service est coupé
				$array = 0;
				$lignes = 0;
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				$lignes = count($array['tour']);
			}
			//echo "le nb de lignes est : ".$lignes;
			foreach($xml as $value)
			{
				//$libelle = $tab['libelle'];
				//$lien = $tab['lien'];
				$i = 0; //on insère un compteur
				$libelle = htmlentities($value->libelle);
				//on va extraire le tour
				$tour1 = explode(" ",$libelle);
				$tour2 = trim($tour1[0],'T');

				$lien = htmlentities($value->lien);
				$tab1 = explode("&",$value->lien);

				$tableau = trim($tab1[2], 'cx_tableau=');

				if($tableau != '')
				{

					//On a récupéré les éléments, on peut faire l'insertion dans notre bdd
					//on va d'abord vérifier si ces éléments sont présents ou on créé un index sur la table
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_tours (id, idepreuve,iddivision,libelle, tour, tableau, lien,saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
					$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$libelle,$tour2, $tableau,$lien,$saison));
					$i++;
					//et si on continuait ?
					//reprendre les infos ci dessus pour les traiter !
					//on pourrait préparer les différents tags : poule, classement, partie.
					//on met à jour la table divisions pour dire qu'on a bien uploadé
					$uploaded = 1;
					$query2 = "UPDATE ".cms_db_prefix()."module_ping_divisions SET uploaded = ? WHERE iddivision = ? AND saison = ?";
					$dbresult2 = $db->Execute($query2, array($uploaded, $iddivision, $saison));

				}




			}
			$status = 'Ok';
			$action = 'retrieve_div_tours';
			$designation = $i." tour(s) inséré(s) pour l\'épreuve ".$idepreuve;
			ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			$designation.="Tour(s) inséré(s)";
			$this->SetMessage("$designation");
			$this->Redirect($id,'defaultadmin', $returnid);




		

		
		//on va utiliser cette variable (record_id) comme clé secondaire dans la nouvelle table



	//en fonction de la valeur de la variable action on définit différnets scénarii.



	
}



						


#
# EOF
#
//echo $this->ProcessTemplate('details_rencontre.tpl');
?>
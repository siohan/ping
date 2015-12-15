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
$indivs = isset($params['indivs'])?$params['indivs']:1;
//echo "le tour est individuel ? : ".$indivs;
$error = 0; //on instancie un compteur d'erreurs

//on vérifie que ces paramètres sont correctement renseignés

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
/*
if(isset($params['indivs']) && $params['indivs'] != '')
{
	$indivs = $params['indivs'];
}
else
{
	$error++;
}
*/
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
	
	if($direction =='tour')
	{
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

				//et si on continuait ?
				//reprendre les infos ci dessus pour les traiter !
				//on pourrait préparer les différents tags : poule, classement, partie.
				//on met à jour la table divisions pour dire qu'on a bien uploadé
				$uploaded = 1;
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_divisions SET uploaded = ? WHERE iddivision = ? AND saison = ?";
				$dbresult2 = $db->Execute($query2, array($uploaded, $iddivision, $saison));
			}




		}
		$designation.="Tour(s) inséré(s)";
		$this->SetMessage("$designation");
		$this->Redirect($id,'defaultadmin2', $returnid);




	}
	elseif($direction == 'classement')
	{
		//on récupère le classement
		$var.="&action=classement";
		$tableau = '';
		//echo $var;
		if(isset($params['tableau']) && $params['tableau'] != '')
		{
			$tableau = $params['tableau'];
			$var.="&cx_tableau=".$tableau;
			//echo $var;
		}
		else
		{
			$error++;
		}
		//echo "le tableau est : ".$tableau;
		$tour = '';
		if(isset($params['tour']) && $params['tour'] != '')
		{
			$tour = $params['tour'];
		}
		

		$lien = $service->GetLink($page,$var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//echo "<pre>".var_dump($data)."</pre>";
		//var_dump($xml);
		if($xml === FALSE)
		{
			$designation.="Pas encore de résultats disponibles";
			$this->SetMessage("$designation");
			//$this->RedirectToAdminTab('divisions');
			$this->Redirect($id,'admin_poules',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga));
		}
		
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['classement']);
		
		if($lignes == 0)
		{
			$designation.="Pas encore de résultats disponibles";
			$this->SetMessage("$designation");
			//$this->Redirect($id,'defaultadmin2',$returnid);
			$this->Redirect($id,'admin_poules',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga));
		}
		
		
		

		foreach($xml as $value)
		{
			//$libelle = $tab['libelle'];
			//$lien = $tab['lien'];
			$rang = htmlentities($value->rang);
			$nom = htmlentities($value->nom);
			$clt = htmlentities($value->clt);
			$club = htmlentities($value->club);
			
			//on fait une conditionnelle pour récupérer la licence du joueur du club
			if($club == $this->GetPreference('nom_equipes'))
			{
				//ça match !!
			}
			$points = htmlentities($value->points);

			//On a récupéré les éléments, on peut faire l'insertion dans notre bdd			
			//On fait une conditionnelle pour inclure uniquement les gens du club ?
			//il fait faire une nouvelle préférence
			
			
			
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_classement (id, idepreuve,iddivision,tableau,tour,rang, nom,clt,club,points, saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			//echo $query;
			$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$tableau,$tour,$rang, $nom, $clt, $club, $points,$saison));

			if(!$dbresult)
			{
				$designation .= $db->ErrorMsg();
			}
			else
			{
				//la requete a fonctionné. On met le classement comme uploadé
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded_classement = '1' WHERE idepreuve = ? AND iddivision = ? AND tableau = ?";
				$dbresult2 = $db->Execute($query, array($idepreuve,$iddivision,$tableau));
			}


		}
		$designation.="Classement(s) inséré(s)";
		$this->SetMessage("$designation");
		$this->Redirect($id,'admin_div_classement',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga,"essai"=>"1"));

	}
	elseif($direction == 'partie')
	{
		$var.="&action=partie";
		$tableau = '';
		
		
		if(isset($params['tableau']) && $params['tableau'] != '')
		{
			$tableau = $params['tableau'];
			$var.="&cx_tableau=".$tableau;
		}
		else
		{
			$error++;
		}
		$tour = '';
		if(isset($params['tour']) && $params['tour'] != '')
		{
			$tour = $params['tour'];
		}
		//echo $var;
		$lien = $service->GetLink($page,$var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//echo "<pre>".var_dump($data)."</pre>";
		//var_dump($xml);
		if($xml === FALSE)
		{
			$designation.="Pas encore de parties disponibles";
			$this->SetMessage("$designation");
			$this->Redirect($id,'admin_poules',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga));
		}
		
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['partie']);
		
		if($lignes == 0)
		{
			$designation.="Pas encore de parties disponibles";
			$this->SetMessage("$designation");
			//$this->Redirect($id,'defaultadmin2',$returnid);
			$this->Redirect($id,'admin_poules',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga));
		}
		
		
		foreach($xml as $value)
		{
			//$libelle = $tab['libelle'];
			//$lien = $tab['lien'];
			$libelle = htmlentities($value->libelle);
			$vain = htmlentities($value->vain);
			$perd = htmlentities($value->perd);
			$forfait = htmlentities($value->forfait);
			
			
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_div_parties (id, idepreuve,iddivision,tableau,libelle, vain,perd,forfait, saison) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?)";
			//echo $query;
			$dbresult = $db->Execute($query, array($idepreuve,$iddivision,$tableau,$libelle, $vain, $perd, $forfait,$saison));

			if(!$dbresult)
			{
				$designation .= $db->ErrorMsg();
			}
			else
			{
				//la requete a fonctionné, on peut mettre le statut du tour a "uploadé"
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded = 1 WHERE tableau = ?";
				$dbresult2 = $db->Execute($query2,array($tableau));
			}


		}
		$designation.="Partie(s) insérée(s)";
		$this->SetMessage("$designation");
		//$this->Redirect($id,'defaultadmin2',$returnid);
		$this->Redirect($id,'admin_div_parties',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga));
	}
	//on va utiliser cette variable (record_id) comme clé secondaire dans la nouvelle table



//en fonction de la valeur de la variable action on définit différnets scénarii.




						


#
# EOF
#
//echo $this->ProcessTemplate('details_rencontre.tpl');
?>
<?php
if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
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
$retrieve = new retrieve_ops;
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
	
	
	if($direction == 'classement')
	{
		//on récupère le classement
		if(isset($params['tableau']) && $params['tableau'] != '')
		{
			$tableau = $params['tableau'];
			$add_class = $retrieve->retrieve_div_classement($idepreuve, $iddivision, $tableau);
			$this->Redirect($id,'admin_div_classement',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga,"essai"=>"1"));
		}
		else
		{
			$error++;
		}
		
	
		

	}
	elseif($direction == 'partie')
	{
		$var.="&action=partie";
		$tableau = '';
		
		if(isset($params['licence']) && $params['licence'] != '')
		{
			$licence = $params['licence'];
		}
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
			$this->Redirect($id,'participants_tours',$returnid,array("idepreuve"=>$idepreuve,"licence"=>$licence));
		}
		
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['partie']);
		
		if($lignes == 0)
		{
			$designation.="Pas encore de parties disponibles";
			$this->SetMessage("$designation");
			//$this->Redirect($id,'defaultadmin2',$returnid);
			$this->Redirect($id,'participants_tours',$returnid,array("idepreuve"=>$idepreuve,"licence"=>$licence));
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
	}	//on va utiliser cette variable (record_id) comme clé secondaire dans la nouvelle table
	elseif($direction == 'tour')
	{
		
		$add_tour = $retrieve->retrieve_div_tours($idepreuve, $iddivision);
	
		$this->Redirect($id,'admin_poules',$returnid,array("idepreuve"=>$idepreuve,"iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$idorga));
	
	}
	//on va utiliser cette variable (record_id) comme clé secondaire dans la nouvelle table
	



//en fonction de la valeur de la variable action on définit différnets scénarii.




						


#
# EOF
#
//echo $this->ProcessTemplate('details_rencontre.tpl');
?>

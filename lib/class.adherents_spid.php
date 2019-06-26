<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class adherents_spid
{
  function __construct() {}


##
##





function liste_adherents_spid()
{
	global $gCms;
	$ping = cms_utils::get_module('Ping'); 
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$club_number = $ping->GetPreference('club_number');
	
	
		$page = "xml_liste_joueur_o";
		$service = new Servicen();
		//var_dump($service);
		//paramètres nécessaires 
		$var="club=".$club_number;
		$lien = $service->GetLink($page,$var);
		//var_dump( $lien );
		//var_dump($lien);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			$array = 0;
			$lignes = 0;
			return FALSE;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['joueur']);
		}
		//echo "le nb de lignes est : ".$lignes;
		if($lignes == 0)
		{
			$message = "Pas de lignes à récupérer !";
			return FALSE;
		}
		else
		{
			$i =0;//compteur pour les nouvelles inclusions
			$a = 0;//compteur pour les mises à jour
		
			foreach($xml as $tab)
			{
				//$licence = (isset($tab->licence)?"$tab->licence":"");
				$i++;
				$licence = (isset($tab->licence)?"$tab->licence":"");
				$nom = (isset( $tab->nom)?"$tab->nom":"");
				$prenom = (isset($tab->prenom)?"$tab->prenom": "");
				$nclub = (isset($tab->nclub)?"$tab->nclub":"");
				$clast = (isset($tab->clast)?"$tab->clast":"");
				$adherents = cms_utils::get_module('Adherents'); 
				
				$add = $this->ajouter_adherent_spid($genid,$licence, $nom, $prenom);
				if (true === $add && false !== $group_id)
				{
					$gp_ops->assign_user_to_group($group_id,$genid);
				}
		

			}// fin du foreach
			return TRUE;
		
		}
}//fin de la fonction
//génère un identifiant aléatoire de format integer
function random_int($car) {
	$string = "";
	$chaine = "123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
  }
function ajouter_adherent_spid ($licence,$nom, $prenom)
{
	global $gCms;
	$db = cmsms()->GetDb();
	
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_adherents (genid,licence, nom, prenom ) VALUES (?, ?, ?, ?)";
	$dbresultat = $db->Execute($query,array($genid,$licence,$nom, $prenom));
	if($dbresultat)
	{
		return true;
	}
	else
	{
		return false;
	}
	
}
function maj_adherent_spid ($licence,$nom, $prenom)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET nom = ?, prenom = ? WHERE licence = ?";
	$dbresult = $db->Execute($query, array($nom,$prenom, $licence));
	
	if($dbresult)
	{
		$this->infos_adherent_spid($licence);
	}
}

function infos_adherent_spid ($licence)
{
	global $gCms;
	$adherents = cms_utils::get_module('Adherents'); 
	$db = cmsms()->GetDb();
	$now = trim($db->DBTimeStamp(time()), "'");
	$club_number = $adherents->GetPreference('club_number');
//	var_dump($club_number);
	
		$page = "xml_licence";
		$service = new Servicen();
		//var_dump($service);
		//paramètres nécessaires 
		$var="licence=".$licence;
		$lien = $service->GetLink($page,$var);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		var_dump($xml);
		if($xml === FALSE)
		{
			$array = 0;
			
			//echo "le xml renvoie faux";
			return FALSE;
		//	$this->active_desactive($licence,$sens="0");
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			//$lignes = count($array['licence']);
		
				$i =0;//compteur pour les nouvelles inclusions
				$a = 0;//compteur pour les mises à jour
				foreach($xml as $cle=> $tab)
				{
					//$idlicence = (isset($tab->licence)?"$tab->licence":"");
					$licence = (isset($tab->licence)?"$tab->licence":"");
					$nom = (isset( $tab->nom)?"$tab->nom":"");
					$prenom = (isset($tab->prenom)?"$tab->prenom": "");
					$numclub = (isset($tab->numclub)?"$tab->numclub": "");					
					$nomclub = (isset($tab->nomclub)?"$tab->nomclub": "");
					$sexe = (isset($tab->sexe)?"$tab->sexe":"");
					$type = (isset($tab->type)?"$tab->type":"");
					$certif = (isset($tab->certif)?"$tab->certif":"");
					$validation1 = (isset($tab->validation)?"$tab->validation":"");
					$echelon = (isset($tab->echelon)?"$tab->echelon":"");
					$place = (isset($tab->place)?"$tab->place":"0");
					$point = (isset($tab->point)?"$tab->point":"");
					$cat = (isset($tab->cat)?"$tab->cat":"");
					$cat1 = substr($cat,0,1);
					$categ = $cat1.$sexe;
					//var_dump($certif);
					if($numclub != $club_number)
					{
						//echo "renvoie vide";
					
						$validation = '';
						//return false;
					}
					else
					{
						if($validation1 !='')
						{
							$validation2 = array();
							$validation2 = explode('/', $validation1);
							$validation = $validation2[2].'-'.$validation2[1].'-'.$validation2[0];	
						}
					
					}
						
						$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET sexe = ?, certif = ?, validation = ?, cat = ?, maj = NOW() WHERE licence = ?";
						//echo $query;
						$dbresult = $db->Execute($query, array($sexe, $certif,$validation, $point, $categ, $licence));
						if($dbresult)
						{
							return true;
						}
						else
						{
							return false;
						}


				}// fin du foreach

		
	}
}//fin de la fonction
//vérifie le numéro d'un club
function VerifyClub($club_number)
    {
		global $gCms;
		$db = cmsms()->GetDb();
		$now = trim($db->DBTimeStamp(time()), "'");
		$adherents = cms_utils::get_module('Adherents'); 
		$servicen = new Servicen();
		$page = "xml_club_detail";
		$var = "club=".$club_number;
		$lien = $servicen->GetLink($page,$var);
		//echo $lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		
		if($xml === FALSE)
		{
			return FALSE;
		}
		else
		{
			
			
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['club']);
			echo $lignes;
			//return TRUE;
			
			///on initialise un compteur général $i
			$i=0;
			//on initialise un deuxième compteur
			$compteur=0;

				foreach($xml as $cle =>$tab)
				{

					$i++;
					$idclub = (isset($tab->idclub)?"$tab->idclub":"");
					$numero  = (isset($tab->numero)?"$tab->numero":"");
					if($numero == $club_number)
					{
						return true;
					}
					else
					{
						return false;
					}
					
					$nom = (isset($tab->nomsalle)?"$tab->nomsalle":"");
					$this->SetPreference("nom_equipes", $nom);
					/*
					$adressesalle1 = (isset($tab->adressesalle1)?"$tab->adressesalle1":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					$libelle = (isset($tab->libelle)?"$tab->libelle":"");
					*/
				}
		}
		
    }
function maj_adherent_spid2 ($genid, $sexe, $type,$certif,$actif,$validation, $cat)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET sexe = ?, type = ?, certif = ?, validation = ?, cat = ? WHERE genid = ?";
	$dbresult = $db->Execute($query, array($sexe, $type, $certif,$validation, $cat, $genid));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function edit_adherent($fftt,$licence,$nom,$prenom,$anniversaire,$adresse, $code_postal, $ville)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET anniversaire = ?, adresse = ?, code_postal = ?, ville = ? WHERE licence = ?";
	$dbresult = $db->Execute($query, array($anniversaire,$adresse, $code_postal, $ville, $licence));
	
	
}
//ajoute un nouveau joueur
function add_adherent($fftt,$licence,$nom,$prenom,$anniversaire,$adresse, $code_postal, $ville)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_adherents_adherents (fftt,licence, nom, prenom,anniversaire, adresse, code_postal, ville) VALUES (?, ?, ?, ?,?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($fftt,$licence,$nom, $prenom,$anniversaire,$adresse, $code_postal, $ville));
}
function fe_edit_adherent($genid,$anniversaire,$adresse, $code_postal, $ville)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET anniversaire = ?, adresse = ?, code_postal = ?, ville = ? WHERE genid = ?";
	$dbresult = $db->Execute($query, array($anniversaire,$adresse, $code_postal, $ville, $genid));
}
//donne la catégorie d'un adhérent
function get_cat($genid)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT cat FROM ".cms_db_prefix()."module_adherents_adherents  WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$cat = $row['cat'];
		return $cat;
	}
	else
	{
		return FALSE;
	}
}
//récupère le nom et prénom du joueur
function get_name($genid)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$joueur = $row['joueur'];
		return $joueur;
	}
	else
	{
		return FALSE;
	}
}
function random_serie($car) {
$string = "";
$chaine = "ABCDEFGHIJKLMOPQRSTUVWXYZ0123456789";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string;
}
function maj_seq()
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents_seq SET id = LAST_INSERT_ID(id+1)";
	$dbresult = $db->Execute($query);
}
function refresh()
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT licence FROM ".cms_db_prefix()."module_adherents_adherents WHERE fftt = 1 AND (certif IS NULL OR certif = '')";
	$dbresult = $db->Execute($query);
	
	if($dbresult)
	{
		if($dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$licence = $row['licence'];
				$maj_joueurs = $this->infos_adherent_spid($licence);
			}
		}
	} 
}
function activate ($genid)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET actif = 1 WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult)
	{
		$gp_ops = new groups;
		$id_group = $gp_ops->assign_to_adherent();
		//maintenant on peut désactiver
		$gp_ops->assign_user_to_group($id_group,$genid);
	}
	
}
function desactivate ($genid)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_adherents_adherents SET actif = 0 WHERE genid = ?";
	$dbresult = $db->Execute($query, array($genid));
	if($dbresult)
	{
		$gp_ops = new groups;
		$id_group = $gp_ops->assign_to_adherent();
		//maintenant on peut désactiver
		$gp_ops->delete_user_from_group($id_group,$genid);
	}
	
}
//retourne la liste des adhérents
function liste_adherents()
{
	$db = cmsms()->GetDb();
	//on fait une requete pour completer l'input dropdown du formulaire
	$query = "SELECT genid as client_id, CONCAT_WS(' ',nom, prenom) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents WHERE actif = 1 ORDER BY nom ASC, prenom ASC";
	$dbresult = $db->Execute($query);

		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row= $dbresult->FetchRow())
			{
				$nom[$row['joueur']] = $row['client_id'];
				//$indivs = $row['indivs'];
			}
		return $nom;	
		}
	
	
	
}
//créé un choix de saison pour un dropdown de formulaire
function saison_dropdown()
{
	$saisondropdown = array();
	$an = date('Y');
	for($i = 2016; $i<=$an; $i++)
	{
		$annee1 = $i;
		$annee2 = $i+1;
		$saison = $annee1.'-'.$annee2;
		$saisondropdown[$saison]=$saison;
	}
	return $saisondropdown;
}
#
#
#
}//end of class
#
# EOF
#
?>
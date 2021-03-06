<?php
class equipes_ping
{
   function __construct() {}
//récupère tous les éléments d'une equipe de ping une équipe
   function details_equipe($record_id)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id, saison, phase, numero_equipe, libequipe, libdivision, friendlyname, liendivision, idpoule, iddiv, type_compet, tag, idepreuve, calendrier, horaire FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?"; 
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		$details = array();
		while($row = $dbresult->FetchRow())
		{
			$details['id'] = $row['id'];
			$details['saison'] = $row['saison'];
			$details['phase'] = $row['phase'];
			$details['numero_equipe'] = $row['numero_equipe'];
			$details['libequipe'] = $row['libequipe'];
			$details['libdivision'] = $row['libdivision'];
			$details['friendlyname'] = $row['friendlyname'];
			$details['liendivision'] = $row['liendivision'];
			$details['idpoule'] = $row['idpoule'];
			$details['iddiv'] = $row['iddiv'];
			$details['type_compet'] = $row['type_compet'];
			$details['idepreuve'] = $row['idepreuve'];
			$details['tag'] = $row['tag'];
			$details['calendrier'] = $row['calendrier'];
			$details['horaire'] = $row['horaire'];
		}
		return $details;
	}
	else
	{ 
		return false;
	}
}
//ajoute une équipe
function add_team($saison, $phase,$idequipe, $numero_equipe,$new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag,$idepreuve, $calendrier)
{
	$db =cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_ping_equipes (saison, phase, $idequipe,numero_equipe, libequipe, libdivision, liendivision, idpoule, iddiv, type_compet, tag, idepreuve, calendrier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query,array($saison, $phase, $idequipe, $numero_equipe,$new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag,$idepreuve, $calendrier));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function maj_idequipe ($record_id, $idequipe)
{
	$db =cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET idequipe = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($idequipe, $record_id));
}
function equipe_exists($idequipe)
{
	//$query = "SELECT count(*) FROM ".cms_db_prefix()."module_ping_equipes WHERE idequipe";
}
//modifie une équipe
function update_team($record_id, $friendlyname, $horaire)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET friendlyname = ?, horaire = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($friendlyname, $horaire, $record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
// supprime une équipe
function delete_team($record_id)
   {
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?"; 
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
   }
   function delete_classement ($record_id)
   {
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_classement WHERE idequipe = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
   }
   
    function add_classement ($idequipe, $saison, $iddiv, $idpoule, $poule, $clt, $equipe, $joue, $pts, $totvic, $totdef, $numero, $idclub, $vic, $def, $nul, $pf, $pg, $pp, $num_equipe)
   	{
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_classement (idequipe, saison, iddiv, idpoule, poule, clt, equipe, joue, pts, totvic, totdef, numero, idclub, vic, def, nul, pf, pg, pp, num_equipe) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($idequipe,$saison, $iddiv, $idpoule,$poule, $clt, $equipe, $joue,$pts, $totvic, $totdef, $numero, $idclub, $vic, $def, $nul, $pf, $pg, $pp, $num_equipe));
		if($dbresult)
		{
			return true;
		}
		else
		{
			return false;
		}
   }
   
   function maj_class($record_id)
   {
   		$db = cmsms()->GetDb();
   		$query = "UPDATE ".cms_db_prefix()."module_ping_equipes SET maj_class = UNIX_TIMESTAMP() WHERE id = ?";
   		$dbresult = $db->Execute($query, array($record_id));
   	}
   
function del_poule_rencontres($record_id)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv = ? AND idpoule = ? AND saison = ?";
	$dbresult = $db->Execute($query, array($iddiv,$idpoule,$saison));
}
function add_team_result($record_id,$renc_id,$saison,$idpoule, $iddiv, $club, $affichage, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve,$horaire, $equip_id1, $equip_id2)
{
	$db = cmsms()->GetDb();
	$uploaded = 0;
	$query = "INSERT IGNORE INTO ".cms_db_prefix()."module_ping_poules_rencontres (eq_id,renc_id,saison,idpoule, iddiv, club, affiche, tour, date_event, uploaded, libelle, equa, equb, scorea, scoreb, lien, idepreuve, horaire, equip_id1, equip_id2) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	//$query = "UPDATE ".cms_db_prefix()."module_ping_poule_rencontres";
	$dbresult = $db->Execute($query,array($record_id,$renc_id,$saison,$idpoule, $iddiv, $club, $affichage, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve, $horaire,$equip_id1, $equip_id2));

	if($dbresult)
	{
		return true;
	}
	else
	{
		return $db->ErrorMsg();;
	}
}

function update_team_result($saison, $idpoule, $iddiv, $club, $affichage, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve, $horaire, $equip_id1, $equip_id2, $renc_id)
{
	$db = cmsms()->GetDb();
	$uploaded = 0;
	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET  saison = ?, idpoule = ?, iddiv = ?, club = ?, affiche = ?, tour = ?, date_event = ?, uploaded = ?, libelle = ?, equa = ?, equb = ?, scorea = ?, scoreb = ?, lien = ?, idepreuve = ?, horaire = ?, equip_id1 = ?, equip_id2 = ? WHERE renc_id = ?";
	//$query = "UPDATE ".cms_db_prefix()."module_ping_poule_rencontres";
	$dbresult = $db->Execute($query,array($saison, $idpoule, $iddiv, $club, $affichage, $tour, $date_event, $uploaded, $libelle, $equa, $equb, $scorea, $scoreb, $lien, $idepreuve, $horaire, $equip_id1, $equip_id2, $renc_id));

	if($dbresult)
	{
		return true;
	}
	else
	{
		return $db->ErrorMsg();;
	}
}

 function renc_exists($renc_id)
 {
 	$db = cmsms()->GetDb();
 	$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";//SELECT count(*) FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";
 	$dbresult = $db->Execute($query, array($renc_id));
 	$row = $dbresult->FetchRow();
	$renc_id = $row['renc_id'];
	return $renc_id;
 }
 
 //cherche le numéro de club d'une équipe
 function idclub($record_id)
 {
 	$db = cmsms()->GetDb();
 	$query = "SELECT idclub FROM ".cms_db_prefix()."module_ping_classement WHERE num_equipe = ? LIMIT 1";
 	$dbresult = $db->Execute($query, array($record_id));
 	if($dbresult)
 	{
 		if($dbresult->RecordCount() >0)
 		{
 			$row = $dbresult->FetchRow();
 			$idclub = $row['idclub'];
 			return $idclub;
 		}
 		else
 		{
 			return false;
 		}
 	}
 	else
 	{
 		return false;
 	}
 }
// Cherche et retourne le logo d'une équipe s'il existe
 function has_image($record_id)
 {
 	$eq = $eq_ops->idclub($record_id);//eq1 = le numéro du club
    var_dump($eq);
	$img= '';
	$dir = 'modules/Ping/images/logos/';

	$ext_list = array('.gif', '.jpg', '.png','.jpeg');
				
	foreach($ext_list as $ext)
	{
		if(true == file_exists($dir.$eq.$ext))
		{
			$img = $eq.$ext;
		}
	}
	return $img;
 }
//change l'horaire habituel des rencontres d'une équipe, le record_id est le numéro de l'équipe en bdd
function change_horaire($record_id,$hor)
	{
		$db = cmsms()->GetDb();
		$query="UPDATE ".cms_db_prefix()."module_ping_equipes SET  horaire = ? WHERE id = ?";
		$dbresult = $db->Execute($query, array($hor, $record_id));
		if($dbresult)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		} 
 
	}
} // end of class

#
# EOF
#
?>

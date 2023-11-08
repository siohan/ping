<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class brulage_ping
{
	function __construct() {}
	
	
	//détermine si les joueurs du club sont en A ou W
	function joueur_en_a($renc_id)
	{
		$db= cmsms()->GetDb();
		$query = "SELECT xja, xjb FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ? LIMIT 1";
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				
				while($row = $dbresult->FetchRow())
				{
					$sideA = $this->is_our_player($row['xja']);					
					if(false == $sideA)
					{
						$side = "W";
						//$sideA = $this->is_our_player($row['xjb']);
					}
					else
					{
						$side = "A";
					}
					return $side;					
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return NULL;
		}
	}
	//détermine si le joueur est joueur du club
	function is_our_player($nom_complet)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE ?  LIKE CONCAT_WS(' ', nom,prenom)";//(licence = ? AND ref_action = ?";
		$dbresult = $db->Execute($query, array($nom_complet));
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				$row = $dbresult->FetchRow();
				$licence = $row['licence'];
				
					return $licence;
			}
			else
			{
				return FALSE;
			}	
				
		}
	}
	
	function has_played ($renc_id, $side)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		////on extrait les données du renc_id : saison, journée
		$renc_id = (int) $renc_id;
		
		$ren_ops = new rencontres;
		$eq_ping = new equipes_ping;
		$details_renc = $ren_ops->details_rencontre($renc_id);
		
		$journee = $details_renc['tour'];
		$eq_id = $details_renc['eq_id'];
		$details_eq = $eq_ping->details_equipe($eq_id);
		$numero_equipe = $details_eq['numero_equipe'];
		//on déduit la journee pour savoir quelle colonne modifier
		
		
		if($side == 'A')
		{
			$query = "SELECT xja AS nom_complet FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
		}
		else
		{
			$query = "SELECT xjb AS nom_complet FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
		}
		
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			
				while($row = $dbresult->FetchRow())
				{
					$licence = $this->is_our_player($row['nom_complet']);
					
					//on a la licence on peut donc insérer le joueur
					if(!false == $licence)
					{
						//maintenant on peut lister la table
						$this->add_brul_eq($licence,$numero_equipe);										
					}
				}
							
		}
		
	}
	//vérifie si le joueur est déjà ds la table brulage
	function is_already_there($licence, $ref_action)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_brulage WHERE licence = ? AND renc_id = ?";
		$dbresult = $db->Execute($query, array($licence, $ref_action));
		if($dbresult)
		{
			// la requete fonctionne ! Ouf !
			//des résultats ?
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
			if($nb >0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	//ajoute un joueur dans la table brulage
	function insert_all_players($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = 1 AND type = 'T'";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$liste_equipes = $this->liste_equipes($idepreuve);
				$this->add_player_brul_eq($row['licence'], $idepreuve);
			}
		}
	}
	
	//insère uniquement les féminines
	function insert_all_f($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = 1 AND type = 'T' AND sexe ='F'";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$liste_equipes = $this->liste_equipes($idepreuve);
				$this->add_player_brul_eq($row['licence'],$idepreuve);
			}
		}
	}
	
	function add_player_brul_eq($licence, $idepreuve)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$liste_equipes = $this->liste_equipes($idepreuve);
		$value = 0;
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_brul_eq ";//(genid, eq1, eq2, eq3, eq4) VALUES (?,?,?,?,?)";
		$query.="(licence";
		for($i=1;$i<=$liste_equipes;$i++)
		{
			$eq = 'eq'.$i;
			$query.=", $eq";
		}
		$query.=" )";	
		$query.=" VALUES (?";
		for($i=1;$i<=$liste_equipes;$i++)
		{
			
			$query.=", 0";
		}
		$query.=" );";	
		echo $query;
		$dbresult = $db->Execute($query, array($licence));
	}
	
	
	function player_exists_brul($licence)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_brul_eq WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
		if($dbresult)
		{
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
			if($nb >0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	function raz_brul_eq($licence)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$liste_equipes = $this->liste_equipes();
		foreach($liste_equipes as $value)
		{
			$colonne = 'eq'.$value;
			$def_value = 0;
			$query = "UPDATE ".cms_db_prefix()."module_ping_brul_eq SET $colonne = ?  WHERE licence = ?";
			$dbresult = $db->Execute($query, array($def_value, $licence));
		}
			
	}
	
	
	// insère les données d'une journée (licence, epreuve, J1,J2,...) dans la table brulage
	//c'est une modif
	function brulage($renc_id)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$details = $this->details_rencontre($renc_id);
		$journee = $details['journee'];
		$eq_id = $details['id'];
		$details_eq = $this->details_equipe($eq_id);
		
		$query = "SELECT cp.genid, cp.ref_action, eq.ref_equipe, cp.genid FROM ".cms_db_prefix()."module_compositions_compos_equipes AS cp, ".cms_db_prefix()."module_compositions_equipes AS eq WHERE cp.ref_equipe = eq.ref_equipe AND cp.ref_action = ? ORDER BY eq.numero_equipe ASC";
		$dbresult = $db->Execute($query, array($ref_action));
		if($dbresult)
		{
			
			if($dbresult->RecordCount()>0)
			{
				//on récupère la journée, la saison, l'équipe aussi
				
				//on déduit la journee pour savoir quelle colonne modifier
				$colonne = 'J'.$journee;
				
				//on peut faire la boucle
				while($row = $dbresult->FetchRow())
				{
					$licence = $row['genid'];
					$numero_equipe = $row['ref_equipe'];
					$equipe = 'eq'.$numero_equipe;
					
					$player_exists = $this->player_exists($licence);
					if(true === $player_exists)
					{
						$query2 = "UPDATE ".cms_db_prefix()."module_ping_brulage SET $colonne = ? WHERE licence = ?";
						$dbresult2 = $db->Execute($query2, array($numero_equipe, $licence));
					}
					else
					{
						
						$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_brulage (licence, $colonne) VALUES (?, ?)";
						$dbresult2 = $db->Execute($query2, array($licence, $numero_equipe));
						
					}
										
				}
			}
		}
		else
		{
			echo $db->ErrorMsg();
		}
		
		
	}
	//retourne le nb d'équipes concernées
	function liste_equipes($idepreuve)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$ping = \cms_utils::get_module('Ping');
		
		$phase = $ping->GetPreference ('phase_en_cours');
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_equipes WHERE idepreuve = ? AND phase = ?";
		$dbresult = $db->Execute($query, array($idepreuve, $phase));
		$row = $dbresult->FetchRow();
		$nb = $row['nb'];
		return $nb;
		
	}
	function add_brul_eq($licence, $ref_equipe)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$colonne = 'eq'.$ref_equipe;
		$query="UPDATE ".cms_db_prefix()."module_ping_brul_eq SET $colonne = $colonne+1 WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));
	}
	function create_table($idepreuve)
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$liste_equipes = $this->liste_equipes($idepreuve);
		$query = "CREATE TABLE ".cms_db_prefix()."module_ping_brul_eq (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, licence VARCHAR (15)";
		for($i=1;$i<=$liste_equipes;$i++)
		{
			$eq = 'eq'.$i;
			$query.=", $eq INT(2)";
		}
		$query.=" );";	
		$dbresult = $db->Execute($query);
	}
	
	function drop_table()
	{
		global $gCms;
		$db= cmsms()->GetDb();
		$query = "DROP TABLE IF EXISTS ".cms_db_prefix()."module_ping_brul_eq";
		$dbresult = $db->Execute($query);
	}
	
}

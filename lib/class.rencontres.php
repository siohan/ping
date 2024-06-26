<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id: News.module.php 2114 2005-11-04 21:51:13Z wishy $

class rencontres
{
   function __construct() {}
   
   //les détails d'une rencontre
   function details_rencontre($renc_id)
   {
   		$db = cmsms()->GetDb();
   		$details = array();
   		$query = "SELECT id, eq_id, renc_id, saison, idpoule, iddiv, club, tour, date_event, affiche, uploaded, libelle, equa, equb, scorea, scoreb, lien, idepreuve, countdown, horaire FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";
   		$dbresult = $db->Execute($query, array($renc_id));
   		if ($dbresult && $dbresult->RecordCount()>0)
   		{
   			while($row = $dbresult->FetchRow())
   			{
   				$details['id'] = $row['id'];
   				$details['eq_id'] = $row['eq_id'];
   				$details['renc_id'] = $row['renc_id'];
   				$details['saison'] = $row['saison'];
   				$details['idpoule'] = $row['idpoule'];
   				$details['iddiv'] = $row['iddiv'];
   				$details['club'] = $row['club'];
   				$details['tour'] = $row['tour'];
   				$details['date_event'] = $row['date_event'];
   				$details['affiche'] = $row['affiche'];
   				$details['uploaded'] = $row['uploaded'];
   				$details['libelle'] = $row['libelle'];
   				$details['equa'] = $row['equa'];
   				$details['equb'] = $row['equb'];
   				$details['scorea'] = $row['scorea'];
   				$details['scoreb'] = $row['scoreb'];
   				$details['lien'] = $row['lien'];
   				$details['idepreuve'] = $row['idepreuve'];
   				$details['countdown'] = $row['countdown'];
   				$details['horaire'] = $row['horaire'];
   			}
   			return $details;
   		}
   }
   
   //modifie une rencontre
   function edit_rencontre($renc_id, $club, $tour, $date_event, $affiche, $uploaded,$equa, $equb, $scorea, $scoreb, $idepreuve, $countdown, $horaire)
   {
   		$db = cmsms()->GetDb();
   		$details = array();
   		$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET club = ?, tour = ?, date_event = ?, affiche = ?, uploaded = ?, equa = ?, equb = ?, scorea = ?, scoreb = ?, idepreuve = ?, countdown = ?, horaire = ? WHERE renc_id = ?";
   		$dbresult = $db->Execute($query, array($club, $tour, $date_event, $affiche, $uploaded,$equa, $equb, $scorea, $scoreb, $idepreuve, $countdown, $horaire, $renc_id));
   		if($dbresult)
   		{
			return true;
		}
		else
		{
			return false;
		}
   	}
   //retourne la feuille de rencontre et les parties 
   function feuille_parties($renc_id)
    {
    	$db = cmsms()->GetDb();
    	$service = new Servicen();
    	$ping_ops = new ping_admin_ops;
    	$details = $this->details_rencontre($renc_id);
    	$link = $details['lien'];
		$page = "xml_chp_renc";
		$error = 0;//un compteur d'erreur pour indiquer false or true
		$lien = $service->GetLink($page, $link);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		if($xml === FALSE)
		{
			//le service est coupé
			$array = 0;
			$lignes = 0;
			$status = 'Ko';
			$designation = 'Ko :'.$details['equa'].' - '.$details['equb'];
			$action = 'feuille_parties'; 
			$ping_ops->ecrirejournal($status, $designation,$action);
			return false;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['resultat']);
			//$array['joueur'] = array();
			if($lignes >0)
			{
				$lignes_joueurs = count($array['joueur']);
			}
			else
			{
				$lignes_joueurs = 0;
			}
		}

			if(!is_array($array) || $lignes == 0 || $lignes_joueurs == 0)
			{ 

				//le tableau est vide, il faut envoyer un message pour le signaler
				$status = 'Ko';
				$designation = 'infos inexistantes :'.$details['equa'].' - '.$details['equb'];
				$action = 'feuille_parties'; 
				$ping_ops->ecrirejournal($status, $designation,$action);
				return false;
			}   
			else
			{
				//on essaie de faire qqs calculs
				$tableau1 = array();
				$tab2 = array();
				$compteur = count($array['joueur']);
				$compteur_parties = count($array['partie']);
	
				//on scinde le tableau principal en plusieurs tableaux ?
				$tab1 = array_slice($array,0,1);
				$tab2 = array_slice($array,1,1);
				$tab3 = array_slice($array,2,1);
				
				$i=0;
				$a=0;
				$error = 0;
					for($i=0;$i<$compteur;$i++)
					{
						//la feuille de rencontre...
						$xja = 'xja'.$i;//ex : $xja = 'xja0';
						$xca = 'xca'.$i; //on met aussi le classement du joueurex : xca0, xca1,xca2, etc...
						$xjb = 'xjb'.$i;//ex : $xja = 'xja0';
						$xcb = 'xcb'.$i;
						$$xja = $tab2['joueur'][$i]['xja'];//ex : $xja0 = '';
						$$xca = $tab2['joueur'][$i]['xca'];
						$$xjb = $tab2['joueur'][$i]['xjb'];//ex : $xja0 = '';
						$$xcb = $tab2['joueur'][$i]['xcb'];
						//on insère le tout dans la bdd
						$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_feuilles_rencontres ( fk_id, xja, xca, xjb, xcb) VALUES ( ?, ?, ?, ?, ?)";
						$dbresult3 = $db->Execute($query3, array($renc_id, $$xja,$$xca,$$xjb,$$xcb));
					}
					
					for($i=0;$i<$compteur_parties;$i++)
					{
						//on s'occupe maintenant des parties
						$ja = 'ja'.$i;
						$scorea = 'scoreA'.$i;
						$jb = 'jb'.$i;
						$scoreb = 'scoreB'.$i;
						$detail = 'detail'.$i;
						$$ja = $tab3['partie'][$i]['ja'];
						$$scorea = $tab3['partie'][$i]['scorea'];
						$$jb = $tab3['partie'][$i]['jb'];
						$$scoreb = $tab3['partie'][$i]['scoreb'];
						$$detail = $tab3['partie'][$i]['detail'];
						//on insère aussi dans la bdd
						if($$scorea == '-')
						{
							$$scorea = 0;
						}
						if($$scoreb == '-')
						{
							$$scoreb = 0;
						}
						$query4 = "INSERT INTO ".cms_db_prefix()."module_ping_rencontres_parties ( fk_id, joueurA, scoreA, joueurB, scoreB, detail) VALUES ( ?, ?, ?, ?, ?, ?)";
						$dbresult4 = $db->Execute($query4, array($renc_id, $$ja,$$scorea, $$jb, $$scoreb, $$detail));
								
					}
					
			}
					
    }	
	//détermine si le club joue en A ou B
	function club_en_A($renc_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT fk_id, joueurA FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ? LIMIT 1";
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$joueur = $row['joueurA'];
			$joueur_club = $this->est_joueur_du_club($joueur);
			if(FALSE === $joueur_club)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
	function we_results($renc_id, $side)
	{
		global $gCms;
		$db = cmsms()->GetDb();
		////on extrait les données du renc_id : saison, journée
		$renc_id = (int) $renc_id;
		
		$ren_ops = new rencontres;
		$eq_ping = new equipes_ping;
		$details_renc = $ren_ops->details_rencontre($renc_id);
		$idepreuve = $details_renc['idepreuve'];
		$journee = $details_renc['tour'];
		$eq_id = $details_renc['eq_id'];
		$details_eq = $eq_ping->details_equipe($eq_id);
		$numero_equipe = $details_eq['numero_equipe'];
		//on déduit la journee pour savoir quelle colonne modifier
		
		
		if($side == 'A')
		{
			$query = "SELECT joueurA AS nom_complet, scoreA AS score, joueurB,  FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ?";
		}
		else
		{
			$query = "SELECT joueurB AS nom_complet, scoreB AS score, joueurA FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
		}
		
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			
				while($row = $dbresult->FetchRow())
				{
					$licence = $this->est_joueur_du_club($row['nom_complet']);//on récupère la licence du joueur du club
					
					//on a la licence on peut donc insérer le joueur
					if(!false == $licence)
					{
						//maintenant on peut lister la table
						$player_exists = $this->renc_id_player_exists($licence, $renc_id);
						if( false == $player_exists)
						{
							$victoires = $nb_parties = 0;
							$details = '';
							$this->add_we_results($licence,$journee,$renc_id,$idepreuve,$numero_equipe,$victoires, $nb_parties,$details);
							//maintenant on peut lister la feuille de rencontre
						}
						$this->update_we_results($renc_id, $licence, $row['score']);							
					}
				}
							
		}
		
	}
	
	function add_we_results($licence,$journee, $renc_id,$idepreuve,$numero_equipe,$victoires, $nb_parties,$details)
	{
		$db = cmsms()->GetDb();
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_we_results (licence, tour, renc_id, idepreuve, numero_equipe, victoires, nb_parties, details) VALUES  (?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array( $licence,$journee, $renc_id,$idepreuve,$numero_equipe,$victoires, $nb_parties,$details));
	}
	
	function update_we_results($renc_id, $licence, $score)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_we_results SET victoires = victoires + ?, nb_parties = nb_parties+1 WHERE licence = ? AND renc_id = ?";
		$dbresult = $db->Execute($query, array($score, $licence, $renc_id));
	}
	
	//détermine si un joueur est déjà dans cette rencontre (et faire un update)
	function renc_id_player_exists($licence, $renc_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_we_results WHERE licence = ? AND renc_id = ?";
		$dbresult = $db->Execute($query, array($licence, $renc_id));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$nb = $row['nb'];
			if($nb >0)
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	//détermine quel joueur
	function est_joueur_du_club($joueur)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT licence, CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE CONCAT_WS(' ',nom, prenom) = ?";
		//echo $query2;
		$dbresult = $db->Execute($query, array($joueur));
		if($dbresult)
		{
		
			if($dbresult->RecordCount()>0)
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
		else
		{
			//une erreur de requete
		}
	}
	
	
	
	//cette fonction va chercher le dernier match (renc_id) d'une equipe à afficher (pour xibo)
	public function derniere_rencontre($libequipe,$iddiv, $idpoule)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event <= NOW() AND iddiv = ? AND idpoule = ? AND (equa LIKE ? OR equb LIKE ?) ORDER BY date_event DESC LIMIT 1";
		$dbresult = $db->Execute($query, array($iddiv, $idpoule, $libequipe,$libequipe ));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			$row = $dbresult->FetchRow();
			$renc_id = $row['renc_id'];
			return $renc_id;
		}
		else
		{
			return FALSE;
		}
	}
	//cette fonction va chercher les équipes et le score du dernier match d'une equipe à afficher (pour xibo)
	public function rencontre_score_adversaires($renc_id)
	{
		$db = cmsms()->GetDb();
		$res = array();
		$query = "SELECT equa, equb, scorea, scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE renc_id = ?";
		$dbresult = $db->Execute($query, array($renc_id ));
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$res[] = $row['equa'];
				$res[] = $row['equb'];
				$res[] = $row['scorea'];
				$res[] = $row['scoreb'];
				return $res;
				
			}
			
		}
		else
		{
			return FALSE;
		}
	}
	//Met à uploadé une rencontre
	function is_uploaded($renc_id)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET uploaded = 1 WHERE renc_id = ?";
		$dbresult = $db->Execute($query, array($renc_id));
		if($dbresult && $dbresult->recordCount() >0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function last_round ($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT DISTINCT tour FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event < CURRENT_DATE() AND idepreuve = ? ORDER BY tour DESC LIMIT 1";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$tour = $row['tour'];
			}
			return $tour;
		}
		else
		{
			return false;
		}		
	}
	
	//trouve la prochaine journée
	function next_round ($idepreuve)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT DISTINCT tour FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event >= CURRENT_DATE() AND idepreuve = ? ORDER BY tour ASC LIMIT 1";
		$dbresult = $db->Execute($query, array($idepreuve));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				$tour = $row['tour'];
			}
			return $tour;
		}
		else
		{
			return false;
		}		
	}
	//trouve la prochaine journée pour une équipe
	function next_match ($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT date_event, equa, equb, renc_id, horaire, idepreuve, equip_id1, equip_id2, tour FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE eq_id = ? AND club = 1 AND affiche = 1 AND date_event >= CURRENT_DATE() ORDER BY tour ASC LIMIT 1";
		
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			if($dbresult->RecordCount()>0)
			{
				$data = array();
				while($row = $dbresult->FetchRow())
				{
					$data['eq_id'] = $record_id;
					$data['date_event'] = $row['date_event'];
					$data['equa'] = $row['equa'];
					$data['equb'] = $row['equb'];
					$data['renc_id'] = $row['renc_id'];
					$data['horaire'] = $row['horaire'];
					$data['idepreuve'] = $row['idepreuve'];
					$data['equip_id1'] = $row['equip_id1'];
					$data['equip_id2'] = $row['equip_id2'];
					$data['tour'] = $row['tour'];
					if($row['equa'] == '' || $row['equb'] == '')
					{
						return false;
					}
					else
					{
						return $data;
						
					}
				}
				
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
	//trouve la dernière journée pour une équipe
	
	function last_match ($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT date_event, equa, equb, renc_id, horaire, scorea, scoreb, uploaded, idepreuve, equip_id1, equip_id2, saison, tour, club, affiche FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE eq_id = ? AND club = 1 AND affiche = 1 AND date_event <= CURRENT_DATE() ORDER BY tour DESC LIMIT 1";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$data = array();
			while($row = $dbresult->FetchRow())
			{
				$data['eq_id'] = $record_id;
				$data['date_event'] = $row['date_event'];
				$data['equa'] = $row['equa'];
				$data['equb'] = $row['equb'];
				$data['renc_id'] = $row['renc_id'];
				$data['horaire'] = $row['horaire'];
				$data['idepreuve'] = $row['idepreuve'];
				$data['scorea'] = $row['scorea'];
				$data['scoreb'] = $row['scoreb'];
				$data['equip_id1'] = $row['equip_id1'];
				$data['equip_id2'] = $row['equip_id2'];
				$data['uploaded'] = $row['uploaded'];
				$data['saison'] = $row['saison'];
				$data['tour'] = $row['tour'];
				$data['club'] = $row['club'];
				$data['affiche'] = $row['affiche'];
			}
			return $data;
		}
		else
		{
			return false;
		}		
	}
	
	//modifie les horaires de rencontre pour la poule d'une équipe
	function update_fixture($record_id, $horaire)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET horaire = ? WHERE eq_id = ?";
		$dbresult = $db->Execute($query, array($horaire, $record_id));
		
	}
	
	//supprime toutes les rencontres d'une poule
	function delete_team_matches($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE eq_id = ?";
		$dbresult = $db->Execute($query, array($record_id));
	}
	//indique si un résultat a vraiment été uploadé
	function is_really_uploaded($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "SELECT COUNT(*) AS nb FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult)
		{
			if( $dbresult->RecordCount()>0)
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
		else
		{
			return false;
		} 
		
	}
	//met le statut de la rencontre à nontéléchargé
	function not_uploaded($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "UPDATE  ".cms_db_prefix()."module_ping_poules_rencontres SET uploaded = 0 WHERE renc_id = ?";
		$dbresult = $db->Execute($query, array($record_id));
	}
	
	function delete_details_rencontre($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_feuilles_rencontres WHERE fk_id = ?";
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
	 function countdown_ok($record_id)
 {
 	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET countdown = 1 WHERE renc_id = ?";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
 } 
 
 function countdown_ko($record_id)
 {
 	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET countdown = 0 WHERE renc_id = ?";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
 } 
 
  function affiche_ok($record_id)
 {
 	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET affiche = 1 WHERE renc_id = ?";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
 } 
 
 function affiche_ko($record_id)
 {
 	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET affiche = 0 WHERE renc_id = ?";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
 } 
	function delete_rencontre_parties($record_id)
	{
		$db = cmsms()->GetDb();
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_rencontres_parties WHERE fk_id = ?";
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
//Change la date et l'heure d'une rencontre	
	function change_date_event($record_id,$new_date,$hor)
	{
		$db = cmsms()->GetDb();
		$query="UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET date_event = ?, horaire = ? WHERE renc_id = ?";
		$dbresult = $db->Execute($query, array($new_date, $hor, $record_id));
		
	}
	
	//vérifie si une équipe est bien présente dans une poule sinon va chercher toutes les rencontres
	function poule_exists($record_id)
	{
		$db = cmsms()->GetDb();
		$query="SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE eq_id = ?";
		$dbresult = $db->Execute($query, array($record_id));
	}
	
	//retourne le nb d'items de resultats pour les scores
	function nb_items_scores($saison, $phase, $idepreuve)
	{
		$db = cmsms()->GetDb();
		$parms = array();
		$query = "SELECT count(*) AS nb_items FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ?";
		
			$parms['saison'] = $saison;
			$parms['phase'] = $phase;
			
			//on détermine s'il s'agit d'un tableau (avec présence virgule) ou pas
			//il faut aussi supprimer la phase présente dans l'argument de l'épreuve(-1 ou -2)
			if(false !== strstr( $idepreuve,","))
			{
		
				//var_dump($params['idepreuve']);
		
				$tab = explode(',', $idepreuve);
		
				$epreuve = array();
				foreach($tab as $value)
				{
					
					$epreuve[] = strstr($value,'-',true);
					
					
				}
				
				$query.= " AND idepreuve IN (".implode(',',$epreuve).")";
			}
			else
			{
				$epreuve = explode('-', $idepreuve);
				$query.= " AND idepreuve = ?";
				$parms['idepreuve'] = $epreuve[0];//$params['idepreuve'];
			}
		$dbresult = $db->Execute($query, $parms);
		if($dbresult)
		{
			if($dbresult->RecordCount() >0)
			{
				while($row = $dbresult->FetchRow())
				{
					$nb_items = $row['nb_items'];
				}
				
			}
			else
			{
				$nb_items = 1;
			}
		}
		else
		{
			$nb_items = 2;
		}
		return $nb_items;
		
	}
	
	//retourne le nb de prochaines rencontres
	
	function nb_items_affiche( $phase, $idepreuve)
	{
		$db = cmsms()->GetDb();
		$parms = array();
		$query = "SELECT count(*) AS nb_items2 FROM ".cms_db_prefix()."module_ping_equipes WHERE phase = ?"; //saison LIKE ? AND phase = ? ";
		//$parms['saison'] = $saison;			
		$parms['phase'] = $phase;			
		
		//on détermine s'il s'agit d'un tableau (avec présence virgule) ou pas
		//il faut aussi supprimer la phase (-1 ou -2)
		if(false !== strstr( $idepreuve,","))
		{
			
			$tab = explode(',', $idepreuve);
			
			$epreuve = array();
			foreach($tab as $value)
			{
				$epreuve[] = strstr($value,'-',true);							
			}
			
			$query.= " AND idepreuve IN (".implode(',',$epreuve).")";
		}
		else
		{
			$epreuve = explode('-', $idepreuve);
			$query.= " AND idepreuve = ?";
			$parms['idepreuve'] = trim($idepreuve);
			//$parms['idepreuve'] = $epreuve[0];
		}
		
		$dbresult = $db->Execute($query,$parms);
					
			if($dbresult)
			{
				if($dbresult->RecordCount() >0)
				{
					while($row = $dbresult->FetchRow())
					{
						$nb_items = $row['nb_items2'];
					}
					
				}
				else
				{
					$nb_items = 0;
				}
			}
			else
			{
				$nb_items = 0;
			}
			return $nb_items;			
		
	}



	
}//end of class
?>

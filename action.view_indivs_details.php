<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Ping Use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('rencontres');
}

	$db = cmsms()->GetDb();
	global $themeObject;
	$anniversaire = date('Y-m-d');
	$now  = time();
	$passe_sanitaire = 0;
	$liste_sexe = array("M"=>"Masculin", "F"=>"Féminin");
	$edit = 0;
	$actif = 0;
	if(isset($params['record_id']) && $params['record_id'])//c'estl'id de l'épreuve
	{
		$record_id = (int)$params['record_id'];
		$ep = new EpreuvesIndivs;
		
		$club = $ep->nom_club();		
		$nclub="%".$club."%";
		$smarty->assign('club', $nclub);
		
		$details = $ep->details_epreuve($record_id);
		//var_dump($details);
		$edit = 1;
		$id = $details['id'];
   		$name = $details['name'];
   		$friendlyname = $details['friendlyname'];
   		$code_compet = $details['code_compet'];
   		$coefficient = $details['coefficient'];
   		$indivs = $details['indivs'];
   		$tag = $details['tag'];
   		$idepreuve = $details['idepreuve'];
   		$idorga = $details['idorga'];
   		$actif = $details['actif'];	
   		$suivi = $details['suivi'];
   		$last_tour = $ep->last_tour($record_id);
   		$smarty->assign('last_tour', $last_tour);
   		$smarty->assign('now', $now);
   		$smarty->assign('compet', $friendlyname);
   		$smarty->assign('tag', $tag);
	}
	/**/
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_is_active.tpl'), null, null, $smarty);	
	$tpl->assign('idepreuve', $idepreuve);
	$tpl->assign('idorga', $idorga);
	$tpl->assign('id', $id);
	$tpl->assign('actif', $actif);
	$tpl->display();
	/**/
	//pour savoir si on supprime définitivement l'utilisateur
/**/
	
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_is_tradi.tpl'), null, null, $smarty);	
	$tpl->assign('idepreuve', $idepreuve);
	$tpl->assign('id', $id);
	$tpl->assign('suivi', $suivi);
	$tpl->display();
	

	//Pour les groupes
	$i = 0;
	$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		while($row = $dbresult->FetchRow())
		{
			$nb = $row['nb'];
		}
	}
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_divisions.tpl'), null, null, $smarty);
	$tpl->assign('idepreuve', $idepreuve);
	$tpl->assign('idorga', $idorga);
	$tpl->assign('id', $id);
	$tpl->assign('nb', $nb);
	$tpl->display();
	$nb_tours = (int) $ep->nb_tours($idepreuve);
	
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_tours.tpl'), null, null, $smarty);
	$tpl->assign('idepreuve', $idepreuve);
	$tpl->assign('idorga', $idorga);
	$tpl->assign('id', $id);
	$tpl->assign('nb', $nb_tours);
	$tpl->display();
	
	$query = "SELECT count(DISTINCT tableau) AS nb FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult)
	{
		while($row = $dbresult->FetchRow())
		{
			$nb = $row['nb'];
		}
	}
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_classements.tpl'), null, null, $smarty);
	$tpl->assign('idepreuve', $idepreuve);
	$tpl->assign('idorga', $idorga);
	$tpl->assign('id', $id);
	$tpl->assign('nb', $nb);
	$tpl->display();
	
/**/	
	 //pour les contacts

	
	$rowarray = array();		
	$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? AND club LIKE ?";
	$dbresult = $db->Execute($query, array($record_id, $nclub));
	
	if($dbresult && $dbresult->RecordCount() >0)
	{		
		while($row = $dbresult->FetchRow())
		{
			$nb_joueurs = $row['nb'];
		}
		
	}
	
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_joueurs.tpl'), null, null, $smarty);
	$tpl->assign('idepreuve', $idepreuve);
	$tpl->assign('idorga', $idorga);
	$tpl->assign('id', $id);
	$tpl->assign('nb', $nb_joueurs);
	$tpl->display();
/*	
//on instancie un compteur pour indiquer la propriété last pour les blocs
$compt = 0;	
	
	if($this->GetPreference('pann_images') == 1)
	{
		$compt++;
		
		//pour la photo représentant le membre
		//on vérifie si un fichier existe déjà
		$img_exists = $as_adh->has_image($record_id);
		$separator = ".";
		$img = '';
		if(!false == $img_exists)
		{

			$myimage = $config['root_url']."/uploads/images/trombines/".$genid.$separator.$img_exists;
			$img = '<img src="'.$myimage.'" alt="ma trombine">';
		}	


		$tpl = $smarty->CreateTemplate( $this->GetTemplateResource('upload_image.tpl'), null, null, $smarty );
		$tpl->assign('genid',$genid);
		$tpl->assign('extension',$img_exists);
		$tpl->assign('separator', $separator);
		$tpl->assign('photo', $img);
		$valeur = $compt/3;
		if(true == is_int( $valeur))
		{
			$tpl->assign('last', true);
		}
		$tpl->display();
	}
	
	//pour le module FEU compte et appartenance aux groupes
	$adh_feu = new AdherentsFeu;
	$mod = \cms_utils::get_module('MAMS');
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_feu_account.tpl'), null, null, $smarty);
	$i = 0;//le compteur
	$activation = false;//le module non activé par défaut
	$autorisation = true;//$this->CheckPermission('Cotisations use');
	$has_email = $cont_ops->has_email($genid);
	if(true == $has_email)
	{
		$last_logged = $adh_feu->last_logged($feu_id);
		$smarty->assign('last_logged', $last_logged);
	}

	if( is_object( $mod) )
	{
		
		$compt++;
		if($checked == 1){$activation = true;}else{$activation=false;}
		$tpl->assign('genid', $genid);
		//le membre a un compte
		$tpl->assign('has_feu_account', $has_feu_account);
		$tpl->assign('has_email', $has_email);
		
				
	}
	$valeur = $compt/3;
	if(true == is_int( $valeur))
	{
		$tpl->assign('last', true);
	}
	$tpl->assign('activation', $activation);
	$tpl->assign('autorisation', $autorisation);
	$tpl->assign('compteur', $i);
	$tpl->display();
	
	
	//pour les cotisations si le module est chargé
	
	
	$module = \cms_utils::get_module('Cotisations');
	
	$i = 0;//le compteur
	$activation = false;//le module non activé par défaut
	$autorisation = $this->CheckPermission('Cotisations use');
	
	if( is_object( $module ) && $this->GetPreference('pann_cotisations') == 1)
	{
		$compt++;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_cotiz_groups.tpl'), null, null, $smarty);
		$cotis_ops = new cotisationsbis;
		if($checked == 1){$activation = true;}else{$activation=false;}
		$query = "SELECT id, nom FROM ".cms_db_prefix()."module_cotisations_types_cotisations WHERE actif = 1";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$pay_ops = new paiementsbis;
			$tpl->assign('liste_groups', $liste_groups);
			$tpl->assign('genid', $record_id);

			while($row = $dbresult->FetchRow())
			{
				$i++;
				$tpl->assign('nom_gp_'.$i, $row['nom']);
				$tpl->assign('id_group_'.$i, $row['id']);
				$participe = $cotis_ops->belongs_exists($genid, $row['id']);
				if(true == $participe)
				{
					$tpl->assign('check_'.$i, true);
				}
				$masque = 'Cotiz_'.$record_id.'_'.$row['id'];
				$reglement = $cotis_ops->is_cotis_paid($masque);
				
				if(true == $reglement)
				{
					$tpl->assign('unremovable_'.$i, true);
				}

			}
		}
		$tpl->assign('activation', $activation);
		$tpl->assign('autorisation', $autorisation);
		$tpl->assign('compteur', $i);
		$valeur = $compt/3;
		if(true == is_int( $valeur))
		{
			$tpl->assign('last', true);
		}
		$tpl->display();		
	}
	
	
	
	
	//pour les commandes si le module est chargé
	
	
	$module = \cms_utils::get_module('Commandes');
	if( is_object( $module ) && $this->GetPreference('pann_commandes') == 1)
	{
		$compt++;
		
	
		$com_ops = new commandes_ops;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_user_commandes.tpl'), null, null, $smarty);
		$i = 0;//le compteur
		if($checked == 1){$activation = true;}else{$activation=false;}//le module non activé par défaut
		$autorisation = $this->CheckPermission('Use Commandes');
		//$liste_statuts = $com_ops->liste_statuts();
		$liste_statuts = array("Non commandés"=>"0", "Commandés"=>"1", "Reçus"=>"2");
		if( is_object( $module ) )
		{
			$activation = true;
			$rowarray = array();
			$query = "SELECT count(*) AS nb, commande FROM ".cms_db_prefix()."module_commandes_cc_items WHERE genid = ? GROUP BY commande";
			$dbresult = $db->Execute($query, array($record_id));
			if($dbresult && $dbresult->RecordCount() >0)
			{
				while($row = $dbresult->FetchRow())
				{

					//var_dump($stat);
					$onerow = new StdClass;
					//$onerow->statut = $com_ops->status($row['commande']);
					$onerow->nb = $row['nb'];
					$rowarray[]= $onerow;
				}
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);		
		}
		$valeur = $compt/3;
		if(true == is_int( $valeur))
		{
			$tpl->assign('last', true);
		}
		$tpl->assign('activation', $activation);
		$tpl->assign('autorisation', $autorisation);
		$tpl->assign('liste_statuts', $liste_statuts);
		$tpl->display();
	}
	
	
	
	//pour les paiements si le module est chargé
	
	
	$module = \cms_utils::get_module('Paiements');
	
	$i = 0;//le compteur
	if($checked == 1){$activation = true;}else{$activation=false;}//le module non activé par défaut
	$autorisation = $this->CheckPermission('Paiements use');
	
	
	if( is_object( $module ) )//&& $this->GetPreference('pann_factures') == "1")
	{
		$compt++;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_user_paiements.tpl'), null, null, $smarty);
		$pay_ops = new paiementsbis;
		if($checked == 1){$activation = true;}else{$activation=false;}
		$rowarray = array();
		$query = "SELECT ref_action, date_created, tarif, nom FROM ".cms_db_prefix()."module_paiements_produits WHERE licence =  ? AND regle = 0";
		$dbresult = $db->Execute($query, array($record_id));
		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row = $dbresult->FetchRow())
			{
				
				$onerow = new StdClass;
				$onerow->ref_action = $row['ref_action'];
				$onerow->tarif = $row['tarif'];
				$onerow->nom = $row['nom'];
				$rowarray[]= $onerow;
			}
		}
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
		
		$valeur = $compt/3;
		if(true == is_int( $valeur))
		{
			$tpl->assign('last', true);
		}
		$tpl->assign('activation', $activation);
		$tpl->assign('autorisation', $autorisation);

		$tpl->display();
			
	}
	
	
	
	
	//Pour les inscriptions si le module est chargé
	
	
	$module = \cms_utils::get_module('Inscriptions');
	
	
	$activation = false;//le module non activé par défaut
	$autorisation = $this->CheckPermission('Inscriptions use');
	$message = '';
	
	if( is_object( $module ) && $this->GetPreference('pann_inscriptions') == 1)
	{
		$compt++;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_user_inscriptions.tpl'), null, null, $smarty);
		$insc_ops = new T2t_inscriptions;
		if($checked == 1){$activation = true;}else{$activation=false;}
		$rowarray = array();
	
		if(is_array($details_groups) && count($details_groups) > 0 )
		{
			$tab = implode(', ',$details_groups);	
			$query = "SELECT id, nom FROM ".cms_db_prefix()."module_inscriptions_inscriptions WHERE actif = 1 AND date_limite >= UNIX_TIMESTAMP()  AND groupe IN ($tab)";
			$dbresult = $db->Execute($query);
			if($dbresult && $dbresult->RecordCount() >0)
			{
				while($row = $dbresult->FetchRow())
				{

					$onerow = new StdClass;
					$onerow->nom = $row['nom'];
					$onerow->participe = $insc_ops->is_inscrit($row['id'], $genid);
					$onerow->id_inscription = $row['id'];
					$onerow->genid = $genid;
					$rowarray[]= $onerow;
				}
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);
		}
		else
		{
			$message = "Le membre ne fait partie d'aucun groupe";
		}
		
		$tpl->assign('error_message', $message);
		$valeur = $compt/3;
		if(true == is_int( $valeur))
		{
			$tpl->assign('last', true);
		}
		$tpl->assign('activation', $activation);
		$tpl->assign('autorisation', $autorisation);

		$tpl->display();	
	}
	

	
	
	//Pour les présences si le module est chargé
	
	
	$module = \cms_utils::get_module('Presence');
	
	
	$activation = false;//le module non activé par défaut
	$autorisation = $this->CheckPermission('Presence use');
	$message = '';
	
	if( is_object( $module ) && $this->GetPreference('pann_presences') == 1)
	{
		$compt++;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_user_presences.tpl'), null, null, $smarty);
		$pres_ops = new T2t_presence;
		if($checked == 1){$activation = true;}else{$activation=false;}
		$rowarray = array();
	
		if(is_array($details_groups) && count($details_groups) > 0 )
		{
			$tab = implode(', ',$details_groups);	
			$query = "SELECT id, nom FROM ".cms_db_prefix()."module_presence_presence WHERE actif = 1 AND date_limite > NOW() AND groupe IN ($tab)";
			$dbresult = $db->Execute($query);
			if($dbresult && $dbresult->RecordCount() >0)
			{
				while($row = $dbresult->FetchRow())
				{

					$onerow = new StdClass;
					$onerow->nom = $row['nom'];
					$onerow->participe = $pres_ops->has_expressed($row['id'], $genid);
					$onerow->id_presence = $row['id'];
					$onerow->genid = $genid;
					$rowarray[]= $onerow;
				}
			}
			$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
			$smarty->assign('itemcount', count($rowarray));
			$smarty->assign('items', $rowarray);
		}
		else
		{
			$message = "Le membre ne fait partie d'aucun groupe";
		}
		
		$tpl->assign('error_message', $message);
	$valeur = $compt/3;
	if(true == is_int( $valeur))
	{
		$tpl->assign('last', true);
	}
	$tpl->assign('activation', $activation);
	$tpl->assign('autorisation', $autorisation);
	
	$tpl->display();	
	}
	
	
	//pour générer une attestation si besoin
	$module = \cms_utils::get_module('Cotisations');
	if( is_object( $module ) )
	{
		$cg_ops = \cms_utils::get_module('CMSMSExt');
		$retourid = $this->GetPreference('pageid_subscription');
		$page = $cg_ops->resolve_alias_or_id($retourid);
		$lien = $this->create_url($id,'default',$page, array("display"=>"attestation", "genid"=>$record_id));	
		
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('feu_envoi_attestation.tpl'), null, null, $smarty);
		$i = 0;//le compteur
		
		$autorisation = true;
		
		$has_email = $cont_ops->has_email($genid);
		if(true == $has_email)
		{
			$last_logged = $adh_feu->last_logged($feu_id);
			$smarty->assign('last_logged', $last_logged);
		}
			$cot_ops= new cotisationsbis;
			$paid = $cot_ops->are_all_paid($record_id);
		
			$smarty->assign('paid', $paid);
		
			$compt++;
			
			$tpl->assign('genid', $genid);
			$tpl->assign('has_email', $has_email);
			$tpl->assign('lien', $lien);
			
					
		
		$valeur = $compt/3;
		if(true == is_int( $valeur))
		{
			$tpl->assign('last', true);
		}
		$tpl->assign('activation', $activation);
		$tpl->assign('autorisation', $autorisation);
		$tpl->assign('compteur', $i);
		$tpl->display();
	}
	*/
	
#
#EOF
#
?>

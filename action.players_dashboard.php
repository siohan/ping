<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Ping use'))
{
	$designation .=$this->Lang('needpermission');
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
}

	$db = cmsms()->GetDb();
	global $themeObject;
	$anniversaire = date('Y-m-d');
	$liste_sexe = array("M"=>"Masculin", "F"=>"Féminin");
	$edit = 0;
	
		// les groupes auxquels il fait partie
		$gp_ops = new groups;
		$details_groups	= $gp_ops->member_of_groups($record_id);
		//var_dump($details_groups);
		$liste_groups = $gp_ops->liste_groupes_dropdown();
	
	}
	
	//on prépare une navigation
	
	
	//Pour les groupes
	
	$query = "SELECT id, nom FROM ".cms_db_prefix()."module_adherents_groupes WHERE actif = 1";
	$dbresult = $db->Execute($query);
	if($dbresult && $dbresult->RecordCount() >0)
	{
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_list_groups.tpl'), null, null, $smarty);
		$tpl->assign('liste_groups', $liste_groups);
		$tpl->assign('genid', $record_id);
		$i = 0;
		while($row = $dbresult->FetchRow())
		{
			$i++;
			$tpl->assign('nom_gp_'.$i, $row['nom']);
			$tpl->assign('id_group_'.$i, $row['id']);
			$participe = $gp_ops->is_member($genid, $row['id']);
			if(true == $participe)
			{
				$tpl->assign('check_'.$i, true);
			}
			
		}
	}
	
	$tpl->assign('compteur', $i);
	$tpl->display();
	
	
	 //pour les contacts

	
	$rowarray = array();		
	$query = "SELECT id,contact, description FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult && $dbresult->RecordCount() >0)
	{		
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->contact =  $row['contact'];
			$onerow->description =  $row['description'];
			$onerow->id =  $row['id'];
			$rowarray[]= $onerow;
		}
		
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
	$smarty->assign('genid', $record_id);
	echo $this->ProcessTemplate('view_contacts.tpl');
	
//on instancie un compteur pour indiquer la propriété last pour les blocs
$compt = 0;	
	
	if($this->GetPreference('images') == 1)
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
	$mod = \cms_utils::get_module('FrontEndUsers');
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_feu_account.tpl'), null, null, $smarty);
	$i = 0;//le compteur
	$activation = false;//le module non activé par défaut
	$autorisation = true;//$this->CheckPermission('Cotisations use');
	
	if( is_object( $mod) )
	{
		
		$compt++;
		$activation = true;
		$tpl->assign('genid', $genid);
		/*
		$user_exists = $adh_feu->GetUserInfoByProperty('genid', $genid);
		*/
		$uid = $adh_feu->GetUserInfoByProperty($genid);
		if($uid >0)
		{
			//le membre a un compte
			$tpl->assign('has_feu_account', true);
		}
		else
		{
			$tpl->assign('has_feu_account', false);
		}
				
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
		$activation = true;
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
		$activation = false;//le module non activé par défaut
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
					$onerow->statut = $com_ops->status($row['commande']);
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
	$activation = false;//le module non activé par défaut
	$autorisation = $this->CheckPermission('Paiements use');
	
	
	if( is_object( $module ) && $this->GetPreference('pann_factures') == 1)
	{
		$compt++;
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('view_user_paiements.tpl'), null, null, $smarty);
		$pay_ops = new paiementsbis;
		$activation = true;
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
		$activation = true;
		$rowarray = array();
	
		if(is_array($details_groups) && count($details_groups) > 0 )
		{
			$tab = implode(', ',$details_groups);	
			$query = "SELECT id, nom FROM ".cms_db_prefix()."module_inscriptions_inscriptions WHERE actif = 1 AND date_limite < UNIX_TIMESTAMP() AND groupe IN ($tab)";
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
		$activation = true;
		$rowarray = array();
	
		if(is_array($details_groups) && count($details_groups) > 0 )
		{
			$tab = implode(', ',$details_groups);	
			$query = "SELECT id, nom FROM ".cms_db_prefix()."module_presence_presence WHERE actif = 1 AND date_limite < NOW() AND groupe IN ($tab)";
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
	
#
#EOF
#
?>
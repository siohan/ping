<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params,'Parameters');
$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$annee_courante = date('Y');
//echo "l'année courante est : ".$annee_courante;

/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_situation_mensuelle_tab')); 
$saisonslist[$this->lang('allseasons')] ='';
$monthslist[$this->Lang('allmonths')] = '';
//$monthslist = array("Tous les mois"=>"","Juillet"=>"7", "Août"=>"8");
$yearslist = array("2014"=>"2014");
$tourlist[$this->Lang('alltours')] = '';
$equipelist[$this->Lang('allequipes')] = '';
$playerslist[$this->Lang('allplayers')] = '';
$typeCompet = array();
$typeCompet[$this->Lang('allcompet')] = '';
$query = "SELECT pts.mois ,j.licence, CONCAT_WS(' ',j.nom, j.prenom) AS player FROM ".cms_db_prefix()."module_ping_sit_mens AS pts  , ".cms_db_prefix()."module_ping_joueurs AS j WHERE pts.licence  = j.licence AND j.actif = '1' ORDER BY j.nom ASC";
$dbresultat = $db->Execute($query);
while ($dbresultat && $row = $dbresultat->FetchRow())
  {
    	
    	$playerslist[$row['player']] = $row['licence'];
	$monthslist[$row['mois']] = $row['mois'];
    	
  }

	if( isset($params['submitfilter']) )
  	{
    		if( isset( $params['monthslist']) )
      		{
			$this->SetPreference('moisChoisi', $params['monthslist']);
      		}
		if( isset( $params['playerslist']) )
      		{
			$this->SetPreference('playerChoisi', $params['playerslist']);
      		}
	}
	
$curmonth = $this->GetPreference('moisChoisi');
//$curtour = $this->GetPreference( 'tourChoisi' );
//$curseason = $this->GetPreference('saisonChoisie');
$curplayer = $this->GetPreference( 'playerChoisi');
$curequipe = $this->GetPreference( 'equipeChoisie' );
//$curCompet = $this->GetPreference( 'competChoisie');

$smarty->assign('prompt_tour',
		$this->Lang('tour'));
/*
$smarty->assign('input_tour',
		$this->CreateInputDropdown($id,'tourlist',$tourlist,-1,$curtour));
		*/
$smarty->assign('input_month',
		$this->CreateInputDropdown($id,'monthslist',$monthslist,-1,$curmonth));
$smarty->assign('prompt_equipe',
		$this->Lang('equipe'));		
$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompet,-1,$curCompet));
$smarty->assign('input_player',
		$this->CreateInputDropdown($id,'playerslist',$playerslist,-1,$curplayer));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());



$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
//$action = (empty($_POST['action'])) ? 'default' : $_POST['action'];

//$mois_pref =$this->SetPreference('defaultMonthSitMens', '6');

$mois_pref = $this->GetPreference('defaultMonthSitMens');
//echo "le mois pref est : ".$mois_pref;
//$mois = (!empty($mois_pref)) ? $mois_pref : $mois_courant;
//echo "le mois retenu est : ".$mois;

$result= array ();
$query2 = "SELECT *, j.licence,sm.id,sm.mois,sm.points, sm.annee, CONCAT_WS(' ', j.nom, j.prenom) AS joueur, sm.progmois, sm.clnat, sm.rangreg, sm.rangdep  FROM ".cms_db_prefix()."module_ping_joueurs AS j LEFT JOIN ".cms_db_prefix()."module_ping_sit_mens AS sm ON j.licence = sm.licence WHERE j.actif = '1' ";//AND (sm.annee = ? OR sm.annee IS NULL) ";
//$parms['annee'] = $annee_courante;
//echo $query;

	if( isset($params['submitfilter'] ))
	{
	
		if($curmonth !='')
		{
		
			$query2 .=" AND (sm.mois = ? OR sm.mois IS NULL) ";
			$parms['mois'] = $curmonth;
		}
	
		if ($curplayer !='')
		{
			$query2 .=" AND j.licence = ?";
			$parms['licence'] = $curplayer;
		
		}
		
		$query2 .=" ORDER BY joueur ASC";
		$dbresult= $db->Execute($query2,$parms);
	
	}
	else
	{
		$query2 .="AND (sm.annee = ? OR sm.annee IS NULL)  ORDER BY joueur ASC";
		$dbresult= $db->Execute($query2,array($annee_courante));
	}//fin du submit filter
	
//$query2.="  AND (sm.annee = ? OR sm.annee IS NULL) ";
//$parms['annee'] = $annee_courante;


//echo $query2;

	if (!$dbresult)
	{

		echo "FATAL SQL ERROR: ".$db->ErrorMsg()."<br/>QUERY2: ".$db->sql;
		echo "pb req !";
		$designation = $db->ErrorMsg();
		echo "$designation";

	}



$rowclass= 'row1';
$rowarray= array ();

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
    		while ($row= $dbresult->FetchRow())
      		{
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id= $row['id'];
			$onerow->licence= $row['licence'];
			$onerow->mois= $row['mois'];
			$onerow->annee= $row['annee'];
			$onerow->points= $row['points'];
			$onerow->clnat= $row['clnat'];
			$onerow->rangreg= $row['rangreg'];
			$onerow->rangdep= $row['rangdep'];
			$onerow->progmois= $row['progmois'];
			//$onerow->equipe= $this->createLink($id, 'viewsteamresult', $returnid, $row['equipe'],array('equipe'=>$row['equipe']),$row) ;
			$onerow->joueur= $row['joueur'];
			$onerow->id= $this->CreateLink($id, 'edit_joueurs', $returnid, $row['id'],array('record_id'=>$row['id']), $row);
			$onerow->editlink= $this->CreateLink($id, 'add_sit_mens', $returnid, $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('add-manually'), '', '', 'systemicon'),array('licence'=>$row['licence']));
			$onerow->sitmenslink= $this->CreateLink($id, 'retrieve_sit_mens', $returnid, 'Situation mensuelle', array('licence'=>$row['licence']));
			$onerow->getpartieslink= $this->CreateLink($id, 'retrieve_parties', $returnid, 'Parties disputées', array('licence'=>$row['licence']));
			$onerow->deletelink= $this->CreateLink($id, 'delete_sit_mens', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_confirm'));
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
      		}
  	}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('addallsitmenslink',
				$this->CreateLink($id,'add_all_sit_mens', $returnid, 'Ajouter toutes situations mensuelles'));
$smarty->assign('missing_sit_mens', 
		$this->CreateLink($id, 'missing_sit_mens', $returnid, 'Les situations manquantes'));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Désactiver"=>"unable","Récupérer situation mensuelle"=>"situation");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
				  

echo $this->ProcessTemplate('allsitmens.tpl');


#
# EOF
#
?>
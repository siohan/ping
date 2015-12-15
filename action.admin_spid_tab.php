<?php
if( !isset($gCms) ) exit;
##############################################################
#              SPID                                          #
##############################################################
//	debug_display($params, 'Parameters');

require_once(dirname(__FILE__).'/function.calculs.php');
$saison = $this->GetPreference('saison_en_cours');

$db =& $this->GetDb();
global $themeObject;

/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin','', 'post', '',false,'',array('active_tab'=>'spid')));
//$smarty->assign('formstart',$this->CreateFormStart($id,'admin_spid_tab'));
$error_only = '';
$dateList = array();
$dateList = array("Tous les mois"=>"","Septembre"=>"9","Octobre"=>"10","Novembre"=>"11", "Décembre"=>"12","Janvier"=>"1","Février"=>"2","Mars"=>"3","Avril"=>"4","Mai"=>5,"Juin"=>"6");
//$datelist[$this->Lang('alltours')] = '';
//$datelist[]
$equipelist[$this->Lang('allequipes')] = '';
$playerslist[$this->Lang('allplayers')] = '';
$typeCompet = array();
$typeCompet[$this->Lang('allcompet')] = '';
$query = "SELECT pts.epreuve, pts.date_event, j.licence,pts.numjourn , CONCAT_WS(' ',j.nom, j.prenom) AS player FROM ".cms_db_prefix()."module_ping_parties_spid AS pts  , ".cms_db_prefix()."module_ping_joueurs AS j WHERE pts.licence  = j.licence AND pts.saison = ? ORDER BY pts.date_event ASC,player ASC, pts.numjourn ASC";//"";
//echo $query;
$dbresult = $db->Execute($query, array($saison));
while ($dbresult && $row = $dbresult->FetchRow())
  {
    	//$datelist[$row['date_event']] = $row['date_event'];
    	$playerslist[$row['player']] = $row['licence'];
	$typeCompet[$row['epreuve']] = $row['epreuve'];
  }
/*
if( isset($params['submitfilter']) )
  {
    	if( isset( $params['datelist']) )
      	{
		$this->SetPreference('dateChoisi', $params['datelist']);
      	}
	if( isset( $params['playerslist']) )
      	{
		$this->SetPreference('playerChoisi', $params['playerslist']);
      	}
        if( isset( $params['typeCompet']) )
	{ 
		$this->SetPreference ( 'competChoisie', $params['typeCompet']);
	}
}
$curdate = $this->GetPreference( 'dateChoisi' );
$curplayer = $this->GetPreference( 'playerChoisi');
$curCompet = $this->GetPreference( 'competChoisie');
*/
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_date',
		$this->CreateInputDropdown($id,'dateList',$dateList,-1,(!empty($params['dateList'])?$params['dateList']:"")));		
$smarty->assign('input_compet',
		$this->CreateInputDropdown($id,'typeCompet',$typeCompet,-1,(!empty($params['typeCompet'])?$params['typeCompet']:"")));
$smarty->assign('input_player',
		$this->CreateInputDropdown($id,'playerslist',$playerslist,-1,$curplayer));
$smarty->assign('input_error_only',
		$this->CreateInputCheckbox($id,'error_only',1,0));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());

$result= array ();
$parms = array();
$query2 = "SELECT sp.id AS record_id,CONCAT_WS(' ',j.nom, j.prenom) AS joueur, sp.date_event, sp.epreuve, sp.nom AS name, sp.classement, sp.victoire, sp.ecart, sp.coeff, sp.pointres, sp.forfait FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_parties_spid AS sp  WHERE j.licence = sp.licence AND sp.saison = ? ";//"  GROUP BY joueur,type_compet ORDER BY joueur,type_compet";

$parms['saison'] = $saison;

if( isset($params['submitfilter'] ))
{
	if (isset( $params['dateList']) && $params['dateList'] !='')
	{
		$query2.=" AND MONTH(sp.date_event) = ? ";
		$parms['date_event'] = $params['dateList'];
		
	}

	if ($curplayer !='')
	{
		$query2.=" AND sp.licence = ?";
		$parms['licence'] = $curplayer;
		
	}
	if( isset( $params['typeCompet']) && $params['typeCompet'] !='' )
	{ 
		//$this->SetPreference ( 'competChoisie', $params['typeCompet']);
		$query2.=" AND sp.epreuve LIKE ?";
		$parms['epreuve'] = $params['typeCompet'];
	}
	/*
	if ($curCompet !='')
	{
		$query2.=" AND sp.epreuve = ?";
		$parms['epreuve'] = $curCompet;
	}
	*/
	if(isset($params['error_only']) && $params['error_only'] !='')
	{
		$query2.=" AND sp.classement = -sp.ecart ";
	}
	$query2.=" ORDER BY joueur ASC, sp.date_event ASC";
}
else
{
	$query2.=" ORDER BY joueur ASC, sp.date_event ASC LIMIT 100";
}






$dbresult2= $db->Execute($query2, $parms);
//echo $query2;
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult2 && $dbresult2->RecordCount() > 0)
  {
    while ($row= $dbresult2->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->record_id= $row['record_id'];
	$onerow->joueur= $row['joueur'];//$this->CreateLink($id, 'view_user_results', $returnid, $row['joueur'],array('joueur'=>$row['joueur']),$row) ;
	$onerow->date_event= $row['date_event'];
	$onerow->epreuve= $row['epreuve'];
	$onerow->name= $row['name'];
	$onerow->classement= $row['classement'];
	$onerow->victoire= $row['victoire'];
	$onerow->ecart= $row['ecart'];
	$onerow->coeff= $row['coeff'];
	$onerow->pointres= $row['pointres'];
	$onerow->forfait= $row['forfait'];
	$onerow->editlink= $this->CreateLink($id, 'edit_player_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['record_id']));
	$onerow->duplicatelink= $this->CreateLink($id, 'do_edit_result', $returnid, $themeObject->DisplayImage('icons/system/copy.gif', $this->Lang('duplicate'), '', '', 'systemicon'), array('record_id'=>$row['record_id'], 'duplicate'=>'1'));
	
	if($this->CheckPermission('Ping Delete'))
	{
		$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['record_id'], "type_compet"=>"spid"), $this->Lang('delete_confirm'));
	}
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
/**/
$smarty->assign('cron_spid_fftt', 
		$this->CreateLink($id, 'cron_spid_fftt', $returnid, 'Vérif Spid <-> FFTT'));
$smarty->assign('verif_spid_fftt', 
		$this->CreateLink($id, 'verif_spid_fftt', $returnid, 'Vérif Spid <-> FFTT'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
/*
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));

$smarty->assign('retrieve_all', 
		$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid,
				$themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('long_import'), '', '', 'systemicon')).
				$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid, 
								  $this->Lang('retrieveallpartiesspid'), 
								  array()));
*/
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Mettre le Coeff à 0,5"=>"coeff05","Mettre le Coeff à 0,75"=>"coeff075","Mettre le Coeff à 1"=>"coeff1","Mettre le Coeff à 1,25"=>"coeff125","Mettre le Coeff à 1,5"=>"coeff15", "Récupérer situation mensuelle"=>"situation","Supprimer"=>"supp_spid");

$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

			
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
/**/
echo $this->ProcessTemplate('spid.tpl');


#
# EOF
#
?>
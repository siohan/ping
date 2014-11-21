<?php

if( !isset($gCms) ) exit;
/**/
	if (isset($params['submit_massdelete']) )
  	{
     		if( isset($params['sel']) && is_array($params['sel']) && count($params['sel']) > 0 )
      		{
        		foreach( $params['sel'] as $journalid )
	  		{
	    			ping_admin_ops::delete_journal( $journalid );
	  		}
      		}
  	}
/**/

$db =& $this->GetDb();
global $themeObject;
$maintenant = date("Y-m-d");
//liste des liens pour récupérer les données 
$smarty->assign('retrieve_users',
		$this->CreateLink($id, 'retrieve_joueurs_by_club', $returnid, $contents = "Récupération des joueurs", $warn_message = "Etes vous sûr ? Trop d'appels vers la base de données peuvent avoir des conséquences importantes !"));
$smarty->assign('retrieve_teams',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes (championnat seniors)", array('type'=>'M')));
$smarty->assign('retrieve_teams_autres',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes"));
$smarty->assign('retrieve_all_parties',
		$this->CreateLink($id, 'retrieve_all_parties', $returnid, $contents = "Récupération de toutes les parties FFTT"));
$smarty->assign('recup_joueurs',
		$this->CreateLink($id, 'recup_joueurs', $returnid));
$smarty->assign('retrieve_all_spid',
		$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid, $contents = 'Récupérations de toutes les parties SPID', $warn_message = 'Etes vous sûr ?'));
$smarty->assign('retrieve_details_rencontres',
		$this->CreateLink($id, 'retrieve_club', $returnid, $contents = 'Récupérations du détail des rencontres'));

/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_data_tab')); 
$statuslist[$this->lang('allstatus')] ='';
$datelist[$this->Lang('alldates')] = '';
$typeCompet = array();
//$typeCompet[$this->Lang('allcompet')] = '';
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_recup";
$dbresult = $db->Execute($query);
while ($dbresult && $row = $dbresult->FetchRow())
	{
		setlocale (LC_TIME, 'fr_FR'); 
		//$datelist[$row['datecreated']] = strftime("%A %e %B %Y à %H:%M:%S",strtotime($row['datecreated']));
		$datelist[$row['datecreated']] = $row['datecreated']; 
		// $playerslist[$row['player']] = $row['licence'];
		$statuslist[$row['status']] = $row['status'];
		//$equipelist[$row['equipe']] = $row['equipe'];
		//$typeCompet[$row['codechamp']] = $row['codechamp'];
	}

			if( isset($params['submitfilter']) )
		  	{
		    		if( isset( $params['datelist']) )
		      		{
					$this->SetPreference('dateChoisi', $params['datelist']);
		      		}
		
				if( isset( $params['statuslist']) )
		      		{
					$this->SetPreference('statusChoisie', $params['statuslist']);
		      		}
			}
		
$curdate = $this->GetPreference( 'dateChoisi' );
$curstatus = $this->GetPreference('statusChoisie');

$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_date',
		$this->CreateInputDropdown($id,'datelist',$datelist,-1,$curdate));
$smarty->assign('input_status',
		$this->CreateInputDropdown($id,'statuslist',$statuslist,-1,$curstatus));
$smarty->assign('prompt_equipe',
		$this->Lang('equipe'));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());


$result= array ();
$query= "SELECT cal.id, comp.name,cal.type_compet,cal.date_debut, cal.date_fin, cal.numjourn FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE cal.type_compet = comp.code_compet";

	if( isset($params['submitfilter'] ))
	{

		if ($curdate !='')
		{
			$query .=" AND datecreated = ? ";
			$parms['datecreated'] = $curdate;
		
		}
		if($curstatus !='')
		{
			$query.=" AND status = ?";
			$parms['status'] = $curstatus;
		}

		$dbresult= $db->Execute($query,$parms);
	}

	else 
	{
		$query .=" ORDER BY cal.date_debut ASC";
		$dbresult= $db->Execute($query);
	}//fin du if dbresult
	//echo $query;
	
		if (!$dbresult)
		{

			die('FATAL SQL ERROR: '.$db->ErrorMsg().'<br/>QUERY: '.$db->sql);

		}




//$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
    		while ($row= $dbresult->FetchRow())
      		{
			//	$actif = $row['actif'];
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id= $row['id'];
			$onerow->name= $row['name'];
			$onerow->type_compet= $row['type_compet'];
			$onerow->date_debut= $row['date_debut'];
			$onerow->date_fin= $row['date_fin'];
			$onerow->numjourn= $row['numjourn'];
			$onerow->editlink= $this->CreateLink($id, 'add_compet', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']));
			$onerow->deletelink= $this->CreateLink($id, 'delete_date_compet', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
      		}
  	}
$smarty->assign('maintenant',$maintenant);
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_compet', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_compet', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
$smarty->assign('form2start',$this->CreateFormStart($id,'admin_data_tab',$returnid));
$smarty->assign('form2end',$this->CreateFormEnd());
$smarty->assign('submit_massdelete',
		$this->CreateInputSubmit($id,'submit_massdelete',$this->Lang('delete_selected'),
									     '','',$this->Lang('areyousure_deletemultiple')));
echo $this->ProcessTemplate('calendar.tpl');


#
# EOF
#
?>
<?php
if( !isset($gCms) ) exit;
##############################################################################
###                    JOURNAL                                               ###
##############################################################################


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


$db =& $this->GetDb();
global $themeObject;
//require_once(dirname(__FILE__).'/function.calculs.php');
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
//$smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin','', 'post', '',false,'',array('active_tab'=>'journal')));
$smarty->assign('formstart', $this->CreateFormStart($id, 'admin_journal_tab'));
$statuslist[$this->lang('allstatus')] ='';
$datelist[$this->Lang('alldates')] = '';
$typeCompet = array();
//$typeCompet[$this->Lang('allcompet')] = '';
$query1 = "SELECT datecreated, status FROM ".cms_db_prefix()."module_ping_recup ORDER BY datecreated DESC";
$dbresult1 = $db->Execute($query1);

if($dbresult1 && $dbresult1->RecordCount()>0)
{
	

	while ($row = $dbresult1->FetchRow())
		{
			setlocale (LC_TIME, 'fr_FR'); 
			$datelist[$row['datecreated']] = $row['datecreated']; 
			$statuslist[$row['status']] = $row['status'];
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
}

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

$edit = 0;//pour completer la requete.
$parm= array ();
$critere = '';
$activation = 0;
$query2= "SELECT id, datecreated, designation, status,action FROM ".cms_db_prefix()."module_ping_recup";
$result= $db->Execute($query2);
$totalrows = $result->RecordCount();
	if( isset($params['submitfilter'] ))
	{

		if ($curdate !='')
		{
			$edit = 1;
			$critere.=" WHERE datecreated = ? ";
			$parms['datecreated'] = $curdate;
		
		}
		if($curstatus !='')
		{
			if($edit==1)
			{
				$critere.=" AND status = ?";
				$parms['status'] = $curstatus;
			}
			else
			{
				$critere.=" WHERE status = ?";
				$parms['status'] = $curstatus;
			}
		}
		$activation = 1;//permet de différencier les deux requetes
		
	}
	
	$critere.= " ORDER BY datecreated DESC";
	//on instancie des variables pour créer une pagination dans l'onglet journal
	
	//fin du if dbresult
	$dbresult2 = ''; 
        $page = 1;
	if (isset($_GET['page']))$page = $_GET['page'];

	$limit = 20;
	if(isset($params['limit']))
	$page_string = "";
	$from = ($page * $limit) - $limit;
	if($activation=='0')
	{
		$dbresult2 = $db->SelectLimit('SELECT id, datecreated, designation, status,action FROM '.cms_db_prefix().'module_ping_recup '.$critere.'', $limit, $from);

	}
	
	elseif($activation=='1')
	{
		$dbresult2 = $db->SelectLimit('SELECT id, datecreated, designation, status,action FROM '.cms_db_prefix().'module_ping_recup '.$critere.'', $limit, $from, $parms);
		
	}
	echo $totalrows;
	
		/*
		if (!$dbresult2)
		{

			die('FATAL SQL ERROR: '.$db->ErrorMsg().'<br/>QUERY: '.$db->sql);

		}
		*/



//$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

	if ($dbresult2 && $dbresult2->RecordCount() > 0)
  	{
    		$page_string = pagination($page, $totalrows, $limit);
		$smarty->assign("pagestring",$page_string);
		while ($row= $dbresult2->FetchRow())
      		{
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id= $row['id'];
			$onerow->datecreated= $row['datecreated'];
			$onerow->designation= $row['designation'];
			$onerow->action= $row['action'];
			//$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
      		}
  	}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_compte', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_compte', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
$smarty->assign('form2start',$this->CreateFormStart($id,'admin_journal_tab',$returnid));
$smarty->assign('form2end',$this->CreateFormEnd());
$smarty->assign('submit_massdelete',
		$this->CreateInputSubmit($id,'submit_massdelete',$this->Lang('delete_selected'),
									     '','',$this->Lang('areyousure_deletemultiple')));
echo $this->ProcessTemplate('journal.tpl');


#
# EOF
#
?>
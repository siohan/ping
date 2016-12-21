<?php
if( !isset($gCms) ) exit;
//debug_display($params,'Parameters');
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

$totalcount = $db->GetOne('SELECT COUNT(id) as count FROM ' . cms_db_prefix() . 'module_ping_recup');
/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('deletelog',$this->CreateLink($id,'delete',$returnid,'Supprimer tout le journal',array('record_id'=>'0','type_compet'=>'journal')));
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
$parms= array();
$critere = '';
$activation = 0;
$query2= "SELECT id, datecreated, designation, status,action FROM ".cms_db_prefix()."module_ping_recup";

	if( isset($params['submitfilter'] ))
	{

		if ($curdate !='')
		{
			$edit = 1;
			$query2.=" WHERE datecreated = ? ";
			$parms['datecreated'] = $curdate;
		
		}
		if($curstatus !='')
		{
			if($edit==1)
			{
				$query2.=" AND status = ?";
				$parms['status'] = $curstatus;
			}
			else
			{
				$query2.=" WHERE status = ?";
				$parms['status'] = $curstatus;
			}
		}
		$activation = 1;//permet de différencier les deux requetes
		$query2.= " ORDER BY datecreated DESC";
		$result= $db->Execute($query2,$parms);
	}
	else
	{
		$query2.= " ORDER BY id DESC";
		$result= $db->Execute($query2);
	}
	
	
	//on instancie des variables pour créer une pagination dans l'onglet journal
	
	//fin du if dbresult
	
	
	//$totalrows = $result->RecordCount();

//$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

	if ($result && $result->RecordCount() > 0)
  	{
    		
		//$page_string = ping_admin_ops::pagination2($page, $totalrows, $limit,$actionid);
		//$smarty->assign("pagestring",$page_string);
		while ($row= $result->FetchRow())
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
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
$designation = '';
$maintenant = date("Y-m-d");
$mois_courant = date('n');
$mois_choisi = '';
$phase_choisie = '';
$phase_en_cours = $this->GetPreference('phase_en_cours');
$saison = $this->GetPreference('saison_en_cours');
$dep = $this->GetPreference('dep');
if(isset($params['phase_choisie']) && $params['phase_choisie'] !='')
{
	$phase_choisie = $params['phase_choisie'];
}
else
{
	$phase_choisie = $phase_en_cours;
}
$smarty->assign('phase', $phase_choisie);
if(isset($params['mois']) && $params['mois'] !='')
{
	$mois_choisi = $params['mois'];
	//$actif = $mois_choisi;
}
else
{
	$mois_choisi = $mois_courant;
}
if($mois_choisi ==1)
{
	$mois_precedent = 12;
}
else
{
	$mois_precedent = $mois_choisi -1;
}
if($mois_choisi==12)
{
	$mois_suivant = 1;
}
else
{
	$mois_suivant = $mois_choisi + 1;
}
$smarty->assign('Sep',
		$this->CreateLink($id,'defaultadmin', $returnid,'Septembre', array("active_tab"=>"calendrier","mois"=>"9","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==9)?'class="pageoptions"':'class="active"')));
$smarty->assign('Oct',
		$this->CreateLink($id,'defaultadmin', $returnid,'Octobre', array("active_tab"=>"calendrier","mois"=>"10","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==10)?'class="pageoptions"':'class="active"')));
$smarty->assign('Nov',
		$this->CreateLink($id,'defaultadmin', $returnid,'Novembre', array("active_tab"=>"calendrier","mois"=>"11","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==11)?'class="pageoptions"':'class="active"')));
$smarty->assign('Dec',
		$this->CreateLink($id,'defaultadmin', $returnid,'Décembre', array("active_tab"=>"calendrier","mois"=>"12","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==12)?'class="pageoptions"':'class="active"')));
$smarty->assign('Jan',
		$this->CreateLink($id,'defaultadmin', $returnid,'Janvier', array("active_tab"=>"calendrier","mois"=>"1","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==1)?'class="pageoptions"':'class="active"')));
$smarty->assign('Fev',
		$this->CreateLink($id,'defaultadmin', $returnid,'Février', array("active_tab"=>"calendrier","mois"=>"2","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==2)?'class="pageoptions"':'class="active"')));
$smarty->assign('Mar',
		$this->CreateLink($id,'defaultadmin', $returnid,'Mars', array("active_tab"=>"calendrier","mois"=>"3","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==3)?'class="pageoptions"':'class="active"')));
$smarty->assign('Avr',
		$this->CreateLink($id,'defaultadmin', $returnid,'Avril', array("active_tab"=>"calendrier","mois"=>"4","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==4)?'class="pageoptions"':'class="active"')));
$smarty->assign('Mai',
		$this->CreateLink($id,'defaultadmin', $returnid,'Mai', array("active_tab"=>"calendrier","mois"=>"5","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==5)?'class="pageoptions"':'class="active"')));
$smarty->assign('Juin',
		$this->CreateLink($id,'defaultadmin', $returnid,'Juin', array("active_tab"=>"calendrier","mois"=>"6","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==6)?'class="pageoptions"':'class="active"')));
$smarty->assign('Juil',
		$this->CreateLink($id,'defaultadmin', $returnid,'Juillet', array("active_tab"=>"calendrier","mois"=>"7","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==7)?'class="pageoptions"':'class="active"')));

$smarty->assign('mois_precedent',
		$this->CreateLink($id,'defaultadmin',$returnid, '<<', array("active_tab"=>"calendrier","phase_choisie"=>"1","mois"=>"12"),
		'', false, false, (($mois_choisi==12)?'class="pageoptions"':'class="active"')));
$smarty->assign('mois_suivant',
		$this->CreateLink($id,'defaultadmin',$returnid, '>>', array("active_tab"=>"calendrier","phase_choisie"=>"2","mois"=>"1") ,
		'', false, false, (($mois_choisi==1)?'class="pageoptions"':'class="active"')));


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
$query = "SELECT cal.tag,cal.id, comp.coefficient,comp.name,comp.indivs,cal.type_compet,cal.date_debut, cal.date_fin, cal.numjourn,comp.idepreuve FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE cal.idepreuve = comp.idepreuve AND cal.saison = ? AND MONTH(cal.date_debut) = ?";
		$query .=" ORDER BY cal.date_debut ASC";
		$dbresult= $db->Execute($query, array($saison, $mois_choisi));

	//echo $query;
	
		if (!$dbresult)
		{

			$designation.= $db->ErrorMsg();

		}




//$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
    		while ($row= $dbresult->FetchRow())
      		{
			$indivs = $row['indivs'];
			$idepreuve = $row['idepreuve'];
			$tour = $row['numjourn'];
			$date_debut = $row['date_debut'];
			//echo $tour;
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->id= $row['id'];
			$onerow->name= $row['name'];
			$onerow->type_compet= $row['type_compet'];
			$onerow->coeff = $row['coefficient'];
			$onerow->date_debut= $row['date_debut'];
			$onerow->date_fin= $row['date_fin'];
			$onerow->numjourn= $row['numjourn'];
			$onerow->tag= $row['tag'];
			$onerow->indivs = $row['indivs'];
			//echo $indivs;
			/*
			if($indivs =='1')
			{
				//la competition est individuelle,on vérifie d'abord la présence de dividions et tours ?
				//non on estime que l'utilisateur l'a fait !
				//on démarre une autre requete
				//on récupère directement le classement !
				$onerow->retrievelink = $this->CreateLink($id,'retrieve_all_classement', $returnid, $contents='Classement', array("idepreuve"=>$idepreuve,"date_debut"=>$date_debut,"tour"=>$tour,"idorga"=>$idorga));
				
				
				
				
				$onerow->participe = $this->CreateLink($id, 'participe', $returnid, 'Participants', array('type_compet'=>$row['type_compet'],'date_debut'=>$row['date_debut'],'date_fin'=>$row['date_fin']));
			}
			else
			{
				$onerow->retrievelink= $this->CreateLink($id, 'retrieve_indivs', $returnid, 'Récupérer', array("type_compet"=>$row['type_compet'], "coefficient"=>$row['coefficient']));
			}
			*/
			$onerow->editlink= $this->CreateLink($id, 'add_compet', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']));
			
			if($this->CheckPermission('Ping Delete'))
				{
					$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id'], 'type_compet'=>'calendrier'), $this->Lang('delete_confirm'));
				}
				
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
				  $this->Lang('add'), 
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
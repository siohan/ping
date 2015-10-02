<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/travaux.php');

$saison = $this->GetPreference('saison_en_cours');
/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_poules_tab'));  
$pouleslist = array();
$pouleslist[$this->Lang('allpoules')] = '';

$query1 = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ?";
$dbresult = $db->Execute($query1,array($saison));
//echo $query1;
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $pouleslist[$row['libdivision']] = $row['idpoule'];
  }

	if( isset($params['submitfilter']) )
  	{
    		if( isset( $params['pouleslist']) )
      		{
			$this->SetPreference('pouleChoisi', $params['pouleslist']);
      		}
	}

$curpoule = $this->GetPreference( 'pouleChoisi' );

$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('input_tour',
		$this->CreateInputDropdown($id,'pouleslist',$pouleslist,-1,$curpoule));
$smarty->assign('input_club_uniquement',
		$this->CreateInputCheckbox($id,'club_uniquement',1,1));
$smarty->assign('input_deja_joues_uniquement',
		$this->CreateInputCheckbox($id,'deja_joues_uniquement',1,1));
		//	(isset($params['club_uniquement'])?$params['club_uniquement']:'1'),1));
$smarty->assign('prompt_equipe',
		$this->Lang('equipe'));
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());
//echo "la poule en cours est : ".$curpoule;
$parms = array();
$result= array();
$query2 = "SELECT *,ren.affiche,ren.club,ren.date_event, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND eq.saison = ?";
$parms['saison'] = $saison;
	if( isset($params['submitfilter'] ))
	{
	
		if ($curpoule !='')
		{
			$query2 .=" AND eq.idpoule = ?";
			$parms['idpoule'] = $curpoule;
			
			
		}
		if($params['club_uniquement']=='1')
		{
			$query2.=" AND club = '1'";
		}
		if($params['deja_joues_uniquement'])
		{
			$query2.=" AND (ren.scorea !=0 AND ren.scoreb !=0 )";
		
		}
	}
/*		
		$dbresult= $db->Execute($query2,$parms);
	
	}
	else
	{
		$dbresult= $db->Execute($query2,array($saison));
	}
*/

$query2.=" ORDER BY ren.date_event DESC"	;
$dbresult= $db->Execute($query2,$parms);
//echo $query2;

$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$club = $row['club'];
	$equb = $row['equb'];
	$equa = $row['equa'];
	$scorea = $row['scorea'];
	$scoreb = $row['scoreb'];
	$friendlyname = $row['friendlyname'];
	$libequipe = $row['libequipe'];
	$uploaded = $row['uploaded'];
	$affiche = $row['affiche'];	
	
	
	//$onerow->equipe= $row['equipe'];
	$onerow->libelle= $row['libelle'];
	
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equa)
		{
			$onerow->equa= $row['friendlyname'];
		}
		else
		{
			$onerow->equa= $row['equa'];
		}
		
	}
	else
	{
		$onerow->equa= $row['equa'];
	}
	
	$onerow->scorea= $row['scorea'];
	$onerow->scoreb= $row['scoreb'];
	$onerow->libequipe= $row['libequipe'];
	
	if(isset($friendlyname) && $friendlyname !='')
	{
		if ($libequipe == $equb)
		{
			$onerow->equb= $row['friendlyname'];
		}
		else
		{
			$onerow->equb= $row['equb'];
		}
		
	}
	else
	{
		$onerow->equb= $row['equb'];
	}
	
	if($affiche ==1)
	{
		$onerow->display= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('do_not_display'), '', '', 'systemicon');
	}
	else
	{
		$onerow->display= $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('display_on_frontend'), '', '', 'systemicon');
	}
	$pb = 0;
	if($scorea ==0 && $scoreb == 0)
	{
		$pb = 1;
	}
	if($uploaded ==0 && $club==1 && $pb==0) {
		
	//$onerow->affichage = 
	$onerow->retrieve_details = $this->CreateLink($id,'retrieve_details_rencontres2', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('record_id'=>$row['id']));
	}
	
	if($this->CheckPermission('Ping Delete'))
	{
		$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id'], 'type_compet'=>'poules'), $this->Lang('delete_confirm'));
	}
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'retrieve_all_poule_rencontres', $returnid,
				  $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('download_all_poule_results'), '', '', 'systemicon')).
		$this->CreateLink($id, 'retrieve_all_poule_rencontres', $returnid, 
				  $this->Lang('download_all_poule_results'), 
				  array()));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Afficher sur le site"=>"display_on_frontend","Ne plus afficher sur le site"=>"do_not_display","Supprimer"=>"delete_team_result");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
echo $this->ProcessTemplate('poulesRencontres.tpl');


#
# EOF
#
?>
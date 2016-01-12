<?php

if( !isset($gCms) ) exit;
//require_once(dirname(__FILE__)'')
if (!$this->CheckPermission('Ping Use'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$db =& $this->GetDb();
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('Phase_en_cours');
$edit = 0;//sert à distinguer l'ajout par défaut 0 d'une édition (= 1)
$record_id = '';
if( isset( $params['record_id'] ) && $params['record_id'] != '')    
{
	
	$record_id = $params['record_id'];
	$edit=1;
	    


    // find the user
    $query = "SELECT eq.saison, eq.phase,eq.libequipe, eq.libdivision,eq.liendivision,eq.friendlyname, eq.iddiv,eq.idpoule,eq.idepreuve FROM ".cms_db_prefix()."module_ping_equipes AS eq WHERE  eq.id = ?";
    $dbresult = $db->GetRow($query, array( $record_id ));
    if($dbresult)
      
	{
		//liste des données a afficher dans le formulaire
		//saison, phase, libequipe,libdivision friendlyname
		$saison = $dbresult['saison'];
		$phase = $dbresult['phase'];
		$libequipe = $dbresult['libequipe'];
		$libdivision = $dbresult['libdivision'];
		$liendivision = $dbresult['liendivision'];
		$friendlyname = $dbresult['friendlyname'];
		$idepreuve = $dbresult['idepreuve'];
		$iddiv = $dbresult['iddiv'];
		$idpoule = $dbresult['idpoule'];
		//on va chercher l'organisme qui organise la compet
		$explode1 = explode("&",$liendivision);
		$explode2 = explode("=", $explode1[2]);
		$organisme = $explode2[1];
	//	$index = $dbresult['index1'] - 1;
	//	$name = $dbresult['name'];
		$type_compet_selected = $dbresult['idepreuve'];
		
		
		//$organisme = get_organisme($libdivision);
		
		
	}
}

  
$smarty->assign('formstart',
		 $this->CreateFormStart( $id, 'do_edit_team', $returnid ) );
if($edit=='1')
{
	$smarty->assign('record_id',
			    $this->CreateInputHidden( $id, 'record_id', 
			(isset($params['record_id'])?$params['record_id']:"")));
}
$listsaisons = array( '2014-2015'=>'2014-2015');
$listphase = array('1'=>'1', '2'=>'2');
   
$smarty->assign('saison',
		$this->CreateInputText($id, 'saison',
		(isset($saison)?$saison:$this->GetPreference('saison_en_cours'))));
$smarty->assign('phase',
		$this->CreateInputText($id, 'phase',
		(isset($phase)?$phase:$this->GetPreference('Phase_en_cours'))));
$smarty->assign('libequipe',
		$this->CreateInputText($id, 'libequipe',
		(isset($libequipe)?$libequipe:""),30,150));
$smarty->assign('libdivision',
		$this->CreateInputText($id, 'libdivision',
		(isset($libdivision)?$libdivision:""),30,150));
$smarty->assign('friendlyname',
		$this->CreateInputText($id, 'friendlyname',
		(isset($friendlyname)?$libdivision:""),10,80));
$smarty->assign('iddiv', 
		$this->CreateInputText($id, 'iddiv', 
		(isset($iddiv)?$iddiv:""), 10,20));
$smarty->assign('idpoule', 
		$this->CreateInputText($id, 'idpoule', 
		(isset($idpoule)?$idpoule:""), 10,20));
		

$numero_club = $this->GetPreference('club_number');
$ligue = substr($numero_club, 0,2);
if($edit =='1')
{
	$smarty->assign('organisme', 
			$this->CreateInputText($id,'organisme', $organisme,10,20));
}
else
{
	$organisme['ligue'] = '10'.$ligue;
	$organisme['departement'] = substr($numero_club,2,2);
	$organisme['federation'] = '100001';
	$smarty->assign('organisme',
			$this->CreateInputDropdown($id,'organisme',$organisme));
}


		//on fait le tour des compétitions possibles excepté U pour undefined
$query2 = "SELECT name, idepreuve FROM ".cms_db_prefix()."module_ping_type_competitions ORDER BY name ASC";//" WHERE indivs = '0'";
$dbresultat = $db->Execute($query2);
if($dbresultat && $dbresultat->RecordCount()>0)
{
	while ($dbresultat && $row = $dbresultat->FetchRow())
	  {
	   	$list[$row['name']] = $row['idepreuve'];
	  }
}

/*
$smarty->assign('type_compet',
		$this->CreateInputDropdown($id,'type_compet',$type_compet,$selectedindex = $index, $selectedvalue=$name));
*/
$smarty->assign('idepreuve',
		$this->CreateInputDropdown($id, 'idepreuve',$list,
		(isset($idepreuve)?$idepreuve:"-1"),(isset($idepreuve)?$idepreuve:"")));
	
				
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('cancel',
		$this->CreateInputSubmit($id,'cancel', $this->Lang('cancel')));
$smarty->assign('back',
		$this->CreateInputSubmit($id,'back', $this->Lang('back')));
$smarty->assign('formend',
		$this->CreateFormEnd());


echo $this->ProcessTemplate('editteam.tpl');

#
# EOF
#
?>

<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
global $themeObject;
//$ping = cms_utils::get_module('Ping');
$ping_ops = new ping_admin_ops;
//$liste_epreuves_equipes = $this->liste_epreuves_equipes();


//$ping = new Ping;
$saison_courante = $this->GetPreference('saison_en_cours');
$phase_courante = $this->GetPreference('phase_en_cours');
$saison_en_cours = (isset($params['saison_en_cours']))?$params['saison_en_cours']:$saison_courante;
$phase_en_cours = (isset($params['phase_en_cours']))?$params['phase_en_cours']:$phase_courante;
$smarty->assign('phase', $phase_en_cours);
$items_phase = array("Phase 1"=>"1", "Phase 2"=>"2");
if(isset($params['idepreuve']))	
{
	$idepreuve = $params['idepreuve'];
}
else
{
	$idepreuve = '1';
}




$parms = array();
$query = "SELECT id, licence, J1, J2, J3, J4, J5, J6, J7,J8, J9, J10, J11, J12, J13, J14 FROM ".cms_db_prefix()."module_ping_brulage ORDER BY id ASC";
$dbresult= $db->Execute($query);//,array($idepreuve));


	$ping = new Asso_adherents;
	$rowarray= array();
	$rowclass = '';

		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
					$onerow= new StdClass();
					$onerow->rowclass= $rowclass;
					
					$onerow->licence=  $ping_ops->name($row['licence']);
					$onerow->J1= $row['J1'];
					$onerow->J2= $row['J2'];
					$onerow->J3= $row['J3'];
					$onerow->J4= $row['J4'];
					$onerow->J5= $row['J5'];
					$onerow->J6= $row['J6'];
					$onerow->J7= $row['J7'];
					$onerow->J8= $row['J8'];
					$onerow->J9= $row['J9'];
					$onerow->J10= $row['J10'];
					$onerow->J11= $row['J11'];
					$onerow->J12= $row['J12'];
					$onerow->J13= $row['J13'];
					$onerow->J14= $row['J14'];
					//	$onerow->view= $this->createLink($id, 'admin_poules_tab3', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view_results'), '', '', 'systemicon'),array('active_tab'=>'equipes','libequipe'=>$row['libequipe'],"record_id"=>$row['eq_id'],"idepreuve"=>$row['idepreuve'])) ;
					$onerow->editlink= $this->CreateLink($id, 'add_edit_brulage', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray[]= $onerow;
			
      			}
			
  		}
		
	
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		//on prépare le second form d'action de masse
	

echo $this->ProcessTemplate('admin_brulage.tpl');


#
# EOF
#
?>

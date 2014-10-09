<?php

if( !isset($gCms) ) exit;
//require_once(dirname(__FILE__)'')
if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

//$this->SetCurrentTab('users');
$db =& $this->GetDb();
//$record_id = $params['record_id'];
if( isset( $params['message'] ) )
  {
    $smarty->assign('message',html_entity_decode($params['message']));
  }
if( isset( $params['error'] ) )
  {
    $smarty->assign('error',html_entity_decode($params['error']));
  }



$record_id = '';
if( !isset( $params['record_id'] ) || $params['record_id'] == '')    
{
	
	$params['message'] = $this->Lang('error_insufficientparams');
	    $params['error'] = 1;
	$this->SetMessage("Paramètres manquants");
	    $this->RedirectToAdminTab('equipes' );
	    return;
}

    // find the user
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?";
    $dbresult = $db->GetRow($query, array( $params['record_id'] ));
    if($dbresult)
      
	{
		//liste des données a afficher dans le formulaire
		//saison, phase, libequipe,libdivision friendlyname
		$saison = $dbresult['saison'];
		$phase = $dbresult['phase'];
		$libequipe = $dbresult['libequipe'];
		$libdivision = $dbresult['libdivision'];
		$friendlyname = $dbresult['friendlyname'];
		
		
	}
/*
$competitionsList = array();
$code_competList = array();
$query = 'SELECT * FROM '.cms_db_prefix().'module_ping_competitions WHERE indivs="Non"';
$dbresult = $db->Execute($query);
	while($dbresult && $row = $dbresult->FetchRow()){
			$competitionsList[$row['name']] = $row['code_compet'];
			$code_competList[$row['code_compet']] = $row['code_compet'];
		}
*/
  
    $smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'do_edit_team', $returnid ) );
    $smarty->assign('record_id',
		    $this->CreateInputHidden( $id, 'record_id', $params['record_id'] ));
$listsaisons = array('2013-2014'=>'2013-2014', '2014-2015'=>'2014-2015');
$listphase = array('1'=>'1', '2'=>'2');
   
$smarty->assign('saison',
		$this->CreateInputDropdown($id, 'saison',$listsaisons,$saison,$saison));
$smarty->assign('phase',
		$this->CreateInputDropdown($id, 'phase',$listphase,$phase,$phase));
$smarty->assign('libequipe',
		$this->CreateInputText($id, 'libequipe',$libequipe,30,150));
$smarty->assign('libdivision',
		$this->CreateInputText($id, 'libdivision',$libdivision,30,150));
$smarty->assign('friendlyname',
		$this->CreateInputText($id, 'friendlyname',$friendlyname,10,80));					
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

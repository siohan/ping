<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }
if( isset($params['cancel']) )
  {
    $this->RedirectToAdminTab('rencontres');
    return;
  }

$this->SetCurrentTab('users');
$db =& $this->GetDb();

   
    $smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'do_add_type_compet', $returnid ) );
$smarty->assign('type_compet',
				$this->CreateInputText($id,'type_compet','',5,10));

$smarty->assign('name',
		$this->CreateInputText($id,'name',$name,75,150));
/*
$smarty->assign('code_compet',
		$this->CreateInputText($id, 'code_compet',$code_compet,2,3));
*/
$listecoeff = array("0,25"=>"0.25","0,50"=>"0.50","0,75"=>"0.75", "1,00"=>"1.00", "1,25"=>"1.25","1,50"=>"1.50");
$smarty->assign('coefficient',
		$this->CreateInputDropdown($id, 'coefficient',$listecoeff,3));
$smarty->assign('indivs',
		$this->CreateInputDropdown($id, 'indivs',array("Oui"=>"Oui", "Non"=>"Non")));	
$smarty->assign('tooltip',$helptext = 'Doit être unique');	
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('cancel',
		$this->CreateInputSubmit($id,'cancel',
					$this->Lang('cancel')));
$smarty->assign('back',
		$this->CreateInputSubmit($id,'back',
					$this->Lang('back')));

$smarty->assign('formend',
		$this->CreateFormEnd());


echo $this->ProcessTemplate('add_type_compet.tpl');

#
# EOF
#
?>

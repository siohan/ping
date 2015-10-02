<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$db =& $this->GetDb();
//$record_id = $params['record_id'];


if( !isset( $params['licence'] ) || $params['licence'] == '')    
{
	
	$params['message'] = $this->Lang('error_insufficientparams');
	$params['error'] = 1;
	//$this->Redirect( $id, 'defaultadmin', $returnid, $params );
	    //return;
}

    // find the user
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
    $dbresult = $db->GetRow($query, array( $params['licence'] ));
    if($dbresult)
      
	{
		$licence = $dbresult['licence'];
		$actif = $dbresult['actif'];
		$birthday = $dbresult['birthday'];
		$sexe = $dbresult['sexe'];
		$nom = $dbresult['nom'];
		$prenom = $dbresult['prenom'];
		$adresse = $dbresult['adresse'];
		$ville = $dbresult['ville'];
		$codepostal = $dbresult['codepostal'];
		$licence = $dbresult['licence'];
		
	//	$actif = $dbresult['actif'];
		
	}

  
$smarty->assign('formstart',
		$this->CreateFormStart( $id, 'do_edit_joueur', $returnid ) );
/*
$smarty->assign('record_id',
		    $this->CreateInputHidden( $id, 'record_id', $params['record_id'] ));
*/
$items = array('Oui'=>'1', 'Non'=>'0');
$smarty->assign('actif',
		$this->CreateInputDropdown($id,'actif',$items,-1,$actif));
$smarty->assign('nom',
		$this->CreateInputText($id,'nom',$nom,80,150));					
$smarty->assign('prenom',
		$this->CreateInputText($id, 'prenom',$prenom,80,150));
if(isset($params['licence']) && $params['licence'] != ''){
	$smarty->assign('licence',
			$this->CreateInputHidden($id, 'licence',$licence));
}
else{
	$smarty->assign('licence',
			$this->CreateInputText($id, 'licence',$licence));
}

$smarty->assign('birthday',
		$this->CreateInputDate($id, 'birthday',$birthday));
$items = array('Masculin'=>'M', 'Féminin'=>'F');
$smarty->assign('sexe',
		$this->CreateInputDropdown($id, 'sexe',$items,-1,$sexe));
$smarty->assign('adresse',
		$this->CreateInputText($id, 'adresse',$adresse,100,280));
$smarty->assign('ville',
		$this->CreateInputText($id, 'ville',$ville,80,100));
$smarty->assign('codepostal',
		$this->CreateInputText($id, 'codepostal',$codepostal,80,100));				
															
$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));

$smarty->assign('formend',
		$this->CreateFormEnd());


echo $this->ProcessTemplate('edit_joueur.tpl');

#
# EOF
#
?>

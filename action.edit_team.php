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
if( isset( $params['record_id'] ) && $params['record_id'] != '')    
{
	
	$record_id = $params['record_id'];
	    


    // find the user
    $query = "SELECT eq.libequipe,eq.libdivision,eq.friendlyname FROM ".cms_db_prefix()."module_ping_equipes AS eq WHERE  eq.id = ?";
    $dbresult = $db->GetRow($query, array( $record_id ));
    if($dbresult)
      
	{
		//liste des données a afficher dans le formulaire
		//saison, phase, libequipe,libdivision friendlyname
		
		$libequipe = $dbresult['libequipe'];
		$libdivision = $dbresult['libdivision'];		
		$friendlyname = $dbresult['friendlyname'];
		
		
	}
}
else
{
	//pas de record_id ? on redirige !
	$this->SetMessage("Le numéro de l\'équipe est manquant ! ");
	$this->RedirectToAdminTab('equipes');
}

  
$smarty->assign('formstart',
		 $this->CreateFormStart( $id, 'do_edit_team', $returnid ) );
$smarty->assign('record_id',
		$this->CreateInputHidden( $id, 'record_id', 
			(isset($params['record_id'])?$params['record_id']:"")));

$smarty->assign('libequipe',
		$this->CreateInputText($id, 'libequipe',
		(isset($libequipe)?$libequipe:""),30,150));
$smarty->assign('libdivision',
		$this->CreateInputText($id, 'libdivision',
		(isset($libdivision)?$libdivision:""),50,150));
$smarty->assign('friendlyname',
		$this->CreateInputText($id, 'friendlyname',
		(isset($friendlyname)?$libdivision:""),10,80));
				
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

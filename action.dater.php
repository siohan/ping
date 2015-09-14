<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Ping Manage'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('divisions');
    		return;
  	}
debug_display($params, 'Parameters');
//le formulaire a t-il été soumis ?
if(isset($params['submit']))
{
	//on fait les traitements
	//on vérifie que tt est là
	$db =& $this->GetDb();
	if(isset($params['sel']) && $params['sel'] != '')
	{
		$sel = $params['sel'];
		$id_sel = explode('-', $sel);

		$date_debut = $params['date_debut'];
		$date_fin = $params['date_fin'];
		$i = 0;//on instancie un compteur pour rendre compte
		
		foreach($id_sel as $valeur)
		{
			
			//on va chercher les infos : idepreuve, iddivision etc..
			$query = "SELECT * FROM ".cms_db_prefix()."module_ping_divisions WHERE id = ? ";
			$dbresult = $db->Execute($query, array($valeur));
			
			if($dbresult && $dbresult->RecordCount()>0)
			{
				//
				$row = $dbresult->FetchRow();
				$idepreuve = $row['idepreuve'];
				$iddivsion = $row['iddivision'];
				$tableau = $row['tableau'];
				$libelle = $row['libelle'];
				$saison = $row['saison'];
				$indivs = $row['indivs'];
				
				//on fait la requete d'insertion
				//$query = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id, )";
				
			}
			//$query = "UPDATE ".cms_db_prefix()."module_ping_divisions SET date_debut = ?, date_fin = ? WHERE id = ?";
			//$dbresult = $db->Execute($query, array($date_debut,$date_fin,$valeur));
			
		}
	}
}
else
{
	if(isset($params['sel']) && $params['sel'] !="")
	{			
		$sel = $params['sel'];
		
		//on construit le formulaire
		$smarty->assign('formstart',
				    $this->CreateFormStart( $id, 'dater', $returnid ) );	
		$smarty->assign('record_id',
				$this->CreateInputHidden($id,'sel',$sel));
	
	
		$smarty->assign('date_debut',
				$this->CreateInputDate($id, 'date_debut'));
		$smarty->assign('date_fin',
				$this->CreateInputDate($id, 'date_fin'));
	
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
	
		echo $this->ProcessTemplate('dater.tpl');
	}
}



#
# EOF
#
?>

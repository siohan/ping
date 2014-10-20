<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Ping Use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
	$message = '';
	if(isset($params['message']) && $params['message'] == ''){
		$message = $params['message'];
		echo $message;
		return;
		}

//on instancie les onglets

echo $this->StartTabheaders();
if (FALSE == empty($params['active_tab']))
  {
    $tab = $params['active_tab'];
  } else {
  $tab = 'rencontres';
 }	
	echo $this->SetTabHeader('joueurs', 'Joueurs', ('joueurs' == $tab)?true:false);
	echo $this->SetTabHeader('equipes', 'Equipes', ('Equipes' == $tab)?true:false);
	echo $this->SetTabHeader('individuelles', 'FFTT' , ('individuelles' == $tab)?true:false);
	echo $this->SetTabHeader('results', 'SPID' , ('results' == $tab)?true:false);
	echo $this->SetTabHeader('compets', 'Compétitions' , ('compet' == $tab)?true:false);
	
	echo $this->SetTabHeader('poules', 'Résultats des poules', ('Résultats des poules' == $tab)?true:false);
	echo $this->SetTabHeader('recuperation', 'Recupération', ('Récupération' == $tab)?true:false);
	echo $this->SetTabHeader('situation', 'Situation mensuelle', ('Situation mensuelle' == $tab)?true:false);
	echo $this->SetTabHeader('journal', 'Journal', ('Journal' == $tab)?true:false);
	
	if($this->CheckPermission('Ping Set Prefs')){
		echo $this->SetTabHeader('configuration', 'Configuration' , ('configuration' == $tab)?true:false);
	}

echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	echo $this->StartTab('joueurs', $params);
    	include(dirname(__FILE__).'/action.admin_joueurs_tab.php');
   	echo $this->EndTab();

        echo $this->StartTab('Individuelles', $params);//FFTT
    	include(dirname(__FILE__).'/action.admin_indivs_tab.php');
   	echo $this->EndTab();
 
	echo $this->StartTab('results' , $params);//Spid
    	include(dirname(__FILE__).'/action.view_user_global_results.php');
   	echo $this->EndTab();

       echo $this->StartTab('compets' , $params);
    	include(dirname(__FILE__).'/function.admin_competitions_tab.php');
   	echo $this->EndTab();


 	echo $this->StartTab('equipes' , $params);//les equipes
    	include(dirname(__FILE__).'/action.admin_teams_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('poules' , $params);
    	include(dirname(__FILE__).'/action.admin_poules_tab.php');
   	echo $this->EndTab();


	echo $this->StartTab('recuperation' , $params);
    	include(dirname(__FILE__).'/function.admin_joueurs_recup_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('situation' , $params);//situation mensuelle
    	include(dirname(__FILE__).'/action.admin_situation_mensuelle_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('journal', $params);//le journal
    	include(dirname(__FILE__).'/action.admin_data_tab.php');
   	echo $this->EndTab();
if($this->CheckPermission('Ping Set Prefs')){
	echo $this->StartTab('configuration' , $params);
	include(dirname(__FILE__).'/function.admin_options_tab.php');
	echo $this->EndTab();
}
echo $this->EndTabContent();
//on a refermé les onglets

//echo $this->ProcessTemplate('admin_panel.tpl');
?>
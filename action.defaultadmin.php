<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Ping Use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
	
//debug_display($params, 'Parameters');
//on instancie les onglets
$version = $this->GetVersion('Ping');
//echo "la version est : ".$version;
echo $this->StartTabheaders();
if(isset($params['__activetab']) && !empty($params['__activetab']))
  {
    $tab = $params['__activetab'];
  } else {
  $tab = 'joueurs';
 }	
	echo $this->SetTabHeader('joueurs', 'Joueurs', ('joueurs' == $tab)?true:false);
	echo $this->SetTabHeader('equipes', 'Par Equipes', ('equipes' == $tab)?true:false);
	echo $this->SetTabHeader('indivs', 'Individuelles' , ('indivs' == $tab)?true:false);
	echo $this->SetTabHeader('compets', 'Compétitions' , ('compets' == $tab)?true:false);
	echo $this->SetTabHeader('calendrier', 'Calendrier', ('calendrier' == $tab)?true:false);
	echo $this->SetTabHeader('fftt', 'FFTT' , ('fftt' == $tab)?true:false);
	echo $this->SetTabHeader('spid', 'SPID' , ('spid' == $tab)?true:false);
	
	//echo $this->SetTabHeader('divisions', 'Divisions', ('divisions' == $tab)?true:false);	
	//echo $this->SetTabHeader('poules', 'Résultats', ('resultats' == $tab)?true:false);
	//echo $this->SetTabHeader('recup', 'Recupération', ('Récupération' == $tab)?true:false);
	echo $this->SetTabHeader('situation', 'Situation mensuelle', ('situation' == $tab)?true:false);
	echo $this->SetTabHeader('journal', 'Journal', ('Journal' == $tab)?true:false);
	
	if($this->CheckPermission('Ping Set Prefs'))
	{
		echo $this->SetTabHeader('configuration', 'Configuration' , ('configuration' == $tab)?true:false);
	//	echo $this->SetTabHeader('compte', 'compte' , ('compte' == $tab)?true:false);
	}

echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	/**/
	echo $this->StartTab('joueurs', $params);
	include(dirname(__FILE__).'/action.admin_recup_tab.php');
    	//include(dirname(__FILE__).'/action.admin_joueurs_tab.php');
   	echo $this->EndTab();
	/**/

	echo $this->StartTab('equipes' , $params);//les équipes
    	include(dirname(__FILE__).'/action.admin_teams_tab.php');
   	echo $this->EndTab();
	
	echo $this->StartTab('indivs' , $params);//les types de compétitions
	include(dirname(__FILE__).'/action.admin_compets_indivs_tab.php');
	echo $this->EndTab();
	
	echo $this->StartTab('compets' , $params);//les types de compétitions
	include(dirname(__FILE__).'/action.admin_compets_tab.php');
	echo $this->EndTab();
	
	echo $this->StartTab('calendrier', $params);//Calendrier
    	include(dirname(__FILE__).'/action.admin_calendar_tab.php');
   	echo $this->EndTab();

        echo $this->StartTab('fftt', $params);//FFTT
    	include(dirname(__FILE__).'/action.admin_fftt_tab.php');
   	echo $this->EndTab();	
 
	echo $this->StartTab('spid' , $params);//Spid
    	if($this->GetPreference('spid_calcul') == '1')
	{
		include(dirname(__FILE__).'/action.admin_spid_tab.php');
	}
	else
	{
		include(dirname(__FILE__).'/action.admin_spid_tab.php');	
	}
   	echo $this->EndTab();

	/*
	echo $this->StartTab('recup' , $params);
    	include(dirname(__FILE__).'/action.admin_recup_tab.php');
   	echo $this->EndTab();
	*/
	echo $this->StartTab('situation' , $params);//situation mensuelle
    	include(dirname(__FILE__).'/action.admin_situation_mensuelle_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('journal', $params);//le journal
    	include(dirname(__FILE__).'/action.admin_journal_tab.php');
   	echo $this->EndTab();
if($this->CheckPermission('Ping Set Prefs')){
	echo $this->StartTab('configuration' , $params);
	include(dirname(__FILE__).'/action.admin_options_tab.php');
	echo $this->EndTab();
/*
	echo $this->StartTab('compte' , $params);
	include(dirname(__FILE__).'/action.admin_compte_tab.php');
	echo $this->EndTab();
	*/
}
echo $this->EndTabContent();
//on a refermé les onglets

//echo $this->ProcessTemplate('admin_panel.tpl');
?>
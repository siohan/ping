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
if(isset($params['_activetab']) && !empty($params['_activetab']))
  {
    $tab = $params['_activetab'];
  } else {
  $tab = 'joueurs';
 }	
	echo $this->SetTabHeader('joueurs', 'Joueurs', ('joueurs' == $tab)?true:false);
	echo $this->SetTabHeader('equipes', 'Par Equipes', ('equipes' == $tab)?true:false);
	echo $this->SetTabHeader('compets', 'Epreuves' , ('indivs' == $tab)?true:false);
	echo $this->SetTabHeader('fftt', 'FFTT' , ('fftt' == $tab)?true:false);
	echo $this->SetTabHeader('spid', 'SPID' , ('spid' == $tab)?true:false);
	echo $this->SetTabHeader('situation', 'Situation mensuelle', ('situation' == $tab)?true:false);
	echo $this->SetTabHeader('journal', 'Journal', ('Journal' == $tab)?true:false);
	
	if($this->CheckPermission('Ping Set Prefs'))
	{
		echo $this->SetTabHeader('configuration', 'Configuration' , ('configuration' == $tab)?true:false);
		echo $this->SetTabHeader('compte', 'compte' , ('compte' == $tab)?true:false);
	}

echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	
	echo $this->StartTab('joueurs', $params);
	include(dirname(__FILE__).'/action.admin_joueurs_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('equipes' , $params);//les équipes
    	include(dirname(__FILE__).'/action.admin_teams_tab.php');
   	echo $this->EndTab();
	
	echo $this->StartTab('compets' , $params);//les types de compétitions
	include(dirname(__FILE__).'/action.admin_compets_indivs_tab.php');
	echo $this->EndTab();

        echo $this->StartTab('fftt', $params);//FFTT
    	include(dirname(__FILE__).'/action.admin_fftt2_tab.php');
   	echo $this->EndTab();	
 
	echo $this->StartTab('spid' , $params);//Spid
	include(dirname(__FILE__).'/action.admin_spid_tab.php');
   	echo $this->EndTab();


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

	echo $this->StartTab('compte' , $params);
	include(dirname(__FILE__).'/action.admin_compte_tab.php');
	echo $this->EndTab();
	
}
echo $this->EndTabContent();
//on a refermé les onglets


?>
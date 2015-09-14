<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Ping Use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
	

//on instancie les onglets

  echo '<div class="pageoverflow" style="text-align: left; width: 80%;">';
  echo $this->CreateLink($id,'defaultadmin',$returnid,'<= Menu principal');
  echo '</div>';

echo $this->StartTabheaders();
if (FALSE == empty($params['active_tab']))
  {
    $tab = $params['active_tab'];
  } else {
  $tab = 'divisions';
 }	
	echo $this->SetTabHeader('divisions', 'Divisions', ('divisions' == $tab)?true:false);
	echo $this->SetTabHeader('tours', 'Tours', ('tours' == $tab)?true:false);
	echo $this->SetTabHeader('partie', 'Parties', ('partie' == $tab)?true:false);
	echo $this->SetTabHeader('classement', 'Classement' , ('classement' == $tab)?true:false);

echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	echo $this->StartTab('divisions', $params);
    	include(dirname(__FILE__).'/action.admin_divisions_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('tours' , $params);//les équipes
    	include(dirname(__FILE__).'/action.admin_poules.php');
   	echo $this->EndTab();
/*
	echo $this->StartTab('partie', $params);//Calendrier
    	include(dirname(__FILE__).'/action.admin_calendar_tab.php');
   	echo $this->EndTab();

        echo $this->StartTab('classement', $params);//FFTT
    	include(dirname(__FILE__).'/action.admin_fftt_tab.php');
   	echo $this->EndTab();	
*/

echo $this->EndTabContent();
?>
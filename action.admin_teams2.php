<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Ping Use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
	

//on instancie les onglets

  echo '<div class="pageoverflow" style="text-align: left; width: 80%;">';
  echo $this->CreateLink($id,'defaultadmin',$returnid,'<= Menu principal',array("active_tab"=>"compets"));
  echo '</div>';

echo $this->StartTabheaders();
if (FALSE == empty($params['active_tab']))
  {
    $tab = $params['active_tab'];
  } else {
  $tab = 'divisions';
 }	
	//echo $this->SetTabHeader('equipes', 'Equipes', ('equipes' == $tab)?true:false);
	echo $this->SetTabHeader('calendrier', 'Calendrier et résultats', ('calendrier' == $tab)?true:false);
	echo $this->SetTabHeader('classement', 'Classement' , ('classement' == $tab)?true:false);
	echo $this->SetTabHeader('parties', 'Parties' , ('parties' == $tab)?true:false);

echo $this->EndTabHeaders();

echo $this->StartTabContent();
	/*
	echo $this->StartTab('equipes', $params);
    	include(dirname(__FILE__).'/action.admin_teams_tab.php');
   	echo $this->EndTab();
	*/
	echo $this->StartTab('calendrier' , $params);//les équipes
    	include(dirname(__FILE__).'/action.admin_poules_tab3.php');
   	echo $this->EndTab();

	echo $this->StartTab('classement', $params);//Div parties
    	include(dirname(__FILE__).'/action.admin_classement.php');
   	echo $this->EndTab();

        


echo $this->EndTabContent();
?>
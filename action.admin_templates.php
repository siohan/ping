<?php

if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Modify Templates') ) return;

echo '<div class="pageoverflow" style="text-align: right; width: 80%;">'.
$this->CreateImageLink($id,'defaultadmin',$returnid,
		       $this->Lang('lbl_back'),'icons/system/back.gif',array(),'','',false).'</div><br/>';

echo $this->StartTabHeaders();
echo $this->SetTabHeader('individuelles', $this->Lang('cal_fullcalendar_template'));
/*
echo $this->SetTabHeader('admin_calendar_template', $this->Lang('cal_calendar_template'));
echo $this->SetTabHeader('admin_list_template', $this->Lang('cal_list_template'));
echo $this->SetTabHeader('admin_upcominglist_template', $this->Lang('cal_upcominglist_template'));
echo $this->SetTabHeader('admin_event_template', $this->Lang('cal_event_template'));
echo $this->SetTabHeader('admin_search_form_templates', $this->Lang('cal_search_form_templates'));
echo $this->SetTabHeader('admin_search_result_templates', $this->Lang('cal_search_result_templates'));
echo $this->SetTabHeader('admin_myevents_templates',$this->Lang('cal_myevents_templates'));
echo $this->SetTabHeader('admin_editevent_templates',$this->Lang('cal_editevent_templates'));
echo $this->SetTabHeader('admin_default_templates', $this->Lang('cal_default_templates'));
*/
echo $this->EndTabHeaders();

echo $this->StartTabContent();
echo $this->StartTab("individuelles",$params);
include(__DIR__.'/function.admin_fullcalendar_template_tab.php');
echo $this->EndTab();
/*
echo $this->StartTab("admin_calendar_template",$params);
include(__DIR__.'/function.admin_calendar_template_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_list_template",$params);
include(__DIR__.'/function.admin_list_template_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_upcominglist_template",$params);
include(__DIR__.'/function.admin_upcominglist_template_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_event_template",$params);
include(__DIR__.'/function.admin_event_template_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_search_form_templates",$params);
include(__DIR__.'/function.admin_search_templates_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_search_result_templates",$params);
include(__DIR__.'/function.admin_search_result_templates_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_myevents_templates",$params);
include(__DIR__.'/function.admin_myevents_templates_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_editevent_templates",$params);
include(__DIR__.'/function.admin_editevent_templates_tab.php');
echo $this->EndTab();

echo $this->StartTab("admin_default_templates",$params);
include(__DIR__.'/function.admin_default_templates_tab.php');
echo $this->EndTab();
*/
echo $this->EndTabContent();
#
# EOF
#
?>
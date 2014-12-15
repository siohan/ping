<?php
$lang["friendlyname"]="Polls Made Simple";
$lang["moddescription"]="This module provides simple voting functionality to the frontend users";
$lang["permission"]="Administrate Polls";
$lang["postinstall"]="Polls version %s was successfully installed";

$lang["upgraded"]="Polls was successfully upgraded to version %s";

$lang["really_uninstall"]="Are you sure you want to uninstall Polls and erase all gathered data?";
$lang["postuninstall"]="Polls was successfully uninstalled";

$lang["help_poll_id"]="Use this to specify the id another poll than the one set as active";
$lang["help_showclosed"]="Set this to 1 to include results of closed polls in the output";

$lang["pollid"]="Poll ID";
$lang["pollsettings"]="Poll settings";
$lang["showwhatpoll"]="Show";
$lang["activepoll"]="Active poll";
$lang["defaultpoll"]="Default poll";
$lang["makedefaultpoll"]="Make default poll";
$lang["randompoll"]="Randomly chosen open poll";
$lang["allopen"]="All open polls";

$lang["pollname"]="Poll name";
$lang["pollstatus"]="Poll status";
$lang["activepoll"]="Active";
$lang["edit"]="Edit";
$lang["delete"]="Delete";
$lang["pollstartdate"]="Start date";
$lang["pollclosedate"]="Close date";
$lang["pollinfo"]="Poll info";
$lang["pollid"]="Poll ID";
$lang["updatepoll"]="Update poll";
$lang["pollupdated"]="Poll updated";
$lang["pollranfor"]="Poll ran for";
$lang["pollhasbeenrunningfor"]="Poll has been running for";
$lang["days"]="days";

$lang["open"]="Open";
$lang["closed"]="Closed";
$lang["openpoll"]="Open poll";
$lang["closepoll"]="Close poll";
$lang["confirmclosepoll"]="Are you sure this poll should be closed?";

$lang["confirmopenpoll"]="Are you sure this poll should be opened?";

$lang["pollwasclosed"]="The poll was closed";
$lang["pollwasopened"]="The poll was opened";


$lang["addpoll"]="Add poll";

$lang["addnewpoll"]="Add new poll";
$lang["addandaddoptions"]="Add poll and options";
$lang["pollnamerequired"]="A name for the poll is required";
$lang["pollidrequired"]="A unique ID for the poll is required";

$lang["polladded"]="The poll was added";
$lang["add"]="Add";

$lang["actions"]="Actions";

$lang["cancel"]="Cancel";
$lang["confirmdeletepoll"]="Are you sure this poll should be deleted?";
$lang["polldeleted"]="The poll was deleted";

$lang["confirmresetpoll"]="Are you sure you want to reset votes for this poll?";
$lang["optionnamerequired"]="A name for the option is required";
$lang["addoption"]="Add option";
$lang["votes"]="Votes";
$lang["votepercent"]="%";
$lang["deleteoption"]="Delete option";
$lang["confirmdeleteoption"]="Are you sure you want to delete this option?";
$lang["editoptions"]="Edit options";
$lang["editoption"]="Edit option";
$lang["save"]="Save";
$lang["addingto"]="Adding to: ";
$lang["optionadded"]="The option was added";
$lang["optiondeleted"]="The option was deleted";
$lang["addnewoption"]="Add option";

$lang["editpoll"]="Edit poll";
$lang["resetpoll"]="Reset poll";
$lang["pollreset"]="The votes of this poll was reset";
$lang["optionname"]="Option name";
$lang["template"]="Template";

$lang["polls"]="Polls";

$lang["showpeekbutton"]="Show peek-button";

$lang["settings"]="Settings";
$lang["savesettings"]="Save settings";
$lang["settingssaved"]="Settings was saved";
$lang["polltemplate"]="Poll template";
$lang["resulttemplate"]="Result template";
$lang["listtemplate"]="Poll list template";

$lang["return"]="Return";
$lang["ok"]="OK";
$lang["resettodefault"]="Reset to default template";
$lang["confirmtemplate"]="Are you sure you want to reset to default template?";
$lang["templatesaved"]="The template was saved";
$lang["templatereset"]="The template was reset to default";

$lang["votetext"]="vote";
$lang["votestext"]="votes";
$lang["totalvotes"]="Total votes";
$lang["vote"]="Vote";
$lang["peekresult"]="Peek result";
$lang["returntovote"]="Goto voting";

$lang["registervotedby"]="Allow voting";
$lang["oncepersession"]="Once per session";
$lang["onceperip"]="Once per IP";
$lang["always"]="Always";


$lang["pollcontenthelp"]="
Parameters available:<br/><br/>
{\$pollname}<br/>
{\$pollid}<br/>
{\$totalvotestext}<br/>
{\$totalvotes}<br/>
{\$peekform} - a button to peek the result<br/>
{\$voteform} - a button to return to voteform when peeking<br/>
<br/>
{\$option->label} - the optiontext<br/>
{\$option->uniqueid} - a unique text-id<br/>
{\$option->value} - the value that should be returned
";


$lang["resultcontenthelp"]="
Parameters available:<br/><br/>
{\$pollid}<br/>
{\$pollname}<br/>
<br/>
{\$option->label} - the optiontext<br/>
{\$option->votes} - The number of votes<br/>
{\$option->percent} - The percent of this option
";

$lang['donationstab']="Donations";
$lang['hidedonationssubmit']="Hide donations tab";
$lang['donationstext']="A lot of time and effort has been put into creating this module.
Please consider a small donation (5€ for instance, or what you can spare) using the PayPal-button below, especially if you use this module
in a commercial context.
<br/><br/>
If you donate more than 30€ you can have a link to your company on this page, if you wish to. Send me an email about what you would like shown and I will put it in for the next version.
<br/><br/>
Thank you!";

$lang['sponsors']="Current sponsers, thank you for your support!";


$lang["help"]="
<b>What does this module do?</b>
<br/>
This module provides an easy way to show Ajax-powered polls on your page. The look polls are easily customized using the
templates and css. 
<br/>
<b>How do I use this module?</b>
<br/>
Basically you install the module, access it's administration interface and creates a poll, you add options to it
and activates it.
<br/>
In you page content or template you then insert something like:
<pre>
{Polls}
</pre>
and your activat poll should emerge there. Remember that in order for the required AjaxMadeSimple-module to do it's stuff you need
to add {AjaxMadeSimple} somewhere in your html-header (in template or metadata)

";
?>
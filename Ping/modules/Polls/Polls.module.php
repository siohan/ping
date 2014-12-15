<?php
# PollsMadeSimple. A plugin for CMS - CMS Made Simple
# Copyright (c) 2006-2007 by Morten Poulsen (morten@poulsen.org)
#
# CMS- CMS Made Simple is Copyright (c) Ted Kulp (wishy@users.sf.net)
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

class Polls extends CMSModule {
	function GetName() {		
		return 'Polls';
	}

	function GetFriendlyName() {
		return $this->Lang('friendlyname');
	}

	function GetVersion() {
		return '1.1.0';
	}

	function GetHelp() {
		return $this->Lang('help');
	}

	function GetAuthor() {
		return 'Silmarillion';
	}

	function GetAuthorEmail()	{
		return 'morten@poulsen.org';
	}
	
	function GetChangeLog()	{
		return $this->ProcessTemplate("changelog.tpl");
	}

	function IsPluginModule() {
		return true;
	}

	function HasAdmin() {
		return true;
	}

	function GetAdminSection() {
		return 'extensions';
	}

	function GetAdminDescription() {
		return $this->Lang('moddescription');
	}

	function GetDependencies() {
		return array("AjaxMadeSimple"=>"0.3.1");
	}

	function VisibleToAdminUser() {
		return ($this->CheckPermission('administratepolls') || $this->CheckPermission('Modify Templates') || $this->CheckPermission('Modify Site Preferences'));
	}

	function MinimumCMSVersion() {
		return "1.11";
	}

	function InstallPostMessage() {
	  return $this->Lang('postinstall',$this->GetVersion());
	}
	 
	function UninstallPostMessage() {	
	  return $this->Lang('postuninstall');
	}

	function UninstallPreMessage() {
		return $this->Lang('really_uninstall');
	}

  function SetParameters() {
    $this->RestrictUnknownParams();
    $this->RegisterModulePlugin();
    $this->CreateParameter('poll_id',"", $this->Lang('help_poll_id'));
    $this->SetParameterType('poll_id',CLEAN_STRING);

    $this->CreateParameter('showclosed',"", $this->Lang('help_showclosed'));
    $this->SetParameterType('showclosed',CLEAN_INT);
  }


  function AuthenticateAjaxMSCall($methodname) {
    if ($methodname=="PeekPoll") return true;
    if ($methodname=="ExecuteVote") return true;
    if ($methodname=="ReturnToPoll") return true;

    return false;
  }

  function DefaultPoll() {
    $activepoll=$this->GetPreference("defaultpoll",-1);
		return $activepoll;
	}

	function TimeoutBlockings($pollid) {
    $db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_pollblocked WHERE pollid=? AND votetime<?";
		$p=array($pollid,time()-(3600*24));
		/*$result=*/$db->Execute($q,$p);
	}

	function UserAlreadyVoted($pollid) {
    $registerby=$this->GetPReference("registervotedby","seesion");
    if ($registerby=="always") return false;
    $db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_pollblocked WHERE pollid=? AND sessionid=?";
		//$p=array($pollid,session_id());
    $p=array();
    if ($registerby=="session") {
      $p=array($pollid,session_id());
    } else {
      if (!isset($_SERVER["REMOTE_ADDR"])) return true;
      $p=array($pollid,$_SERVER["REMOTE_ADDR"]);
    }
		$result=$db->Execute($q,$p);
		if (!$result || $result->RecordCount()<1) {
			return false;
		} else {
			return true;
		}
	}


	function GetOptionList($pollid) {
		$db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_polloptions WHERE pollid=?";
		$p=array($pollid);
		$result=$db->Execute($q,$p);
		if (!$result) return false;
		if ($result->RecordCount()==0) return array();
		$optionlist=array();
		while ($row=$result->FetchRow()) {
			$optionlist[]=$row;
		}
		return $optionlist;
	}

	function GetPollName($pollid) {
    $db=cmsms()->GetDb();
		$q="SELECT name FROM ".cms_db_prefix()."module_polls WHERE id=?";
		$p=array($pollid);
		$result=$db->Execute($q,$p);
		if ($result && $result->RecordCount()>0) {
			$row=$result->FetchRow();
			return $row["name"];
		} else {
			return false;
		}
	}

	function GetTotalVotes($pollid) {
    $db=cmsms()->GetDb();
		$q="SELECT count FROM ".cms_db_prefix()."module_polloptions WHERE pollid=?";
		$p=array($pollid);
		$result=$db->Execute($q,$p);
		$totalvote=0;
		if ($result && $result->RecordCount()>0) {
			while ($row=$result->FetchRow()) {
				$totalvote+=$row["count"];
			}
		}
		return $totalvote;
	}

	function GetPollOutput($pollid) {
		$polltemplate=$this->GetPreference("polltemplate", $this->GetTemplateFromFile("defaultpoll"));

		$ajaxobject=$this->GetModuleInstance("AjaxMadeSimple");
		$optionlist=$this->GetOptionList($pollid);

		$optionarray=array();
		foreach ($optionlist as $option) {
			$entry=new stdClass();
			$entry->uniqueid="polloption_".$pollid."_".$option["id"];
			$entry->label=$option["name"];
			$entry->value=$option["id"];

			//For backwards compatibility with older templates
			$entry->optionname=$option["name"];
			$entry->optioninput="<input id='".$entry->uniqueid."' type='radio' name='pollvotingchoice' value='".$option["id"]."' />";
			array_push($optionarray,$entry);
		}

		$this->smarty->assign('pollid',$pollid);
		
		$this->smarty->assign('pollname',$this->GetPollName($pollid));
		$this->smarty->assign_by_ref('options', $optionarray);

		$this->smarty->assign('formstart','<form action="#" '.$ajaxobject->GetFormOnSubmit($this->GetName(),"poll_".$pollid).'>');

		$formend="<input type='submit' id='vote' name='vote' value='".$this->Lang('vote')."' />";
		//$formend.="<input type='submit' id='peek' name='peek' value='".$this->Lang('peekresult')."' />";
		$formend.="</form>";
		$this->smarty->assign('formend',$formend);

		$peekform="";
		if ($this->GetPreference("showpeekbutton",0)==1) {
			$peekform='<form action="#" '.$ajaxobject->GetFormOnSubmit($this->GetName(),"peek_".$pollid).'>';
			$peekform.="<input type='submit' id='peek' name='peek' value='".$this->Lang('peekresult')."' />";
			$peekform.="</form>";
		}

		$this->smarty->assign('peekform',$peekform);
		
		$output="<div id='pollcontent_".$pollid."'>\n";
		$output.=$this->ProcessTemplateFromData($polltemplate);
		$output.="\n</div>\n";
		
		return $output;
	}

	function GetResultOutput($pollid,$closed=false) {
    
		$ajaxobject=$this->GetModuleInstance("AjaxMadeSimple");
		$totalvotes=$this->GetTotalVotes($pollid);
		$optionlist=$this->GetOptionList($pollid);
		$resulttemplate=$this->GetPreference("resulttemplate", $this->GetTemplateFromFile("defaultpolllist"));
		$optionarray=array();
		foreach ($optionlist as $option) {
			$entry=new stdClass();
			
			$entry->label=$option["name"];
			
			$percent=0;
			if ($option["count"]>0) $percent=round(($option["count"]*100)/$totalvotes);
			
			$entry->percent=$percent.="%";
			$entry->votes=$option["count"];
			$entry->optionvotes=$option["count"];
			
			//For compatibility
			$entry->optionname=$option["name"];
			array_push($optionarray,$entry);
		}
		
		$this->smarty->assign('pollid',$pollid);
		
		$this->smarty->assign('votestext',$this->Lang("votestext"));
		$this->smarty->assign('votetext',$this->Lang("votetext"));
		$this->smarty->assign('totalvotestext',$this->Lang("totalvotes"));
		$this->smarty->assign('totalvotes',$totalvotes);
		$this->smarty->assign('pollname',$this->GetPollName($pollid));
		$this->smarty->assign_by_ref('options', $optionarray);


		$voteform="";
    
		if (!$this->UserAlreadyVoted($pollid) && !$closed) {
      //echo "hi";die();
			$voteform="<form action='#' ".$ajaxobject->GetFormOnSubmit($this->GetName(),"return_".$pollid)."'>";
			$voteform.="<input type='submit' id='returntovote' value='".$this->Lang('returntovote')."' />";
			$voteform.="</form>";
		}
		$this->smarty->assign('voteform',$voteform);
		$output="<div id='pollcontent_".$pollid."'>\n";
    //return "blah";
		$output.=$this->ProcessTemplateFromData($resulttemplate);
		$output.="\n</div>\n";

		return $output;
	}

	function PeekPoll($vars) {
    //return print_r($vars,true);
		return $this->GetResultOutput($vars["pollid"]);
	}

	function ReturnToPoll($vars) {
		return $this->GetPollOutput($vars["pollid"]);
	}

	function ExecuteVote($vars) {
		if ($this->UserAlreadyVoted($vars["pollid"])) {
			return $this->GetResultOutput($vars["pollid"]);
		}

    if (!isset($_SERVER["REMOTE_ADDR"])) {
      return $this->GetResultOutput($vars["pollid"]);
    }

		if ($vars["pollvotingchoice_".$vars["pollid"]]=="") return $this->GetPollOutput($vars["pollid"]);
    $db=cmsms()->GetDb();
		$q="UPDATE ".cms_db_prefix()."module_polloptions SET count=count+1 WHERE id=?";
		$p=array($vars["pollvotingchoice_".$vars["pollid"]]);
		$result=$db->Execute($q,$p);
//		print_r($vars);

		if (session_id()=="") session_start();

		$q="INSERT INTO ".cms_db_prefix()."module_pollblocked (sessionid,votetime,pollid) VALUES (?,?,?)";
    $p=array();
    switch($this->GetPreference("registervotedby","session")) {
      case "always" : $p=array("",time(),$vars["pollid"]); break;
      case "session" : $p=array(session_id(),time(),$vars["pollid"]); break;
      case "ip" : $p=array($_SERVER["REMOTE_ADDR"],time(),$vars["pollid"]); break;
    }
		
		$result=$db->Execute($q,$p);

		return $this->GetResultOutput($vars["pollid"]);
	}

  function ShowDonationsTab() {
    return ($this->GetPreference("hidedonationstab")!=$this->GetVersion());
  }

  function _getthemeobj() {
    global $gCms;
    
    $themeObject = $gCms->variables['admintheme'];
    return $themeObject;
  }
}

?>

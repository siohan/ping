<?php

if (!function_exists("cmsms")) exit;

$ajax=$this->GetModuleInstance("AjaxMadeSimple");

$db=$this->GetDb();

$defaultpoll=$this->DefaultPoll();
//echo $pollid;

$pollstoshow=array($defaultpoll);

if(isset($params['poll_id'])) {
  //AND closed = 0
  $q="SELECT * FROM ".cms_db_prefix()."module_polls WHERE poll_id = ?  ORDER BY createtime DESC";
  $p=array($params["poll_id"]);
  $result=$db->Execute($q,$p);
  if ($result && $result->RecordCount()>0) {
    $row=$result->FetchRow();
    $pollstoshow=array($row);
  }
} else {
  if ($this->GetPreference("showwhatpoll","defautpoll")=="randompoll") {
    $q="SELECT * FROM ".cms_db_prefix()."module_polls"; // WHERE closed <> 1
    $result=$db->Execute($q);
    if ($result && $result->RecordCount()>0) {
      $count=$result->RecordCount();
      $chosen=rand(1,$count);
      while ($chosen>0) {
        $row=$result->FetchRow();
        $pollstoshow=array($row);
        $chosen--;
      }
    }
  } elseif ($this->GetPreference("showwhatpoll","defautpoll")=="allopen") {
    $q="SELECT * FROM ".cms_db_prefix()."module_polls"; // WHERE closed <> 1
    $result=$db->Execute($q);
    if ($result && $result->RecordCount()>0) {
      $pollstoshow=array();
      while ($row = $result->FetchRow()) {        
        $pollstoshow[]=$row;
      }
    }
  }
}

$ajax->SetupAjaxMS($id, $returnid);

foreach ($pollstoshow as $poll) {
//  echo $poll["closed"];
  $closed=false;
  if ($poll["closed"]=="1") {
    if (isset($params["showclosed"]) && $params["showclosed"]=="1") {
      $closed=true;
    } else {
      continue;
    }
  }
  $ajax->RegisterAjaxRequester($this->GetName(),"ExecuteVote","poll_".$pollid,"pollcontent_".$pollid,array("pollid"=>$pollid),array("pollvotingchoice_".$pollid=>"radio","vote"=>""));
//echo "hiii";
  if ($this->GetPreference("showpeekbutton","")!="") {
    $ajax->RegisterAjaxRequester($this->GetName(),"PeekPoll","peek_".$pollid,"pollcontent_".$pollid,array("pollid"=>$pollid),array("peek"=>""));  
  }
  $ajax->RegisterAjaxRequester($this->GetName(),"ReturnToPoll","return_".$pollid,"pollcontent_".$pollid,array("pollid"=>$pollid),array("returntovote"=>""));

  if ($this->UserAlreadyVoted($poll["id"]) || $closed) {
    //if ($closed) echo "hi";
    echo $this->GetResultOutput($poll["id"],$closed);
  } else {
    echo $this->GetPollOutput($poll["id"]);
  }

}

?>
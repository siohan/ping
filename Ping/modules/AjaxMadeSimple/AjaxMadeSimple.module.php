<?php
# AjaxMadeSimple. A plugin for CMS - CMS Made Simple
# Copyright (c) 2006-10 by Morten Poulsen (morten@poulsen.org)
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


class AjaxMadeSimple extends CMSModule {
  var $ajaxmsactive=false;
  var $startersent=false;
  var $config=array();
  var $_id;
  var $_returnid;

  function GetName() {
    return 'AjaxMadeSimple';
  }

  function GetFriendlyName() {
    return $this->Lang('friendlyname');
  }

  function GetVersion() {
    return '0.4.0';
  }

  function GetHelp() {
    return $this->ProcessTemplate("help.tpl");
  }

  function GetAuthor() {
    return 'Silmarillion';
  }

  function GetAuthorEmail() {
    return 'morten@poulsen.org';
  }

  function GetChangeLog() {
    return $this->ProcessTemplate("changelog.tpl");
  }

  function IsPluginModule() {
    return true;
  }

  function HasAdmin() {
    return false;
  }

  function GetAdminSection() {
    return 'extensions';
  }

  function GetAdminDescription() {
    return $this->Lang('moddescription');
  }

  function MinimumCMSVersion() {
    return "1.9";
  }

  function UninstallPreMessage() {
    return $this->Lang('really_uninstall');
  }

  function InitializeFrontend() {
    //$this->RestrictUnknownParams(true);
    $this->RegisterModulePlugin();

    /*$this->SetParameterType('modulename',CLEAN_STRING);
    $this->SetParameterType('method',CLEAN_STRING);
    $this->SetParameterType('vars',CLEAN_STRING);*/
  }

  function SetupAjaxMS($id,$returnid="") {
    $this->_id=$id;
    $this->_returnid=$returnid;
  }


  function GetHeaderLink($id,$returnid) {    
    $params=array();
    $scripturl=$this->CreateLink($id, "ajaxmadesimple", $returnid, '', $params, '', true);
    return '<script type="text/javascript" src="'.$scripturl.'&amp;showtemplate=false"></script>';
  }
   
  function RegisterAjaxRequester($modulename, $method, $textid, $divid ,$params=array(),$formfields=array(),$refresh=-1) {
    if (session_id()=="") session_start();
    if ($method != "") {
      if (!$this->ajaxmsactive) {
        //Clear old values
        $_SESSION["ajaxmsgeneratedcode"]="";
        unset($_SESSION["ajaxmsgeneratedcode"]);
        $this->ajaxmsactive=true;
      }
      $name=$modulename.$textid;
      $starter="";
      if (!$this->startersent) {
        $starter='
function gethttp() {
  var http_request = false;
  if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    http_request = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // IE
    try {
      http_request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        http_request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {}
    }
  }
  if (!http_request) {
    alert("Giving up :( Cannot create an XMLHTTP instance");
    return false;
  } else {
    return http_request;
  }
}

function getValues(field, clear) {
  var type, values=[];

  type=field.tagName.toLowerCase();
  if(type == "input") {
    type = field.type.toLowerCase();
  }
  switch(type) {
    case "radio":
    case "checkbox":
      if(field.checked) {
        values.push(field.value);
        if(clear) {
          field.checked=false;
        }
      }
      break;
    case "select":
      value = [];
      for(var i=0; i<field.options.length; i++) {
        var option=field.options.item(i);
        if(option.selected) {
          values.push(option.value);
          if(clear) {
            option.selected=false;
          }
        }
      }
      break;
    default:
      values.push(field.value);
      if(clear) {
        field.value="";
      }
      break;
  }
  return values;
}

function getQueryString(form, fieldNames) {
  var field, values, queryString="";
  for(var fieldName in fieldNames) {
    field=form.elements[fieldName];
    if(typeof(field) != "undefined") {
      if(field instanceof NodeList) {
        for(var f=0; f<field.length; f++) {
          if(field[f].name!="") {
            values = getValues(field[f], fieldNames[fieldName]);
            for(var i=0; i<values.length; i++) {
              queryString += "&"+field[f].name+"="+values[i];
            }
          }
        }
      } else {
        if(field.name!="") {
          values = getValues(field, fieldNames[fieldName]);
          for(var i=0; i<values.length; i++) {
            queryString += "&"+field.name+"="+values[i];
          }
        }
      }
    }
  }
  return queryString;
}
';
        $this->startersent=true;
      }

      $vars="";
      if (count($params)>0) {
        foreach ($params as $paramname=>$value) {
          $vars.="&".$paramname."=".$value;//base64_encode
        }
      }
      /*
      $params=array_merge(
              $params,
              array(
              "modulename"=>$modulename,
              "method"=>$method,
              )
      );
      */
      $scripturl=$this->CreateLink($this->_id, "handlerequest", $this->_returnid, '', array()/*$params*/, '', true);
      $scripturl.="&modulename=".$modulename;
      $scripturl.="&method=".$method;
      $scripturl.=$vars;     

      $submithandler="
function ".$name."FormSubmit(form) {";
      if (count($formfields)>0) {
        $fields=array();
        foreach ($formfields as $field=>$option) {
          $fields[]="'".$field."': ".($option=='clear'?'true':'false');
        }
        $submithandler.="
  var fieldNames={".implode(', ', $fields)."};";
      } else {
        $submithandler.="
  var fieldNames={};
  for(var i=0; i<form.elements.length;i++) {
    fieldNames[i]=false;
  }
";
      }
      $submithandler.="
  var queryString = getQueryString(form, fieldNames);
  var http_request=gethttp();
  http_request.onreadystatechange = function() { alert".$name."(http_request,false); };
  http_request.open('GET', '".$scripturl."'+queryString+'&showtemplate=false', true);
  http_request.send(null);
  return false;
}
";

      if($refresh!=-1) {
        $requester="
function make".$name."Request() {
  var http_request=gethttp();
  http_request.onreadystatechange = function() { alert".$name."(http_request,true); };
  http_request.open('GET', '".$scripturl."&showtemplate=false', true);
  http_request.send(null);
}
";
      } else {
        $requester="";
      }

      $alert="
function alert".$name."(http_request,refresh) {
  if (http_request.readyState == 4) {
    if (http_request.status == 200) {
      element=document.getElementById('".$divid."');
      element.innerHTML=http_request.responseText;
      h = element.scrollHeight;
      element.scrollTop = h;";
      if ($refresh!="-1") {
        $alert.="
      if (refresh) window.setTimeout('make".$name."Request()',".$refresh.");";
      }
      $alert.="
    } else {
      alert('There was a problem with the request.');
    };
  }
}
";

      if ($refresh!=-1) {
        $refreshstarter="make".$name."Request();
";
      } else {
        $refreshstarter="";
      }

      $code=$starter.$requester.$submithandler.$alert.$refreshstarter;

      $_SESSION["ajaxmsgeneratedcode"].=$code;
    }
  }

  /**
   * Get an onsubmit condition for your ajax form
   *
   * @param string $modulename The module you want to work with
   * @param string $textid an id (??)
   * @param string $pre Javascript you want to put before the FormSubmit.
   * @param string $post Javascript you want to put post the FormSubmit.
   * @return string Returns [onsubmit="blabla"]
   */

  function GetFormOnSubmit($modulename,$textid,$pre="",$post="") {
    $name=$modulename.$textid;
    return " onsubmit='".$pre."return ".$name."FormSubmit(this);".$post."'";
  }

  /**
   * This function allow you to run a part of your module externaly, so you can load it in an iframe, for example
   *
   * @param string $modulename Name of the module you call
   * @param string $method Name of the method you want to execute
   * @param string $vars List of vars in a POST style string
   * @param vars $valuesList of value in a POST style string
   * @return string An url to load to get the method executed
   */

  function GetRequestURL ($modulename, $method, $vars=array(), $values=array()) {
    $params=array_merge(
            array(
            "modulename"=>$modulename,
            "method"=>$method,
            ),
            $vars,
            $values
    );
    $scripturl=$this->CreateLink($this->id, "handlerequest", $this->_returnid, '', $params, '', true);
    return $scripturl;    
  }
}

?>
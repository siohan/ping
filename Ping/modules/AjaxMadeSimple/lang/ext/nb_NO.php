<?php
$lang['friendlyname'] = 'Ajax Made Simple ';
$lang['moddescription'] = 'A developer-only modul som tillater lett tilgang til Ajax-funktionalitet i andre moduler';
$lang['installed'] = 'Ajax Made Simple versjon %s ble installert';
$lang['postinstall'] = 'Ajax Made Simple versjon %s ble installert';
$lang['upgraded'] = 'Ajax Made Simple versjon ble oppgradert til versjon %s';
$lang['really_uninstall'] = 'Er du sikker p&aring; at Ajax Made Simple skal avinstalleres? Enhver modul som avhenger av denne vil ikke lengre fungere!';
$lang['uninstalled'] = 'Ajax Made Simple ble avinstallert';
$lang['modulenotfound'] = 'Modulen [%s] ble ikke funnet';
$lang['methodnotfound'] = 'Metoden [%s] i modulen [%s] ble ikke funnet';
$lang['modulecannotauthenticate'] = 'Modulen [%s] er ikke forberedt p&aring; de nye sikkerhetstiltakene bygget inn i AjaxMS 0.3 +. Vennligst oppdater modulen og/eller kontakt modulutvikleren.';
$lang['methodfailedauthentication'] = 'Modulen [%s] tilkjennega ikke at AjaxMS kunne kalle metoden [%s]. Ta kontakt med modulutvikleren.';
$lang['help'] = '
<b>What does this module do?</b><br/>
Ajax Made Simple is a developer only module which provides an API to allow module-programmers
to easily add Ajax-functionality to the frontend of their modules. Admin-functionality is planned.
<br/> 
NOTE: About the Admin functionality, it works. You can call the &quot;GetHeaderHTML&quot; later on the page instead of on the header. (It&#039;s not a clean way, but it will be fixed and for the moment, it work)
<br/>
<br/>
<b>How do I use this module?</b><br/>
You should first of all make sure that your module depends on the AjaxMadeSimple to make sure it will work
on all systems. You could add checks to allow functionality without AjaxMadeSimple, but if you want that you probably also
know how todo it, so I won&#039;t cover that.<br>
<br/>
In your module-frontend, that is for instanse your Action-function or your action.default.php-file set up the
Ajax-requester and provide either the external file or the module-method providing the new content for Ajax to
substitute.
<br/>
You only need 1 or 2 function to set it up and the API goes like this:<br/>
<pre>
function RegisterAjaxRequester($modulename,$textid,$divid,$method=&quot;&quot;,$filename=&quot;&quot;,$params=array(),$formfields=array(),$refresh=-1)  {
</pre>
The parameters:<br/>
<i>$modulename</i> is the name of your module, just use $this->GetName()
<br/><br/>

<i>$textid</i> is a unique id for this requester, allowing you to use several requester in the same module. The modulename is automatically
added to the name to there&#039;s no need to make it site-wide unique.
<br/><br/>

<i>$divid</i> is the id of the div inside which you want the new content to be put. Everything within this div is replaced.
<br/><br/>

<i>$method (optional)</i> is the name of the method in you module that you want to recieve input from Ajax and provide the new content.
It could be called anything, but should be in the form: function $MyAjaxOutput($vars=array()); $vars is an array containing
any info you wanted to pass to the Ajax-provider, like content of form fields or other info (see the $params and $formfields below).
<b></b>

<i>$filename (optional)</i> is the name of the file you want to recieve the connection from ajax. Things like formfields or other info is passed in the
$_GET array and is base64-encoded! Please use base64_decode()-function for proper values! If the $method parameter is set, $filename is ignored.
<br/>

<b>Please not that either $method or $filename should be se to something working. And $method has presedence...</b
<br/><br/>

<i>$params (optional)</i> is an array containing any info you want to pass on to the ajax-provider. Use the form array(&quot;varname&quot;=>&quot;value&quot;)
<br/><br/>

<i>$formfields (optional)</i> is an array containing the form-input-id&#039;s of the fields whose content you want
to pass on the the ajax-provider.
Fields can optionally be clear after send. Use the form array(&quot;myfieldid&quot;=>&quot;option&quot;)<br>
Valid options so far is:<br>
&nbsp;&nbsp;<i>clear</i> - which clears a textfield after ajax has been activated (in a chat input-field for instance, see Chat-module)
<br/>
&nbsp;&nbsp;<i>radio</i> - which indicates that the wanted field is a set of radio-buttons (for instance in a voting box, see Polls-module, which have to be processed
in a special way by ajax. Please not that when referring to radio-buttons the name-of the button tag is used, not the id!
<br/>
Please not, that for now only 1 option is possible for each formfield. This may change in future versions.

<br/><br/>

<i>$refresh (optional)</i> allows you to trigger recurring ajax-requests every x&#039;th millisecond. Allow self-updating content. Default is no automatic refresh.
<br/><br/>

 <pre>
 function GetFormOnSubmit($modulename,$textid,$pre=&quot;&quot;,$post=&quot;&quot;)
 </pre>
 The output returned from this function should be put into the form-statement of a form to automatically
 trigger a Ajax-request when the form is submitted. It can be used as $extra in the module-API function CreateFormStart()
 or simply echo&#039;ed into your own form before the ending > in the form-tag.
 <br/><br/>
 The parameters:<br/>
 <i>$modulename</i> is the name of your module, just use $this->GetName()
<br/><br/>

<i>$textid</i> is a unique id for this requester, allowing you to use several requester in the same module. The modulename is automatically
added to the name to there&#039;s no need to make it site-wide unique.
<br/><br/>
<i>$pre (optional)</i> is any info to be inserted before the Ajax-stuff in the result.
<b></b>
<i>$post (optional)</i> is any info to be inserted after the Ajax-stuff in the result.
<br/>
<br/>
<br/>
For a live example of usage, please install the ChatMadeSimple-module and look into the files:
<pre>
action.default.php (setting up the connections, one using a method the other and external file)
onlinenow.php (the external file-provider)
AjaxMadeSimple.method.php (find the ChatEngine-function exampling a method-provider)
</pre>
The Polls-module also uses AjaxMS in a whole other way, so please have a look there as well.
<br/>
<br/>
Good luck! It&#039;s actually quite easy when you get the hang of it ;-) And feel free to ask for features or help on getting
your module Ajaxified!
';
$lang['utmz'] = '156861353.1279922282.3039.70.utmcsr=forum.cmsmadesimple.org|utmccn=(referral)|utmcmd=referral|utmcct=/index.php';
$lang['utma'] = '156861353.179052623084110100.1210423577.1280528274.1280578300.3078';
$lang['qca'] = '1210971690-27308073-81952832';
$lang['utmb'] = '156861353.2.10.1280578300';
$lang['utmc'] = '156861353';
?>
<?php
$lang['friendlyname'] = 'Ajax Made Simple';
$lang['moddescription'] = 'Modul za razvijalce, ki omogoča preprost dostop do Ajax funkcionalnosti v ostalih modulih';
$lang['installed'] = 'Ajax Made Simple različica %s je bil uspe&scaron;no name&scaron;čen';
$lang['postinstall'] = 'Ajax Made Simple različica %s je bil uspe&scaron;no name&scaron;čen';
$lang['upgraded'] = 'Ajax Made Simple je bil uspe&scaron;no nadgrajen na različico %s';
$lang['really_uninstall'] = 'Ste prepričani, da želite odstraniti Ajax Made Simple? Vsi moduli, ki so od tega modula odvisni, ne bodo več delovali!';
$lang['uninstalled'] = 'Ajax Made Simple je bil uspe&scaron;no odstranjen';
$lang['modulenotfound'] = 'Modul [%s] ni bil najden';
$lang['methodnotfound'] = 'Metoda [%s] v moduli [%s] ni bila najdena';
$lang['changelog'] = '<ul>
<li><b>0.1.6</b> - 
<li><b>0.1.5</b> - <ul>
  <li>Added a lot of comments in code</li>
	<li>Fixed stupid bug preventing javascript inclusions to appear in many circumstances.</li>
	<li>Added backware compatibility with PHP4</li>
	<li>Added some stuffs to allow you to create an upload file form &quot;working/dealing&quot; with your module and Ajax</li>
	</ul></li>
<li><b>0.1.4</b> - Rewrote to using sessions to carry generated code into the external js-returning file
<li><b>0.1.3</b> - Moved javascript to an external file
<li><b>0.1.2</b> - Added handling of radiobuttons, fixed involentary refreshes due to bad default paramter-value</li>
<li><b>0.1.1</b> - Honestly don&#039;t remember</li>
<li><b>0.1.0</b> - First functioning release</li>
</ul>
';
$lang['help'] = '<b>What does this module do?</b><br/>
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
$lang['utma'] = '156861353.587959277.1217433595.1217433595.1217433595.1';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1217433595.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
?>
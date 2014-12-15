<?php
$lang['friendlyname'] = 'Ajax Made Simple.';
$lang['moddescription'] = 'Diğer mod&uuml;llerde Ajax işlevselliklerine kolay erişimi sağlayan bir salt-geliştirici mod&uuml;l.';
$lang['installed'] = 'Ajax Made Simple s&uuml;r&uuml;m %s başarıyla y&uuml;klendi';
$lang['postinstall'] = 'Ajax Made Simple s&uuml;r&uuml;m %s başarıyla y&uuml;klendi';
$lang['upgraded'] = 'Ajax Made Simple s&uuml;r&uuml;m&uuml; başarıyla %s s&uuml;r&uuml;m&uuml;ne y&uuml;kseltildi';
$lang['really_uninstall'] = 'Ajax Made Simple&#039;ın silinmesi gerektiğine emin misiniz? Ona bağlı mod&uuml;ller bundan sonra &ccedil;alışmayacaktır!';
$lang['uninstalled'] = 'Ajax Made Simple başarıyla kaldırıldı';
$lang['modulenotfound'] = 'mod&uuml;l [%s] bulunamadı';
$lang['methodnotfound'] = 'module [%s]teki [%s] metodu bulunamadı';
$lang['changelog'] = '<ul>
<li><b>0.1.4</b> - Rewrote to using sessions to carry generated code into the external js-returning file
<li><b>0.1.3</b> - javascript bir dış dosyaya taşındı
<li><b>0.1.2</b> - radyotuşlarını y&ouml;netme eklendi,  k&ouml;t&uuml; bir &ouml;ntanımlı parametre değerinin sebep olduğu istenmeyen yenilemeler d&uuml;zeltildi</li>
<li><b>0.1.1</b> - D&uuml;r&uuml;st olmak gerekirse hatırlamıyorum</li>
<li><b>0.1.0</b> - İlk &ccedil;alışan s&uuml;r&uuml;m</li>
</ul>
';
$lang['help'] = '<b>Bu mod&uuml;l ne yapar?</b><br/>
Ajax Made Simple is a developer only module which provides an API to allow module-programmers
to easily add Ajax-functionality to the frontend of their modules. Admin-functionality is planned.
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
$lang['utma'] = '156861353.1630041645.1190687897.1191165039.1191615672.6';
$lang['utmz'] = '156861353.1190927862.3.2.utmccn=(referral)|utmcsr=us.mg1.mail.yahoo.com|utmcct=/dc/blank.html|utmcmd=referral';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>
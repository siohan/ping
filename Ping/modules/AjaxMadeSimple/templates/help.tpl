<b>What does this module do?</b><br/>
Ajax Made Simple is a developer only module which provides an API to allow module-programmers
to easily add Ajax functionality to the frontend of their modules.

<br/>
<br/>
<b>How do I use this module?</b><br/>
You should first of all specify that your module depends on AjaxMadeSimple to ensure that it will work
on all systems. You could add checks to allow functionality without AjaxMadeSimple, but if you want that you probably also
know how todo it, so I won't cover that.
<br/><br/>
In your module frontend, that is for instance your Action function or your action.default.php file, set up the
Ajax-requester and provide either the external file or the module-method providing the new content for Ajax to
substitute.
<br/><br/>
Also, you need to put {literal}{AjaxMadeSimple}{/literal} into your template in the header part. This can be done directly in the template, or by using
global metadata.
<br/>
<br/>
<b>What about security?</b><br/>
From version 0.3.0 security measures have been built in. This means that the module from which you plan to use AjaxMS
has to have a method called
<pre>AuthenticateAjaxMSCall($methodname)</pre>
implemented which takes a parameter containing the method name that is called from AjaxMS.
The method has to return TRUE if calling the given methodname is allowed and false otherwise.
This way you cannot call arbitrary methods using AjaxMS (as you could with pre-0.3.0)

<br/>
<br/>
<b>API reference</b>
<br/>
You only need 2 or 3 functions to set it up and the API goes like this:
<br/><br/>
<pre>
function SetupAjaxMS($id, $returnid="")
</pre>
The AjaxMS module must know the $id of the calling module and probably the $returnid as well, so you should pass these to the module using this
function before using any of the other functions
<br/><br/>
<pre>
function RegisterAjaxRequester($modulename, $method, $textid, $divid, $params=array(), $formfields=array(), $refresh=-1)
</pre>
The parameters:<br/>
<i>$modulename</i> is the name of your module, just use $this-&gt;GetName()
<br/><br/>

<i>$method</i> is the name of the method in you module that will recieve input from Ajax and provide the new content.
It could be called anything, but should be in the form: function $MyAjaxOutput($vars=array()); $vars is an array containing
any info you wanted to pass to the Ajax-provider, like content of form fields or other info (see the $params and $formfields below).

<br><br/>
<i>$textid</i> is a unique id for this requester, allowing you to use several requesters in the same module. The module name is automatically
added to the name to there's no need to make it site-wide unique.
<br/><br/>

<i>$divid</i> is the id of the div inside which you want the new content to be put. Everything within this div is replaced.
<br/><br/>

<i>$params (optional)</i> is an array containing any info you want to pass on to Ajax provider. Use the form array("varname"=&gt;"value")
<br/><br/>

<i>$formfields (optional)</i> is an array containing the name's of the fields whose content you want
to pass on the the ajax-provider.
Fields can optionally be cleared after send. Use the form array("myfieldid"=&gt;"option")<br>
Currently, only one option is valid:<br>
&nbsp;&nbsp;<i>clear</i> - which clears a textfield after ajax has been activated (in a chat input-field for instance, see Chat-module)
<br/>
Please note, that for now only one option is possible for each formfield. This may change in future versions.

<br/><br/>

<i>$refresh (optional)</i> allows you to trigger recurring ajax-requests every x'th millisecond. Allow self-updating content. Default is no automatic refresh.
<br/><br/>

<pre>
 function GetFormOnSubmit($modulename, $textid, $pre="", $post="")
 </pre>
The output returned from this function should be put into the form-statement of a form to automatically
trigger an Ajax request when the form is submitted. It can be used as $extra in the module-API function CreateFormStart()
or simply echo'ed into your own form before the ending &gt; of the form tag.
<br/><br/>
The parameters:<br/>
<i>$modulename</i> is the name of your module, just use $this-&gt;GetName()
<br/><br/>

<i>$textid</i> is a unique id for this requester, allowing you to use several requesters in the same module. The module name is automatically
added to the name to there's no need to make it site-wide unique.
<br/><br/>
<i>$pre (optional)</i> is any info to be inserted before the Ajax stuff in the result.
<b></b>
<i>$post (optional)</i> is any info to be inserted after the Ajax stuff in the result.
<br/>
<br/>
<br/>
For a live example of usage, please install the ChatMadeSimple module and look into the files:
<pre>
action.default.php (setting up the connections, one using a method, the other using external file)
onlinenow.php (the external file provider)
Chat.method.php (find the ChatEngine function exampling a method provider)
</pre>
The Polls module also uses AjaxMS in a whole different way, so please have a look there as well.
<br/>
<br/>
Good luck! It's actually quite easy when you get the hang of it ;-) And feel free to ask for features or help on getting
your module Ajaxified!
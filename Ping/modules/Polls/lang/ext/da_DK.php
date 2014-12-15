<?php
$lang['friendlyname'] = 'Afstemninger';
$lang['moddescription'] = 'Dette module giver adgang til at afholde og vise enkle afsteminger for de bes&oslash;gende';
$lang['permission'] = 'Administr&eacute;r afstemninger';
$lang['postinstall'] = 'Polls version %s blev installeret';
$lang['upgraded'] = 'Afsteminger blev opgraderet til version %s';
$lang['really_uninstall'] = 'Er du sikker p&aring; du vil afinstallere Afstemninger og de gemte data?';
$lang['postuninstall'] = 'Polls blev afinstalleret';
$lang['help_poll_id'] = 'Brug dette til at angive id&#039;et p&aring; en anden poll end den der er sat som aktiv';
$lang['showwhatpoll'] = 'Vis';
$lang['activepoll'] = 'Aktiv';
$lang['randompoll'] = 'En tilf&aelig;ldigt valgt &aring;ben afstemning';
$lang['pollname'] = 'Afstemning navn';
$lang['pollstatus'] = 'Status';
$lang['edit'] = 'Redig&eacute;r';
$lang['delete'] = 'Slet';
$lang['pollstartdate'] = 'Start dato';
$lang['pollclosedate'] = 'Lukket dato';
$lang['pollinfo'] = 'Afstemning information';
$lang['pollranfor'] = 'Afstemningen k&oslash;rte i';
$lang['pollhasbeenrunningfor'] = 'Afstemningen har k&oslash;rt i';
$lang['days'] = 'dage';
$lang['open'] = '&Aring;ben';
$lang['closed'] = 'Lukket';
$lang['confirmclosepoll'] = 'Er du sikker p&aring; denne afstemning skal lukkes?';
$lang['pollwasclosed'] = 'Afstemningen blev lukket';
$lang['addpoll'] = 'Tilf&oslash;j afstemning';
$lang['addnewpoll'] = 'Tilf&oslash;j ny afstemning';
$lang['addandaddoptions'] = 'Tilf&oslash;j afstemning og valgmuligheder';
$lang['pollnamerequired'] = 'Afstemningen skal gives et navn';
$lang['polladded'] = 'Afstemningen blev tilf&oslash;jet';
$lang['add'] = 'Tilf&oslash;j';
$lang['cancel'] = 'Fortryd';
$lang['confirmdeletepoll'] = 'Er du sikker p&aring; denne afstemning skal slettes?';
$lang['polldeleted'] = 'Afstemningen blev slettet';
$lang['confirmresetpoll'] = 'Er du sikker p&aring; stemmerne for denne afstemning skal nulstilles?';
$lang['optionnamerequired'] = 'Valgmuligheden skal gives et navn';
$lang['addoption'] = 'Tilf&oslash;j valgmulighed';
$lang['votes'] = 'Stemmer';
$lang['votepercent'] = '%';
$lang['confirmdeleteoption'] = 'Er du sikker p&aring; du vil slette denne valgmulighed?';
$lang['editoptions'] = 'Redig&eacute;r valgmuligheder';
$lang['addingto'] = 'Tilf&oslash;jer til:';
$lang['optionadded'] = 'Valgmuligheden blev tilf&oslash;jet';
$lang['optiondeleted'] = 'Valgmuligheden blev slettet';
$lang['addnewoption'] = 'Tilf&oslash;j valgmulighed';
$lang['editpoll'] = 'Redig&eacute;r afstemning';
$lang['resetpoll'] = 'Nulstil afstemning';
$lang['pollreset'] = 'Stemmerne i denne afstemning blev nulstillet';
$lang['optionname'] = 'Valgmulighed navn';
$lang['template'] = 'Skabelon';
$lang['polls'] = 'Afstemninger';
$lang['showpeekbutton'] = 'Vis smugkig-knap';
$lang['settings'] = 'Indstillinger';
$lang['savesettings'] = 'Gem indstillinger';
$lang['settingssaved'] = 'Indstillingerne blev gemt';
$lang['polltemplate'] = 'Afstemning skabelon';
$lang['resulttemplate'] = 'Resultat skabelon';
$lang['listtemplate'] = 'Afstemningsliste skabelon';
$lang['return'] = 'Tilbage';
$lang['ok'] = 'OK';
$lang['resettodefault'] = 'Genetabl&eacute;r standard skabelon';
$lang['confirmtemplate'] = 'Er du sikker p&aring; du vil genetablere standardskabelonen?';
$lang['templatesaved'] = 'Skabelonen blev gemt';
$lang['templatereset'] = 'Standardskabelonen blev genetableret';
$lang['votetext'] = 'stemme';
$lang['votestext'] = 'stemmer';
$lang['totalvotes'] = 'Total antal stemmer';
$lang['vote'] = 'Stem';
$lang['peekresult'] = 'Smugkig';
$lang['returntovote'] = 'Til afstemning';
$lang['pollcontenthelp'] = 'Parameters available:<br/><br/>
{$pollname}<br/>
{$pollid}<br/>
{$totalvotestext}<br/>
{$totalvotes}<br/>
{$voteform} - a button to return to voteform when peeking<br/>
<br/>
{$option->label} - the optiontext<br/>
{$option->uniqueid} - a unique text-id<br/>
{$option->value} - the value that should be returned
';
$lang['resultcontenthelp'] = 'Parameters available:<br/><br/>
{$pollid}<br/>
{$pollname}<br/>
<br/>
{$option->label} - the optiontext<br/>
{$option->votes} - The number of votes<br/>
{$option->percent} - The percent of this option
';
$lang['changelog'] = '<ul>
<li>
<p>Version 0.2.0</p>
<p>Multiple polls on same page</p>
<p>Added help for template params</p>
<p>Cleaned up default templates, added labels</p>
</li>
<li>
<p>Version 0.1.7</p>
<p>Cleaned up smarty names</p>
<p>Added number of votes and total votes to params passed to templates</p>
</li>
<li>
<p>Version 0.1.6</p>
<p>Added a poll_id for controlling multiple polls (thank pumuklee)</p>
</li>
<li>
<p>Version 0.1.4</p>
<p>Really added the option for hiding peek button (don\&#039;t know what went wrong i 0.1.3)</p>
<p>Fixed a bug with default result template</p>
<p>Fixed a syntax bug in the poll form</p>
<p>Cut down on the ajax-code if peekbutton was disabled</p>
</li>
<li>
<p>Version 0.1.3</p>
<p>Added an option for hiding the peek button</p>
</li>
<li>
<p>version 0.1.0</p>
<p>First usable version</p>
</li>
</ul>
';
$lang['help'] = '<b>Hvad g&oslash;r dette modul?</b>
<br/>
Dette modul giver dig en nem m&aring;de at vise Ajax-styrede afstemninger p&aring; din side. Det er nemt at styre udseendet af afstemningen vha. skabeloner og css.
<br/>
<b>Hvordan bruger jeg dette modul?</b>
<br/>
Du installerer modulet, og opretter en afstemningen gennem dets adminsitration. Husk at tilf&oslash;je valgmuligheder.
<br/>
I din side inds&aelig;tter du derefter:
<pre>
{cms_module module=\&#039;polls\&#039;}
</pre>
og din aktive afstemning skulle vise sig.

';
$lang['utmz'] = '156861353.1181342337.28.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utma'] = '156861353.1182570543.1156368606.1192896062.1193093628.32';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>
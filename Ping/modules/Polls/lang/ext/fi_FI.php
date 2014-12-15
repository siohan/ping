<?php
$lang['friendlyname'] = 'Polls Made Simple';
$lang['moddescription'] = 'T&auml;m&auml; moduuli tarjoaa yksinkertaisen &auml;&auml;nestystoiminnallisuuden sivuston k&auml;ytt&auml;jille';
$lang['permission'] = 'Hallinnoi &auml;&auml;nestyksi&auml;';
$lang['postinstall'] = 'Polls-versio %s onnistuneesti asennettu';
$lang['upgraded'] = 'Polls-moduuli p&auml;ivitetty onnistuneesti versioon %s.';
$lang['really_uninstall'] = 'Haluatko varmasti poistaa Polls-moduulin ja poistaa ker&auml;tyt tiedot?';
$lang['postuninstall'] = 'Polls-moduulin poistettu onnistuneesti.';
$lang['help_poll_id'] = 'Use this to specify the id another poll than the one set as active';
$lang['showwhatpoll'] = 'N&auml;yt&auml;';
$lang['activepoll'] = 'Aktiivinen';
$lang['randompoll'] = 'Satunnaisesti valittu avoin &auml;&auml;nestys';
$lang['pollname'] = '&Auml;&auml;nestyksen nimi';
$lang['pollstatus'] = '&Auml;&auml;nestyksen tila';
$lang['edit'] = 'Muokkaa';
$lang['delete'] = 'Poista';
$lang['pollstartdate'] = 'Alkupvm';
$lang['pollclosedate'] = 'Sulkemispvm';
$lang['pollinfo'] = '&Auml;&auml;nestyksen tiedot';
$lang['pollid'] = '&Auml;&auml;nestyksen ID';
$lang['updatepoll'] = 'P&auml;ivit&auml; &auml;&auml;nestys';
$lang['pollupdated'] = '&Auml;&auml;nestys p&auml;ivitetty';
$lang['pollranfor'] = '&Auml;&auml;nestys oli k&auml;ynniss&auml;';
$lang['pollhasbeenrunningfor'] = '&Auml;&auml;nestys ollut k&auml;ynniss&auml;';
$lang['days'] = 'p&auml;iv&auml;&auml;';
$lang['open'] = 'Avoin';
$lang['closed'] = 'Suljettu';
$lang['confirmclosepoll'] = 'Varmastiko haluat sulkea &auml;&auml;nestyksen?';
$lang['pollwasclosed'] = '&Auml;&auml;nestys suljettu';
$lang['addpoll'] = 'Lis&auml;&auml; &auml;&auml;nestys';
$lang['addnewpoll'] = 'Lis&auml;&auml; uusi &auml;&auml;nestys';
$lang['addandaddoptions'] = 'Lis&auml;&auml; &auml;&auml;nestys ja valinnat';
$lang['pollnamerequired'] = '&Auml;&auml;nestyksen nimi on pakollinen tieto';
$lang['polladded'] = '&Auml;&auml;nestys lis&auml;tty';
$lang['add'] = 'Lis&auml;&auml;';
$lang['cancel'] = 'Keskeyt&auml;';
$lang['confirmdeletepoll'] = 'Varmastiko haluat poistaa &auml;&auml;nestyksen?';
$lang['polldeleted'] = '&Auml;&auml;nestys poistettu';
$lang['confirmresetpoll'] = 'Haluatko varmasti nollata t&auml;m&auml;n &auml;&auml;nestyksen tulokset?';
$lang['optionnamerequired'] = 'Valinnan nimi on pakollinen tieto';
$lang['addoption'] = 'Lis&auml;&auml; valinta';
$lang['votes'] = '&Auml;&auml;ni&auml;';
$lang['votepercent'] = '%';
$lang['confirmdeleteoption'] = 'Haluatko varmasti poistaa t&auml;m&auml;n valinnan?';
$lang['editoptions'] = 'Muokkaa valintoja';
$lang['addingto'] = 'Lis&auml;t&auml;&auml;n &auml;&auml;nestykseen:';
$lang['optionadded'] = 'Valinta lis&auml;tty';
$lang['optiondeleted'] = 'Valinta poistettu';
$lang['addnewoption'] = 'Lis&auml;&auml; valinta';
$lang['editpoll'] = 'Muokkaa &auml;&auml;nestyst&auml;';
$lang['resetpoll'] = 'Palauta &auml;&auml;nestys alkutilaan';
$lang['pollreset'] = '&Auml;&auml;nestys nollattu, &auml;&auml;net poistettu';
$lang['optionname'] = 'Valinnan nimi';
$lang['template'] = 'Pohja';
$lang['polls'] = '<';
$lang['showpeekbutton'] = 'N&auml;yt&auml; katso-painike';
$lang['settings'] = 'Asetukset';
$lang['savesettings'] = 'Tallenna asetukset';
$lang['settingssaved'] = 'Asetukset tallennettu';
$lang['polltemplate'] = '&Auml;&auml;nestyspohja';
$lang['resulttemplate'] = 'Tulospohja';
$lang['listtemplate'] = '&Auml;&auml;nestyslistauksen pohja';
$lang['return'] = 'Palaa';
$lang['ok'] = 'OK';
$lang['resettodefault'] = 'Palauta oletuspohja';
$lang['confirmtemplate'] = 'Haluatko varmasti palauttaa oletuspohjan?';
$lang['templatesaved'] = 'Pohja tallennettu';
$lang['templatereset'] = 'Pohja palautettiin oletukseksi';
$lang['votetext'] = '&auml;&auml;ni';
$lang['votestext'] = '&auml;&auml;nt&auml;';
$lang['totalvotes'] = '&Auml;&auml;ni&auml; kaikkiaan';
$lang['vote'] = '&Auml;&auml;nest&auml;';
$lang['peekresult'] = 'Katso tuloksia';
$lang['returntovote'] = 'Mene &auml;&auml;nest&auml;m&auml;&auml;n';
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
<p>Really added the option for hiding peek button (don&#039;t know what went wrong i 0.1.3)</p>
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
$lang['help'] = '<b>Mit&auml; t&auml;m&auml; moduuli tekee?</b>
<br/>
Tarjoaa helpon tavan n&auml;ytt&auml;&auml; Ajax-pohjaisia &auml;&auml;nestyksi&auml; sivuillasi. &Auml;&auml;nestyksi&auml; on helppo r&auml;&auml;t&auml;l&ouml;id&auml; ja muokata k&auml;ytt&auml;m&auml;ll&auml; pohjia ja CSS:&auml;&auml;.
<br/>
<b>Kuinka k&auml;yt&auml;n t&auml;t&auml; moduulia?</b>
<br/>
Asennat moduulin. Sitten k&auml;yt hallinnointisivulla luomassa &auml;&auml;nestyksen valintoineen ja aktivoit &auml;&auml;nestyksen.
<br/>
Sivulle tai sivupohjaan lis&auml;&auml;t jotain seuraavantapaista:
<pre>
{cms_module module=&#039;polls&#039; <i>params</i>}
</pre>
ja nyt &auml;&auml;nestyksesi pit&auml;isi n&auml;ky&auml; sivulla.
';
$lang['utma'] = '156861353.1959547193.1213865783.1214291689.1214296543.21';
$lang['utmz'] = '156861353.1214056345.10.4.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/forum/forum.php|utmcmd=referral';
$lang['utmc'] = '156861353';
?>
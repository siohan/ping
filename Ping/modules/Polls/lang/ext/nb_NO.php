<?php
$lang['friendlyname'] = 'Polls(Valg) Made Simple';
$lang['moddescription'] = 'Denne modulen tilbyr enkel valg/avstemnings funksjonalitet til frontend brukerne.';
$lang['permission'] = 'Administrer Valg';
$lang['postinstall'] = 'Polls(Valg) versjon %s ble installert';
$lang['upgraded'] = 'Polls(Valg) ble oppgradert til versjon %s';
$lang['really_uninstall'] = 'Er du sikker p&aring; du vil avinstallere Valg og slette alle oppsamlede data?';
$lang['postuninstall'] = 'Polls(valg) ble avinstallert';
$lang['help_poll_id'] = 'Benytt dette til &aring; spesifisere id&#039;en til et annet valg enn det som satt som aktivt. (om det ikke eksisterer s&aring; faller det tilbake til aktivt valg)';
$lang['pollid'] = 'Valg ID(Poll ID)';
$lang['pollsettings'] = 'Valg(Poll) innstillinger';
$lang['showwhatpoll'] = 'Vis';
$lang['activepoll'] = 'Aktiv';
$lang['defaultpoll'] = 'Standard Valg';
$lang['makedefaultpoll'] = 'Gj&oslash;r standard Valg';
$lang['randompoll'] = 'Tilfeldig valgt &aring;pent Valg';
$lang['allopen'] = 'Alle &aring;pne valg';
$lang['pollname'] = 'Valg navn';
$lang['pollstatus'] = 'Valg status';
$lang['edit'] = 'Endre';
$lang['delete'] = 'Slett';
$lang['pollstartdate'] = 'Start dato';
$lang['pollclosedate'] = 'Slutt dato';
$lang['pollinfo'] = 'Valg info';
$lang['updatepoll'] = 'Oppdater Valg';
$lang['pollupdated'] = 'Valg oppdatert';
$lang['pollranfor'] = 'Valget kj&oslash;rte i';
$lang['pollhasbeenrunningfor'] = 'Valget har blitt kj&oslash;rt i';
$lang['days'] = 'dager';
$lang['open'] = '&Aring;pent';
$lang['closed'] = 'Lukket';
$lang['openpoll'] = '&Aring;pne Valg';
$lang['closepoll'] = 'Steng Valg';
$lang['confirmclosepoll'] = 'Er du sikker p&aring; at dette valget skal lukkes?';
$lang['confirmopenpoll'] = 'Er du sikke rp&aring; at dette Valget skal &aring;pnes?';
$lang['pollwasclosed'] = 'Valget ble stengt';
$lang['pollwasopened'] = 'Valget ble &aring;pnet';
$lang['addpoll'] = 'Legg til Valg';
$lang['addnewpoll'] = 'Legg til nytt Valg';
$lang['addandaddoptions'] = 'Legg til Valg og opsjoner';
$lang['pollnamerequired'] = 'Et navn p&aring; Valget er n&oslash;dvendig';
$lang['pollidrequired'] = 'En unik ID for valget(Poll) er p&aring;krevd.';
$lang['polladded'] = 'Valget ble lagt til';
$lang['add'] = 'Legg til';
$lang['actions'] = 'Handlinger';
$lang['cancel'] = 'Avbryt';
$lang['confirmdeletepoll'] = 'Er du sikker p&aring; at dette Valget skal slettes?';
$lang['polldeleted'] = 'Valget ble slettet';
$lang['confirmresetpoll'] = 'Er du sikker p&aring; at du vil nullstille stemmene for dette Valget?';
$lang['optionnamerequired'] = 'Et navn for opsjonen er n&oslash;dvendig';
$lang['addoption'] = 'Legg til opsjon';
$lang['votes'] = 'Stemmer';
$lang['votepercent'] = '% ';
$lang['deleteoption'] = 'Slett alternativet';
$lang['confirmdeleteoption'] = 'Er du sikker p&aring; du vil slette denne opsjonen?';
$lang['editoptions'] = 'Rediger alternativer';
$lang['editoption'] = 'REdiger alternativ';
$lang['save'] = 'Lagre';
$lang['addingto'] = 'Lagt til til: ';
$lang['optionadded'] = 'Opsjonen ble lagt til';
$lang['optiondeleted'] = 'Opsjonen ble slettet';
$lang['addnewoption'] = 'Legg til opsjon';
$lang['editpoll'] = 'Rediger Valg';
$lang['resetpoll'] = 'Nullstill Valg';
$lang['pollreset'] = 'Stemmene for dette valget ble nullstilt';
$lang['optionname'] = 'Opsjonsnavn';
$lang['template'] = 'Mal';
$lang['polls'] = 'Valg';
$lang['showpeekbutton'] = 'Vis Status n&aring;-knapp';
$lang['settings'] = 'Instillinger';
$lang['savesettings'] = 'Lagre instillinger';
$lang['settingssaved'] = 'Instillinger lagret';
$lang['polltemplate'] = 'Valg mal';
$lang['resulttemplate'] = 'Resultat mal';
$lang['listtemplate'] = 'Valg-liste mal';
$lang['return'] = 'Tilbake';
$lang['ok'] = 'OK ';
$lang['resettodefault'] = 'Tilbakesatt til standard mal';
$lang['confirmtemplate'] = 'Er du sikker p&aring; du vil tilbakestille til standard mal?';
$lang['templatesaved'] = 'Malen ble lagret';
$lang['templatereset'] = 'Malen ble tilbakesatt til standard';
$lang['votetext'] = 'stem';
$lang['votestext'] = 'stemmer';
$lang['totalvotes'] = 'Totalt stemmer';
$lang['vote'] = 'Stem';
$lang['peekresult'] = 'Status n&aring;';
$lang['returntovote'] = 'G&aring; til avstemning';
$lang['registervotedby'] = 'Tillat avstemning';
$lang['oncepersession'] = 'En gang per sesjon';
$lang['onceperip'] = 'En gang fra hver IP';
$lang['always'] = 'Alltid';
$lang['pollcontenthelp'] = 'Parameters available:<br/><br/>
{$pollname}<br/>
{$pollid}<br/>
{$totalvotestext}<br/>
{$totalvotes}<br/>
{$peekform} - a button to peek the result<br/>
{$voteform} - a button to return to voteform when peeking<br/>
<br/>
{$option->label} - the optiontext<br/>
{$option->uniqueid} - a unique text-id<br/>
{$option->value} - the value that should be returned
value} - the value that should be returned';
$lang['resultcontenthelp'] = 'Parameters available:<br/><br/>
{$pollid}<br/>
{$pollname}<br/>
<br/>
{$option->label} - the optiontext<br/>
{$option->votes} - The number of votes<br/>
{$option->percent} - The percent of this option';
$lang['donationstab'] = 'Donasjoner';
$lang['hidedonationssubmit'] = 'Sjul donasjonsfanen';
$lang['donationstext'] = 'A lot of time and effort has been put into creating this module.
Please consider a small donation (5&euro; for instance, or what you can spare) using the PayPal-button below, especially if you use this module
in a commercial context.
<br/><br/>
If you donate more than 30&euro; you can have a link to your company on this page, if you wish to. Send me an email about what you would like shown and I will put it in for the next version.
<br/><br/>
Thank you!';
$lang['sponsors'] = 'N&aring;v&aelig;erende sponsorer, takk for deres st&oslash;tte!';
$lang['help'] = '<b>What does this module do?</b>
<br/>
This module provides an easy way to show Ajax-powered polls on your page. The look polls are easily customized using the
templates and css. 
<br/>
<b>How do I use this module?</b>
<br/>
Basically you install the module, access it&#039;s administration interface and creates a poll, you add options to it
and activates it.
<br/>
In you page content or template you then insert something like:
<pre>
{Polls}
</pre>
and your activat poll should emerge there. Remember that in order for the required AjaxMadeSimple-module to do it&#039;s stuff you need
to add {AjaxMadeSimple} somewhere in your html-header (in template or metadata)
';
$lang['qca'] = 'P0-536849115-1307983495210';
$lang['utma'] = '156861353.1400698784.1339530996.1339878866.1339882165.16';
$lang['utmz'] = '156861353.1339530996.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>
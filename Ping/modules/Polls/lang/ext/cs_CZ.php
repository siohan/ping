<?php
$lang['friendlyname'] = 'Ankety';
$lang['moddescription'] = 'Tento modul zaji&scaron;ťuje jednoduch&eacute; ankety.';
$lang['permission'] = 'Spravovat Ankety';
$lang['postinstall'] = 'Ankety v. %s byly &uacute;spě&scaron;ne nainstalov&aacute;ny';
$lang['upgraded'] = 'Ankety byly &uacute;spě&scaron;ně upgradov&aacute;ny na verzi %s';
$lang['really_uninstall'] = 'Jste si jisti, že chcete odinstalovat Ankety a vymazat v&scaron;echna nasb&iacute;ran&aacute; data?';
$lang['postuninstall'] = 'Ankety byly &uacute;spě&scaron;ně odinstalov&aacute;ny';
$lang['help_poll_id'] = 'Použijte pro upřesněn&iacute; id jin&eacute; ankety, než je ta aktivn&iacute;';
$lang['showwhatpoll'] = 'Zobrazit';
$lang['activepoll'] = 'Aktivn&iacute;';
$lang['randompoll'] = 'N&aacute;hodně zvolen&aacute; aktivn&iacute; anketa';
$lang['pollname'] = 'Jm&eacute;no ankety';
$lang['pollstatus'] = 'Status ankety';
$lang['edit'] = 'Upravit';
$lang['delete'] = 'Smazat';
$lang['pollstartdate'] = 'Datum zač&aacute;tku';
$lang['pollclosedate'] = 'Datum konce';
$lang['pollinfo'] = 'Informace o anketě';
$lang['pollranfor'] = 'Anketa běžela';
$lang['pollhasbeenrunningfor'] = 'Anketa běž&iacute;';
$lang['days'] = 'dn&iacute;';
$lang['open'] = 'Otevřen&aacute;';
$lang['closed'] = 'Ukončen&aacute;';
$lang['confirmclosepoll'] = 'Jste si jisti, že tato anketa m&aacute; b&yacute;t ukončena?';
$lang['pollwasclosed'] = 'Anketa byla uzavřena';
$lang['addpoll'] = 'Přidat anketu';
$lang['addnewpoll'] = 'Přidat novou anketu';
$lang['addandaddoptions'] = 'Přidat anketu a možnosti';
$lang['pollnamerequired'] = 'Jm&eacute;no ankety je vyžadov&aacute;no';
$lang['polladded'] = 'Anketa byla přid&aacute;na';
$lang['add'] = 'Přidat';
$lang['cancel'] = 'Zru&scaron;it';
$lang['confirmdeletepoll'] = 'Jste si jisti, že m&aacute; b&yacute;t anketa smaz&aacute;na?';
$lang['polldeleted'] = 'Anketa byla smaz&aacute;na';
$lang['confirmresetpoll'] = 'Jste si jisti, že chcete smazat hlasy k t&eacute;to anketě?';
$lang['optionnamerequired'] = 'Jm&eacute;no pro možnost je vyžadov&aacute;no';
$lang['addoption'] = 'Přidat monost';
$lang['votes'] = 'Hlasy';
$lang['votepercent'] = '%';
$lang['confirmdeleteoption'] = 'Jste si jisti, že chcete smazat tuto možnost?';
$lang['editoptions'] = 'Upravit možnosti';
$lang['addingto'] = 'Přid&aacute;v&aacute;m do: ';
$lang['optionadded'] = 'Možnost byla přid&aacute;na';
$lang['optiondeleted'] = 'Možnost byla smaz&aacute;na';
$lang['addnewoption'] = 'Přidat možnost';
$lang['editpoll'] = 'Upravit anketu';
$lang['resetpoll'] = 'Resetovat anketu';
$lang['pollreset'] = 'Hlasy pro tuto anketu byly vymaz&aacute;ny';
$lang['optionname'] = 'Jm&eacute;no možnosti';
$lang['template'] = '&Scaron;ablona';
$lang['polls'] = 'Ankety';
$lang['showpeekbutton'] = 'Zobrazit tlač&iacute;tko pro zobrazen&iacute; v&yacute;sledků';
$lang['settings'] = 'Nastaven&iacute;';
$lang['savesettings'] = 'Uložit nastaven&iacute;';
$lang['settingssaved'] = 'Nastaven&iacute; bylo uloženo';
$lang['polltemplate'] = '&Scaron;ablona ankety';
$lang['resulttemplate'] = '&Scaron;ablona v&yacute;sledku';
$lang['listtemplate'] = '&Scaron;ablona anketn&iacute;ho seznamu';
$lang['return'] = 'N&aacute;vrat';
$lang['ok'] = 'OK';
$lang['resettodefault'] = 'Resetovat na v&yacute;choz&iacute; &scaron;ablonu';
$lang['confirmtemplate'] = 'Jste si jisti, že chcete resetovat na v&yacute;choz&iacute; &scaron;ablonu?';
$lang['templatesaved'] = '&Scaron;ablona byla uložena';
$lang['templatereset'] = '&Scaron;ablona byla resetov&aacute;na na v&yacute;choz&iacute;';
$lang['votetext'] = 'hlas';
$lang['votestext'] = 'hlasy';
$lang['totalvotes'] = 'Hlasy celkově';
$lang['vote'] = 'Hlasovat';
$lang['peekresult'] = 'Pod&iacute;vat se na v&yacute;sledky';
$lang['returntovote'] = 'Hlasovat';
$lang['pollcontenthelp'] = 'Dostupn&eacute; parametry:<br/><br/>
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
$lang['resultcontenthelp'] = 'Dostupn&eacute; parametry:<br/><br/>
{$pollid}<br/>
{$pollname}<br/>
<br/>
{$option->label} - the optiontext<br/>
{$option->votes} - The number of votes<br/>
{$option->percent} - The percent of this option
';
$lang['changelog'] = '<ul>
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
$lang['help'] = '<b>Co děl&aacute; tento modul?</b>
<br/>
<b>Jak m&aacute;m tento modul použ&iacute;vat?</b>
<br/>
Jednodu&scaron;e nainstalujete modul, a přes administraci vytv&aacute;ř&iacute;te a upravujete ankety.
<br/>
Do str&aacute;nky pak vlož&iacute;te n&aacute;sleduj&iacute;c&iacute;:
<pre>
{cms_module module=&#039;polls&#039;}
</pre>
a va&scaron;e aktivn&iacute; ankety by tam měli b&yacute;t vidět.
<br/>
<br/>
V&iacute;ce možnost&iacute; přibude později.
';
$lang['utma'] = '156861353.880267837.1180991669.1193257793.1193289628.125';
$lang['utmz'] = '156861353.1193214395.118.28.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/tracker/index.php|utmcmd=referral';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>
<?php
$lang['friendlyname'] = 'Sondy';
$lang['moddescription'] = 'Ten moduł dostarcza funkcjonalność głosowania dla frontend users';
$lang['permission'] = 'Administracja sondami';
$lang['postinstall'] = 'Sondy wersja %s została poprawnie zainstalowana';
$lang['upgraded'] = 'Sondy zostały uaktualnione do wersji %s';
$lang['really_uninstall'] = 'Czy chcesz odinstalować Sondy i usunąć wszystkie zebrane dane?';
$lang['postuninstall'] = 'Sondy zostały odinstalowane';
$lang['help_poll_id'] = 'Użyj tego aby określić id innej sondy niż ta kt&oacute;ra jest ustawiona jako aktywna';
$lang['showwhatpoll'] = 'Pokaż';
$lang['activepoll'] = 'Aktywne';
$lang['randompoll'] = 'Losowo wybrana otwarta sonda';
$lang['pollname'] = 'Nazwa sondy';
$lang['pollstatus'] = 'Status sondy';
$lang['edit'] = 'Edytuj';
$lang['delete'] = 'Usuń';
$lang['pollstartdate'] = 'Data rozpoczęcia';
$lang['pollclosedate'] = 'Data zamknięcia';
$lang['pollinfo'] = 'Informacje';
$lang['pollid'] = 'ID Sondy';
$lang['updatepoll'] = 'Uaktualnij sondę';
$lang['pollupdated'] = 'Sonda została uaktualniona';
$lang['pollranfor'] = 'Sonda jest aktywna przez';
$lang['pollhasbeenrunningfor'] = 'Sonda była aktywna przez';
$lang['days'] = 'dni';
$lang['open'] = 'Otwarta';
$lang['closed'] = 'Zamknięta';
$lang['confirmclosepoll'] = 'Czy chcesz zamknąć tą sondę?';
$lang['pollwasclosed'] = 'Sonda została zamknięta';
$lang['addpoll'] = 'Dodaj sondę';
$lang['addnewpoll'] = 'Dodaj nową sondę';
$lang['addandaddoptions'] = 'Dodaj sondę i opcje';
$lang['pollnamerequired'] = 'Nazwa sondy jest wymagana';
$lang['polladded'] = 'Sonda została dodana';
$lang['add'] = 'Dodaj';
$lang['cancel'] = 'Anuluj';
$lang['confirmdeletepoll'] = 'Czy chcesz usunąć sondę?';
$lang['polldeleted'] = 'Sonda została usunięta';
$lang['confirmresetpoll'] = 'Czy chcesz zresetować głosy dla tej sondy?';
$lang['optionnamerequired'] = 'Nazwa opcji jest wymagana';
$lang['addoption'] = 'Dodaj opcję';
$lang['votes'] = 'Głosy';
$lang['votepercent'] = '%';
$lang['confirmdeleteoption'] = 'Czy chcesz usunąć tą opcję?';
$lang['editoptions'] = 'Edytuj opcje';
$lang['addingto'] = 'Dodano do: ';
$lang['optionadded'] = 'Opcja została dodana';
$lang['optiondeleted'] = 'Opcja została usunięta';
$lang['addnewoption'] = 'Dodaj opcję';
$lang['editpoll'] = 'Edytuj sondę';
$lang['resetpoll'] = 'Resetuj sondę';
$lang['pollreset'] = 'Głosy dla tej sondy zostały skasowane';
$lang['optionname'] = 'Nazwa opcji';
$lang['template'] = 'Szablon';
$lang['polls'] = 'Sondy';
$lang['showpeekbutton'] = 'Pokaż przycisk wynik&oacute;w';
$lang['settings'] = 'Ustawienia';
$lang['savesettings'] = 'Zapisz ustawienia';
$lang['settingssaved'] = 'Ustawienia zostały zapisane';
$lang['polltemplate'] = 'Szablon sondy';
$lang['resulttemplate'] = 'Szablon wynik&oacute;w';
$lang['listtemplate'] = 'Szablon listy sond';
$lang['return'] = 'Powr&oacute;t';
$lang['ok'] = 'OK';
$lang['resettodefault'] = 'Przywr&oacute;ć domyślny szablon';
$lang['confirmtemplate'] = 'Czy chcesz przywr&oacute;cić domyślny szablon?';
$lang['templatesaved'] = 'Szablon został zapisany';
$lang['templatereset'] = 'Domyślny szablon został przywr&oacute;cony';
$lang['votetext'] = 'głosuj';
$lang['votestext'] = 'głos&oacute;w';
$lang['totalvotes'] = 'Wszystkich głos&oacute;w';
$lang['vote'] = 'Głosuj';
$lang['peekresult'] = 'Zobacz wyniki';
$lang['returntovote'] = 'Wr&oacute;ć do głosowania';
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
{cms_module module=&#039;polls&#039; <i>params</i>}
</pre>
and your activat poll should emerge there.

';
$lang['utma'] = '156861353.1137862180506108200.1236028070.1250516113.1251278028.24';
$lang['utmz'] = '156861353.1251278028.24.7.utmccn=(referral)|utmcsr=forum.cmsmadesimple.org|utmcct=/index.php/topic,35327.0.html|utmcmd=referral';
$lang['qca'] = '1209029246-81444135-94725748';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>
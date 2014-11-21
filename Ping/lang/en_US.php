<?php
$lang['friendlyname'] = 'Table Tennis';
$lang['postinstall'] = 'Post Install Message, e.g., Be sure to set "Use Skeletons" permissions to use this module!';
$lang['postuninstall'] = 'Post Uninstall Message, e.g., "Curses! Foiled Again!"';
$lang['really_uninstall'] = 'Really? You\'re sure you want to uninstall this fine module?';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['prefsupdated'] = 'Module preferences updated.';
$lang['submit'] = 'Envoyer';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['error'] = 'Error!';
$lang['resultsfoundtext'] = 'records found';
$lang['link_view'] = 'View Record';
$lang['edit'] = 'Edit Record';
$lang['title_num_records'] = '%s records found.';
$lang['add_record'] = 'Add a Record';
$lang['saved_record'] = 'Add a Record';
$lang['added_record'] = 'Added record.';
$lang['updated_record'] = 'Record updated.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['title_allow_add'] = 'Users may add records?';
$lang['title_allow_add_help'] = 'Click here to allow users to add records.';
$lang['title_mod_prefs'] = 'Module Preferences';
$lang['title_general'] = 'General Info';
$lang['title_description'] = 'Description';
$lang['title_explanation'] = 'Long Description';
$lang['title_mod_admin'] = 'Module Admin Panel';
$lang['dash_record_count'] = 'This module handles %s records';
$lang['alert_no_records'] = 'There have not been any records added in the Skeleton module!';
$lang['help_skeleton_id'] = 'Internally identifier for selecting records';
$lang['help_description'] = 'Internal parameter used to pass description info when creating or editing a record';
$lang['help_explanation'] = 'Internal parameter used to pass explanation info when creating or editing a record';
$lang['help_module_message'] = 'Internally used parameter for passing messages to user';
$lang['event_info_OnSkeletonPreferenceChange'] = 'An event generated when  the preferences to the Skeleton Module get changed';
$lang['event_help_OnSkeletonPreferenceChange'] = '<p>An event generated when the preferences to the Skeleton Module get changed</p>
<h4>Parameters</h4>
<ul>
<li><em>allow_add</em> - The new setting of the "Allow Add" preference; boolean</li>
</ul> 
';

$lang['moddescription'] = 'Ce module calcule vos points FFTT.';
$lang['welcome_text'] = '<p>Bienvenue dzans le gestionnaire d\'envoi de SMS. Something else would probably go here
if the module actually did something. Add it to your front-end pages with a {Skeleton}</p>';
$lang['changelog'] = '<ul>
<li>Version 1.8.1, Feb 2011, SjG. Compatibility fixes for MySQL 5.5</li>
<li>Version 1.8, Sep 2010 SjG
<ul>
<li>Added an additional field to database records to make it more interesting.</li>
<li>Implemented PrettyURLs</li>
<li>Updated for CMSMS 1.9 and for inclusion in <em>CMS Developer\'s Cookbook</em></li>
</ul></li>
<li>Version 1.7, Sep 2009 SjG, Cleaned up, and modernized a bit.</li>
<li>Version 1.6, Nov 2008 SjG, added parameter sanitizing for Nuno</li>
<li>Version 1.5, July 2007 SjG
<ul>
   <li>Added actual database app.</li>
   <li>Made Admin tabbed for interest.</li>
   <li>Updated Minimum and Maximum CMS versions.</li>
</ul>
</li>
<li>Version 1.4, June 2006 (calguy1000). 
  <ul>
    <li>Replaced DisplayAdminNav with a single tab</li>
    <li>Replaced call to DoAction with a Redirect</li>
    <li>Changed minimum cms version to 1.0-svn</li>
  </ul>
</li>
<li>Version 1.3. June 2006 (sjg). 
  <ul>
    <li>Split out install, upgrade, and uninstall methods</li>
    <li>Added Events</li>
    <li>Added references to pretty urls and route registration</li>
    <li>corrected language file directory structure</li>
    <li>added more comments</li>
  </ul>
</li>
<li>Version 1.2. 29 December 2005. Fixes to bugs pointed out by Patrick Loschmidt. Updates to be correct for CMS Made Simple versions 0.11.x.</li>
<li>Version 1.1. 11 September 2005. Cleaned up references that caused problems for PHP 4.4.x or 5.0.5.</li>
<li>Version 1.0. 6 August 2005. Initial Release.</li></ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>Nothing. It\'s designed to be a starting point for you to develop your own modules.</p>
<h3>How Do I Use It</h3>
<p>Well, you could actually install it by placing the module in a page or template using the
smarty tag &#123;Skeleton}</p>
<p>You would be wiser, however, to use the module as a starting point, and editing the code to do
whatever it is you are wanting to do.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report, please visit the Module Forge
<a href="http://dev.cmsmadesimple.org/projects/skeleton/">Skeleton Page</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, SjG, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2010, Samuel Goldstein <a href="mailto:sjg@cmsmodules.com">&lt;sjg@cmsmodules.com&gt;</a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>
';
?>

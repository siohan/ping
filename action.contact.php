<?php
if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
$cont = new PingContacts;
$details_contacts = $cont->details_contacts();

$smarty->assign('details_contacts', $details_contacts);


#
# EOF
#
?>

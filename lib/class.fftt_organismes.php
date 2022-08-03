<?php
class fftt_organismes
{
   function __construct() {}

function liste_zones()
{
	$db = cmsms()->GetDb();
	$query = "SELECT idorga, libelle FROM ".cms_db_prefix()."module_ping_organismes WHERE scope = 'Z'";
	$dbresult = $db->Execute($query);
	if($dbresult && $dbresult->recordCount() >0)
	{
		$listorga = array();
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			$listorga[$row['idorga']] = $row['libelle'];  	
		}
		return $listorga;
	}
	else
	{
		return false;
	}
}

}
# end of class
?>
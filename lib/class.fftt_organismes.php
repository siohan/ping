<?php
class fftt_organismes
{
   function __construct() {}

 function organisateur ($idepreuve)
 {
	$db = cmsms()->GetDb();
	$query = "SELECT libelle FROM ".cms_db_prefix()."module_ping_organismes WHERE idorga = ?";
	$dbresult = $db->Execute($query, array($idepreuve));
	if($dbresult && $dbresult->recordCount() >0)
	{ 
		$row = $dbresult->FetchRow();
		$orga = $row['libelle'];
		return $orga;
	}
	else
	{
		return false;
	}
 }

function liste_fede()
{
	$db = cmsms()->GetDb();
	$query = "SELECT idorga, libelle FROM ".cms_db_prefix()."module_ping_organismes WHERE scope = 'F'";
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

function liste_ligues()
{
	$db = cmsms()->GetDb();
	$query = "SELECT idorga, libelle FROM ".cms_db_prefix()."module_ping_organismes WHERE scope = 'L'";
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

function liste_deps()
{
	$db = cmsms()->GetDb();
	$query = "SELECT idorga, libelle FROM ".cms_db_prefix()."module_ping_organismes WHERE scope = 'D'";
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

function delete_organismes()
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_ping_organismes";
	$dbresult = $db->Execute($query);
}

}
# end of class
?>

<?php
class PingContacts
{
   function __construct() {}

function details_contacts()
{
	$query = "SELECT idclub, numero, nom, nomsalle, adressesalle1, adressesalle2, codepsalle, villesalle, web, nomcor, prenomcor,mailcor, telcor FROM ".cms_db_prefix()."module_ping_coordonnees";
$dbresult= $db->Execute($query);
$rowarray= array();
$rowclass = '';
$details = array();
if ($dbresult)
{
	while ($row= $dbresult->FetchRow())
	{
		$details['idclub']= $row['idclub'];
		$details['numero'] = $row['numero'];
		$details['nom'] = $row['nom'];
		$details['nomsalle']= $row['nomsalle'];
		$details['adressesalle1']=  $row['adressesalle1'];
		$details['adressesalle2']= $row['adressesalle2'];
		$details['codepsalle']= $row['codepsalle'];
		$details['villesalle']= $row['villesalle'];
		$details['web'] = $row['web'];
		$details['nomcor'] = $row['nomcor'];
		$details['prenomcor'] = $row['prenomcor'];
		$details['mailcor'] = $row['mailcor'];
		$details['telcor'] = $row['telcor'];
			
		}
		return $details;
	}
}

}
# end of class
?>

<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$db = cmsms()->GetDb();
global $themeObject;

$query = "SELECT * FROM ".cms_db_prefix()."module_ping_coordonnees";
$dbresult= $db->Execute($query);
$rowarray= array();
$rowclass = '';

if ($dbresult)
{
	while ($row= $dbresult->FetchRow())
	{
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->idclub= $row['idclub'];
		$onerow->numero = $row['numero'];
		$onerow->nom = $row['nom'];
		$onerow->nomsalle= $row['nomsalle'];
		$onerow->adressesalle1=  $row['adressesalle1'];
		$onerow->adressesalle2= $row['adressesalle2'];
		$onerow->codepsalle= $row['codepsalle'];
		$onerow->villesalle= $row['villesalle'];
		$onerow->web = $row['web'];
		$onerow->nomcor = $row['nomcor'];
		$onerow->prenomcor = $row['prenomcor'];
		$onerow->mailcor = $row['mailcor'];
		$onerow->telcor = $row['telcor'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}

}
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('contacts.tpl');


#
# EOF
#
?>
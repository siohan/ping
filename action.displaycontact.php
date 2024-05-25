<?php
if ( !isset($gCms) ) exit; 
//debug_display($params, 'Params');

$db = cmsms()->GetDb();	
global $themeObject;

if(isset($params['template']) && $params['template'] !="")
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Coordonnées');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template not found !');
        return;
    }
    $template = $tpl->get_name();
}

$query = "SELECT idclub, numero, nom, nomsalle, adressesalle1, adressesalle2, codepsalle, villesalle, web, nomcor, prenomcor, mailcor, telcor,lat, lng  FROM ".cms_db_prefix()."module_ping_coordonnees";
$dbresult = $db->Execute($query);

if($dbresult) 
{
	if( $dbresult->RecordCount() >0)
	{
		$rowarray = array();
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->idclub = $row['idclub'];
			$onerow->numero = $row['idclub'];
			$onerow->nom = $row['nom'];
			$onerow->nomsalle = $row['nomsalle'];
			$onerow->adressesalle1 = $row['adressesalle1'];
			$onerow->adressesalle2 = $row['adressesalle2'];
			$onerow->codepsalle = $row['codepsalle'];
			$onerow->villesalle = $row['villesalle'];
			$onerow->web = $row['web'];		
			$onerow->nomcor= $row['nomcor'];
			$onerow->prenomcor= $row['prenomcor'];
			$onerow->mailcor= $row['mailcor'];
			$onerow->telcor= $row['telcor'];
			$onerow->lat= $row['lat'];
			$onerow->lng= $row['lng'];
			$rowarray[] = $onerow;
		}
		
	}
		$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));
		
}
else
{
	//echo "pas de résultats !";
}
	

	
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();

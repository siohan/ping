<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;
$template = "Ping Liste Joueurs";

$saison = $this->GetPreference('saison_en_cours');
$smarty->assign('saison',$saison);
$mois_courant = date('n');
$annee_courante = date('Y');


if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Liste Joueurs');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template Liste Joueurs introuvable');
        return;
    }
    $template = $tpl->get_name();
}
$parms = array();
$query= "SELECT id, CONCAT_WS(' ',nom, prenom) AS joueur, prenom,sexe, licence, actif, type, cat, clast FROM ".cms_db_prefix()."module_ping_joueurs"; //WHERE actif = 1";
$query.=" WHERE actif = ?";
$parms['actif'] = 1;
if(isset($params['tradi']) && $params['tradi'] !='')
{
	$query.=" AND type= ?";
	$parms['type'] = $params['tradi'];
}
$query.=" ORDER BY nom ASC";//" LIMIT ?,?";
$dbresult= $db->Execute($query,$parms);//,array($limit, $length));
$rowclass= 'odd';
$rowarray= array();

if ($dbresult && $dbresult->RecordCount() > 0)
{
    while ($row= $dbresult->FetchRow())
    {
		
		 
		$actif = $row['actif'];
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->licence= $row['licence'];
		$onerow->sexe= $row['sexe'];
		$onerow->voyelle =
		$onerow->joueur= $row['joueur'];
		if (true == in_array($voyelle,substr($row['prenom'], 1,1)))
		{
			$onerow->voyelle = 1;
		}
		else
		{
			$onerow->voyelle = 0;
		}
		$onerow->actif= $row['actif'];
		$onerow->points= $row['clast'];
		$onerow->cat= $row['cat'];
		$onerow->type= $row['type'];
		($rowclass == "odd" ? $rowclass= "even" : $rowclass= "odd");
		$rowarray[]= $onerow;
    }
}

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();

#
# EOF
#
?>

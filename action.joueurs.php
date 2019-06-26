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
$template = "Ping Liste Joueurs";
/*
$limit = 0;
if(isset($params['limit']) && $params['limit'] !='')
{
	$limit = $params['limit'];
}
$length = 50;
*/
if(isset($params['template']) && $params['template'] !="")
{
	$template = $params['template'];
}
$query= "SELECT id, CONCAT_WS(' ',nom, prenom) AS joueur, sexe, licence, actif, type, cat, clast FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";//" LIMIT ?,?";
$dbresult= $db->Execute($query);//,array($limit, $length));
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
	$onerow->joueur= $this->CreateLink($id, 'user_results', $returnid, $row['joueur'], array("licence"=>$row['licence']));
	$onerow->actif= $row['actif'];
	$onerow->points= $row['clast'];
	$onerow->cat= $row['cat'];
	$onerow->type= $row['type'];
	($rowclass == "odd" ? $rowclass= "even" : $rowclass= "odd");
	$rowarray[]= $onerow;
      }
}
/*
$suivant = $limit + $length;
echo $suivant;

	$smarty->assign('suivant', $this->CreateLink($id, 'joueurs', $returnid, $contents='>', array("limit"=>$suivant)));

unset($suivant);
*/
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
//echo $this->ProcessTemplate('joueurs2.tpl');
#
# EOF
#
?>
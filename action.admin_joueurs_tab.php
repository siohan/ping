<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}

$db = cmsms()->GetDb();
global $themeObject;

error_reporting(E_ERROR | E_PARSE);

$result= array ();
$query= "SELECT id,CONCAT_WS(' ',nom, prenom) AS joueur, licence, actif, sexe, type, certif, validation,cat FROM ".cms_db_prefix()."module_ping_joueurs ";

if(isset($params['actif']) )
{
	$query.=" WHERE actif = 0";
	$act = 0;
}
else
{
	$query.=" WHERE actif = 1";
	$act = 1;
}
$query.=" ORDER BY joueur ASC";
$smarty->assign('act', $act);
$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array();
$allowed_extensions = $this->GetPreference('allowed_extensions');

$ext = explode(',', $allowed_extensions);

if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
    {
		$actif = $row['actif'];
		$onerow= new StdClass();
		$licence = $row['licence'];
		$onerow->rowclass= $rowclass;
		$onerow->licence= $row['licence'];
		/*$separator = ".";
		foreach ($ext AS $value)
		{
			
			$img = $config['root_url']."/uploads/images/trombines/".$licence.$separator.$value;
			if (false!=file($img))
			{
				 $onerow->img = $config['root_url']."/uploads/images/trombines/".$licence.$separator.$value;
			}
			
		}
		*/
		$onerow->joueur= $row['joueur'];
		$onerow->actif= $row['actif'];
		$onerow->type= $row['type'];
		$onerow->sexe= $row['sexe'];
		$onerow->certif= $row['certif'];
		$onerow->validation= $row['validation'];
		$onerow->cat= $row['cat'];
		$onerow->actif= $row['actif'];		
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);



$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Désactiver"=>"unable","Activer"=>"activate");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('joueurs.tpl');


#
# EOF
#
?>

<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//global $themeObject;
//require_once(dirname(__FILE__).'/include/prefs.php');
$licence = '';
$date_event = '';
$ok = 0;
$saison_courante = (isset($params['saison']))?$params['saison']:$this->GetPreference('saison_en_cours');
if(isset($params['template']) && $params['template'] !="")
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats par joueur');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats par joueur introuvable');
        return;
    }
    $template = $tpl->get_name();
}
//echo 'la phase est : '.$phase;
	if(!isset($params['licence']) && $params['licence'] =='' )
	{
		echo "la licence est absente !";
		
	}
	else
	{
		$licence = $params['licence'];
		$parms = array();
	
		
		
		$rowarray1 = array();
		$query = "SELECT SUM(vd) AS vic, count(vd) AS total, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ?";
		$dbresult = $db->Execute($query, array($licence, $saison_courante));
		$rowclass = 'row1';
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row1 = $dbresult->FetchRow())
				{
					$onerow1= new StdClass();
					$onerow1->rowclass= $rowclass;
					$onerow1->vic= $row1['vic'];
					$onerow1->total= $row1['total'];
					$onerow1->pts= $row1['pts'];
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray1[]= $onerow1;
				}
			}
			$smarty->assign('items1', $rowarray1);


		$query3= "SELECT advnompre, advclaof,pointres, vd,date_event FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND saison = ? ORDER BY date_event DESC";
		$dbresult3 = $db->Execute($query3, array($licence, $saison_courante));
		
		$rowarray= array();

		if ($dbresult3 && $dbresult3->RecordCount() > 0)
		{
		    while ($row= $dbresult3->FetchRow())
			{
	
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$onerow->date_event= $row['date_event'];
				$onerow->advnompre= $row['advnompre'];
				//$onerow->nom= $row['nom'];
				$onerow->advclaof= $row['advclaof'];
				$onerow->vd= $row['vd'];
				//$onerow->coeff= $row['coeff'];
				$onerow->pointres= $row['pointres'];
				$rowarray[]= $onerow;
		      	}
		}
		
		$smarty->assign('resultats',
				$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$licence,'saison'=>$saison_courante)));
	}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
 		$this->CreateReturnLink($id, $returnid,'<= Retour'));
$smarty->assign('items', $rowarray);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template), null, null, $smarty);
$tpl->display();
//echo $this->ProcessTemplate('user_results.tpl');


#
# EOF
#
?>
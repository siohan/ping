<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
$brul = new brulage_ping;
//$adh = new Asso_adherents;
$idepreuve = $params['idepreuve'];
$liste_equipes = $brul->liste_equipes($idepreuve);
$phase = $this->GetPreference('phase_en_cours');

$smarty->assign('liste_equipes',$liste_equipes);
$fields = array('licence');

for($i = 1;$i<=$liste_equipes;$i++)
{
	$eq = 'eq'.$i;
	$fields[] = $eq;
}
//var_dump($fields);

$query = "SELECT * FROM ".cms_db_prefix()."module_ping_brul_eq AS br, ".cms_db_prefix()."module_ping_joueurs AS pj WHERE br.licence = pj.licence AND pj.actif = 1 AND pj.type = 'T' ORDER BY pj.clast DESC  ";
$dbresult= $db->Execute($query);
$rowarray= array();
$rowclass = '';
$eq_ops = new equipes_ping;

$class_mini = array();
    for($i = 1;$i<=$liste_equipes;$i++)
	{
	    if(false == in_array($i,$class_mini))
		{
			$details = $eq_ops->details_equipe_by_num_equipe($i,$phase, $idepreuve);
			$class_mini[$i] = (int) $details['class_mini'];
		} 
	}


if ($dbresult && $dbresult->RecordCount() > 0)
{	
	while ($row= $dbresult->FetchRow())
    {
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->genid = $row['nom'].' '.$row['prenom'];
		$onerow->clast = $row['clast'];
		$brulage=0;
		$other_brulage=0;
		for($i = 1;$i<=$liste_equipes;$i++)
		{
			
			$eq = 'eq'.$i;
			$can_play = 'can_play'.$i;
			
			$play = 0;
			if($row['clast'] < $class_mini[$i])
			{ 
				$play = 1;
			}
			
			$onerow->$can_play = $play;
			$onerow->$eq = $row[$eq];
			$other_brulage = $other_brulage + $row[$eq];
			if($row[$eq]>=2){$brulage++;}
			$inner_brulage = 'inner_brulage'.$i;
			$onerow->$inner_brulage = $brulage;
			$full_brulage = 'other_brulage'.$i;
			$onerow->$full_brulage = $other_brulage;
		}
		
		$onerow->brulage=$brulage;
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;			
    }
    /* */
}
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

	

echo $this->ProcessTemplate('admin_brul_eq.tpl');

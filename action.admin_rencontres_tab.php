<?php
if ( !isset($gCms) ) exit; 
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db = cmsms()->GetDb();	
global $themeObject;
$p_ops = new ping_admin_ops;
$ren_ops = new rencontres;
$seasons_list = $p_ops->seasons_list();
$smarty->assign('seasons_list', $seasons_list);

$default_list = array(-1=>'Toutes');
$liste_epreuves = $p_ops->liste_epreuves();
$liste_epreuves[] = array(-1=>'Toutes');
$final_list = array();


$myclubonly = (isset($_POST['myclubonly']) ? $_POST['myclubonly'] : '0');
$smarty->assign('myclubonly', $myclubonly);
$smarty->assign('liste_epreuves', $liste_epreuves);

$saison = (isset($_POST['saison']) ? $_POST['saison'] : $this->GetPreference('saison_en_cours'));
$smarty->assign('saison', $saison);
//debug_display($_POST, 'Parameters');
$query = "SELECT id, eq_id, renc_id, saison, idpoule, iddiv, club, tour, date_event, affiche, uploaded, libelle, equa, equb, scorea, scoreb, lien, idepreuve, countdown, horaire FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison = ?";
$parms['saison'] = $saison;
//
if( isset($_POST['id_pool']) && $_POST['id_pool'] > 0)
{
	$query.= " AND eq_id = ?";
	$parms['eq_id'] = $_POST['eq_id'];
	$smarty->assign('eq_id', $_POST['eq_id']);
}
if( isset($_POST['tour']) && $_POST['tour'] > 0)
{
	$query.= " AND tour = ?";
	$parms['tour'] = $_POST['tour'];
	$smarty->assign('tour', $_POST['tour']);
}
//mon club uniquement ?

if(isset($_POST['myclubonly']) && $_POST['myclubonly'] =='on')
{
	$query.=" AND club = 1";
	
}
//seulement les rencontres non jouées ?
$upcoming_only = 1;
if(!isset($_POST['tour']) && $upcoming_only == "1")
{
	$query.= " AND date_event >= CURRENT_DATE()";
}
if( isset($_POST['idepreuve']) && $_POST['idepreuve'] > 0)
{
	$query.= " AND idepreuve = ?";
	$parms['idepreuve'] = $_POST['idepreuve'];
	$smarty->assign('idepreuve', $_POST['idepreuve']);
}
//myclubonly ?
$query.= " ORDER BY date_event ASC, tour ASC";
$dbresult = $db->Execute($query, $parms);
if($dbresult)
{
	if($dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->id = $row['id'];
			//$is_uploaded = $ren_ops->is_uploaded($row['renc_id']);
			$onerow->renc_id = $row['renc_id'];
			$onerow->eq_id = $row['eq_id'];
			$onerow->saison = $row['saison'];
			$onerow->date_event = $row['date_event'];
			$onerow->affiche = $row['affiche'];
			$onerow->idepreuve = $row['idepreuve'];
			$onerow->tour = $row['tour'];
			$onerow->scorea = $row['scorea'];
			$onerow->scoreb = $row['scoreb'];
			$onerow->club = $row['club'];
			$date = explode('-', $row['date_event']);
			$onerow->date_smarty = strtotime($row['date_event']);
			$onerow->actual_time = time();
			$onerow->horaire = $row['horaire'];
			$onerow->is_uploaded = $row['uploaded'];
			$onerow->display= $row['affiche'];
			$onerow->countdown= $row['countdown'];
			$onerow->details= $this->CreateLink($id,'retrieve_details_rencontres2', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('download'), '', '', 'systemicon'), array("record_id"=>$row['renc_id']));
			$onerow->equa= $row['equa'];
			$onerow->equb= $row['equb'];
			$rowarray[] = $onerow;
					
		}
		$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));
		
	}
	$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Affiche Ok"=>"affiche_ok","Affiche Ko"=>"affiche_ko","Rebours Ok"=>"countdown_ok","Rebours Ko"=>"countdown_ko","Changer la date et l'horaire"=>"change_date_event", "Indiquer comme téléchargé"=>"is_really_uploaded");

	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
}


echo $this->ProcessTemplate('rencontres.tpl');
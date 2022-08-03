<?php
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
$ping = cms_utils::get_module('Ping');
$saison_en_cours = $ping->GetPreference('saison_en_cours');
$phase_en_cours = $ping->GetPreference('phase_en_cours');
$idepreuve = (isset($params['idepreuve']))?$params['idepreuve']:"2303";
$saison = (isset($params['saison']))?$params['saison']:$saison_en_cours;
$phase = (isset($params['phase']))?$params['phase']:$phase_en_cours;

$record_id = '';
if(!isset($params['record_id']) || $params['record_id'] =='')
{
	$message = 'Un pb est survenu';
}
else
{
	$record_id = (int) $params['record_id'];
	$eq_ops = new equipes_ping;
	$details = $eq_ops->details_equipe($record_id);
	//$id = $details['idequipe'];
	//var_dump($id);
	$titre = $details['friendlyname']." : Le championnat";
	$smarty->assign('titre', $titre);
}

if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats pour une équipe');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}

//Qqs valeurs par défaut pour les images
$dir = 'modules/Ping/images/logos/';
$ext_list = array('.gif', '.jpg', '.png','.jpeg');

//le numéro de l'équipe est ok, on continue
//on va d'abord récupérer le classement de cette équipe
$query = "SELECT cl.clt, cl.joue,cl.equipe,cl.pts,cl.vic, cl.nul, cl.def, cl.pg, cl.pp, cl.pf, num_equipe FROM ".cms_db_prefix()."module_ping_classement AS cl  WHERE  cl.idequipe = ? ORDER BY cl.id ASC";
$dbresult= $db->Execute($query, array($record_id));

$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$classement = $row['clt'];
		$joue = $row['joue'];
		$friendlyname = $row['friendlyname'];
		if($classement=='0' || $joue =='0' )
		{
			$classement = '-';
		}
		$onerow= new StdClass();
		//$onerow->friendlyname= $row['friendlyname'];
		$onerow->clt=  $classement;
		$onerow->equipe= $row['equipe'];
		$onerow->joue= $row['joue'];
		$onerow->pts= $row['pts'];
		$onerow->vic= $row['vic'];
		$onerow->nul= $row['nul'];
		$onerow->def= $row['def'];
		$onerow->pg= $row['pg'];
		$onerow->pp= $row['pp'];
		$onerow->pf= $row['pf'];
		$eq1 = $eq_ops->idclub($row['num_equipe']);//eq1 = le numéro du club
		foreach($ext_list as $ext)
		{
			if(true == file_exists($dir.$eq1.$ext))
			{
				$img_club = $eq1.$ext;
			}
		}
		
		$onerow->img_club =$img_club;
		$rowarray[]= $onerow;
	}
}
else
{
	echo 'Pas encore de résultats';//pas de résultats ?
}
//$smarty->assign('libequipe', $friendlyname);
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

/**/

$query2 = "SELECT date_event FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren WHERE eq_id = ? GROUP BY date_event ORDER BY date_event ASC ";
$dbresultat = $db->Execute($query2,array($record_id));
$rowarray2 = array();
$i = 0;
$renc_ops = new rencontres;
if($dbresultat && $dbresultat->RecordCount()>0)
{
	
	while($row2 = $dbresultat->FetchRow())
	{
		$i++;
		$date_event = $row2['date_event'];
		$idpoule = $row2['idpoule'];
		$iddiv = $row2['iddiv'];
		$onerow2 = new StdClass();
		$onerow2->rowclass =$rowclass;
		$onerow2->date_event = $row2['date_event'];
		$onerow2->valeur = $i;
		
		
			//on fait la deuxième requete dérivant de la première
			$query3 = "SELECT ren.equa, ren.scorea, ren.equb, ren.scoreb, ren.renc_id, ren.equip_id1, ren.equip_id2, ren.uploaded FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren WHERE ren.date_event = ? AND eq_id = ?";
			$dbresult3 = $db->Execute($query3, array($date_event, $record_id));
			$rowarray3 = array();
			
				if($dbresult3 && $dbresult3->RecordCount()>0)
				{
					
					$img1= '';
					$img2 = '';
					while($row3 = $dbresult3->FetchRow())
					{
						
						$eq1 = $eq_ops->idclub($row3['equip_id1']);//eq1 = le numéro du club
	
						foreach($ext_list as $ext)
						{
							if(true == file_exists($dir.$eq1.$ext))
							{
								$img1 = $eq1.$ext;
							}
						}
						$eq2 = $eq_ops->idclub($row3['equip_id2']);//eq1 = le numéro du club
	
						foreach($ext_list as $ext)
						{
							if(true == file_exists($dir.$eq2.$ext))
							{
								$img2 = $eq2.$ext;
							}
						}
						
						$onerow3  = new StdClass();
						$onerow3->rowclass = $rowclass;
						$onerow3->equa = $row3['equa'];
						$onerow3->scorea = $row3['scorea'];
						$onerow3->equb = $row3['equb'];
						$onerow3->scoreb = $row3['scoreb'];
						$onerow3->img1 =$img1;
						$onerow3->img2 =$img2;
						$onerow3->uploaded = $row3['uploaded'];//$renc_ops->is_uploaded($row3['renc_id']);//$uploaded;
						$onerow3->renc_id = $row3['renc_id'];
						$rowarray3[] = $onerow3;
					}
					$smarty->assign('prods_'.$i,$rowarray3);
					$smarty->assign('itemscount_'.$i, count($rowarray3));
					unset($rowarray3);
					
				}
		$rowarray2[]  = $onerow2;
	}
	 
	$smarty->assign('itemcount2', count($rowarray2));
	$smarty->assign('items2', $rowarray2);
}
/**/
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();

#
#EOF
#
?>

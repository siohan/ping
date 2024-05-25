<?php
if ( !isset($gCms) ) exit; 

$db = cmsms()->GetDb();	
global $themeObject;
$p_ops = new ping_admin_ops;
$eq_ops = new equipes_ping;
$seasons_list = $p_ops->seasons_list();
$smarty->assign('seasons_list', $seasons_list);
$liste_epreuves = $p_ops->liste_epreuves();
$smarty->assign('liste_epreuves', $liste_epreuves);
$eq_ops = new equipes_ping;
if(isset($params['record_id']) && $params['record_id'] !="")//C'EST LE NUMÉRO D'UNE ÉQUIPE
{
	$record_id = (int) $params['record_id'];
}

if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Countdown');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}
$rowarray = array();
$saison = (isset($_POST['saison']) ? $_POST['saison'] : $this->GetPreference('saison_en_cours'));
//debug_display($params, 'Parameters');
$query = "SELECT id, eq_id, renc_id, saison, idpoule, iddiv, club, tour, date_event, affiche, uploaded, libelle, equa, equb, scorea, scoreb, lien, idepreuve, horaire, equip_id1, equip_id2 FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event >= CURRENT_DATE()";
if(isset($params['record_id']) && $params['record_id'] !="")
{
	$record_id = (int) $params['record_id'];
	$query.= " AND eq_id = ? AND club = 1 ORDER BY date_event ASC LIMIT 1";
	$dbresult = $db->Execute($query, array($record_id));
}
else
{
	$query.= " AND countdown = 1 ORDER BY date_event ASC LIMIT 1";
	$dbresult = $db->Execute($query);
}

if($dbresult)
{
	if($dbresult->RecordCount() >0)
	{
		while($row = $dbresult->FetchRow())
		{
			
				$equip_id1 = $row['equip_id1'];
				$eq1 = $eq_ops->idclub($equip_id1);//eq1 = le numéro du club
    			
				$img1= '';
				$dir = 'modules/Ping/images/logos/';

				$ext_list = array('.gif', '.jpg', '.png','.jpeg');
				
				foreach($ext_list as $ext)
				{
					if(true == file_exists($dir.$eq1.$ext))
					{
						$img1 = $eq1.$ext;
					}
				}
				$img2 = '';			
				$equip_id2 = $row['equip_id2'];
				$eq2 = $eq_ops->idclub($equip_id2);//eq1 = le numéro du club
    			
				
				$dir = 'modules/Ping/images/logos/';

				$ext_list = array('.gif', '.jpg', '.png','.jpeg');
				
				foreach($ext_list as $ext)
				{
					if(true == file_exists($dir.$eq2.$ext))
					{
						$img2 = $eq2.$ext;
					}
				}
			
			$onerow = new StdClass();
			$horaire = $row['horaire'];
			$date_event = $row['date_event'];
			$hor = explode(':', $horaire);
			
			$tab = explode('-', $row['date_event']);
			
			$details = $eq_ops->details_equipe($row['eq_id']);
			
			if($hor[1] == '00')
			{$hor[1] = (int) 0;}
			$hor[2] = 0; //pour les secondes
			$month = $tab[1];
			//echo $month;
			$deadline = mktime($hor[0],$hor[1], 0, $tab[1],$tab[2],$tab[0]);
			
			$pos = strpos($details['libdivision'], '_', $offset=0);
			//var_dump($pos);
			if($pos == 3)
			{
				$onerow->libdivision = substr(str_replace('_', ' ',$details['libdivision']),4);
			}
			else
			{
				$onerow->libdivision = str_replace('_', ' ',$details['libdivision']);
			}
			$onerow->renc_id = $row['renc_id'];
			$onerow->eq_id = $row['eq_id'];
			$onerow->saison = $row['saison'];
			$onerow->date_event = $row['date_event'];
			$onerow->affiche = $row['affiche'];
			$onerow->idepreuve = $p_ops->nom_compet($row['idepreuve']);
			
			$onerow->tour = $row['tour'];
			$onerow->libelle = $row['libelle'];
			$onerow->scorea = $row['scorea'];
			$onerow->scoreb = $row['scoreb'];
			$onerow->img1 = $img1;
			$onerow->img2 = $img2;
			$onerow->club = $row['club'];		
			$onerow->equa= $row['equa'];
			$onerow->equb= $row['equb'];
			$onerow->heures= (int)$hor[0];
			$onerow->minutes=(int) $hor[1];
			$onerow->secondes= (int) $hor[2];
			$onerow->horaire= $row['horaire'];
			$onerow->date_unix = $deadline;
			$rowarray[] = $onerow;
					
		}
		/*$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));*/
		
	}
}
$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();
//echo $this->ProcessTemplate('displaycountdown.tpl');

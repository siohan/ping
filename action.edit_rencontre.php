<?php


if(!isset($gCms)) exit;

global $themeObject;
$ren_ops = new rencontres;
if(!empty($_POST))
{
	$error = 0;
	debug_display($_POST, 'Parameters');
	//renc_id, club, tour, date_event, affiche, uploaded, 
	// equa, equb, scorea, scoreb, idepreuve, countdown, horaire
	if(isset($_POST['renc_id']) && $_POST['renc_id'] !='')
	{
		$renc_id = $_POST['renc_id'];
	}
	else
	{
		$error++;
	}
	if(isset($_POST['club']) && $_POST['club'] !='')
	{
		$club = $_POST['club'];
	}
	if(isset($_POST['eq_id']) && $_POST['eq_id'] !='')
	{
		$eq_id = $_POST['eq_id'];
	}
	if(isset($_POST['tour']) && $_POST['tour'] !='')
	{
		$tour = $_POST['tour'];
	}
	if(isset($_POST['date_event']) && $_POST['date_event'] !='')
	{
		$date_event = $_POST['date_event'];
	}
	if($_POST['debut_Hour'] !='' && $_POST['debut_Minute'] !='')
	{
		$horaire = $_POST['debut_Hour'].':'.$_POST['debut_Minute'];
	}
	if(isset($_POST['affiche']) && $_POST['affiche'] !='')
	{
		$affiche = $_POST['affiche'];
	}
	if(isset($_POST['uploaded']) && $_POST['uploaded'] !='')
	{
		$uploaded = $_POST['uploaded'];
	}
	if(isset($_POST['equa']) && $_POST['equa'] !='')
	{
		$equa = $_POST['equa'];
	}
	if(isset($_POST['equb']) && $_POST['equb'] !='')
	{
		$equb = $_POST['equb'];
	}
	if(isset($_POST['scorea']) && $_POST['scorea'] !='')
	{
		$scorea = $_POST['scorea'];
	}
	if(isset($_POST['scoreb']) && $_POST['scoreb'] !='')
	{
		$scoreb = $_POST['scoreb'];
	}
	if(isset($_POST['idepreuve']) && $_POST['idepreuve'] !='')
	{
		$idepreuve = $_POST['idepreuve'];
	}
	if(isset($_POST['countdown']) && $_POST['countdown'] !='')
	{
		$countdown = $_POST['countdown'];
	}
	$edit_rencontre = $ren_ops->edit_rencontre($renc_id, $club, $tour, $date_event, $affiche, $uploaded,$equa, $equb, $scorea, $scoreb, $idepreuve, $countdown, $horaire);
	if(true == $edit_rencontre)
	{
		$this->SetMessage('Rencontre modifiée !');
	}
	else
	{
		$this->SetMessage('Rencontre non modifiée !');
	}
	$this->Redirect($id, 'admin_poules_tab3', $returnid, array('record_id'=>$eq_id));
}
else
{
	debug_display($params, 'Parameters');
	//le record_id est défini, on peut récupérer toutes les variables nécessaires
	if(isset($params['renc_id']) && $params['renc_id'] !='')
	{
		//on instancie la classe rencontres
		
		$renc_id = $params['renc_id'];
		$details = $ren_ops->details_rencontre($renc_id);
		
		//on prépare le formulaire
		$tpl = $smarty->CreateTemplate($this->GetTemplateResource('edit_rencontre.tpl'), null, null, $smarty);
		$tpl->assign('id', $details['id']);
		$tpl->assign('eq_id', $details['eq_id']);
		$tpl->assign('renc_id', $details['renc_id']);
		$tpl->assign('saison', $details['saison']);
		$tpl->assign('idpoule', $details['idpoule']);
		$tpl->assign('iddiv', $details['iddiv']);
		$tpl->assign('club', $details['club']);
		$tpl->assign('tour', $details['tour']);
		$tpl->assign('date_event', $details['date_event']);
		$tpl->assign('affiche', $details['affiche']);
		$tpl->assign('uploaded', $details['uploaded']);
		$tpl->assign('libelle', $details['libelle']);
		$tpl->assign('equa', $details['equa']);
		$tpl->assign('equb', $details['equb']);
		$tpl->assign('scorea', $details['scorea']);
		$tpl->assign('scoreb', $details['scoreb']);
		$tpl->assign('lien', $details['lien']);
		$tpl->assign('idepreuve', $details['idepreuve']);
		$tpl->assign('countdown', $details['countdown']);
		$tpl->assign('horaire', $details['horaire']);
		
		$tpl->display();
	}
}
	

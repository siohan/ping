<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Delete'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$error = 0;

$saison_en_cours = $this->GetPreference('saison_en_cours');
$phase_en_cours =  $this->GetPreference('phase_en_cours');

if(isset($params['record_id']) && $params['record_id'] >0)
{
	$record_id =  $params['record_id'];	
}

else
{
	$error++;
}
if(isset($params['page_contenu']) && $params['page_contenu'] >0)
{
	$page_contenu = (int) $params['page_contenu'];
}
else
{
	$error++;
}
if($error ==0)
{
	$tab = explode('-', $record_id);
	$idepreuve = $tab[0];
	$phase = $tab[1];
	$epreuv = new EpreuvesIndivs;
	$det_ep = $epreuv->details_epreuve($idepreuve);
	$saison = $det_ep['saison'];
	$name = $det_ep['name'];
	if($saison != $saison_en_cours)
	{
		//la saison n'est pas la même
		//il faut chercher une epreuve avec le même nom dans la saison en cours
		$search_epr = $epreuv->search_epreuve($name);
		if(false != $search_epr)
		{
			//on fait le changement dans la page en question
			//maintenant on peut faire l'update
			$content = $search_epr.'-'.$phase_en_cours;
			$query2 = "UPDATE ".cms_db_prefix()."content_props SET content = ? WHERE content_id = ? AND prop_name = 'epreuveAffiche'";
			$dbresult2 = $db->Execute($query2, array($content, $page_contenu));
			$message = 'Epreuve mise à jour dans la page de résultats';
		}
		else
		{
			$message = 'Pas d\épreuve correspondante pour cette saison !';
		}
	}
	else
	{
		//on regarde pour la phase
		$content = $idepreuve.'-'.$phase_en_cours;
		$query2 = "UPDATE ".cms_db_prefix()."content_props SET content = ? WHERE content_id = ? AND prop_name = 'epreuveAffiche'";
		$dbresult2 = $db->Execute($query2, array($content, $page_contenu));
		$message = 'Epreuve mise à jour dans la page de résultats';
	}
			
	$this->SetMessage($message);
	$this->Redirect($id, 'page_contenu', $returnid);
	
}
else
{
	$this->SetMessage('Page de résultats et/ou épreuve inexistante(s)');
	$this->Redirect($id, 'page_resultats', $returnid);
}


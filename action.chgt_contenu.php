<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Delete'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$error = 0;
if(isset($params['record_id']) && $params['record_id'] >0)
{
	$record_id = (int) $params['record_id'];
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
	$eq_ops = new equipes_ping;
	$saison = $this->GetPreference('saison_en_cours');
	$phase =  $this->GetPreference('phase_en_cours');
	$db = cmsms()->GetDb();
	$details = $eq_ops->details_equipe($record_id);
	if($details['saison'] != $saison )
	{
				//Il faut trouver l'idepreuve correspondant (ils ne sont pas identiques d'une saison l'autre)
				//donc on doit récupérer l'identifiant en utilisant le nom de l'épreuve
				//quel est le nom de l'épreuve ?
				$idepreuve = $details['idepreuve'];
				$epreuv = new EpreuvesIndivs;
				$det_ep = $epreuv->details_epreuve($idepreuve);
				$name = $det_ep['name']; //voilà le nom de l'épreuve
				$det = $epreuv->details_epreuve_by_name($name,$saison);
				if(false !==$det)
				{
					
					//il faut trouver l'équipe correspondante (si elle existe !) pour cette saison et cette phase ET l'épreuve correspondante
					$eq_saison = $eq_ops->search_team($saison, $phase,$det['idepreuve'],$details['numero_equipe']);
					//maintenant on peut faire l'update
					$query2 = "UPDATE ".cms_db_prefix()."content_props SET content = ? WHERE content_id = ? AND prop_name = 'equipeAffiche'";
					$dbresult2 = $db->Execute($query2, array($eq_saison, $page_contenu));
					$message = 'Saison et phase modifiées';
				}
				else
				{
					$message = 'Pas d\'épreuves correspondantes ! Changement non effectué !';
				}
	}
	elseif($details['phase'] != $phase)
	{
				//on n'a juste la phase a changer, pas de idepreuve a trouver
				$eq_saison = $eq_ops->search_team($saison, $phase,$details['idepreuve'],$details['numero_equipe']);
				//maintenant on peut faire l'update
				$query2 = "UPDATE ".cms_db_prefix()."content_props SET content = ? WHERE content_id = ? AND prop_name = 'equipeAffiche'";
				$dbresult2 = $db->Execute($query2, array($eq_saison, $page_contenu));
				$message = 'Phase modifiée';
	}
	$this->SetMessage($message);
	$this->Redirect($id, 'page_contenu', $returnid);
	
}
else
{
	$this->SetMessage('Page de contenu et/ou équipe inexistante(s)');
	$this->Redirect($id, 'page_contenu', $returnid);
}

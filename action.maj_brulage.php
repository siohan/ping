<?php

if(!isset($gCms)) exit;
$db = cmsms()->GetDb();

if(!$this->CheckPermission('Ping Use lock'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$brul = new brulage_ping;
$nb_equipes = $this->liste_equipes();


$brul->drop_table();
$brul->create_table();
$query = "SELECT ref_action, ref_equipe,genid FROM ".cms_db_prefix()."module_ping_brulage ORDER BY licence ASC";
$dbresult = $db->Execute($query);
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$exists = $brul->player_exists_brul($row['genid']);
		if(true == $exists)
		{
			//on fait un raz 
			$brul->raz_brul_eq($row['genid']);
		}
		else
		{
			$brul->add_player_brul_eq($row['genid']);
		}
		//maintenant on peut lister la table
		$brul->add_brul_eq($row['genid'],$row['ref_equipe']);
		
	}
}
$this->Redirect($id,'brulage_par_eq',$returnid);


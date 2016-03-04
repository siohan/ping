<?php
################################################################
#      Ce script rafraichit les données de la récupération    ##
################################################################
if( !isset($gCms)) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
}
$saison = $this->GetPreference('saison_en_cours');
$i = 0;//on instancie un compteur pour connaitre le nb de tableau rafraichit

	$query = "SELECT dv.tableau, dv.uploaded_classement FROM ".cms_db_prefix()."module_ping_div_tours AS dv LEFT OUTER JOIN ".cms_db_prefix()."module_ping_div_classement AS cla  ON dv.tableau = cla.tableau WHERE cla.tableau IS NOT NULL AND dv.uploaded_classement IS NULL AND dv.saison = ?";
	$dbresult = $db->Execute($query, array($saison));
	
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$i++;
			$uploaded_classement = $row['uploaded_classement'];
			$tableau = $row['tableau'];
			if(is_null($uploaded_classement))
			{
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded_classement = '1' WHERE tableau = ? AND saison = ?";
				$dbresult2 = $db->Execute($query2, array($tableau, $saison));
			}
		}
		
	}

	$query = "SELECT dv.tableau, dv.uploaded_classement FROM ".cms_db_prefix()."module_ping_div_tours AS dv  LEFT OUTER JOIN ".cms_db_prefix()."module_ping_div_classement AS cla  ON dv.tableau = cla.tableau WHERE cla.tableau IS NULL AND dv.saison = ?";
	$dbresult = $db->Execute($query, array($saison));

	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$i++;
			$uploaded_classement = $row['uploaded_classement'];
			$tableau = $row['tableau'];
			if($uploaded_classement == "1")
			{
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET uploaded_classement IS NULL WHERE tableau = ? AND saison = ?";
				$dbresult2 = $db->Execute($query2, array($tableau, $saison));
			}
		}
		
	}

$message = "MAJ de classements de poules";
$this->SetMessage($message);
$this->Redirect($id,'admin_poules',$returnid, array("idepreuve"=>$idepreuve));




#
# EOF
#
?>
<?php

if( !isset($gCms) ) exit;
//require_once(dirname(__FILE__)'')
if (!$this->CheckPermission('Ping Use'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }
debug_display($params,'Parameters');

$db =& $this->GetDb();
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('Phase_en_cours');
$edit = 0;//sert à distinguer l'ajout par défaut 0 d'une édition (= 1)
$record_id = '';
$query = "SELECT id, code_compet, indivs FROM ".cms_db_prefix()."module_ping_type_competitions";
$dbresult = $db->Execute($query);

if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$tag = "{Ping action='";
		$id = $row['id'];
		$code = $row['code_compet'];
		$indivs = $row['indivs'];
		
		if($indivs =='1')
		{
			$tag.="individuelles'";
		}
		else
		{
			$tag.="par-equipes'";
		}
		$tag.=" type_compet='$code'";
		$tag.="}";
		echo $tag;
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET tag = ? WHERE id = ?";
		$db->Execute($sqlarray, array($tag,$id));
		//unset($tag);
	}


}

/* 
$this->SetMessage('Update tag réalisé');
$this->RedirectToAdminTab('competitions');
*/
#
# EOF
#
?>

<?php
#################################################################
#    Première étape de récupération des équipes                 #
#################################################################



if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
if(!isset($club_number) && $club_number =='')
{
	$message = "Votre numéro de club n'est pas configuré !!";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
$now = trim($db->DBTimeStamp(time()), "'");
//on instancie la classe service
$service = new Servicen();
$result = '';

$page = "rss_all";

	$lien = $service->GetRSS($page);
	$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
	//var_dump($xml);
	if($xml === FALSE)
	{
		$this->SetMessage("Le service est coupé");
		$this->RedirectToAdminTab('equipes');
	}
	else
	{
		$array = json_decode(json_encode((array)$xml), TRUE);
	}

$i = 0;

foreach ($xml->channel->item as $item)
{
 	$datetime = date_create($item->pubDate);
 	$date = date_format($datetime, 'Y-m-d H:i:s');
	$des = $item->description;//filter_var($item->description, FILTER_SANITIZE_STRING,!FILTER_FLAG_STRIP_LOW);
	$link = munge_string_to_url($item->link,false, true);
	$title = addslashes($item->title);//, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
	$enclosure_url = munge_string_to_url($item->enclosure_url,false, true);
	
	//on fait la requete pour voir si le lien existe déjà
	$query = "SELECT news_title FROM ".cms_db_prefix()."module_news WHERE news_title LIKE ?";
	$dbresult = $db->Execute($query, array($title));
	
	if($dbresult && $dbresult->RecordCount() == 0)
	{
		//on peut insérer la news
		$i++;//un compteur pour connaitre le nb d'articles dûment importés
		$article_id = $db->GenId(cms_db_prefix().'module_news_seq');
		$query2 = "INSERT INTO ".cms_db_prefix()."module_news (news_id, news_category_id, news_title, news_data, summary, status, news_date, start_time, end_time, create_date, modified_date,author_id,news_extra,news_url,searchable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$dbresult2 = $db->Execute($query2, array($article_id,'1',$title,$des,$des,'published',$date,NULL,NULL,'','',1,'',$link,1));
		
		//on teste si ça marche
	/*
		if ($dbresult2)
		{
			$i++;
			//on incrémente la table news_seq
			$query3 = "UPDATE ".cms_db_prefix()."module_news_seq SET id = LAST_INSERT_ID(id+1)";
			$dbresult3 = $db->Execute($query3);
			
		}
	*/	
	}
	
	
 
}


$designation .= "Récupération de ".$i." articles";

	
	

	
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('equipes');
#
# EOF
#

?>
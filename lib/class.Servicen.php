<?php
 
//namespace Mping\CoreBundle\Fftt;
 
//use Doctrine\Common\Cache\Cache;
 
class Servicen
{
    private $cache;
    private $logger;
    private $ipsource;
    private $serials;
    private $autoInitialization;
    private $id;
    private $serie;
    private $tm;
    private $tmc;
    
    

 
    public function __construct(Cache $cache = null, $logger = null, $serials = array(), $ipsource = null, $ping = null, $code = null, $id = null, $serial = null, $tm = null, $tmc = null)
    {
        $this->cache = $cache;
        $this->logger = $logger; // Must have a method log($url, $data)
        $this->ipsource = $ipsource;
 	
	$this->ping = cms_utils::get_module('Ping');
        $this->autoInitialization = true;
 
        libxml_use_internal_errors(true);
    }
    public function GetPassword()
    {
	$ping = cms_utils::get_module('Ping');
	$this->code = $ping->GetPreference('motdepasse');
	return $this->code;
	//echo "le code est : ".$code;
    }
    
   public function GetSerie()
    {
	$ping = cms_utils::get_module('Ping');
	$this->serie = $ping->GetPreference('serie');
	return $this->serie;
	//echo "le code est : ".$code;
    }

   public function GetIdAppli()
    {
	$ping = cms_utils::get_module('Ping');
	$this->id = $ping->GetPreference('idAppli');
	return $this->id;
	//echo "le code est : ".$code;
    }

    public function GetTimestamp()
   {
	$this->tm = substr(date('YmdHisu'),0,17);
	return $this->tm;
	
   }

   public function GetEncryptedTimestamp()
   {
	$this->code = servicen::GetPassword();
	$this->tm = servicen::GetTimestamp();
	$this->tmc = hash_hmac("sha1",$this->tm,$this->code);
	return $this->tmc;

   }
    public function initialisationAPI() 
    {
	
	$this->serie = servicen::GetSerie();
	$this->tm = servicen::GetTimestamp();
	$this->tmc = servicen::GetEncryptedTimestamp();
	$this->id = servicen::GetIdAppli();
	
	$chaine = 'http://www.fftt.com/mobile/pxml/xml_initialisation.php?serie='.$this->serie.'&tm='.$this->tm.'&tmc='.$this->tmc.'&id='.$this->id; 
	$result = file_get_contents($chaine);

	$dom = new DomDocument();
	$dom->loadXML($result); 
	$reponse = $dom->getElementsByTagName('appli')->item(0)->nodeValue;
	return $reponse;
	//return $chaine;
    }

    public function GetLink($page,$var = "")
    {
		$this->serie = servicen::GetSerie();
		$this->tm = servicen::GetTimestamp();
		$this->tmc = servicen::GetEncryptedTimestamp();
		$this->id = servicen::GetIdAppli();
		$chaine = 'https://apiv2.fftt.com/mobile/pxml/'.$page.'.php?serie='.$this->serie.'&tm='.$this->tm.'&tmc='.$this->tmc.'&id='.$this->id.'&'.$var;
		//$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$this->serie.'&tm='.$this->tm.'&tmc='.$this->tmc.'&id='.$this->id.'&'.$var; 
		return file_get_contents($chaine);
		//return $chaine;//pour tester le lien
    }

    

 
}

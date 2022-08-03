<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
debug_display($params, 'Parameters');


$idepreuve = '';
$niveau = '';
$error = 0;
$retrieve_ops = new retrieve_ops;
$ping_ops = new ping_admin_ops;
$saison = $this->GetPreference('saison_en_cours');

if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	$error++;
}
if(isset($params['tour']) && $params['tour'] != '')
{
	$tour = $params['tour'];
}
else
{
	$error++;
}
if(isset($params['epreuve']) && $params['epreuve'] != '')
{
	$iddivision = $params['epreuve'];
}
else
{
	$error++;
}
if (isset($params['cancel']))
{
	$this->Redirect($id, 'participants', $returnid, array("idepreuve"=>$idepreuve));
}
echo $error;

if($error < 1)
{
	
		//on envoie les données en bdd
		//on fait qqs traitements
		
	
			
			//on récupère tous les tours d'abord
			
			$tours = $retrieve_ops->retrieve_div_tours($idepreuve, $iddivision);
			// recherche le N° de tableau et l'iddivision
			$tableau = $ping_ops->tableau($idepreuve,$iddivision,$tour);
			if(isset($params['niveau']) && $params['niveau'])
			{
				$idorga = $params['niveau'];
			}
	//		$query = "INSERT INTO ".cms_db_prefix()."module_ping_participe_tours(licence, idepreuve, iddivision,idorga, tour, tableau, saison) VALUES (?, ?, ?, ?, ?, ?, ?) ";
	//		$dbresult = $db->Execute($query, array($licence, $idepreuve, $iddivision,$idorga, $tour, $tableau,$saison));
		
		//		$this->Redirect($id, 'participants_tours', $returnid, array("licence"=>$licence, "idepreuve"=>$idepreuve));
		
			
	
		
	
}
else
{
	echo "des erreurs !";
}

#
#EOF
#
?>
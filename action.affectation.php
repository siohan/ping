<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
debug_display($params, 'Parameters');

$step = '';
$licence= '';
$idepreuve = '';
$niveau = '';
$error = 0;
$retrieve_ops = new retrieve_ops();
$ping_ops = new ping_admin_ops();
$saison = $this->GetPreference('saison_en_cours');

if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	$error++;
}
if (isset($params['cancel']))
{
	$this->Redirect($id, 'participants', $returnid, array("idepreuve"=>$idepreuve));
}
    

if(isset($params['step']) && $params['step'] != '')
{
	$step = $params['step'];
}
else
{
	$error++;
}
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
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
if($error <1)
{
	if($step ==1)
	{
		//il s'agit du niveau
		if(isset($params['niveau']) && $params['niveau'] != '')
		{
			$libelle = array();
			$niveau = $params['niveau'];
			$retrieve_divisions = $retrieve_ops->retrieve_divisions($niveau,$idepreuve,$type='1');
			
			//ensuite, on sélectionne ds la bdd pour faire un dropdown
			$query = "SELECT idorga, idepreuve, iddivision,libelle, saison FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve = ? AND idorga = ? AND saison = ?";
			//echo $query;
			$dbresult = $db->Execute($query, array($idepreuve, $niveau, $saison));
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$iddivision = $row['iddivision'];
					$libelle[$row['libelle']] = $row['iddivision'];
				}
			}
			//var_dump($libelle);
			$smarty->assign('formstart',
					    $this->CreateFormStart( $id, 'affectation', $returnid ) );
			$smarty->assign('licence',
					$this->CreateInputText($id,'licence',$licence,12,15));
			$smarty->assign('step', $this->CreateInputHidden($id,'step',"2"));
			$smarty->assign('idepreuve',
					$this->CreateInputText($id,'idepreuve',$idepreuve,5,15));
			$smarty->assign('tour',
					$this->CreateInputText($id,'tour',$tour,5,15));

			$smarty->assign('niveau',
					$this->CreateInputText($id, 'niveau',$niveau));
			$smarty->assign('libelle',
					$this->CreateInputDropdown($id, 'libelle',$libelle));
			$smarty->assign('submit',
					$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
			$smarty->assign('cancel',
					$this->CreateInputSubmit($id,'cancel',
								$this->Lang('cancel')));
			$smarty->assign('back',
					$this->CreateInputSubmit($id,'back',
								$this->Lang('back')));

			$smarty->assign('formend',
					$this->CreateFormEnd());
			echo $this->ProcessTemplate('affectation_niveaux.tpl');
		}
		
	}
	elseif($step==2)
	{
		//on envoie les données en bdd
		//on fait qqs traitements
		
		if(isset($params['libelle']) && $params['libelle'] != '')
		{
			$iddivision = $params['libelle'];
			//on récupère tous les tours d'abord
			
			$tours = $retrieve_ops->retrieve_div_tours($idepreuve, $iddivision);
			// recherche le N° de tableau et l'iddivision
			$tableau = $ping_ops->tableau($idepreuve,$iddivision,$tour);
			if(isset($params['niveau']) && $params['niveau'])
			{
				$idorga = $params['niveau'];
			}
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_participe_tours(licence, idepreuve, iddivision,idorga, tour, tableau, saison) VALUES (?, ?, ?, ?, ?, ?, ?) ";
			$dbresult = $db->Execute($query, array($licence, $idepreuve, $iddivision,$idorga, $tour, $tableau,$saison));
			
				$this->Redirect($id, 'participants_tours', $returnid, array("licence"=>$licence, "idepreuve"=>$idepreuve));
			
			
		}
		
	}
}
else
{
	echo "des erreurs !";
}

#
#EOF
#
?>
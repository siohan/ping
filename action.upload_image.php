<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
if(isset($params['genid']) && $params['genid'] !='')
{
	$genid = $params['genid'];
	
    // Repertoire cible
	$target = $config['root_url']."/uploads/images/trombines";

	if( !is_dir($target) ) 
	{
  		if( !mkdir($target, 0755) ) 
  		{
    		exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  		}
	}

	$tpl = $smarty->CreateTemplate( $this->GetTemplateResource('upload_image.tpl'), null, null, $smarty );
    $tpl->assign('genid',$genid);
    $tpl->display();
}
else
{
	$idclub = $params['idclub'];
	
    // Repertoire cible
	$target = "../modules/Ping/images/logos/";
	
	$ext_list = array('.gif', '.jpg', '.png','.jpeg');
		foreach($ext_list as $ext)
		{
 			if(true == file_exists($target.$idclub.$ext))
 			{
  				unlink($target.$idclub.$ext);
  				
 			}
		}
    
	if( !is_dir($target) ) 
	{
  		if( !mkdir($target, 0755) ) 
  		{
    		exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  		}
	}
	
	$tpl = $smarty->CreateTemplate( $this->GetTemplateResource('upload_image.tpl'), null, null, $smarty );
    $tpl->assign('idclub',$idclub);
    $tpl->display();
}
?>

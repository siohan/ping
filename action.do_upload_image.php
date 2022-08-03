<?php
 if( !isset($gCms) ) exit;
//debug_display($_POST, 'Parameters');
/************************************************************
 * Script realise par Emacs
 * Crée le 19/12/2004
 * Maj : 23/06/2008
 * Licence GNU / GPL
 * webmaster@apprendre-php.com
 * http://www.apprendre-php.com
 * http://www.hugohamon.com
 *
 * Changelog:
 *
 * 2008-06-24 : suppression d'une boucle foreach() inutile
 * qui posait problème. Merci à Clément Robert pour ce bug.
 *
 *************************************************************/
 // Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
//$tabExt = $this->GetPreference('allowed_extensions');//
foreach($tabExt as $value)
{
	$tabExt[] = trim($value);
}
//var_dump($tabExt);
$infosImg = array();
//$adh_ops = new Asso_adherents;
// Variables
$extension = '';
$message = '';
$nomImage = '';
if(isset($_POST['genid']) && $_POST['genid'] >0)
{
	$target =  '../uploads/images/trombines/';
	$genid = $_POST['genid'];
}

if(isset($_POST['idclub']) && $_POST['idclub'] >0)
{
	$target =  "../modules/Ping/images/logos/";
	$genid = $_POST['idclub'];
}
	$max_size = 300000;//$this->GetPreference('max_size');//100000;    // Taille max en octets du fichier
	$width_max =  800;//$this->GetPreference('max_width');//800;    // Largeur max de l'image en pixels
	$height_max = 800;//$this->GetPreference('max_height');//800;    // Hauteur max de l'image en pixels
	//var_dump($width_max);
//if(isset($params[''])) 
/************************************************************
 * Script d'upload
 *************************************************************/
if(!empty($_POST))
{
  //
if(isset($_POST['genid']))
{
	$genid = $_POST['genid'];
}
// On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
//var_dump($extension);

 
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
//var_dump($infosImg);
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
	$poids = filesize($_FILES['fichier']['tmp_name']);
	//var_dump($poids);
        if($infosImg[0] <= $width_max && $infosImg[1] <= $height_max && filesize($_FILES['fichier']['tmp_name']) <= $max_size)
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error']) 
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            //$nomImage = md5(uniqid()) .'.'. $extension;
	    $nomImage = $genid.'.'. $extension;
 
            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], $target.$nomImage))
            {
              $message = 'Upload réussi !';
	      //on ajoute l'extension à la table adhérents
	      //$eq_ops->add_image_extension($genid, $extension);
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image ou fichier trop lourd !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }
}
$this->SetMessage($message);
$this->RedirectToAdminTab('equipes');//($id, 'view_adherent_details', $returnid, array("record_id"=>$genid));
?>
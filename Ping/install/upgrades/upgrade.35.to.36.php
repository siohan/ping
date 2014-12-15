<?php
$gCms = cmsms();

echo '<p>Ajout de la table module_smarty_plugins ... ';
$flds = "
         sig C(80) KEY NOT NULL,
         name C(80) NUT NULL,
         module C(160) NOT NULL,
         type C(40) NOT NULL,
         callback C(255) NOT NULL,
         available I,
         cachable I1
";
$dbdict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dbdict->CreateTableSQL(cms_db_prefix()."module_smarty_plugins", $flds, $taboptarray);
$return = $dbdict->ExecuteSQLArray($sqlarray);
echo '[fait]</p>';

echo '<p>Am&eacute;lioration la table adminlog ... ';
$sqlarray = $dbdict->AlterColumnSQL(cms_db_prefix().'adminlog','ip_addr C(40)');
$return = $dbdict->ExecuteSQLArray($sqlarray);
$ado_ret = ($return == 2) ? ilang('done') : ilang('failed');
if( $return == 2 )
  {
    $sqlarray = $dbdict->CreateIndexSQL(cms_db_prefix().'index_adminlog1', cms_db_prefix()."adminlog", 'timestamp');
    $return = $dbdict->ExecuteSQLArray($sqlarray);
  }
echo "[fait]</p>";

echo '<p>Am&eacute;lioration de la table de css ... ';
$sqlarray = $dbdict->AddColumnSQL(cms_db_prefix().'css','media_query X');
$return = $dbdict->ExecuteSQLArray($sqlarray);
echo "[fait]</p>";	 

echo '<p>Cr&eacute;ation de la table routes ... ';//+ jce
$flds = "
 	    term C(255) KEY NOT NULL,
 	    key1 C(50) KEY NOT NULL,
 	    key2 C(50),
 	    key3 C(50),
 	    data X,
 	    created ".CMS_ADODB_DT;
$sqlarray = $dbdict->CreateTableSQL(cms_db_prefix()."routes", $flds, $taboptarray);
$return = $dbdict->ExecuteSQLArray($sqlarray);
$ado_ret = ($return == 2) ? ilang('done') : ilang('failed');
echo '[fait]</p>';

echo '<p>Ajout index_content_by_idhier de la table content... '; 	 
$sqlarray = $dbdict->CreateIndexSQL(cms_db_prefix().'index_content_by_idhier', cms_db_prefix()."content", 'content_id, hierarchy');
$return = $dbdict->ExecuteSQLArray($sqlarray);
$ado_ret = ($return == 2) ? ilang('done') : ilang('failed');
echo '[fait]</p>';

echo '<p>rebuild_static_routes ... ';
cms_route_manager::rebuild_static_routes();
echo '[fait]</p>';

echo '<p>Upgrade au sch&eacute;ma version ... ';
$query = "UPDATE ".cms_db_prefix()."version SET version = 36";
$db->Execute($query);
echo '[fait]</p>';

?>
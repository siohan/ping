<?php
# CMS Made Simple - Fichier de configuration 
# Documentation : /doc/CMSMS_config_reference.pdf
#
$config['dbms'] = 'mysqli';
$config['db_hostname'] = 'localhost';
$config['db_username'] = 'root';
$config['db_password'] = 'root';
$config['db_name'] = 'rc1';
$config['db_prefix'] = 'rc1_';
$config['timezone'] = 'Europe/Paris';
$config['developer_mode'] = true;
if ($_GET['debug'] && $_SESSION['cms_admin_username']) {
  $config['debug'] = true;
} else {
  $config['debug'] = false;
}
?>

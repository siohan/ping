<?php

#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.5.1
# File   : method.uninstall.php
# Purpose: uninstall btAdminer
# License: GPL
#
#-------------------------------------------------------------------------------

$this->RemovePreference();
$this->RemovePermission();

$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

<?php

    /**
     * Proxy module for Amazon Web Services
     */

require_once(__DIR__ . '/lib/autoload.php');

class AWS extends CMSModule
{
    public function GetName()
    {
        return 'AWS';
    }

    public function GetFriendlyName()
    {
        return 'Amazon Web Services';
    }

    public function GetAuthor()
    {
        return 'Jean-Christophe Cuvelier';
    }

    public function GetAuthorEmail()
    {
        return 'jcc@atomseeds.com';
    }

    public function GetVersion()
    {
        return '2.4.12'; // Follow the AWS SDK Versions
    }

    public function Autoload()
    {
        require_once(__DIR__ . '/lib/autoload.php');
    }
}

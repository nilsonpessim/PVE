<?php
// Once again require the autoloader
require_once '../vendor/autoload.php';

// Sample custom credentials class
class CustomCredentials
{
    private $hostname;
    private $username;
    private $password;

    public function __construct($host, $user, $pass)
    {
        $this->hostname = $host;
        $this->username = $user;
        $this->password = $pass;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) return $this->$property;
    }
}

// Create ProxmoxVE instance by passing your custom credentials object
$customCredentials = new CustomCredentials(CONF_PVE_HOST,  CONF_PVE_USER, CONF_PVE_PASS);
$proxmox = new ProxmoxVE\Proxmox($customCredentials);
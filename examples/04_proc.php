<?php

require_once '../vendor/autoload.php';

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
$serverCredentials = new CustomCredentials(CONF_PVE_HOST,  CONF_PVE_USER, CONF_PVE_PASS);

// You can specify format as 2nd argument when creating API client object.
$proxmox = new ProxmoxVE\Proxmox($serverCredentials, 'html');

// Ask for nodes, gives back a PHP string with HTML response
$proxmox->get('/nodes');

// Change response type to JSON
$proxmox->setResponseType('json');

// Now asking for nodes gives back JSON raw string
var_dump(
    $proxmox->get('/nodes')
);

// If you want again return PHP arrays you can use the 'array' format.
$proxmox->setResponseType('array');

// Also you can call getResponseType for whatever reason you have
$responseType = $proxmox->getResponseType();  // array
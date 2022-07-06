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

$proxmox = new ProxmoxVE\Proxmox($serverCredentials, 'png');

// Because querying '/nodes' does not return PNG this will give you errrors.
$proxmox->get('/nodes');

// Asking for a PNG resource will give you back binary data.
$binaryPNG = $proxmox->get('/nodes/mynode/rrd', ['ds' => 'cpu', 'timeframe' => 'day']);

// You can do this with the returned data
if ($resource = imagecreatefromstring($binaryPNG)) {
    // We can save the image, or render to the browser, whatever you like
    imagepng($resource, 'sample.png');
    imagedestroy($resource);
}

// It is common to fetch images and then use base64 to display the image easily in a webpage
$proxmox->setResponseType('pngb64');  // Sample format: data:image/png;base64,iVBORw0KGgoAAAA...
$base64 = $proxmox->get('/nodes/mynode/rrd', ['ds' => 'cpu', 'timeframe' => 'day']);

// So we can do something like this
echo "<img src='{$base64}' \>";

// 'array' it is used as default response type when unrecognized or no format is specified.
$proxmox->setResponseType();  // sets response type to 'array'
$proxmox->setResponseType('McDonalds');  // Also sets response type to 'array'

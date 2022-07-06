<?php
// Once again require the autoloader
require_once '../vendor/autoload.php';

// Sample custom credentials class
class CustomCredentials
{
    public function __construct($host, $user, $pass)
    {
        $this->hostname = $host;
        $this->username = $user;
        $this->password = $pass;
    }
}

// Create ProxmoxVE instance by passing your custom credentials object
$credentials = new CustomCredentials(CONF_PVE_HOST,  CONF_PVE_USER, CONF_PVE_PASS);
$proxmox = new ProxmoxVE\Proxmox($credentials);

// Then you can use it, for example create a new user.

// Create User
$params = [
    'userid' => 'nilson@pve',
    'comment' => 'Nilson de Andrade Pessim',
    'password' => '1234567890!@#$%',
];

// Send request passing params
$result = $proxmox->create('/access/users', $params);

// If an error occurred the 'errors' key will exist in the response array
if (isset($result['errors'])) {
    error_log('Unable to create new proxmox user.');
    foreach ($result['errors'] as $title => $description) {
        error_log($title . ': ' . $description);
    }
} else {
    echo 'Successful user creation!';
}
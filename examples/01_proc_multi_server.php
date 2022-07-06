<?php

require_once '../vendor/autoload.php';

$serverA = ['hostname' => CONF_PVE_HOST, 'username' => CONF_PVE_USER, 'password' => CONF_PVE_PASS];
$proxmox = new ProxmoxVE\Proxmox($serverA);  // API object created only once

// Get nodes on server A
$proxmox->get('/nodes');

$serverB = ['hostname' => CONF_PVE_HOST, 'username' => CONF_PVE_USER, 'password' => CONF_PVE_PASS];
$proxmox->setCredentials($serverB);

// After that every communication is sent to the new server

$proxmox->get('/nodes');  // Get nodes on server B

// Also you can call getCredentials for whatever reason
$credentialsB = $proxmox->getCredentials();

echo 'Hostname: ' . $credentialsB->getHostname();  // Hostname: hostB
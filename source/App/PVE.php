<?php
/**
 * API DOCUMENTATION
 * https://pve.proxmox.com/pve-docs/api-viewer/
 */

namespace Source\App;
use ProxmoxVE\Proxmox;

class PVE
{
    private $proxmox;
    private $credentials;

    public function __construct()
    {
        $this->credentials = credentials();
        self::proxmox($this->credentials);
    }

    public function proxmox($credentials): Proxmox
    {
        $this->proxmox = new Proxmox($credentials);
        return $this->proxmox;
    }

    public function get($action = CONF_DEFAULT_METHODS_GET)
    {
        return $this->proxmox->get($action);
    }
}
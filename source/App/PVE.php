<?php
/**
 * API DOCUMENTATION
 * https://pve.proxmox.com/pve-docs/api-viewer/
 * https://github.com/zzantares/ProxmoxVE/wiki
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

    public function proxmox(array $credentials): Proxmox
    {
        $this->proxmox = new Proxmox($credentials, 'json');
        return $this->proxmox;
    }

    public function get(string $action = CONF_DEFAULT_METHODS_GET)
    {
        return $this->proxmox->get($action);
    }
}
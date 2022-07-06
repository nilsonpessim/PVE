<?php

function credentials()
{
    $credentials = [
        'hostname' => CONF_PVE_HOST,
        'username' => CONF_PVE_USER,
        'password' => CONF_PVE_PASS,
        'realm'    => CONF_PVE_REALM,
        'port'     => CONF_PVE_PORT
    ];

    return $credentials;
}
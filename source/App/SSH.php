<?php

namespace Source\App;

/**
 * CLASSE PARA CONEXÃO SSH
 * Nilson Pessim
 * 06/07/2022
 */

class SSH
{

    /** * @var $connection */
    private $connection;

    /**
     * @param $host
     * @param $port
     * @return bool
     */
    public function connect($host = CONF_SSH_HOST, $port = CONF_SSH_PORT)
    {
        $this->connection = ssh2_connect($host, $port);
        return $this->connection ? true : false;
    }

    /**
     * @param $user
     * @param $pass
     * @return bool
     */
    public function authPassword($user = CONF_SSH_USER, $pass = CONF_SSH_PASS)
    {
        return $this->connection ? ssh2_auth_password($this->connection,$user,$pass) : false;
    }

    /**
     * @return bool
     */
    public function disconnect()
    {
        if($this->connection) ssh2_disconnect($this->connection);
        $this->connection = null;
        return true;
    }

    /**
     * @param $stream
     * @param $id
     * @return false|string
     */
    private function getOutput($stream, $id)
    {
        $streamOut = ssh2_fetch_stream($stream,$id);
        return stream_get_contents($streamOut);
    }

    /**
     * @param $command
     * @param $stdErr
     * @return false|string|null
     */
    public function exec($command, &$stdErr = null)
    {
        if(!$this->connection) return null;

        if (!$stream = ssh2_exec($this->connection,$command)) {
            return null;
        }

        stream_set_blocking($stream,true);

        $stdIo  = $this->getOutput($stream,SSH2_STREAM_STDIO);
        $stdErr = $this->getOutput($stream,SSH2_STREAM_STDERR);

        stream_set_blocking($stream,false);

        return $stdIo;
    }
}

?>
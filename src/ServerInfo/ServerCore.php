<?php
namespace ServerInfo;

use SshWrapper\SshCore;


class ServerCore
{
    private $ssh;
    
    function __construct(SshCore $ssh)
    {
        $this->ssh = $ssh;
    }
}
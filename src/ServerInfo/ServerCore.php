<?php
namespace ServerInfo;

use SshWrapper\SshCore;
use ServerInfo\Helpers;

class ServerCore
{
    private $ssh;
    private $helper;
    
    function __construct(SshCore $ssh)
    {
        $this->ssh = $ssh;
        $this->format = new Helpers\Format();
    }
    
    /**
     * @return string
     */
    public function getPHPVersion() {
        $data = $this->ssh->exec("ls -lah /etc/init.d/ | grep 'php' |  awk '{print $9}'");
        return $this->format->stripEOL($data);
    }
    
    public function getVhosts() {
        $data = $this->ssh->exec("apache2ctl -S");
        
        return $this->format->readVhost($data);
        
    }
    
}
<?php
namespace ServerInfo;

use SshWrapper\SshCore;
use ServerInfo\Helpers;
use ServerInfo\Library;

class ServerCore
{
    private $ssh;
    private $format;
    
    /**
     * ServerCore constructor.
     *
     * @param \SshWrapper\SshCore $ssh
     */
    function __construct(SshCore $ssh)
    {
        $this->ssh    = $ssh;
        $this->format = new Helpers\Format();
        $this->apache = new Library\Apache();
    }
    
    /**
     * Retrieves the hostname of the server
     *
     * @return string
     */
    public function getHostname()
    {
        $data = $this->ssh->exec("cat /etc/hostname");
        
        return $this->format->stripEOL($data);
    }
    
    /**
     * Retrieves the exact name of the PHP service (since this can be php7, php7.0-fpm etc)
     *
     * @return string
     */
    public function getPHPServiceName()
    {
        $data = $this->ssh->exec("ls -lah /etc/init.d/ | grep 'php' |  awk '{print $9}'");
        
        return $this->format->stripEOL($data);
    }
    
    /**
     * Reads the vhosts information and returns the domains and aliases
     *
     * @return array
     */
    public function getVhosts()
    {
        $data = $this->ssh->exec("apache2ctl -S");
        
        return $this->apache->readApacheVhosts($data);
    }
}
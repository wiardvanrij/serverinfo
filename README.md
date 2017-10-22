# Server information via PHP

## Information

This libary uses the "ssh wrapper" : https://github.com/wiardvanrij/sshwrapper as requirement

It provides out of the box functions to retrieve server information. Mostly used for webbased servers on a Linux operating system

## Requirements

Please read the sshwrapper library, you will need ssh2 php module.

## Installation

Via composer

    {
        "require": {
            "wiardvanrij/serverinfo": "^0"
        }
    }

or

    composer require wiardvanrij/serverinfo
    
## Usage
    
again please read the sshwrapper for those features
     
Require the autoloader and include the namespaces
     
    <?php
    require_once('vendor/autoload.php');
    
    use SshWrapper\SshCore;
    use ServerInfo\ServerCore;
  
Initiate the class with the host and make a connection
    
    
    $ssh = new SshCore('123.123.123.123');
    $ssh->connect();
    
Initiate the serverinfo class and pass the connection
    
    $server = new ServerCore($ssh);

Use the functions you desire

Returns the hostname of the server as string

    $hostname = $server->getHostname();
    
Returns the exact PHP version/service on the server. For instance php7.0 or php7.0-fpm etc.
    
    $php      = $server->getPHPServiceName();
    
Returns an array of the vhosts including domains, vhost location and aliases sorted by port 80 & 443
    
    $data     = $server->getVhosts();     

Example output:

    Array
    (
        [http] => Array
            (
                [1] => Array
                    (
                        [domain] => foo.com
                        [config] => /etc/apache2/sites-enabled/ssl-foo.com.conf
                    )
                [2] => Array
                    (
                        [domain] => bar.com
                        [config] => /etc/apache2/sites-enabled/ssl-bar.com.conf
                        [aliases] => Array
                            (
                                [0] => foobar.eu
                                [1] => www.barfoo.eu
                            )
    
                    )
            )
        [https] => Array
            (
                [1] => Array
                    (
                        [domain] => foo.com
                        [config] => /etc/apache2/sites-enabled/foo.com.conf
                    )
                [2] => Array
                    (
                        [domain] => bar.com
                        [config] => /etc/apache2/sites-enabled/bar.com.conf
                        [aliases] => Array
                            (
                                [0] => foobar.eu
                                [1] => www.barfoo.eu
                            )
      
                    )
             )
    )                                      
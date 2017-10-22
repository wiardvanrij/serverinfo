<?php

namespace ServerInfo\Library;

use ServerInfo\Helpers;

Class Apache
{
    
    private $format;
    
    /**
     * Apache constructor.
     *
     */
    function __construct()
    {
        $this->format = new Helpers\Format();
    }
    
    /**
     * It reads the vhosts information from string and parses the lines.
     * Each line might consist of useful information, ea; is it port 80 or 443.
     * While parsing the lines we keep an index on both ports so we can store the actual data (domain & aliasses)
     *
     * @param $string
     *
     * @return array
     */
    public function readVhost($string)
    {
        $lines = explode(PHP_EOL, $string);
        
        $data         = [];
        $http         = 0;
        $https        = 0;
        $currentIndex = 0;
        $key          = 'undefined';
        
        foreach ($lines as $line) {
            $line = $this->format->trimLeadingSpaces($line);
            
            $lineValues = explode(' ', $line);
            
            if ($lineValues[0] == 'port') {
                if ($lineValues[1] == '80') {
                    $key = 'http';
                    $http++;
                    $currentIndex = $http;
                } elseif ($lineValues[1] == '443') {
                    $key = 'https';
                    $https++;
                    $currentIndex = $https;
                } else {
                    // It should be port 80 or 443, otherwise there is something funky and we ignore the data
                    continue;
                }
                
                $data[$key][$currentIndex]['domain'] = $lineValues[3];
                $data[$key][$currentIndex]['config'] = $this->format->removeGrepData($lineValues[4]);
            } elseif ($lineValues[0] == 'alias') {
                $data[$key][$currentIndex]['aliases'][] = $lineValues[1];
            } else {
                // Ignore this data for now. Can be extended later on.
            }
        }
        
        return $data;
    }
}
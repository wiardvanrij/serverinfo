<?php

namespace ServerInfo\Helpers;

Class Format
{
    
    public function stripEOL($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }
    
    public function readVhost($string)
    {
        $lines = explode(PHP_EOL, $string);
        
        $http         = 0;
        $https        = 0;
        $currentIndex = 0;
        $key          = 'undefined';
        
        foreach ($lines as $line) {
            $line = $this->trimLeadingSpaces($line);
            
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
                    continue;
                }
                
                $data[$key][$currentIndex]['domain'] = $lineValues[3];
                $data[$key][$currentIndex]['config'] = $this->removeGrepData($lineValues[4]);
            }
            
            if ($lineValues[0] == 'alias') {
                $data[$key][$currentIndex]['aliases'][] = $lineValues[1];
            }
        }
        
        return $data;
    }
    
    
    public function removeGrepData($string)
    {
        $data = explode(':', $string);
        
        return ltrim($data[0], '(');
    }
    
    public function trimLeadingSpaces($string)
    {
        return trim($string, " \t.");
    }
}
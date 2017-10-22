<?php

namespace ServerInfo\Helpers;

Class Format
{
    /**
     * Removes data from the linux grep command that is not wanted. Ea; the "(" at start and the ":x" linenumber
     *
     * @param $string
     *
     * @return string
     */
    public function removeGrepData($string)
    {
        $data = explode(':', $string);
        
        return ltrim($data[0], '(');
    }
    
    /**
     * Removes all leading spaces in a given string.
     *
     * @param $string
     *
     * @return string
     */
    public function trimLeadingSpaces($string)
    {
        return trim($string, " \t.");
    }
    
    /**
     * Removes new lines in a given string.
     *
     * @param $string
     *
     * @return string
     */
    public function stripEOL($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}
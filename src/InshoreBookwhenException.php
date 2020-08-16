<?php

declare(strict_types=1);

namespace InShore\BookWhen;

/**
 * InshoreBookwhenException Class
 * 
 * @package inshore-packages\bookwhen
 * @todo comments
 * @todo externalise config
 * @todo fix token
 */
class InshoreBookwhenException extends InshoreBookwhenException
{
    /**
     * 
     * @return string
     * @todo
     */
    public function errorMessage() {
        //error message
        $errorMessage = 'Error on line '.$this->getLine().' in '.$this->getFile()
        .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
        return $errorMessage;
    }
}

//EOF!

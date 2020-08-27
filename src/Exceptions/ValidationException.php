<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Exceptions;

use InShore\Bookwhen\Exceptions\InshoreBookwhenException;

/**
 * InshoreBookwhenConfigurationException Class
 * 
 * @package inshore\Bookwhen
 */
class ValidationException extends InshoreBookwhenException
{
    private $key;
    
    private $value;
    
    /**
     * 
     * @param unknown $key
     * @param unknown $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
    
    /**
     * 
     * @return string
     */
    public function errorMessage()
    {
        return 'Validation Error!<br/>The value "' . $this->value . '" is invalid for ' . $this->key . '.<br/>Please refer to the package documentation <a href=https://github.com/inshore/bookwhen>https://github.com/inshore/bookwhen</a> or <a href=https://api.bookwhen.com/v2>https://api.bookwhen.com/v2</a>';
    }
}

//EOF!

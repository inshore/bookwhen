<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Interfaces;

interface ValidatorInterface
{
    
    /**
     *
     */
    public function __construct();
        
    /**
     * @param string $date
     */
    public function validDate($date);

    /**
     * @param string $fileName
     */
    public function validFileName($fileName);

    /**
     * @param string $fileType
     */
    public function validFileType($fileType);
    
    /**
     * @param string $from
     * @param string $to
     */
    public function validFrom($from, $to);
    
    /**
     * @param string $id
     * @param string $type
     */
    public function validId($id, $type);
    
    /**
     * @param string $tag
     */
    public function validTag($tag);

    /**
     * @param string $title
     */
    public function validTitle($title);
    
    /**
     * @param string $to
     * @param string|null $from
     */
    public function validTo($to, $from);
    
    /**
     * @param string $token
     */
    public function validToken($token);

}


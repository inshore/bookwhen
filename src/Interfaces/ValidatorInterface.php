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
     * @return bool
     */
    public function validDate($date);

    /**
     * @param string $fileName
     * @return bool
     */
    public function validFileName($fileName);

    /**
     * @param string $fileType
     * @return bool
     */
    public function validFileType($fileType);
    
    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function validFrom($from, $to);
    
    /**
     * @param string $id
     * @param string $type
     * @return bool
     */
    public function validId($id, $type);

    /**
     * @param string $include
     * @return bool
     */
    public function validInclude($include);
    
    /**
     * @param string $tag
     */
    public function validTag($tag);

    /**
     * @param string $title
     * @return bool
     */
    public function validTitle($title);
    
    /**
     * @param string $to
     * @param string|null $from
     * @return bool
     */
    public function validTo($to, $from);
    
    /**
     * @param string $token
     * @return bool
     */
    public function validToken($token);

}


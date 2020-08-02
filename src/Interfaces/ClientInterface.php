<?php 

namespace InShore\BookWhen;


interface ClientInterface
{

    /**
     * 
     * @param string $token
     */
    public function __construct($token);
    
    /**
     * ?? return Events Object
     */
    public function getAttachment($attachmentId);
    
    /**
     * ?? return Events Object
     */
    public function getAttachments();
    
    /**
     * ?? return Events Object
     */
    public function getClassPass($eventId);
    
    /**
     * ?? return Events Object
     */
    public function getClassPasses();
    
    /**
     * ?? return Events Object
     */
    public function getEvent($eventId);
    
    /**
     * ?? return Events Object
     */
    public function getEvents();
    
    /**
     * ?? return Events Object
     */
    public function getLocation($locationId);
    
    /**
     * ?? return Events Object
     */
    public function getLocations();
    
    /**
     * ?? return Events Object
     */
    public function getTicket($locationId);
    
    /**
     * ?? return Events Object
     */
    public function getTickets();

}

// EOF!

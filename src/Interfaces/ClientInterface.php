<?php 

namespace InShore\BookWhen\Interfaces;


interface ClientInterface
{

    /**
     * @param string $token.
     */
    public function __construct($token);
    
    /**
     * @return attachment object.
     */
    public function getAttachment($attachmentId);
    
    /**
     * @return attachments objects array.
     */
    public function getAttachments();
    
    /**
     * @return class pass object.
     */
    public function getClassPass($eventId);
    
    /**
     * @return class passes object array.
     */
    public function getClassPasses();
    
    /**
     * @return event object.
     */
    public function getEvent($eventId);
    
    /**
     * API wrapper to getEvents.
     *
     * @param array $tags
     * @param string $from
     * @param string $to
     * @param bool $includeLocation
     * @param bool $includeTickets
     * 
     * @return events object array.
     */
    public function getEvents($tags, $from, $to, $includeLocation, $includeTickets);
    
    /**
     * @return location object.
     */
    public function getLocation($locationId);
    
    /**
     * @return locations objects array.
     */
    public function getLocations();
    
    /**
     * @return ticket object.
     */
    public function getTicket($ticketId);
    
    /**
     * @return tickets object array.
     */
    public function getTickets($eventId);

}

// EOF!

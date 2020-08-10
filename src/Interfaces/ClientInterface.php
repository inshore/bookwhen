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
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @copyright inShore Ltd (Jersey)
     * 
     * @param unknown calendar
     * @param unknown entry
     * @param array location Array of location slugs to include.
     * @param array $tags Array of tags to include.
     * @param array $title Array of titles to search for.
     * @param array $detail Array of details to search for.
     * @param string $from Inclusive time to fetch events from in format YYYYMMDD or YYYYMMDDHHMISS.
     * @param string $to Non-inclusive time to fetch events until in format YYYYMMDD or YYYYMMDDHHMISS.
     * @param bool $includeLocation
     * @param bool $includeAttachments 
     * @param bool $includeTickets
     * @param bool $includeTicketsEvents
     * @param bool $includeTicketsClassPasses
     * 
     * @return events object array.
     */
    public function getEvents($calendar, $entry, $location, $tags, $title, $detail, $from, $to, $includeLocation, $includeAttachments, $includeTickets, $includeTicketsEvents, $includeTicketsClassPasses);
    
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

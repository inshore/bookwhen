<?php 

namespace InShore\Bookwhen\Interfaces;


use InShore\Bookwhen\Exceptions\RestException;

interface ClientInterface
{

    /**
     * @param string $token.
     */
    public function __construct($token);
    
    /**
     * API wrapper to getAttachment.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $attachmentId ID of attachment to retrieve.
     * 
     * @return object attachment.
     * 
     * @throws ValidationException if any supplied parameter is invalid.
     * @throws RestException if an error occurs during API interation.
     */
    public function getAttachment($attachmentId);
    
    /** 
     * API wrapper to getAttachments
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $title Filter on the file title text.
     * @param string $fileName Filter on the file name.
     * @param string $fileType Filter on the file type.
     * 
     * @return array of attachment objects.
     * 
     * @throws ValidationException if any supplied parameter is invalid.
     * @throws RestException if an error occurs during API interation.
     */
    public function getAttachments($title, $fileName, $fileType);
    
    /**
     * API wrapper to getClassPass.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $classPassId required ID of class pass to retrieve.
     * 
     * @return object class pass.
     * 
     * @throws ValidationException if any supplied parameter is invalid.
     * @throws RestException if an error occurs during API interation.
     */
    public function getClassPass($classPassId);
    
    /**
     * API wrapper to getClassPasses.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $title Filter on the title text of the pass.
     * @param string $detail Filter on the details text.
     * @param string $usageType Filter on the type of the pass: personal or any.
     * @param string $cost Filter on the cost with an exact value or use a comparison operator. e.g. filter[cost][gte]=2000
     * @param string $usagAallowance Filter on pass usage allowance. This also accepts a comparison operator like cost.
     * @param string $useRestrictedForDays Filter on pass days restriction. This also accepts a comparison operator like cost.
     * 
     * @return array of class passes objects.
     */
    public function getClassPasses($title, $detail, $usageType, $cost, $usageAllowance, $useRestrictedForDays);

    /** 
     * API wrapper to getEvent.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $eventId ID of account to retrieve.
     *
     * @return object of the event.
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
     * API wrapper to locationId.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string ID of location to retrieve
     * 
     * @return location object.
     */
    public function getLocation($locationId);
    
    /**
     * API wrapper to getLocations.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $addressText Restrict to locations containing the address text filter.
     * @param string $additionalInfo Filter by the text contained in the additional info.
     * 
     * @return locations objects array.
     */
    public function getLocations($addressText, $additionalInfo);
    
    /**
     * API wrapper to getTicket.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $ticketId ID of ticket to retrieve.
     * 
     * @return ticket object.
     */
    public function getTicket($ticketId);
    
    /**
     * API wrapper to getTickets.
     * 
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     * 
     * @access public 
     * 
     * @param string $eventId The ID of the event to list tickets for.
     * 
     * @return tickets object array.
     */
    public function getTickets($eventId);

}

// EOF!

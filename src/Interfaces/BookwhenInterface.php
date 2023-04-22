<?php

namespace InShore\Bookwhen\Interfaces;

use InShore\Bookwhen\Domain\Attachment;
use InShore\Bookwhen\Domain\ClassPass;
use InShore\Bookwhen\Domain\Event;
use InShore\Bookwhen\Domain\Location;
use InShore\Bookwhen\Domain\Ticket;
use InShore\Bookwhen\Exceptions\RestException;

interface BookwhenInterface
{
    /**
     * @param string $token.
     * @param string $debug.
     */
    //public function __construct(string $token, string $logFile, string $logLevel);

    /**
     * API wrapper to get an Attachment.
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
    public function attachment(string $attachmentId): Attachment;

    /**
     * API wrapper to get a list of Attachments
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
    public function attachments(
        null | string $title,
        null | string $fileName,
        null | string $fileType
    ): array;

    /**
     * API wrapper to get a ClassPass.
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
    public function classPass(string $classPassId): ClassPass;

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
    public function classPasses(
        null | string $title,
        null | string $detail,
        null | string $usageType,
        null | string $cost,
        null | string $usageAllowance,
        null | string $useRestrictedForDays
    );

    /**
     * API wrapper to get an Event.
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
     public function event(string $eventId): Event;

    /**
     * API wrapper to get a list of Events.
     *
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @copyright inShore Ltd (Jersey)
     *
     * @param string $calendar
     * @param string $entry
     * @param array $location Array of location slugs to include.
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
     * @return array of events objects.
     */
    public function events(
        string $calendar,
        string $entry,
        array $location,
        array $tags,
        array $title,
        array $detail,
        string $from,
        string $to,
        bool $includeLocation,
        bool $includeAttachments,
        bool $includeTickets,
        bool $includeTicketsEvents,
        bool $includeTicketsClassPasses
    ): array;

    /**
     * API wrapper to get a location.
     *
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $locationId of location to retrieve
     *
     * @return object location.
     */
    public function location(string $locationId): Location;

    /**
     * API wrapper to get a list of locations.
     *
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $addressText Restrict to locations containing the address text filter.
     * @param string $additionalInfo Filter by the text contained in the additional info.
     *
     * @return array of location objects.
     */
    public function locations(
        string $addressText,
        string $additionalInfo
    ): array;

    /**
     * API wrapper to get a Ticket.
     *
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $ticketId ID of ticket to retrieve.
     *
     * @return object ticket.
     */
     public function ticket(string $ticketId): Ticket;

    /**
     * API wrapper to get Tickets.
     *
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $eventId The ID of the event to list tickets for.
     *
     * @return array of ticket objects.
     */
    public function tickets(string $eventId): array;

}

// EOF!

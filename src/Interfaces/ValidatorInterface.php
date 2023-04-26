<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Interfaces;

interface ValidatorInterface
{
    /**
     * @param string $attachmentId
     * @return bool
     */
    public function validAdditionalInfo(string $additionalInfo): bool;

    /**
     * @param string $addressText
     * @return bool
     */
    public function validAddressText(string $addressText): bool;

    /**
     * @param string $attachmentId
     * @return bool
     */
    public function validAttachmentId(string $attachmentId): bool;

    /**
     * @param string $classPassId
     * @return bool
     */
    public function validClassPassId(string $classPassId): bool;

    /**
     * @param string $date
     * @return bool
     */
    public function validDate(string $date): bool;

    /**
     * @param string $details
     * @return bool
     */
    public function validDetails(string $details): bool;

    /**
     * @param string $eventId
     * @return bool
     */
    public function validEventId(string $eventId): bool;

    /**
     * @param string $fileName
     * @return bool
     */
    public function validFileName(string $fileName): bool;

    /**
     * @param string $fileType
     * @return bool
     */
    public function validFileType(string $fileType): bool;

    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function validFrom(string $from, string $to): bool;

    /**
     * @param string $id
     * @param string $type
     * @return bool
     */
    public function validId(string $id, string $type): bool;

    /**
     * @param string $include
     * @return bool
     */
    public function validInclude(bool $include): bool;

    /**
     * @param string $location
     * @return bool
     */
    public function validLocation(string $location): bool;

    /**
     * @param string $locationId
     * @return bool
     */
    public function validLocationId(string $locationId): bool;

    /**
     * @param string $tag
     * @return bool
     */
    public function validTag(string $tag): bool;

    /**
     * @param string $ticketId
     * @return bool
     */
    public function validTicketId(string $ticketId): bool;

    /**
     * @param string $title
     * @return bool
     */
    public function validTitle(string $title): bool;

    /**
     * @param string $to
     * @param string|null $from
     * @return bool
     */
    public function validTo(string $to, string $from): bool;

    /**
     * @param string $token
     * @return bool
     */
    public function validToken(string $token): bool;

    /**
     * @param int $usageAllowance
     * @return bool
     */
    public function validusageAllowance(int $usageAllowance): bool;

    /**
     * @param string $usageType
     * @return bool
     */
    public function validusageType(string $usageType): bool;

        /**
     * @param int $useRestrictedForDays
     * @return bool
     */
    public function validUseRestrictedForDays(int $useRestrictedForDays): bool;

}

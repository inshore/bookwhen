<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use InShore\Bookwhen\Interfaces\ValidatorInterface;
use Respect\Validation\Validator as v;

class Validator implements ValidatorInterface
{
    /**
     *
     * @author Daniel Mullin daniel@inshore.je
     *
     * @access public
     *
     * @param string $additionalInfo
     * @return bool
     */
    public function validAdditionalInfo(string $additionalInfo): bool
    {
        return v::stringType()->notEmpty()->alnum()->validate($additionalInfo);
    }

    /**
     *
     * @author Daniel Mullin daniel@inshore.je
     *
     * @access public
     *
     * @param string $addressText
     * @return bool
     */
    public function validAddressText(string $addressText): bool
    {
        return v::stringType()->notEmpty()->alnum()->validate($addressText);
    }

    /**
     *
     * @author Daniel Mullin daniel@inshore.je
     *
     * @access public
     *
     * @param string $attachmentId
     * @return bool
     */
    public function validAttachmentId(string $attachmentId): bool
    {
        return v::stringType()->notEmpty()->alnum()->length(12, 12)->validate($attachmentId);
    }

    /**
     *
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $classPassId
     * @return bool
     */
    public function validClassPassId(string $classPassId): bool
    {
        $exploded = explode('-', $classPassId);

        if (count($exploded) !== 2) {
            return false;
        }

        if ($exploded[0] !== 'cp') {
            return false;
        }

        return v::stringType()->notEmpty()->alnum()->length(12, 12)->validate($exploded[1]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validDate()
     */
    public function validDate(string $date): bool
    {
        if (v::stringType()->notEmpty()->numericVal()->length(8, 8)->date('Ymd')->validate($date)) {
            return true;
        } else {
            return v::stringType()->notEmpty()->numericVal()->length(14, 14)->dateTime('YmdHis')->validate($date);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validDetails()
     */
    public function validDetails($details): bool
    {
        return v::stringType()->notEmpty()->validate($details);
    }

    /**
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $eventId
     * @return bool
     */
    public function validEventId(string $eventId): bool
    {
        $exploded = explode('-', $eventId);

        if (count($exploded) !== 3) {
            return false;
        }

        if ($exploded[0] !== 'ev') {
            return false;
        }

        // Syntax.
        if (!v::stringType()->notEmpty()->alnum()->length(4, 4)->validate($exploded[1])) {
            return false;
        }

        return $this->validDate($exploded[2]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validFileName()
     */
    public function validFileName($fileName): bool
    {
        return v::stringType()->notEmpty()->validate($fileName);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validFileType()
     */
    public function validFileType(string $fileType): bool
    {
        return v::stringType()->notEmpty()->in(['jpg', 'jpeg', 'gif', 'png'])->validate(strtolower($fileType));
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validFrom()
     */
    public function validFrom(string $from, string $to = null): bool
    {
        if (!$this->validDate($from)) {
            return false;
        }

        $fromDate = new \DateTime($from);

        if (empty($to)) {
            return true;
        }

        if (!$this->validDate($to)) {
            return false;
        }

        $toDate = new \DateTime($to);

        // Compare if actual to date is greater than from.
        if ($fromDate > $toDate) {
            return false;
        }

        return true;
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validId()
     * @todo
     */
    public function validId(string $id, null | string $type = null): bool
    {
        if (!v::stringType()->notEmpty()->validate($id)) {
            return false;
        }

        switch ($type) {
            case 'classPass':
                return $this->validClassPassId($id);
            case 'event':
                return $this->validEventId($id);
            case 'ticket':
                return $this->validTicketId($id);
            case 'attachment':
                return $this->validAttachmentId($id);
            case 'location':
                return $this->validLocationId($id);
            default:
                return v::alnum()->length(12, 12)->validate($id);
        }
    }

    /**
     *
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validInclude()
     */
    public function validInclude(bool $include): bool
    {
        return v::boolType()->validate($include);
    }

    /**
     *
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validLocation()
     */
    public function validLocation(string $location): bool
    {
        return v::stringType()->notEmpty()->validate($location);
    }

    /**
     *
     * @author Daniel Mullin daniel@inshore.je
     *
     * @access public
     *
     * @param string $locationId
     * @return bool
     */
    public function validLocationId(string $locationId): bool
    {
        return v::stringType()->notEmpty()->alnum()->length(12, 12)->validate($locationId);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validTag()
     */
    public function validTag(string $tag): bool
    {
        return v::stringType()->notEmpty()->alnum()->validate($tag);
    }

    /**
     * @author Daniel Mullin daniel@inshore.je
     * @author Brandon Lubbehusen brandon@inshore.je
     *
     * @access public
     *
     * @param string $ticketId
     * @return bool
     */
    public function validTicketId(string $ticketId): bool
    {

        $exploded = explode('-', $ticketId);

        if (count($exploded) !== 4) {
            return false;
        }

        if ($exploded[0] !== 'ti') {
            return false;
        }

        // Syntax.
        if (!v::stringType()->notEmpty()->alnum()->length(4, 4)->validate($exploded[1])) {
            return false;
        }

        if (!$this->validDate($exploded[2])) {
            return false;
        }

        return v::stringType()->notEmpty()->alnum()->length(4, 4)->validate($exploded[3]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validTitle()
     */
    public function validTitle(string $title): bool
    {
        return v::stringType()->notEmpty()->validate($title);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validTo()
     */
    public function validTo(string $to, null | string $from = null): bool
    {
        if (!$this->validDate($to)) {
            return false;
        }

        $toDate = new \DateTime($to);

        if (empty($from)) {
            return true;
        }

        $fromDate = new \DateTime($from);

        if (!$this->validFrom($from)) {
            return false;
        }
        if ($toDate < $fromDate) {
            return false;
        }

        return true;
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ValidatorInterface::validToken()
     */
    public function validToken(string $token): bool
    {
        return v::alnum()->validate($token);
    }
}

// EOF!

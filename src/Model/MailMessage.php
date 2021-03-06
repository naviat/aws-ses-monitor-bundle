<?php

/*
 * This file is part of the SHQAwsSesBundle.
 *
 * Copyright Adamo Aerendir Crespi 2015 - 2017.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2015 - 2017 Aerendir. All rights reserved.
 * @license   MIT License.
 */

namespace SerendipityHQ\Bundle\AwsSesMonitorBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * A MailMessage Entity.
 *
 * This is called MailObject by Amazon.
 *
 * @see http://docs.aws.amazon.com/ses/latest/DeveloperGuide/notification-contents.html#mail-object
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class MailMessage
{
    /**
     * @var int
     */
    private $id;

    /**
     * A unique ID that Amazon SES assigned to the message.
     *
     * Amazon SES returned this value to you when you sent the message.
     * This message ID was assigned by Amazon SES. You can find the message ID of the original
     * email in the headers and commonHeaders fields of the mail object.
     *
     * @var string
     */
    private $messageId;

    /**
     * The time at which the original message was sent (in ISO8601 format).
     *
     * Formerly "timestamp".
     *
     * @var \DateTime
     */
    private $sentOn;

    /**
     * The email address from which the original message was sent (the envelope MAIL FROM address).
     *
     * Formerly "source".
     *
     * @var string
     */
    private $sentFrom;

    /**
     * The Amazon Resource Name (ARN) of the identity that was used to send the email.
     *
     * In the case of sending authorization, the sourceArn is the ARN of the identity that the identity owner authorized
     * the delegate sender to use to send the email. For more information about sending authorization, see Using Sending
     * Authorization.
     *
     * @var string
     */
    private $sourceArn;

    /**
     * The AWS account ID of the account that was used to send the email.
     *
     * In the case of sending authorization, the sendingAccountId is the delegate sender's account ID.
     *
     * @var string
     */
    private $sendingAccountId;

    /**
     * A list of the email's original headers. Each header in the list has a name field and a value field.
     *
     * Any message ID within the headers field is from the original message that you passed to Amazon SES. The message
     * ID that Amazon SES subsequently assigned to the message is in the messageId field of the mail object.
     *
     * (Only present if the notification settings include the original email headers.)
     *
     * @var string
     */
    private $headers;

    /**
     * A list of the email's original, commonly used headers.
     *
     * Each header in the list has a name field and a value field.
     * Any message ID within the commonHeaders field is from the original message that you passed to Amazon SES. The
     * message ID that Amazon SES subsequently assigned to the message is in the messageId field of the mail object.
     *
     * (Only present if the notification settings include the original email headers.)
     *
     * @var string
     */
    private $commonHeaders;

    /** @var ArrayCollection */
    private $bounces;

    /** @var ArrayCollection */
    private $complaints;

    /** @var ArrayCollection */
    private $deliveries;

    /**
     * MailMessage constructor.
     */
    public function __construct()
    {
        $this->bounces      = new ArrayCollection();
        $this->complaints   = new ArrayCollection();
        $this->deliveries   = new ArrayCollection();
    }

    /**
     * @param Bounce $bounce
     *
     * @return $this
     */
    public function addBounce(Bounce $bounce)
    {
        $this->bounces->add($bounce);

        if ($bounce->getMailMessage() !== $this) {
            $bounce->setMailMessage($this);
        }

        return $this;
    }

    /**
     * @param Complaint $complaint
     *
     * @return $this
     */
    public function addComplaint(Complaint $complaint)
    {
        $this->complaints->add($complaint);

        if ($complaint->getMailMessage() !== $this) {
            $complaint->setMailMessage($this);
        }

        return $this;
    }

    /**
     * @param Delivery $delivery
     *
     * @return $this
     */
    public function addDelivery(Delivery $delivery)
    {
        $this->deliveries->add($delivery);

        if ($delivery->getMailMessage() !== $this) {
            $delivery->setMailMessage($this);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBounces()
    {
        return $this->bounces;
    }

    /**
     * @return ArrayCollection
     */
    public function getComplaints()
    {
        return $this->complaints;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeliveries()
    {
        return $this->deliveries;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @return \DateTime
     */
    public function getSentOn()
    {
        return $this->sentOn;
    }

    /**
     * @return string
     */
    public function getSentFrom()
    {
        return $this->sentFrom;
    }

    /**
     * @return string
     */
    public function getSourceArn()
    {
        return $this->sourceArn;
    }

    /**
     * @return string
     */
    public function getSendingAccountId()
    {
        return $this->sendingAccountId;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getCommonHeaders()
    {
        return $this->commonHeaders;
    }

    /**
     * @param string $messageId
     *
     * @return $this
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @param \DateTime $sentOn
     *
     * @return $this
     */
    public function setSentOn($sentOn)
    {
        $this->sentOn = $sentOn;

        return $this;
    }

    /**
     * @param string $sentFrom
     *
     * @return $this
     */
    public function setSentFrom($sentFrom)
    {
        $this->sentFrom = $sentFrom;

        return $this;
    }

    /**
     * @param string $sourceArn
     *
     * @return $this
     */
    public function setSourceArn($sourceArn)
    {
        $this->sourceArn = $sourceArn;

        return $this;
    }

    /**
     * @param string $sendingAccountId
     *
     * @return $this
     */
    public function setSendingAccountId($sendingAccountId)
    {
        $this->sendingAccountId = $sendingAccountId;

        return $this;
    }

    /**
     * @param string $headers
     *
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $commonHeaders
     *
     * @return $this
     */
    public function setCommonHeaders($commonHeaders)
    {
        $this->commonHeaders = $commonHeaders;

        return $this;
    }
}

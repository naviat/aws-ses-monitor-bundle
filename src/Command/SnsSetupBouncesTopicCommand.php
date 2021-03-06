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

namespace SerendipityHQ\Bundle\AwsSesMonitorBundle\Command;

use SerendipityHQ\Bundle\AwsSesMonitorBundle\Service\NotificationHandler;

/**
 * Setups a topic to receive bounces notifications from SNS.
 *
 * @author Audrius Karabanovas <audrius@karabanovas.net>
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 *
 * {@inheritdoc}
 */
class SnsSetupBouncesTopicCommand extends SnsSetupCommandAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getNotificationConfig()
    {
        return 'shq_aws_ses_monitor.bounces';
    }

    /**
     * {@inheritdoc}
     */
    public function getNotificationKind()
    {
        return NotificationHandler::MESSAGE_TYPE_BOUNCE;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription(
            'Registers SNS Topic, attaches it to chosen identities as bounce topic and subscribes endpoint to receive bounce notifications'
        );
        $this->setName('aws:ses:monitor:setup:bounces-topic');
    }
}

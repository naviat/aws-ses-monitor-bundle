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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Sends test emails to the addresses provided by AWS SES.
 *
 * @see: http://docs.aws.amazon.com/ses/latest/DeveloperGuide/mailbox-simulator.html
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 *
 * {@inheritdoc}
 */
class SesSendTestEmailsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription(
            'Sends test emails through SwiftMailer to the addresses provided by AWS SES.'
        );
        $this->setName('aws:ses:monitor:test:swiftmailer');
    }

    /**
     * Executes the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailAddresses = [
            'success@simulator.amazonses.com',
            'bounce@simulator.amazonses.com',
            'ooto@simulator.amazonses.com',
            'complaint@simulator.amazonses.com',
            'suppressionlist@simulator.amazonses.com',
        ];

        $question = new Question('<question>Please, enter the from email address to use:</question>');

        $fromAddress = $this->getHelper('question')->ask($input, $output, $question);

        $sents = [];
        foreach ($emailAddresses as $toAddress) {
            $message = $this->createMessage($fromAddress, $toAddress);
            $output->writeln(sprintf('<info>Sending an email from <comment>%s</comment> to <comment>%s</comment></info>', $fromAddress, $toAddress));
            $result = $this->getContainer()->get('mailer')->send($message);

            $tag           = 'fg=green';
            $outputMessage = 'Email to ' . $toAddress . ' ';

            if (0 === $result) {
                $tag = 'fg=red;';
                $outputMessage .= '<options=bold>NOT</> ';
            }

            $outputMessage .= 'sent.';

            $sents[] = '<' . $tag . '>' . $outputMessage . '</>';
        }

        foreach ($sents as $sent) {
            $output->writeln($sent);
        }
    }

    /**
     * @param $sendTo
     * @param mixed $sendFrom
     *
     * @return \Swift_Mime_SimpleMimeEntity
     */
    private function createMessage($sendFrom, $sendTo)
    {
        return (new \Swift_Message())
            ->setSubject('Test message from Aws Ses Monitor Bundle')
            ->setFrom($sendFrom)
            ->setTo($sendTo)
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody('This is a test message sent from the Aws SES Monitor Bundle command.');
    }
}

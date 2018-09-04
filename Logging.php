<?php

namespace Extension\Google;

use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\LoggingClient;

class Logging extends \Core\Module
{

    public static function testCommand($command, $args, $options)
    {
        \kernel::log(LOG_INFO, 'this a test message from testCommand()');
        return true;
    }

    private function logSignalDo($source, $message, $level, $timestamp, $address, $port, $session_id, $tags)
    {
        $projectId = $this->getModuleValue('project_id');

        $logging = new LoggingClient();

        $severity = 0;
        switch ($level) {
            case LOG_DEBUG:
                $severity = Logger::DEBUG;
                break;
            case LOG_INFO:
                $severity = Logger::INFO;
                break;
            case LOG_NOTICE:
                $severity = Logger::NOTICE;
                break;
            case LOG_WARNING:
                $severity = Logger::WARNING;
                break;
            case LOG_ERR:
                $severity = Logger::ERROR;
                break;
            case LOG_CRIT:
                $severity = Logger::CRITICAL;
                break;
            case LOG_ALERT:
                $severity = Logger::ALERT;
                break;
            case LOG_EMERG:
                $severity = Logger::EMERGENCY;
                break;
        }

        $logger = $logging->logger('this-a-test-name');
        $entry  = $logger->entry($message, [
            'severity' => $severity,
            'resource' => [
                'type' => 'global',
            ],
        ]);

        $logger->write($entry);
    }

    public static function logSignal($source, $message, $level, $timestamp, $address, $port, $session_id)
    {
        $o = new self();
        $o->logSignalDo($source, $message, $level, $timestamp, $address, $port, $session_id, array('system', 'generic'));
    }
}

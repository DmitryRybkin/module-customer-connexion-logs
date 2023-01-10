<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Cron;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use MyCompany\CustomerConnexionLogs\Model\Config;
use MyCompany\CustomerConnexionLogs\Service\EmailSender;
use Psr\Log\LoggerInterface;

class SendEmail
{
    private Config $config;
    private EmailSender $emailSender;
    private LoggerInterface $logger;

    public function __construct(
        Config $config,
        EmailSender $emailSender,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->emailSender = $emailSender;
        $this->logger = $logger;
    }

    public function execute(): void
    {
        if (!$this->config->isCustomerLogTrackingEnabled()) {
            return;
        }

        try {
            $this->emailSender->sendTotalConnexionsForLastDay();
        } catch (MailException|LocalizedException $e) {
            $this->logger->error(__($e->getMessage()));
        }
    }
}

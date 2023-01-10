<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Service;

use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\Store;
use MyCompany\CustomerConnexionLogs\Model\Config;
use MyCompany\CustomerConnexionLogs\Service\CustomerLoginTracker;

class EmailSender
{
    private TransportBuilder $transportBuilder;
    private StateInterface $inlineTranslation;
    private Config $config;
    private CustomerLoginTracker $customerLoginTracker;

    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        Config $config,
        CustomerLoginTracker $customerLoginTracker
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->config = $config;
        $this->customerLoginTracker = $customerLoginTracker;
    }

    /**
     * @throws MailException
     * @throws LocalizedException
     */
    public function sendTotalConnexionsForLastDay(): void
    {
        $templateIdentifier = $this->config->getEmailTrackerTemplate();
        $customVars = [
            'total_connexion' => $this->customerLoginTracker->getTotalConnexionCountForLastDay()
        ];
        $sender = [
            'name' => $this->config->getSenderName(),
            'email' => $this->config->getSenderEmail()
        ];
        $recipient = $this->config->getRecipientEmail();

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateIdentifier)
            ->setTemplateOptions(
                [
                    'area' => Area::AREA_FRONTEND,
                    'store' => Store::DEFAULT_STORE_ID
                ]
            )
            ->setTemplateVars($customVars)
            ->setFromByScope($sender)
            ->addTo($recipient)
            ->getTransport();
        $transport->sendMessage();

        $this->inlineTranslation->resume();
    }
}

<?php


namespace App\Service;

use App\Entity\Offer;
use Psr\Log\LoggerInterface;

class Notifier
{
    private $mailer;
    private $logger;

    public function __construct( \Swift_Mailer $mailer, LoggerInterface $logger )
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * @param Offer $o
     * @param array $applicantInfo
     */
    public function notify( Offer $o, array $applicantInfo )
    {
        $mail = new \Swift_Message(
            'Nuevo postulante para '.$o->getTitle().'!',
            $applicantInfo['name'].' se ha postulado!, contactelo a '.$applicantInfo['email']
        );
        $mail->setTo( $o->getCompany()->getEmail() );
        $this->mailer->send( $mail );
        $this->logger->info('Se envio un mail a '.$o->getCompany()->getEmail() );
    }
}
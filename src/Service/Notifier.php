<?php


namespace App\Service;

use App\Entity\Offer;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class Notifier
{
    private $translator;
    private $twig;
    private $mailer;

    public function __construct( Environment $environment, \Swift_Mailer $mailer, TranslatorInterface $translator )
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->twig = $environment;
    }

    public function notify( Offer $offer, array $info )
    {
        $to = $offer->getCompany()->getEmail();
        $subject = $this->translator->trans('offer.new.application.received');
        $body = '
<p>'.$this->translator->trans('offer.title').'</p>
<p>'.$info['name'].'</p>
<p>'.$info['email'].'</p>';

        $mail = new \Swift_Message( $subject, $body );
        $mail->setTo( $to );
        $this->mailer->send( $mail);
    }
}
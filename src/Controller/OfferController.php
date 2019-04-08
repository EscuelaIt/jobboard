<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\ApplicationType;
use App\Service\Notifier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offer;

class OfferController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $this->getDoctrine()->getRepository(Offer::class )->findAll(),
        ]);
    }

    /**
     * @param Offer $offer
     * @Route(path="/offer/{id}/apply", name="apply_to_offer")
     * @ParamConverter(class="App\Entity\Offer", name="offer")
     */
    public function apply( Offer $offer, Request $request, Notifier $notifier )
    {
        $form = $this->createForm( ApplicationType::class );
        $form->add(
            'submit',
            SubmitType::class,
            [
                'label' => 'Enviar',
            ]
        );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $notifier->notify( $offer, [
                'name' => $form['name']->getData(),
                'email' => $form['email']->getData(),
                ]);

            return $this->redirectToRoute('home');
        }

        return $this->render('offer/apply.html.twig',
            [
                'form' => $form->createView(),
                'offer' => $offer,
            ]);
    }

    private function sendApplicantInfo( Company $company, array $info )
    {
        $mail = new \Swift_Message('');
    }
}

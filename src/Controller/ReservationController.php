<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(EntityManagerInterface $manager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $user = $this->getUser();
        $email = $user->getEmail();
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $reservation = $form->getData();
            $reservation->setEmail($email);
            
            $manager->persist($reservation);
            $manager->flush();

            $this->addFlash(
                'info',
                'Votre réservation à été prise en compte avec succès !'
            );

        return $this->redirectToRoute('app_reservation');

        }

        return $this->render('pages/reservation/index.html.twig', [
            'form' => $form
        ]);
    }
}

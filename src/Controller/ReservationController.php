<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Service\GestionRestaurant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ReservationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reservation', name: 'app_reservation')]

    public function index(Request $request, GestionRestaurant $gestion): Response
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
            
            $reservDate = $reservation->getCreatedAt();
            $dispoPlace = $gestion->getRemainingSeatsForInterval($reservDate);
            
            if ($dispoPlace >= $reservation->getNumberSeat()){

                $this->entityManager->persist($reservation);
                $this->entityManager->flush();
                
                $this->addFlash(
                    'info',
                    'Votre réservation a été prise en compte avec succès !'
                );
            } else {
                    // dd($dispoPlace);
                    return $this->redirectToRoute('products.index');
                }
        }
        return $this->render('pages/reservation/index.html.twig', [
            'form' => $form
        ]);
    }
}

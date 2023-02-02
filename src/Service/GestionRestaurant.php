<?php

namespace App\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class GestionRestaurant
{
    //protected $remainingSeats;
    protected $maxSeats; 
    protected $doctrine; 
    protected \DateInterval $occupedTime; 

    public function __construct(EntityManagerInterface $manager)
    {
        $this->doctrine = $manager; 
        $this->maxSeats = 20;
        $this->occupedTime = new \DateInterval("PT2H");
	}
    public function getRemainingSeatsForInterval(DateTimeImmutable $dateTime) 
    {
        $endReservation = $dateTime->format('Y-m-d H:i:s');
        $startReservation = $dateTime->sub($this->occupedTime)->format('Y-m-d H:i:s'); 

        //juste pour le test: 
        // $startReservation = '2015-06-01 20:00:00';
        // $endReservation = '2025-06-01 20:00:00';


        
        //  dump($startReservation);
        //  dump($endReservation);

        $conn = $this->doctrine->getConnection();

        $query = 
            'SELECT SUM(number_seat) AS occuped
            FROM reservation
            -- WHERE reserv_date BETWEEN :startReservation AND :endReservation            
            '
        ;

        $stmt = $conn->prepare($query);

        // reste plus à lancer la requete DQL 

        $resultSetResult =  $stmt->executeQuery(
            //[
            // 'startReservation' => $startReservation,
            // 'endReservation' => $endReservation
           // ]        
        );
        $resultat = $resultSetResult->fetchAssociative();
        // dump($resultat);
        //die(); 
        $occupedSeat = (int) $resultat['occuped'] ; 
        
        // dump($occupedSeat);
        
        $remainingSeats = $this->maxSeats - $occupedSeat; 
        
        // dump($occupedSeat); 
        //die(); // a supprimer

        return (int) $remainingSeats; 



    }
}; 
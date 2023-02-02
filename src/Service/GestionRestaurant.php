<?php

namespace App\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class GestionRestaurant
{
    //protected $remainingSeats;
    protected $maxSeats; 
    // acceder bdd
    protected $doctrine; 
    // temps d'occupation moyen des client
    protected \DateInterval $occupedTime; 

    public function __construct(EntityManagerInterface $manager)
    {
        $this->doctrine = $manager;
        
        // nbre de place dispo dans le resto de base
        $this->maxSeats = 10;

        // temps d'occupation moyen des client en dessous 2h
        $this->occupedTime = new \DateInterval("PT2H");
	}
    public function getRemainingSeatsForInterval(DateTimeImmutable $dateTime) 
    {
        // vérification interval des places occupé avant l'heure de reservation
        $startReservation = $dateTime->sub($this->occupedTime)->format('Y-m-d H:i:s');
        
        // fin reservation défini par $occupedTime
        $endReservation = $dateTime->format('Y-m-d H:i:s');
        // j'ouvre une connexion vers ma base de données pour vérification
        $conn = $this->doctrine->getConnection();
        // prepare une requete SQL pour faire la somme des reservations compris dans l'intervalle (fonction d'agrégation = faire somme totale) 
        $query = 
            'SELECT SUM(number_seat) AS occuped
            FROM reservation
             WHERE reserv_date_at BETWEEN :startReservation AND :endReservation            
            '
        ;
        $stmt = $conn->prepare($query);
        // execute la requte sql avec les parametres donné dans le tableau nommé
        $resultSetResult =  $stmt->executeQuery(
            [
            'startReservation' => $startReservation,
            'endReservation' => $endReservation
           ]        
        );
        // retourne la premiere ligne de la reponse SQL
        $resultat = $resultSetResult->fetchAssociative();
        // le nombre de place occupé qui est dans la colonne "occupé" via l'alias
        $occupedSeat = (int) $resultat['occuped'] ; 
        // calcul du nombre restant en faisant une soustraction
        $remainingSeats = $this->maxSeats - $occupedSeat; 
        //retourne le nombre de place restantes
        // et je m'assure de caster en int pour quil me renvoi un int
        return (int) $remainingSeats; 



    }
}; 
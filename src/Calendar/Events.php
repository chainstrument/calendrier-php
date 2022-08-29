<?php


namespace App\Calendar;

use Exception;

class Events{

    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getEventsBetween(\DateTime $start, \DateTime $end)
    {

   
        $sql = 'SELECT * FROM events WHERE start BETWEEN "' . $start->format('Y-m-d 00:00:00') . '" AND "' . $end->format('Y-m-d 23:59:59') . '"';
           
        $statement = $this->pdo->query($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, \App\Calendar\Event::class);
        return $statement->fetchAll();
        

    }


    public function getEventsBetweenByDay(\DateTime $start, \DateTime $end)
    {
        $events = $this->getEventsBetween($start, $end);
         
        $days = [];
        foreach($events as $event)
        {
            $date =  $event->getStart()->format('Y-m-d');
            if(!isset($days[$date]))
            {
                $days[$date] = [$event];
            }else{
                $days[$date][] =  $event;
            }
        }

        return $days;
    }


    public function find(int $id) : App\Calendar\Event
    {

        require 'Event.php';
        $statement = $this->pdo->query('SELECT * FROM events WHERE id =' . $id .' LIMIT 1');
        $statement->setFetchMode(\PDO::FETCH_CLASS, \Calendar\Event::class);
        $resultat = $statement->fetch();

        if($resultat === false)
        {
            throw new Exception('Aucun resultat trouvé');

        }

        return $resultat;
    }

}
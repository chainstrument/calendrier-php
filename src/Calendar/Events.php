<?php


namespace Calendar;

use Exception;

class Events{

    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getEventsBetween(\DateTime $start, \DateTime $end)
    {

   
        $sql = 'SELECT * FROM events WHERE start BETWEEN ' . $start->format('Y-m-d 00:00:00') . ' AND '
 . $end->format('Y-m-d 00:00:00');

        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
        

    }


    public function getEventsBetweenByDay(\DateTime $start, \DateTime $end)
    {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach($events as $event)
        {
            $date = explode(' ', $event['start'])[0];
            if(!isset($days[$date]))
            {
                $days[$date] = [$event];
            }else{
                $days[$date][] =  $event;
            }
        }

        return $days;
    }


    public function find(int $id) : \Calendar\Event
    {

        require 'Event.php';
        $statement = $this->pdo->query('SELECT * FROM evens WHERE id =' . $id .' LIMIT 1');
        $statement->setFetchMode(\PDO::FETCH_CLASS, \Calendar\Event::class);
        $resultat = $statement->fetch();

        if($resultat === false)
        {
            throw new Exception('Aucun resultat trouvé');

        }

        return $resultat;
    }

}
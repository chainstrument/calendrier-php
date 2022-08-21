<?php

namespace App\Date;

use DateTime;

class Month
{
    public $year;
    public $month;

    private $months = [
        'janvier',
        'fevrier',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'aout',
        'septembre',
        'octobre',
        'novembre',
        'decembre'];

    public $days = [
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
    ];

    public function __construct( ?int $month = null, ?int $year = null)
    {
        if ($month < 0 || $month > 12) {
            throw new \Exception('Invalid Month');
        }
        
        if($month === null || $month < 1 || $month > 12)
        {
            $month = intval(date('m'));
        }
        
        if($year === null  ){
            
            $year = intval(date('Y'));
        }
        $this->month = $month;
        $this->year = $year;
    }

public function getStartingDay() :\DateTime
{
  return  new \DateTime("{$this->year}-{$this->month}-01");
}

    public function __toString()
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    public function getWeeks():int
    {
        $start = $this->getStartingDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W'));
        if($weeks < 0) {
            $weeks = intval($start->format('W'));
        }

        return $weeks;
    }
    public function widthInMonth(\DateTime $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    public function nextMonth()
    {

        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12)
        {
            $month = 1;
            $year += 1;
        }

        return new Month($month, $year);
    }
    
    public function previousMonth()
    {

        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1)
        {
            $month = 12;
            $year -= 1;
        }

        return new Month($month, $year);
    }

}

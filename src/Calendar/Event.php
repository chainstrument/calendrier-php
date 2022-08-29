<?php 

class Event {

    protected $name;

    protected $start;

    protected $end;

    protected $description;


    public function getName()
    {
        return $this->name;
    }

    public function getStart()
    {
        return new \DateTime($this->start);
    }


    public function getEnd()
    {
        return new \DateTime($this->end);
    }

}
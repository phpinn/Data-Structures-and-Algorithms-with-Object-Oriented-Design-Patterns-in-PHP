<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Simulation.php,v 1.3 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Association.php';
require_once 'Opus11/LeftistHeap.php';
require_once 'Opus11/ExponentialRV.php';

//{
/**
 * Represents an event in the simulation.
 *
 * @package Opus11
 */
class Simulation_Event
    extends Association
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a Simulation_Event with the given type and time.
     *
     * @param integer $type The type of the event.
     * @param integer $time The time of the event.
     */
    public function __construct($type, $time)
    {
        parent::__construct(box($time), box($type));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Time getter.
     *
     * @return integer The time of this event.
     */
    public function getTime()
    {
        return unbox($this->getKey());
    }

    /**
     * Type getter.
     *
     * @return integer The type of this event.
     */
    public function getType()
    {
        return unbox($this->getValue());
    }
//}>a

    /**
     * Returns a textual representation of this event.
     *
     * @return string A string.
     */
    public function __toString()
    {
        if ($this->getType() == Simulation::ARRIVAL)
        {
            return "Event {" . $this->getTime() . ", arrival}";
        }
        elseif ($this->getType() == Simulation::DEPARTURE)
        {
            return "Event {" . $this->getTime() . ", departure}";
        }
    }
}

//{
/**
 * Represents a stack implemented using an array.
 *
 * @package Opus11
 */
class Simulation
{
    /**
     * The event list.
     */
    protected $eventList = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Represents an arrival.
     */
    const ARRIVAL = 1;
    /**
     * Represents a departure.
     */
    const DEPARTURE = 2;

    /**
     * Constructs a Simulation.
     */
    public function __construct()
    {
        $this->eventList = new LeftistHeap();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->eventList = NULL;
    }
//}>b

//{
    /**
     * Runs the simulation.
     *
     * @param integer $timeLimit The amount of simulation time to be simulated.
     */
    public function run($timeLimit)
    {
        $serverBusy = false;
        $numberInQueue = 0;
        $serviceTime = new ExponentialRV(100.);
        $interArrivalTime = new ExponentialRV(100.);
        $this->eventList->enqueue(
            new Simulation_Event(self::ARRIVAL, 0));
        while (!$this->eventList->isEmpty()) {
            $event = $this->eventList->dequeueMin();
            $t = $event->getTime();
            if ($t > $timeLimit)
                  { $this->eventList->purge(); break; }
//[
            printf("%s\n", str($event));
//]
            switch ($event->getType())
            {
            case self::ARRIVAL:
                if (!$serverBusy) {
                    $serverBusy = true;
                    $this->eventList->enqueue(
                        new Simulation_Event(self::DEPARTURE,
                        $t + $serviceTime->next()));
                }
                else
                    ++$numberInQueue;
                $this->eventList->enqueue(
                    new Simulation_Event(self::ARRIVAL,
                    $t + $interArrivalTime->next()));
                break;
            case self::DEPARTURE:
                if ($numberInQueue == 0)
                    $serverBusy = false;
                else {
                    --$numberInQueue;
                    $this->eventList->enqueue(
                        new Simulation_Event(self::DEPARTURE,
                        $t + $serviceTime->next()));
                }
                break;
            }
        }
    }
//}>c
}
?>

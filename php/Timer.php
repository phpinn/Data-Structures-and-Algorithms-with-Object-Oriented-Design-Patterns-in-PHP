<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Timer.php,v 1.3 2005/12/09 01:11:18 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Exceptions.php';

/**
 * A timer for measuring elapsed time.
 *
 * @package Opus11
 */
class Timer
{
    /**
     * @var integer The stopped state.
     */
    const STOPPED = 1;
    /**
     * @var integer The running state.
     */
    const RUNNING = 2;
    /**
     * @var integer The current state.
     */
    protected $state = self::STOPPED;
    /**
     * @var float The start time.
     */
    protected $startTime = 0.0;
    /**
     * @var float The stop time.
     */
    protected $stopTime = 0.0;

    /**
     * Constructs a Timer.
     */
    public function __construct()
    {
        $this->state = self::STOPPED;
        $this->startTime = microtime(true);
        $this->stopTime = microtime(true);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Starts this timer.
     */
    public function start()
    {
        if ($this->state != self::STOPPED)
            throw new StateError();
        $this->startTime = microtime(true);
        $this->state = self::RUNNING;
    }

    /**
     * Stops this timer.
     */
    public function stop()
    {
        if ($this->state != self::RUNNING)
            throw new StateError();
        $this->stopTime = microtime(true);
        $this->state = self::STOPPED;
    }

    /**
     * Elapsed time getter.
     *
     * @returns float The elapsed time.
     */
    public function getElapsedTime()
    {
        if ($this->state == self::RUNNING)
        {
            $this->stopTime = microtime(true);
        }
        return $this->stopTime - $this->startTime;
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Timer main program.\n");
        $status = 0;
        $t = new Timer();
        $t->start();
        $x = 2;
        for ($i = 0; $i < 10000000; ++$i)
        {
            $x = $x * 2;
        }
        $t->stop();
        printf("Elapsed time %f\n", $t->getElapsedTime());
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Timer::main(array_slice($argv, 1)));
}
?>

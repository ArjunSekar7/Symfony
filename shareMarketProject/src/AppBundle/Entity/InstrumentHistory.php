<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstrumentHistory
 */
class InstrumentHistory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $instrumentId;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var float
     */
    private $historyValue;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set instrumentId
     *
     * @param integer $instrumentId
     * @return InstrumentHistory
     */
    public function setInstrumentId($instrumentId)
    {
        $this->instrumentId = $instrumentId;

        return $this;
    }

    /**
     * Get instrumentId
     *
     * @return integer 
     */
    public function getInstrumentId()
    {
        return $this->instrumentId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return InstrumentHistory
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set historyValue
     *
     * @param float $historyValue
     * @return InstrumentHistory
     */
    public function setHistoryValue($historyValue)
    {
        $this->historyValue = $historyValue;

        return $this;
    }

    /**
     * Get historyValue
     *
     * @return float 
     */
    public function getHistoryValue()
    {
        return $this->historyValue;
    }
}

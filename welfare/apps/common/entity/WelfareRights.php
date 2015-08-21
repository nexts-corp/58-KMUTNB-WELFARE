<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="WelfareRights")
     */
class WelfareRights {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="welfareRightsId") */
        public $welfareRightsId;

       /**
        * @Column(type="integer" , length=11, name="welfareId") */
       public $welfareId;

        /**
        *@Column(type="integer", length=11, name="registerId")
        */
       public $registerId;
       
       /**
        *@Column(type="integer", length=11, name="amount") 
        */
       public $amount;
       
       /**
        *@Column(type="date", name="dateStartWelfare") 
        */
       public $dateStartWelfare;


        /**
         * @Column(type="integer" , length=11, name="statusId") */
        public $statusId;












    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getDateStartWelfare()
    {
        return $this->dateStartWelfare;
    }

    /**
     * @param mixed $dateStartWelfare
     */
    public function setDateStartWelfare($dateStartWelfare)
    {
        $this->dateStartWelfare = $dateStartWelfare;
    }

    /**
     * @return mixed
     */
    public function getRegisterId()
    {
        return $this->registerId;
    }

    /**
     * @param mixed $registerId
     */
    public function setRegisterId($registerId)
    {
        $this->registerId = $registerId;
    }

    /**
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * @param mixed $statusId
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;
    }

    /**
     * @return mixed
     */
    public function getWelfareId()
    {
        return $this->welfareId;
    }

    /**
     * @param mixed $welfareId
     */
    public function setWelfareId($welfareId)
    {
        $this->welfareId = $welfareId;
    }

    /**
     * @return mixed
     */
    public function getWelfareRightsId()
    {
        return $this->welfareRightsId;
    }

    /**
     * @param mixed $welfareRightsId
     */
    public function setWelfareRightsId($welfareRightsId)
    {
        $this->welfareRightsId = $welfareRightsId;
    }









       
}

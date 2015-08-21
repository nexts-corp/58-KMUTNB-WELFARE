<?php
namespace apps\common\entity;
/**
     * @Entity
     * @Table(name="MedicalFee")
     */
class MedicalFee {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="medicalFeeId") */
       public $medicalFeeId;
       
        /**
        *@Column(type="string" , length=255, name="registerId") 
        */
       public $registerId;
       
       /**
        *@Column(type="float" , name="amount") 
        */
       public $amount;
       
        /**
        *@Column(type="string" , length=255, name="hospital") 
        */
       public $hospital;
       
       /**
        *@Column(type="string" , length=255, name="detailMedical") 
        */
       public $detailMedical;
       
       /**
        *@Column(type="date" , name="dateMedical") 
        */
       public $dateMedical;
       
        /**
        *@Column(type="date" , name="endDateMedical") 
        */
       public $endDateMedical;
       
       /**
        *@Column(type="date" , name="dateDrawMoney") 
        */
       public $dateDrawMoney;
       
       /**
        *@Column(type="date" , name="recipients") 
        */
       public $recipients;
       

       function getMedicalFeeId() {
           return $this->medicalFeeId;
       }

       function getRegisterId() {
           return $this->registerId;
       }

       function getAmount() {
           return $this->amount;
       }

       function getHospital() {
           return $this->hospital;
       }

       function getDetailMedical() {
           return $this->detailMedical;
       }

       function getDateMedical() {
           return $this->dateMedical;
       }

       function getEndDateMedical() {
           return $this->endDateMedical;
       }

       function getDateDrawMoney() {
           return $this->dateDrawMoney;
       }

       function getRecipients() {
           return $this->recipients;
       }

       function setMedicalFeeId($medicalFeeId) {
           $this->medicalFeeId = $medicalFeeId;
       }

       function setRegisterId($registerId) {
           $this->registerId = $registerId;
       }

       function setAmount($amount) {
           $this->amount = $amount;
       }

       function setHospital($hospital) {
           $this->hospital = $hospital;
       }

       function setDetailMedical($detailMedical) {
           $this->detailMedical = $detailMedical;
       }

       function setDateMedical($dateMedical) {
           $this->dateMedical = $dateMedical;
       }

       function setEndDateMedical($endDateMedical) {
           $this->endDateMedical = $endDateMedical;
       }

       function setDateDrawMoney($dateDrawMoney) {
           $this->dateDrawMoney = $dateDrawMoney;
       }

       function setRecipients($recipients) {
           $this->recipients = $recipients;
       }




}

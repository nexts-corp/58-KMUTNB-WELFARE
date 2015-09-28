<?php
namespace apps\common\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="Nottifications")
 */
class Nottifications extends EntityBase{


    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="nftId") */
    public $nftId;

    /**
     *@Column(type="integer",  length=11,name="memberId")
     */
    public $memberId;
    
     /**
     *@Column(type="integer" , length=11, name="nftAppId")
     */
    public $nftAppId;
    
    /**
     *@Column(type="string" , length=255, name="nftAppName")
     */
    public $nftAppName;
    

    /**
     *@Column(type="string" , length=255, name="nftName")
     */
    public $nftName;

    /**
     *@Column(type="string" , length=255, name="nftLink" , nullable=true)
     */
    public $nftLink;
    
    /**
     *@Column(type="string" , length=10, name="nftStatus")
     */
    public $nftStatus;
    
    function getNftId() {
        return $this->nftId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getNftAppId() {
        return $this->nftAppId;
    }

    function getNftAppName() {
        return $this->nftAppName;
    }

    function getNftName() {
        return $this->nftName;
    }

    function getNftLink() {
        return $this->nftLink;
    }

    function getNftStatus() {
        return $this->nftStatus;
    }

    function setNftId($nftId) {
        $this->nftId = $nftId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setNftAppId($nftAppId) {
        $this->nftAppId = $nftAppId;
    }

    function setNftAppName($nftAppName) {
        $this->nftAppName = $nftAppName;
    }

    function setNftName($nftName) {
        $this->nftName = $nftName;
    }

    function setNftLink($nftLink) {
        $this->nftLink = $nftLink;
    }

    function setNftStatus($nftStatus) {
        $this->nftStatus = $nftStatus;
    }


}

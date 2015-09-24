<?php
namespace apps\member\entity;
use apps\common\entity\EntityBase;

/**
 * @Entity
 * @Table(name="MemberDocument")
 */
class Document extends EntityBase {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="documentId") 
     */
    public $documentId;

    /**
     * @Column(type="integer", length=11, name="memberId") 
     */
    public $memberId;

    /**
     * @Column(type="string", length=255, name="filename",nullable=true) 
     */
    public $filename;

    /**
     * @Column(type="string", length=255, name="remark",nullable=true) 
     */
    public $remark;
    
    function getDocumentId() {
        return $this->documentId;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getFilename() {
        return $this->filename;
    }

    function getRemark() {
        return $this->remark;
    }

    function setDocumentId($documentId) {
        $this->documentId = $documentId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }


}

<?php
namespace apps\qa\entity;
use apps\common\entity\EntityBase;

/**
     * @Entity
     * @Table(name="QAMultiFile")
     */
class MultiFile extends EntityBase {
    /** 
        * @Id
        * @GeneratedValue
        * @Column(type="integer" , length=11, name="multiFileId") */
    
       public $multiFileId;
     
        /**
        *@Column(type="string", name="multiFileName") 
        */
       public $multiFileName;
       
       public $file;
       
       function getMultiFileId() {
           return $this->multiFileId;
       }

       function getMultiFileName() {
           return $this->multiFileName;
       }

       function getFile() {
           return $this->file;
       }

       function setMultiFileId($multiFileId) {
           $this->multiFileId = $multiFileId;
       }

       function setMultiFileName($multiFileName) {
           $this->multiFileName = $multiFileName;
       }

       function setFile($file) {
           $this->file = $file;
       }


   

}

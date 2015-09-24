<?php
namespace apps\news\entity;
use apps\common\entity\EntityBase;

/**
     * @Entity
     * @Table(name="NewsMultiFile")
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
       
       
        /**
        *@Column(type="integer", name="newsId",nullable=true) 
        */
       public $newsId;
       
       public $file;
       
       function getFile() {
           return $this->file;
       }

       function setFile($file) {
           $this->file = $file;
       }

              
       function getMultiFileId() {
           return $this->multiFileId;
       }

       function getMultiFileName() {
           return $this->multiFileName;
       }

       function getNewsId() {
           return $this->newsId;
       }

       function setMultiFileId($multiFileId) {
           $this->multiFileId = $multiFileId;
       }

       function setMultiFileName($multiFileName) {
           $this->multiFileName = $multiFileName;
       }

       function setNewsId($newsId) {
           $this->newsId = $newsId;
       }


       
}

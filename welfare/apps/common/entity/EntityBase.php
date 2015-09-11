<?php

namespace apps\common\entity;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 */
class EntityBase {

    /**
     * @column(name="dateCreated",type="datetime",nullable=true)
     */
    public $dateCreated;

    /**
     * @column(name="dateUpdated",type="datetime",nullable=true)
     */
    public $dateUpdated;

    /**
     * @column(name="createBy",type="string",length=100,nullable=true)
     */
    public $createBy;

    /**
     * @column(name="updateBy",type="string",length=100,nullable=true)
     */
    public $updateBy;

    /**
     * @PrePersist
     */
    function prePersist() {
        $this->dateCreated = new \DateTime("now");
         $this->createBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER->name;
         $this->updateBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER->name;
    }

    /**
     * @PreUpdate
     */
    function preUpdate() {
        $this->dateUpdated = new \DateTime("now");
        $this->updateBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER->name;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    public function setDateUpdated($dateUpdated) {
        $this->dateUpdated = $dateUpdated;
    }

    function getCreateBy() {
        return $this->createBy;
    }

    function getUpdateBy() {
        return $this->updateBy;
    }

    function setCreateBy($createBy) {
        $this->createBy = $createBy;
    }

    function setUpdateBy($updateBy) {
        $this->updateBy = $updateBy;
    }

}
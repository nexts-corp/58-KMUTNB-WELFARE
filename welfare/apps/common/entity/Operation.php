<?php
namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="Operation")
 */
class Operation {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="operationId") */
    public $operationId;


    /**
     *@Column(type="string" , length=255, name="name")
     */
    public $name;


    /**
     *@Column(type="string" , length=255, name="note")
     */
    public $note;





    /**
     * @return mixed
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * @param mixed $operationId
     */
    public function setOperationId($operationId)
    {
        $this->operationId = $operationId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }




}

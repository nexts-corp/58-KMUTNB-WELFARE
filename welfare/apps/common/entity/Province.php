<?php
namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="Province")
 */
class Province {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=100, name="provinceId") */
    public $provinceId;

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="string" , length=100, name="name") */
    public $name;





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
    public function getProvinceId()
    {
        return $this->provinceId;
    }

    /**
     * @param mixed $provinceId
     */
    public function setProvinceId($provinceId)
    {
        $this->provinceId = $provinceId;
    }






}

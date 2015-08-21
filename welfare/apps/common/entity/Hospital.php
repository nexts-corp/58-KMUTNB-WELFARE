<?php
namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="Hospital")
 */
class Hospital {


    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer" , length=11, name="hospitalId") */
    public $hospitalId;

    /**
     *@Column(type="string",  length=100,name="name")
     */
    public $name;

    /**
     *@Column(type="integer" , length=11, name="provinceId")
     */
    public $provinceId;





    /**
     * @return mixed
     */
    public function getHospitalId()
    {
        return $this->hospitalId;
    }

    /**
     * @param mixed $hospitalId
     */
    public function setHospitalId($hospitalId)
    {
        $this->hospitalId = $hospitalId;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
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












}

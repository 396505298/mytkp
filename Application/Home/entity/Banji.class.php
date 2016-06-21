<?php
namespace entity;
class Banji{
    public $cid;
    
    public $name;
    
    public $classType;
    
    public $status;
    /**
     * @return $cid
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @return $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return $classType
     */
    public function getClassType()
    {
        return $this->classType;
    }

    /**
     * @return $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setClassType($classType)
    {
        $this->classType = $classType;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}

?>
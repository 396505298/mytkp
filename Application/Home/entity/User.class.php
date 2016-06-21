<?php
namespace entity;
class User{
    public  $uid;
    
    public  $userName;
    
    public  $userPass;
    
    public  $userType;
    
    public  $trueName;
    
    public  $sex;
    
    public  $phone;
    
    public  $school;
    /**
     * @return $uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return $userName
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return $userPass
     */
    public function getUserPass()
    {
        return $this->userPass;
    }

    /**
     * @return $userType
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @return $trueName
     */
    public function getTrueName()
    {
        return $this->trueName;
    }

    /**
     * @return $sex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return $school
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUserPass($userPass)
    {
        $this->userPass = $userPass;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setTrueName($trueName)
    {
        $this->trueName = $trueName;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    
}

?>
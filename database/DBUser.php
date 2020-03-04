<?php
require_once "DB.php";

class DBUser
{
    private $table = "users";

    public function isUser($email,$password,$userType)
    {
        $sql = "SELECT * FROM $this->table where email=:email and password=:password and userType=:userType";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userType', $userType);
        $stmt->execute();
        if ($stmt->rowCount()>0)
            return "exist";
        else
            return "not exist";
    }
    public function registerUser($name,$email,$password,$contact,$address,$userType){
        $sql="INSERT into $this->table(name,email,password,contact,address,userType) values (:name,:email,:password,:contact,:address,:userType)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':contact',$contact);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':userType',$userType);
        return $stmt->execute();
    }
    public function getUser($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getFarmer($id)
    {
        $sql="SELECT * FROM $this->table where id=:id and userType=:userType";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $userType="Farmer";
        $stmt->bindParam(':userType',$userType);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getUsers()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getUserByEmailPass($email,$password)
    {
        $sql="SELECT * FROM $this->table where email=:email and password=:password";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->execute();
        return $stmt->fetch();
    }
}

?>
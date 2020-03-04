<?php
require_once "DB.php";

class DBRequest
{
    private $table = "requests";

    public function addRequest($ownerId,$storageId, $storagename,$productid,$product, $farmerid,
                   $capacity,$price,$date,$status){
        $sql="INSERT into $this->table(ownerId,storageid,storagename,productid,product,farmerid,capacity,price,date,status) values 
          (:ownerId,:storageid,:storagename,:productid,:product,:farmerid,:capacity,:price,:date,:status)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':ownerId',$ownerId);
        $stmt->bindParam(':storageid',$storageId);
        $stmt->bindParam(':storagename',$storagename);
        $stmt->bindParam(':productid',$productid);
        $stmt->bindParam(':product',$product);
        $stmt->bindParam(':farmerid',$farmerid);
        $stmt->bindParam(':capacity',$capacity);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':status',$status);
        return $stmt->execute();
    }

    public function getRequestByStatus($status){
        $sql="SELECT * FROM $this->table where status=:status";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':status',$status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

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
    public function saveProductByStorage($storageid,$product,$capacity,$pricetype,$price){
        $sql="INSERT into $this->table(storageid,product,capacity,pricetype,price) values (:storageid,:product,:capacity,:pricetype,:price)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':storageid',$storageid);
        $stmt->bindParam(':product',$product);
        $stmt->bindParam(':capacity',$capacity);
        $stmt->bindParam(':pricetype',$pricetype);
        $stmt->bindParam(':price',$price);
        return $stmt->execute();
    }
    public function getStorageRequestByOwnerId($ownerId,$status)
    {
        $sql="SELECT * FROM $this->table where ownerId=:ownerId and status=:status";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':ownerId',$ownerId);
        $stmt->bindParam(':status',$status);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getStorageRequestByFarmerId($farmerId,$status)
    {
        $sql="SELECT * FROM $this->table where farmerid=:farmerid and status=:status";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':farmerid',$farmerId);
        $stmt->bindParam(':status',$status);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getRequestById($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateProducts($id, $product, $capacity,$pricetype,$price)
    {
        $sql="UPDATE $this->table set product=:product,capacity=:capacity,pricetype=:pricetype,
            price=:price where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':product',$product);
        $stmt->bindParam(':capacity',$capacity);
        $stmt->bindParam(':pricetype',$pricetype);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function acceptRequest($id,$date)
    {
        $sql="UPDATE $this->table set date=:date,status=:status where id=:id";
        $stmt=DB::prepare($sql);
        $status="accepted";
        $stmt->bindParam(':date',$date);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function deleteRequest($id){
        $sql="DELETE from $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
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

    public function checkoutRequest($id)
    {
        $sql="UPDATE $this->table set status=:status where id=:id";
        $stmt=DB::prepare($sql);
        $status="checkout";
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }

    public function getRequests()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>
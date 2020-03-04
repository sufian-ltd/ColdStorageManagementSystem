<?php
require_once "DB.php";

class DBProducts
{
    private $table = "products";

    public function saveProductByStorage($storageid,$product,$capacity,$availablecapacity,$price){
        $sql="INSERT into $this->table(storageid,product,totalcapacity,availablecapacity,price) values 
          (:storageid,:product,:totalcapacity,:availablecapacity,:price)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':storageid',$storageid);
        $stmt->bindParam(':product',$product);
        $stmt->bindParam(':totalcapacity',$capacity);
        $stmt->bindParam(':availablecapacity',$availablecapacity);
        $stmt->bindParam(':price',$price);
        return $stmt->execute();
    }
    public function getStorageProduct($storageid)
    {
        $sql="SELECT * FROM $this->table where storageid=:storageid";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':storageid',$storageid);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getProductById($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getProductByRequestId($requestid)
    {
        $sql="SELECT * FROM $this->table where requestid=:requestid";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':requestid',$requestid);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function updateProducts($id, $product, $capacity,$availablecapacity,$price)
    {
        $sql="UPDATE $this->table set product=:product,totalcapacity=:totalcapacity,availablecapacity=:availablecapacity,
        price=:price where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':product',$product);
        $stmt->bindParam(':totalcapacity',$capacity);
        $stmt->bindParam(':availablecapacity',$availablecapacity);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function deleteByStorageId($storageid){
        $sql="DELETE from $this->table where storageid=:storageid";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':storageid',$storageid);
        return $stmt->execute();
    }
    public function deleteByRequestId($requestid){
        $sql="DELETE from $this->table where requestid=:requestid";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':requestid',$requestid);
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
    public function searchProduct($product){
        $sql="SELECT * FROM $this->table where product like :product";
        $stmt=DB::prepare($sql);
        $key='%'.$product.'%';
        $stmt->bindParam(':product',$product);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getProducts(){
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function updateAvailableCapacity($id,$availablecapacity){
        $sql="UPDATE $this->table set availablecapacity=:availablecapacity where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':availablecapacity',$availablecapacity);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
}

?>
<?php
    require_once "DB.php";
    class DBStorageOffer
    {
        private $table = "offers";

        public function saveStorageOffer($storageid,$days,$description,$date)
        {
            $sql="INSERT into $this->table(storageid,days,description,date)
 values (:storageid,:days,:description,:date)";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':storageid',$storageid);
            $stmt->bindParam(':days',$days);
            $stmt->bindParam(':description',$description);
            $stmt->bindParam(':date',$date);
            return $stmt->execute();
        }
        public function getStorages()
        {
            $sql="SELECT * FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getTotalOfferCapacityByStorageId($storageid)
        {
            $sql="SELECT sum(capacity) as capacity FROM $this->table where storageid=:storageid";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':storageid',$storageid);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function getStorageOfferById($id)
        {
            $sql="SELECT * FROM $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function getStorageOfferByStorageId($storageid)
        {
            $sql="SELECT * FROM $this->table where storageid=:storageid";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':storageid',$storageid);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function getStorageOffer($storageid)
        {
            $sql="SELECT * FROM $this->table where storageid=:storageid";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':storageid',$storageid);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function updateStorageOffer($storageid,$days,$description)
        {
            $sql="UPDATE $this->table set days=:days,description=:description where storageid=:storageid";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':days',$days);
            $stmt->bindParam(':description',$description);
            $stmt->bindParam(':storageid',$storageid);
            return $stmt->execute();
        }
        public function deleteStorageOfferByStorageid($id)
        {
            $sql="DELETE from $this->table where storageid=:storageid";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':storageid',$id);
            return $stmt->execute();
        }
        public function getProductsByCatAndSubCat($category,$subCategory)
        {
            $sql="select * from $this->table where category=:category and subCategory=:subCategory";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->bindParam(':subCategory',$subCategory);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProductByCategory($category)
        {
            $sql="SELECT * FROM $this->table where category=:category";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProductBySubCategory($subCategory)
        {
            $sql="SELECT * FROM $this->table where subCategory=:subCategory";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':subCategory',$subCategory);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function searchProduct($key)
        {
            $sql="SELECT * FROM $this->table where category like :category or name like :name";
//            $sql="SELECT * FROM $this->table where category like ? or subCategory like ? or productName like ?";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':category',$key);
            $stmt->bindParam(':name',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function sellProduct($productId)
        {
            $sql="UPDATE $this->table set sells=sells+1 where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$productId);
            return $stmt->execute();
        }
        public function updateStock($productId,$qtn)
        {
            $sql="UPDATE $this->table set qtn=qtn-$qtn where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$productId);
            return $stmt->execute();
        }
        public function updateStorageCapacity($id,$availablecapacity){
            $sql="UPDATE $this->table set availablecapacity=$availablecapacity where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function getTotalProductByCategory($category)
        {
            $sql="SELECT count(id) as id FROM $this->table where category=:category";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function hasOffer($storageid)
        {
            $sql = "SELECT * FROM $this->table where storageid=:storageid";
            $stmt = DB::prepare($sql);
            $stmt->bindParam(':storageid', $storageid);
            $stmt->execute();
            if ($stmt->rowCount()>0)
                return "exist";
            else
                return "not exist";
        }
    }
?>
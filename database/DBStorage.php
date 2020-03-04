<?php
    require_once "DB.php";
    class DBStorage
    {
        private $table = "storages";

        public function addStorage($userId,$name,$type,$totalcapacity, $availablecapacity,
            $division,$district,$thana,$location,$latitude,$longitude)
        {
            $sql="INSERT into $this->table(userId,name,type,totalcapacity,availablecapacity,division,district,thana,
            location,latitude,longitude,isactive) values (:userId,:name,:type,:totalcapacity,
            :availablecapacity,:division,:district,:thana,:location,:latitude,:longitude,1)";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$userId);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':totalcapacity',$totalcapacity);
            $stmt->bindParam(':availablecapacity',$availablecapacity);
            $stmt->bindParam(':division',$division);
            $stmt->bindParam(':district',$district);
            $stmt->bindParam(':thana',$thana);
            $stmt->bindParam(':location',$location);
            $stmt->bindParam(':latitude',$latitude);
            $stmt->bindParam(':longitude',$longitude);
            return $stmt->execute();
        }
        public function getStorages()
        {
            $sql="SELECT * FROM $this->table where isactive=1";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProduct()
        {
            $sql="SELECT * FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getStorageById($id)
        {
            $sql="SELECT * FROM $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function getStorageByUserId($userId)
        {
            $sql="SELECT * FROM $this->table where userId=:userId and isactive=1";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getInactiveStorageByUserId($userId)
        {
            $sql="SELECT * FROM $this->table where userId=:userId and isactive=0";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function updateStorage($id,$name,$type,$totalcapacity, $availablecapacity,$division,
        $district,$thana,$location,$latitude,$longitude)
        {
            $sql="UPDATE $this->table set name=:name,unit=:unit,beforeDiscount=:beforeDiscount,
            afterDiscount=:afterDiscount,qtn=:qtn,image=:image,sells=:sells,
            latitude=:latitude,longitude=:longitude where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':totalcapacity',$totalcapacity);
            $stmt->bindParam(':availablecapacity',$availablecapacity);
            $stmt->bindParam(':division',$division);
            $stmt->bindParam(':district',$district);
            $stmt->bindParam(':thana',$thana);
            $stmt->bindParam(':location',$location);
            $stmt->bindParam(':latitude',$latitude);
            $stmt->bindParam(':longitude',$longitude);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public function editStorage($id,$name,$type,$totalcapacity, $availablecapacity,$district,$thana,$location
            ,$latitude,$longitude)
        {
            $sql="UPDATE $this->table set name=:name,type=:type,totalcapacity=:totalcapacity,
            availablecapacity=:availablecapacity,district=:district,thana=:thana,
            location=:location,latitude=:latitude,longitude=:longitude where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':totalcapacity',$totalcapacity);
            $stmt->bindParam(':availablecapacity',$availablecapacity);
            $stmt->bindParam(':district',$district);
            $stmt->bindParam(':thana',$thana);
            $stmt->bindParam(':location',$location);
            $stmt->bindParam(':latitude',$latitude);
            $stmt->bindParam(':longitude',$longitude);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public function deleteStorage($id)
        {
            $sql="DELETE from $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
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
        public function searchByKeyAndDivision($division,$key)
        {
            $sql="SELECT * FROM $this->table where division like :division or name
  like :name or type like :type or district like :district or thana like :thana or location like :location and isactive=1";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':division',$division);
            $stmt->bindParam(':name',$key);
            $stmt->bindParam(':type',$key);
            $stmt->bindParam(':district',$key);
            $stmt->bindParam(':thana',$key);
            $stmt->bindParam(':location',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function searchByDivision($division){
            $sql="SELECT * FROM $this->table where division like :division and isactive=1";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':division',$division);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function searchByKey($key){
            $sql="SELECT * FROM $this->table where division like :division or name
  like :name or type like :type or district like :district or thana like :thana or location like :location and isactive=1";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':division',$key);
            $stmt->bindParam(':name',$key);
            $stmt->bindParam(':type',$key);
            $stmt->bindParam(':district',$key);
            $stmt->bindParam(':thana',$key);
            $stmt->bindParam(':location',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function updateStorageCapacity($id,$availablecapacity){
            $sql="UPDATE $this->table set availablecapacity=:availablecapacity where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':availablecapacity',$availablecapacity);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public function updateStorageAvailableCapacity($id,$capacity){
            $sql="UPDATE $this->table set availablecapacity=availablecapacity+$capacity where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public function makeInActiveStorage($id){
            $sql="UPDATE $this->table set isactive=0 where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public function makeActiveStorage($id){
            $sql="UPDATE $this->table set isactive=1 where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
    }
?>
<?php 

include("connexion.php");


// ? importation des données json

$jsonFile=file_get_contents("products.json");

$products=json_decode($jsonFile,true);

foreach($products as $product){

    $ref=$product['ref'];
    $name=$product['name'];
    $type=$product['type'];
    $price=$product['price'];
    $categories=$product['category'];
    $shipping=$product['shipping'];
    $description=$product['description'];
    $manifacturer=$product['manufacturer'];
    $image=$product['image'];

    
    $stmt=$conn->prepare("insert into produit values(?,?,?,?,?,?,?,?)");
    $stmt->execute(array($ref,$name,$type,$price,$shipping,$description,$manifacturer,$image));
   
    

    foreach($categories as $category){

        $id_category=$category['id'];
        $name_category=$category['name'];

        $stmt=$conn->query("select * from category where id_category='$id_category'");
        $rows=$stmt->fetch(PDO::FETCH_ASSOC);
      
        if(!$rows['id_category']){

        $stmt=$conn->prepare("insert into category values(?,?)");
        $stmt->execute(array($id_category,$name_category));


        }
       
        $stmt=$conn->prepare("insert into produit_category values(?,?)");
        $stmt->execute(array($ref,$id_category));
    

    }

        
        
       

    }

    



?>
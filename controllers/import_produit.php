<?php 

include("connexion.php");

<<<<<<< HEAD
// Importation des données JSON
$jsonFile = file_get_contents("products.json");
$products = json_decode($jsonFile, true);
try {

 // Set the PDO error mode to exception
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    foreach ($products as $product) {
        $ref = $product['ref'];
        $name = $product['name'];
        $type = $product['type'];
        $price = $product['price'];
        $categories = $product['category'];
        $shipping = $product['shipping'];
        $description = $product['description'];
        $manifacturer = $product['manufacturer'];
        $image = $product['image'];

          // Convert categories array to JSON string for storage
          $categories_json = json_encode($categories);
           // Ensure shipping is a valid decimal
        $shipping = is_numeric($shipping) ? $shipping : 0;

    // Prepare SQL statement with ON DUPLICATE KEY UPDATE clause
    $sql = "INSERT INTO produit (ref, name,type, price, shipping,description,manufacturer,image)
    VALUES (?,?,?,?,?,?,?,?)
    ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        type= VALUES(type), 
        price = VALUES(price),
        shipping= VALUES(shipping),
        description= VALUES(description),
        manufacturer= VALUES(manufacturer),
        image= VALUES(image)";
$stmt = $conn->prepare($sql);

// Insert each product
$stmt->execute(array($ref,$name,$type,$price,$shipping,$description,$manifacturer,$image));

// echo "Product inserted/updated successfully: ID " . $ref . "<br>";
    
        foreach ($categories as $category) {
            $id_category = $category['id'];
            $name_category = $category['name'];
    
            $stmt = $conn->prepare("SELECT * FROM category WHERE id_category = ?");
            if (!$stmt->execute(array($id_category))) {
                echo "Error fetching category: " . $stmt->errorInfo()[2];
                continue;
            }
    
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$rows) {
                $stmt = $conn->prepare("INSERT INTO category (id_category, name) VALUES (?, ?)");
                if (!$stmt->execute(array($id_category, $name_category))) {
                    echo "Error inserting category: " . $stmt->errorInfo()[2];
                    continue;
                }
            }
    
            $stmt = $conn->prepare("INSERT IGNORE INTO produit_category (ref, id_category) VALUES (?, ?)");
            if (!$stmt->execute(array($ref, $id_category))) {
                echo "Error inserting product category: " . $stmt->errorInfo()[2];
                continue;
            }
        }
    }
    
} catch (PDOException $e) {
    echo "Error inserting product: " . $e->getMessage() . "<br>";
}

// Close connection
$conn = null;




?>
=======

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
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd

<?php

include("connexion.php"); 





if($_POST['action']=='load_produit'){

    $page=isset($_POST['page']) ? $_POST['page'] : 0;

    $stmt=$conn->query("select * from produit limit 12 offset ".$page*12);
 
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;

    
    $results_per_page = 12;

<<<<<<< HEAD
    $stmtPagi=$conn->query("select count(ref) as total from produit");
    $rowsPagi=$stmtPagi->fetch(PDO::FETCH_ASSOC);
   
    $total_pages = ceil($rowsPagi["total"] / $results_per_page);
    // $data['page']=$total_pages;

    for ($i=1; $i<=$total_pages; $i++) { 
            
    $data['page']="<li class='page-item'><b><a class='page-link mx-2 text-danger' onclick='pagination($i-1)'>".$i."</a></b></li>"; 

    };

    
=======
    $stmt=$conn->query("select count(ref) as total from produit");
    $rows=$stmt->fetch(PDO::FETCH_ASSOC);
   
    $total_pages = ceil($rows["total"] / $results_per_page);
    
    for ($i=1; $i<=$total_pages; $i++) { 
               
       $data['page'].="<li class='page-item'><b><a class='page-link mx-2 text-danger' onclick='pagination($i-1)'>".$i."</a></b></li>"; 

      
        
    };

    
    
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
}




if($_POST['action']=='load_category'){

    
<<<<<<< HEAD
    $stmt=$conn->query("select c.name, c.id_category ,COUNT(pc.ref) num_produit 
    from category c,produit_category pc 
    WHERE c.id_category=pc.id_category 
    group by c.id_category 
    order by count(pc.ref) DESC 
    limit 8
    ");

    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data=$rows;
=======
$stmt=$conn->query("select c.name, c.id_category ,COUNT(pc.ref) num_produit 
from category c,produit_category pc 
WHERE c.id_category=pc.id_category 
group by c.id_category 
order by count(pc.ref) DESC 
limit 8
");

$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$data=$rows;
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd



}



if($_POST['action']=='click_category'){

<<<<<<< HEAD
    $cat_id=$_POST['id_category'];

    $stmt=$conn->query("select p.ref,p.name,p.price,p.image from produit p ,produit_category pc 
                where p.ref=pc.ref and id_category='$cat_id' limit 12");

    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
=======

$cat_id=$_POST['id_category'];


$stmt=$conn->query("select p.ref,p.name,p.prix,p.image from produit p ,produit_category pc 
              where p.ref=pc.ref and id_category='$cat_id' limit 12");

$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$data['produit']=$rows;
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd

    
    
}




if($_POST['action']=='asc'){

<<<<<<< HEAD
    $stmt=$conn->query("select * from produit order by price asc limit 12 offset 45");
=======
    $stmt=$conn->query("select * from produit order by prix asc limit 12 offset 45");
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
    
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
    
    
}



if($_POST['action']=='desc'){

<<<<<<< HEAD
    $stmt=$conn->query("select * from produit order by price desc limit 12 offset 25");
=======
    $stmt=$conn->query("select * from produit order by prix desc limit 12 offset 25");
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
    
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
    
    
}




if($_POST['action']=='search'){

    $name=$_POST['name'];
    $stmt=$conn->query("select * from produit where name like '%$name%' limit 12");
    
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
    
    
}

<<<<<<< HEAD
=======

>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
echo json_encode($data);

?>
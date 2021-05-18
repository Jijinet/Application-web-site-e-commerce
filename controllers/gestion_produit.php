<?php

include("connexion.php"); 





if($_POST['action']=='load_produit'){

    $page=isset($_POST['page']) ? $_POST['page'] : 0;

    $stmt=$conn->query("select * from produit limit 12 offset ".$page*12);
 
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;

    
    $results_per_page = 12;

    $stmt=$conn->query("select count(ref) as total from produit");
    $rows=$stmt->fetch(PDO::FETCH_ASSOC);
   
    $total_pages = ceil($rows["total"] / $results_per_page);
    
    for ($i=1; $i<=$total_pages; $i++) { 
               
       $data['page'].="<li class='page-item'><b><a class='page-link mx-2 text-danger' onclick='pagination($i-1)'>".$i."</a></b></li>"; 

      
        
    };

    
    
}




if($_POST['action']=='load_category'){

    
$stmt=$conn->query("select c.name, c.id_category ,COUNT(pc.ref) num_produit 
from category c,produit_category pc 
WHERE c.id_category=pc.id_category 
group by c.id_category 
order by count(pc.ref) DESC 
limit 8
");

$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$data=$rows;



}



if($_POST['action']=='click_category'){


$cat_id=$_POST['id_category'];


$stmt=$conn->query("select p.ref,p.name,p.prix,p.image from produit p ,produit_category pc 
              where p.ref=pc.ref and id_category='$cat_id' limit 12");

$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$data['produit']=$rows;

    
    
}




if($_POST['action']=='asc'){

    $stmt=$conn->query("select * from produit order by prix asc limit 12 offset 45");
    
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
    
    
}



if($_POST['action']=='desc'){

    $stmt=$conn->query("select * from produit order by prix desc limit 12 offset 25");
    
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
    
    
}




if($_POST['action']=='search'){

    $name=$_POST['name'];
    $stmt=$conn->query("select * from produit where name like '%$name%' limit 12");
    
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['produit']=$rows;
    
    
}


echo json_encode($data);

?>
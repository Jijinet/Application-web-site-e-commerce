<?php

include("connexion.php"); 

session_start();


$arr_produit = isset($_SESSION['infos_produit']) ? $_SESSION['infos_produit'] : array();

if ($_POST['count'] == "ok") {
            
    echo json_encode(count($_SESSION['infos_produit']));
  

}



else{


 if (isset($_POST['produit_ref'])){

    $newref=$_POST['produit_ref'];

    $new_order=array(

        $newref=>array(

            'name'=>$_POST['produit_name'],
            'prix'=>floatval($_POST['produit_prix']),
            'qte'=>floatval($_POST['produit_qte'])
        )
    );
         array_push($arr_produit,$new_order);
    
        $_SESSION['infos_produit']=$arr_produit;



}


echo json_encode($_SESSION['infos_produit']);
}


?>
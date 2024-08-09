<?php

include("connexion.php"); 

session_start();


$arr_produit = isset($_SESSION['infos_produit']) ? $_SESSION['infos_produit'] : array();
<<<<<<< HEAD
$data = array(); // Initialize the $data array


if ($_POST['action'] == "ok") {
    $data['count_produit']=count($_SESSION['infos_produit']);

    
}


if ($_POST['action'] == "add") {

    if (isset($_POST['produit_ref'])) {
        $newref = $_POST['produit_ref'];

        $new_order = array(
            'ref' => $_POST['produit_ref'],
            'name' => $_POST['produit_name'],
            'price' => floatval($_POST['produit_prix']),
            'qta' => floatval($_POST['produit_qte'])
        );

        // Add or update the product in the session array
        $arr_produit[$newref] = $new_order;
        $_SESSION['infos_produit'] = $arr_produit;

        $data['message'] = "Product added/updated successfully.";
    }

}

if ($_POST['action'] == "delete") {
    if (isset($_POST['produit_ref'])) {
        $ref = $_POST['produit_ref'];
        if (isset($arr_produit[$ref])) {
            // Remove the product from the session array
            unset($arr_produit[$ref]);
            $_SESSION['infos_produit'] = $arr_produit;

            $data['message'] = "Product deleted successfully.";
        } else {
            $data['error'] = "Product with ref $ref not found.";
        }
    }
}
   

if(isset($_POST["action"])=="load_card"){
    $data['infos_produit']=$_SESSION['infos_produit'];

}

echo json_encode($data);
=======

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

>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd

?>
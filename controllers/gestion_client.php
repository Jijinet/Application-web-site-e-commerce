<?php 

session_start();

include("connexion.php");

// $data= isset($_SESSION['username']) ? $_SESSION['username'] : array();
<<<<<<< HEAD
// Ensure $_POST['action'] is set before using it
$data = array();  // Initialize the $data array

$action = isset($_POST['action']) ? $_POST['action'] : '';

if($action=='register'){
=======

if($_POST['action']=='register'){
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd


    if(!empty($_POST['first']) && !empty($_POST['last']) 
    && !empty($_POST['email']) && !empty($_POST['password']) 
    && !empty($_POST['adresse']) && !empty($_POST['tel']) && !empty($_POST['birth'])  ){

        $first=$_POST['first'];
        $last=$_POST['last'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $adresse=$_POST['adresse'];
        $tel=$_POST['tel'];
        $birth=$_POST['birth'];
       
    }
   
 
    try{

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $stmt=$conn->prepare("insert into client values(?,?,?,?,?,?,?,?)");
    $stmt->execute(array(null,$first,$last,$email,$password,$adresse,$tel,$birth));
        
    if($stmt){
        $msg="Vous avez inscrit avec succée";
    }

    
    }
    catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

    $data['msg']=$msg;
    
}
<<<<<<< HEAD



    if($action=='login'){
=======
    
    

    if($_POST['action']=='login'){
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
      

        if(!empty($_POST['email'] && !empty($_POST['pass']))){
            
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            
            $stmt=$conn->query("select * from client where email='$email' and password='$pass'");
            $rows=$stmt->fetch(PDO::FETCH_ASSOC);

            
          
            if(!empty($rows['email']) && !empty($rows['password'])){

<<<<<<< HEAD
                $_SESSION['username']=$rows['first'];
=======
                $_SESSION['username']=$rows['firstname'];
               
               if(isset($_SESSION['username'])){
                   
                $data['set']="ok";
                $data['username']=$_SESSION['username'];
                $msg="<p class='mt-4 text-success text-center login_success'>Vous êtes authetifier avec succée!</p>";           
                $data['msg']=$msg;
    
    
               }
          
           
           
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
                      
            }
            else{
                $msg="<p class='mt-4 text-danger login_msg'>Vous êtes pas inscrit!</p>";           
                $data['msg']=$msg;
            }
            
        }
        else{
            $msg="<p class='mt-4 text-danger login_msg'>Chmanp obligatoire!</p>";         
            $data['msg']=$msg;

        }

            
        
    }

<<<<<<< HEAD
    elseif ($action== 'logout') {
        // Unset only the 'username' session variable
        unset($_SESSION['username']);
        
        $data['msg'] = "Vous êtes déconnecté.";
    }

    elseif($action=='verify_client'){
       
        if(isset($_SESSION['username'])){
             
                
            $data['set']="ok";
            $data['username']=$_SESSION['username'];
            $msg="<p class='mt-4 text-success text-center login_success'>Vous êtes authetifier avec succée!</p>";           
            $data['msg']=$msg;

           }
           

    }

    elseif($action=='validate'){
=======


        
    


    if($_POST['action']=='logout'){
        
        unset($_SESSION['username']);

    }


    if($_POST['action']=='verify_client'){
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
       
        if(isset($_SESSION['username'])){
             
            $msg="<p class='mt-4 text-success checkout_msg'>Votre Commande est validé!</p>";
            $data['msg']=$msg;
<<<<<<< HEAD
            unset($_SESSION['infos_produit']);
           }
           else{
           
            $msg="<p class='mt-4 text-danger checkout_msg'>Vous etes pas authentifier!</p>";           
=======
           }
           else{
           
            $msg="<p class='mt-4 text-danger checkout_msg'>Vous etes pas authentifier! <a href='#' class='text-primary text-center'>Sign_in</a></p>";           
>>>>>>> b13c5c05b233a0dc126a151d38b4f2eab9f63ebd
            $data['msg']=$msg;

           }
           

    }

    
    echo json_encode($data);


?>
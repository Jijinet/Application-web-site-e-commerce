<?php 
session_start();  

include("controllers/connexion.php");  
include("controllers/import_produit.php"); 
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/logo.png" type="image/png" sizes="16x16">
    <title>ElectroMarkt</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  
</head>

<body>

    <!-- NAVBAR  -->
    <div class="container-fluid">

        <div class="row d-flex align-items-center justify-content-between border-bottom">


            <div class="col-12 col-lg-2">
                <a class="navbar-brand" rel="icon" href="index.php">
                    <img src="assets/logo.png"  class="ml-4" alt=""></a>
            </div>
            <div class="col-12 col-lg-6 align-self-center search-box">
                <div class="input-group">
									<input type="text" placeholder="search" class="form-control w-75 search-item" aria-label="search" aria-describedby="button-addon2">
									<div class="input-group-btn"><button type="button" class="btn btn-danger text-uppercase font-weight-normal btn_search">search</button></div>
								</div>
            </div>
            <div class="col-12 col-lg-3 d-flex">

            <div class="dropdown show">
              <div class="user_div">
              <a class="dropdown-toggle account ml-n4 display-5 username" href="#"  role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item drop_login" data-toggle="modal" data-target="#loginModal" >Login</a>
                    <a class="dropdown-item drop_register" data-toggle="modal" data-target="#registerModal" >Register</a>
                </div>
            </div>
          </div>
                <!-- Button trigger cart modal -->
                <a href="#" data-toggle="modal" class="basket" data-target=".bd-example-modal-lg">
                    <i class="fas fa-shopping-basket text-dark ml-4"></i>                   
                    <span class="badge badge-danger badge-pill ml-2 num_produit">0</span>
                </a>
            </div>


        </div>

        <!-- Login Modal -->

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form_inputs">
                      <div class="form-group">
                        <label for="email_log" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" id="email_log" value="" required>
                      </div>
                      <div class="form-group">
                        <label for="pass" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" value="" id="pass" required>
                      </div>
                    </div>
                    <p></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success login" >Login</button>
                </div>
                </form>
              </div>
            </div>
          </div>

         <!-- Register Modal -->
          <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel" >Register</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="first" class="col-form-label">Firstname</label>
                      <input type="text" class="form-control first"  id="first" required>
                    </div>
                    <div class="form-group">
                      <label for="last" class="col-form-label">Lastname</label>
                      <input type="text" class="form-control"  id="last" required>
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-form-label">Email</label>
                      <input type="text" class="form-control"  id="email" required>
                    </div>
                    <div class="form-group">
                      <label for="email" class="col-form-label">Password</label>
                      <input type="password" class="form-control"  id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse" class="col-form-label">Adresse</label>
                        <textarea class="form-control" id="adresse" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tel" class="col-form-label">Phone number</label>
                        <input type="text" class="form-control"  id="tel" required>
                    </div>
                    <div class="form-group">
                        <label for="birth" class="col-form-label">Date of birth</label>
                        <input type="date" class="form-control" id="birth" required>
                    </div>
                  
                  <p class="mt-4 text-success register_msg"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success register">Register</button>
                 
                </div>
                </form>
              </div>
            </div>
          </div>
        


        <!-- Cart Modal -->

        <div class="modal fade bd-example-modal-lg p-4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shop_card">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">Card<span class="badge badge-primary badge-pill ml-2">2</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <table class="table table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col">Produit</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Quantity</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                       
                        </tbody>
                        <tfoot>
                        <tr class="border-0">
                        <th scope="col">Prix total</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col" class="total"></th>
                        </tr> 
                        </tfoot>
                    </table>
                    <p class="py-5 text-center font-weight-bold empty">Your card is empty!</p>
                   
                    <div class="modal-footer d-flex justify-content-between">
                       <p class='checkout_msg'></p>
                        <div>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-success valider" onclick="checkout();">Valider</button>
                        </div>
                       
                    </div>
                </div>

            </div>
        </div>



    </div>

   

    <div class="container-fluid">
      <div class="row">
      <div class="col-12 col-lg-7 py-4  d-flex align-items-center justify-content-center">

      <a href="#" class="text-danger asc mr-3" data-toggle="tooltip" data-placement="top" title="Decroissant"><i class="fas fa-sort-amount-up-alt"></i></a>
      <a href="#" class="text-danger desc"><i class="fas fa-sort-amount-down" data-toggle="tooltip" data-placement="top" title="Croissant"></i></a>

      </div>
      </div>
        <div class="row ml-2">
            <div class="col-12 col-lg-3">
                <div class="list-group w-100 category_container">

                    <a class="list-group-item list-group-item-action bg-danger text-white" id="list-home-list" href="#list-home"
                        role="tab" aria-controls="home"><i class="fas fa-bars pr-3"></i>Category</a>
                
                </div>
            </div>


        <div class="col-12 col-lg-9">
            <div class="container">
                <div class="row produit_container">
             
                </div>

            </div>
        </div>
        </div>
    </div>


    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-9 d-flex align-items-center justify-content-center mt-3">
          <nav aria-label="...">
            <ul class="pagination pagination-sm page_pagination ">
            </ul>
          </nav>
        </div>
      </div>
    </div>



    <footer class="mt-5">
        <div class="card mt-5">
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <p class="font-weight-light text-secondary text-center display-5">© 2021,ElectroMarket</p>
              </blockquote>
            </div>
          </div>
    </footer>

                      


    <script src="https://kit.fontawesome.com/eeae5646a1.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    

    <script src="assets/js/script.js"></script>

</body>

</html>
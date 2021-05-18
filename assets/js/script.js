

$(document).ready(function(){
    
        var dataObj={};
    
        $('.shop_card .empty').hide();
   


$('.login').on('click',function(e){
    var dataObj={

        action:'login',
        email:$('#email_log').val(),
        pass:$('#pass').val()
    
    }
   
    login(dataObj);

});

$('.basket').on('click',function(e){

    $('.checkout_msg').html('');
    calculeTotalPrice()

})

calculeTotalPrice();

$(document).on('change','.p_qte',function(e){

    calculeTotalPrice();

});




$(document).on('click','.btn_search', function(){
    $('.produit_container').empty();
    
    var dataObj = {
        action:'search',
        name:$('.search-item').val()
    };

    $.ajax({
        type: 'POST',
        url: 'controllers/gestion_produit.php',
        data: dataObj,
        dataType: 'json',
        async: true,
        success: function (data) {

            load_produit(data)
        }
    });
});

$(document).on('keyup', '.search-item', function(){
    $('.produit_container').empty();
    $('.btn_search').trigger('click');
});



count_el();
selectProduit();
filter_price();
register();
first_produit();
load_category();
click_category();
login();



});



function load_produit(data){
    $('.produit_container').empty();
    $(data.produit).each(function(i,n){
        
        $('.produit_container').append(`<div class="col-sm-4 col-lg-3 mb-4 col-produit">
                  
        <div class="card border_thick">
            <img class="card-img-top produit_image"
                src="${n.image}"
                alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title title_produit">${n.name}</h5>
                <input type="text" class="title_produit" id="title_produit_${n.ref}" value="${n.name}" hidden >
                <input type="text" class="id_produit" id="id_produit_${n.ref}" value="${n.ref}" hidden >
            </div>
          <div class="card-footer d-flex justify-content-between card_details">
                <p value="">${n.prix}</p>
                <input type="text" class="prix_produit" id="prix_produit_${n.ref}" value="${n.prix}" hidden>
                <ul class="pagination pagination-sm d-flex justify-content-center"> 
                <li class="page-item position-absolute mr-3 check_produit"><a class="page-link"><i class="fas fa-check text-danger"></i></a></li> 
                <li class="page-item position-absolute mr-3 add_produit" onclick="selectProduit(this,${n.ref})"><a class="page-link" ><i class="fas fa-plus text-danger"></i></a></li>                                                         
                </ul>
    
          </div>
        </div>
       
    </div>`);


    })
    $('.page_pagination').empty(); 
    $('.page_pagination').append(data.page);   

 
}


function first_produit(){

    var dataObj={
        action:'load_produit'
    }


    $.ajax({
        method:'POST',
        url:'controllers/gestion_produit.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){

            load_produit(data)
           
      

    }
    

});



}





function load_category(){

    var dataObj={
        action:'load_category',
    } 

    $.ajax({
        method:'POST',
        url:'controllers/gestion_produit.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){
          $(data).each(function(i,n){

            $('.category_container').append(`<a class="list-group-item list-group-item-action category_name" id="list-profile-list" href="#list-profile" role="tab" aria-controls="profile">${n.name}<span class="badge badge-danger badge-pill ml-2 num_produit">${n.num_produit}</span><input class="id_category" value="${n.id_category}" hidden ></a>`);
           
            
          })

    }
    

    });

}


function click_category(){
console.log("1")
    $(document).on("click",".category_name", function(e){
        console.log("2")
        $('.produit_container').empty();
            var dataObj={
                action:'click_category',
                id_category:$(".id_category",this).val()
            } 

        $.ajax({
            url:'controllers/gestion_produit.php',
            method:'POST',
            data:dataObj,
            dataType:'json',
            async:true,
            success:function(data){
                
                load_produit(data)
                console.log("3")
          }
    
        })
      
        
    });
}





function selectProduit(e,id){

    $(e).hide();
    $(e).prev().css('display','block');



    var qte=1;
    var p_name="";
    var p_ref="";
    var p_prix="";


    p_name=$('#title_produit_'+id).val();
    p_ref=$('#id_produit_'+id).val();
    p_prix=$('#prix_produit_'+id).val();


    
    calculeTotalPrice();

    var dataObj={
            action:"add",
            produit_ref:p_ref,
            produit_name:p_name,
            produit_prix:p_prix,
            produit_qte:qte

    }
   
        load_shop_card(dataObj);
        count_el();

}


function calculeTotalPrice(){
    
    var  totalPrice = 0;
    $('.shop_card tbody tr').each(function(e){
        var price = $(".p_prix",this).html();
        var quantity = $(".p_qte",this).val();
        console.log(price)
        console.log(quantity)
         totalPrice +=Number(price*quantity);
    });
    $('.total').html('$'+ Number(totalPrice));
  
}





function count_el(){



        var dataObj={

            count:'ok'
        
        }
    
        $.ajax({
            method:'POST',
            url:'controllers/gestion_shop_card.php',
            data:dataObj,
            dataType:'json',
            async:true,
            success:function(data){

                $('.basket .num_produit').html(data);
                console.log(data)
                
            }
          
    });

    

}


function checkout(){
    $('.checkout_msg').html('');
    var dataObj={

        action:'verify_client'
    
    }

    $.ajax({
        method:'POST',
        url:'controllers/gestion_client.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){

            $('.checkout_msg').html(data.msg);
            $('username').html(data.username)
        }
      
});



}



function remove_el(e,ref){


    $('#id_'+ref).remove();
        var dataObj={

            produit_ref:$('.p_ref',this).val(),
            action:'delete'
            
           
        
        }
    
        $.ajax({
            method:'POST',
            url:'controllers/gestion_shop_card.php',
            data:dataObj,
            dataType:'json',
            async:true,
            success:function(data){
                console.log(data);
            }
          
    });
    calculeTotalPrice();

    

}





function load_shop_card(dataObj){


    $.ajax({

        method:'POST',
        url:'controllers/gestion_shop_card.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){
            $('.shop_card tbody').empty();
          $.map(data,function(d){
            $.each(d,function(i,n){

                $('.shop_card tbody').append(`<tr id="id_${n.ref}" class="align-self-center" class="card_element">
                <th scope="row" class="w-50 p_name">${n['name']}</th> 
                <input class="p_ref" value="${n.ref}" hidden>
                <td class="p_prix" >${n.prix}</td>
                <input type="text" class="border rounded w-25 p_price" value="${n.prix}" hidden>
                <td><input type="number" name='qte' class="border rounded w-25 p_qte" name='quantity' value="${n.qte}" min="1"></td>
                <td><button type="button" class="btn btn-danger btn_remove" onclick="remove_el(this,${n.ref});">Remove</button></td>
                </tr>`);

            })
            
          })

     }
      
    });


}





function filter_price(){

        $(".asc").on("click", function(e){

            $('.produit_container').empty();

             var dataObj={
                action:'asc'
                
            } 



        $.ajax({
        method:'POST',
        url:'controllers/gestion_produit.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){
            load_produit(data)

    }
    

});


        

    })


        $(".desc").on("click", function(e){

            $('.produit_container').empty();

             var dataObj={
                action:'desc'
                
            } 



        $.ajax({
        method:'POST',
        url:'controllers/gestion_produit.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){

            load_produit(data)

    }
    

});
        

    })

}




function register(){


    $('.register').on('click',function(e){

        var dataObj={
            action:'register',
            first:$('#first').val(),
            last:$('#last').val(),
            email:$('#email').val(),
            password:$('#password').val(),
            adresse:$('#adresse').val(),
            tel:$('#tel').val(),
            birth:$('#birth').val()
        }

    $.ajax({
        method:'POST',
        url:'controllers/gestion_client.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){

         $('.register_msg').html(data.msg)
         $('#registerModal form input,textarea').val('');        


    }
    

    });

})

}



function login(dataObj){

    $.ajax({
        method:'POST',
        url:'controllers/gestion_client.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){
            
                $('#loginModal form p').html(data.msg)
                
                
                if(data.set=='ok'){
                    $('.user_div').html('')
                    $('.login').hide()
                    $('#loginModal .form_inputs').hide()
                    $('.user_div').append(`<a class="dropdown-toggle account ml-n4 display-5 username" role="button" href="#" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ${data.username}
                </a>
                <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item logout" onclick="logout()" href="#">Logout</a>
                </div>`)
                 
                }
                else{
                    
                    $('.user_div').html('')
                    $('.login').show()
                    $('#loginModal .form_inputs').show()
                    $('.user_div').append(`<a class="dropdown-toggle account ml-n4 display-5 username" role="button" href="#" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" data-toggle="modal" data-target="#loginModal"  href="#">Login</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#registerModal"  href="#">Register</a>
                </div>`)
                }
            
    
        }
    
    
    });

}






function logout(dataObj){

    var dataObj={
        action:'logout'
    }
   
    $.ajax({
        method:'POST',
        url:'controllers/gestion_client.php',
        data:dataObj,
        dataType:'json',
        async:true,
        success:function(data){
                    $('#loginModal form p').html('')
                    $('#loginModal .form_inputs').show()
                    $('.login').show()
                        $('.user_div').html('')
                        $('.user_div').append(`<a class="dropdown-toggle account ml-n4 display-5 username" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" data-toggle="modal" data-target="#loginModal"  href="#">Login</a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#registerModal"  href="#">Register</a>
                    </div>`)
                    
                

        }

    });

}


function pagination(page){

    var dataObj={
        action:'load_produit',
        page:page
    }

$.ajax({
    method:'POST',
    url:'controllers/gestion_produit.php',
    data:dataObj,
    dataType:'json',
    async:true,
    success:function(data){

     load_produit(data)   


}


});

}


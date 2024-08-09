$(document).ready(function () {
  var dataObj = {};

  $(".shop_card .empty").hide();

  $(".login").on("click", function (e) {
    var dataObj = {
      action: "login",
      email: $("#email_log").val(),
      pass: $("#pass").val(),
    };
    $.ajax({
      method: "POST",
      url: "controllers/gestion_client.php",
      data: dataObj,
      dataType: "json",
      async: true,
      success: function (data) {
        verifyClient();
      },
    });
  });

  $(".basket").on("click", function (e) {
    $(".checkout_msg").html("");
    calculTotalPrice();
  });

  calculTotalPrice();

  $(document).on("change", ".p_qte", function (e) {
    calculTotalPrice();
  });

  $(document).on("click", ".btn_search", function () {
    $(".produit_container").empty();

    var dataObj = {
      action: "search",
      name: $(".search-item").val(),
    };

    $.ajax({
      type: "POST",
      url: "controllers/gestion_produit.php",
      data: dataObj,
      dataType: "json",
      async: true,
      success: function (data) {
        load_produit(data);
      },
    });
  });

  $(document).on("keyup", ".search-item", function () {
    $(".produit_container").empty();
    $(".btn_search").trigger("click");
  });

  first_produit();
  count_el();
  load_shop_card();
  filter_price();
  verifyClient();
  register();
  load_category();
  click_category();
  // pagination();
});

function load_produit(data) {
  $(".produit_container").empty();
  $(data.produit).each(function (i, n) {
    $(
      ".produit_container"
    ).append(`<div class="col-sm-4 col-lg-3 mb-4 col-produit">
                  
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
                <p value="">${n.price}</p>
                <input type="text" class="prix_produit" id="prix_produit_${n.ref}" value="${n.price}" hidden>
                <ul class="pagination pagination-sm d-flex justify-content-center"> 
                <li class="page-item position-absolute mr-3 check_produit"><a class="page-link"><i class="fas fa-check text-danger"></i></a></li> 
                <li class="page-item position-absolute mr-3 add_produit" onclick="selectProduit(this,${n.ref})"><a class="page-link" ><i class="fas fa-plus text-danger"></i></a></li>                                                         
                </ul>
          </div>
        </div>
       
    </div>`);
  });
  // $("#page_pagination").empty();
  // $("#page_pagination").append(data.page);

  //  $(".page_pagination").empty();
  // $(data.produit).each(function (i, n) {
  // $(".page_pagination").append(`<li class='page-item'><b><a class='page-link mx-2 text-danger' onclick='pagination(${i}-1)'>".${i}."</a></b></li>`);
  // })
}

function first_produit() {
  console.log("1");

  var dataObj = {
    action: "load_produit",
  };
  console.log("2");

  $.ajax({
    method: "POST",
    url: "controllers/gestion_produit.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      load_produit(data);
    },
  });
}

function load_category() {
  var dataObj = {
    action: "load_category",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_produit.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      $(data).each(function (i, n) {
        $(".category_container").append(
          `<a class="list-group-item list-group-item-action category_name" id="list-profile-list" href="#list-profile" role="tab" aria-controls="profile">${n.name}<span class="badge badge-danger badge-pill ml-2 num_produit">${n.num_produit}</span><input class="id_category" value="${n.id_category}" hidden ></a>`
        );
      });
    },
  });
}

function click_category() {
  $(document).on("click", ".category_name", function (e) {
    $(".produit_container").empty();
    var dataObj = {
      action: "click_category",
      id_category: $(".id_category", this).val(),
    };

    $.ajax({
      url: "controllers/gestion_produit.php",
      method: "POST",
      data: dataObj,
      dataType: "json",
      async: true,
      success: function (data) {
        load_produit(data);
      },
    });
  });
}

function selectProduit(e, id) {
  $(e).hide();
  $(e).prev().css("display", "block");

  var qte = 1;
  var p_name = "";
  var p_ref = "";
  var p_prix = "";

  p_name = $("#title_produit_" + id).val();
  p_ref = $("#id_produit_" + id).val();
  p_prix = $("#prix_produit_" + id).val();

  var dataObj = {
    action: "add",
    produit_ref: p_ref,
    produit_name: p_name,
    produit_prix: p_prix,
    produit_qte: qte,
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_shop_card.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      fill_shop_card(data);
      count_el();
  calculTotalPrice();
    },
  });
  
}

function fill_shop_card(data) {
  $(".shop_card tbody").empty();
  $.each(data.infos_produit, function (i, n) {
    $(
      ".shop_card tbody"
    ).append(`<tr id="id_${n.ref}" class="align-self-center" class="card_element">
            <th scope="row" class="w-50 p_name">${n.name}</th> 
            <input class="p_ref" value="${n.ref}" hidden>
            <td class="p_prix" >${n.price}</td>
            <input type="text" class="border rounded w-25 p_price" value="${n.price}" hidden>
            <td><input type="number" name='qte' class="border rounded w-25 p_qte" name='quantity' value="${n.qta}" min="1"></td>
            <td><button type="button" class="btn btn-danger btn_remove" onclick="remove_el(this,${n.ref});">Remove</button></td>
            </tr>`);
  });
}

function load_shop_card() {
  var dataObj = {
    action: "load_card",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_shop_card.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      fill_shop_card(data);
    },
  });
}

function calculTotalPrice() {
  var totalPrice = 0;
  $(".shop_card tbody tr").each(function (e) {
    var price = $(".p_prix", this).html();
    var quantity = $(".p_qte", this).val();
    console.log(price);
    console.log(quantity);
    totalPrice += Number(price * quantity);
    console.log(totalPrice);
  });
  $(".total").html("$" + Number(totalPrice));
}

function count_el() {
  var dataObj = {
    action: "ok",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_shop_card.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      $(".basket .num_produit").html(data.count_produit);
      if (data.count_produit == 0) {
        $(".modal-footer .valider").hide();
      } else {
        $(".modal-footer .valider").show();
      }
    },
  });
}

function checkout() {
  $(".checkout_msg").html("");
  var dataObj = {
    action: "validate",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_client.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      $(".checkout_msg").html(data.msg);
      $("username").html(data.username);
      if (data.username) {
        $(".modal-footer .valider").hide();
        $(".basket .num_produit").html(0);
      }
      load_shop_card();
      calculTotalPrice();

    },
  });
  $(".shop_card tbody").empty();
}

function verifyClient() {
  $(".checkout_msg").html("");
  var dataObj = {
    action: "verify_client",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_client.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      if (data.set == "ok") {
        $("#loginModal form p").html(data.msg);

        $(".user_div").html("");
        $(".login").hide();
        $("#loginModal .form_inputs").hide();
        $(".user_div")
          .append(`<a class="dropdown-toggle account ml-n4 display-5 username" role="button" href="#" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ${data.username}
                </a>
                <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item logout" onclick="logout()" href="#">Logout</a>
                </div>`);
      } else {
        $("#loginModal form p").html(data.msg);

        $(".user_div").html("");
        $(".login").show();
        $("#loginModal .form_inputs").show();
        $(".user_div")
          .append(`<a class="dropdown-toggle account ml-n4 display-5 username" href="#"  role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item drop_login" data-toggle="modal" data-target="#loginModal" >Login</a>
                    <a class="dropdown-item drop_register" data-toggle="modal" data-target="#registerModal" >Register</a>
                </div>`);
      }
    },
  });
}

function remove_el(e, ref) {
  $("#id_" + ref).remove();
  var dataObj = {
    produit_ref: ref,
    action: "delete",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_shop_card.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      fill_shop_card(data);
      calculTotalPrice();
      count_el();
    },
  });

  var first = $(`.produit_container .card-footer #prix_produit_${ref}`)
    .next()
    .children()
    .first();
  var last = $(`.produit_container .card-footer #prix_produit_${ref}`)
    .next()
    .children()
    .last();

  first.hide();
  last.css("display", "block");
 
}

function filter_price() {
  $(".asc").on("click", function (e) {
    $(".produit_container").empty();

    var dataObj = {
      action: "asc",
    };

    $.ajax({
      method: "POST",
      url: "controllers/gestion_produit.php",
      data: dataObj,
      dataType: "json",
      async: true,
      success: function (data) {
        load_produit(data);
      },
    });
  });

  $(".desc").on("click", function (e) {
    $(".produit_container").empty();

    var dataObj = {
      action: "desc",
    };

    $.ajax({
      method: "POST",
      url: "controllers/gestion_produit.php",
      data: dataObj,
      dataType: "json",
      async: true,
      success: function (data) {
        load_produit(data);
      },
    });
  });
}

function register() {
  $(".register").on("click", function (e) {
    var dataObj = {
      action: "register",
      first: $("#first").val(),
      last: $("#last").val(),
      email: $("#email").val(),
      password: $("#password").val(),
      adresse: $("#adresse").val(),
      tel: $("#tel").val(),
      birth: $("#birth").val(),
    };

    $.ajax({
      method: "POST",
      url: "controllers/gestion_client.php",
      data: dataObj,
      dataType: "json",
      async: true,
      success: function (data) {
        $(".register_msg").html(data.msg);
        $("#registerModal form input,textarea").val("");
      },
    });
  });
}

function logout(dataObj) {
  var dataObj = {
    action: "logout",
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_client.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      $("#loginModal form p").html("");
      $("#loginModal .form_inputs").show();
      $(".login").show();
      $(".user_div").html("");
      $(".user_div")
        .append(`<a class="dropdown-toggle account ml-n4 display-5 username" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu account_menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" data-toggle="modal" data-target="#loginModal"  href="#">Login</a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#registerModal"  href="#">Register</a>
                    </div>`);
    },
  });
}

function pagination(page) {
  var dataObj = {
    action: "load_produit",
    page: page,
  };

  $.ajax({
    method: "POST",
    url: "controllers/gestion_produit.php",
    data: dataObj,
    dataType: "json",
    async: true,
    success: function (data) {
      load_produit(data);
    },
  });
}

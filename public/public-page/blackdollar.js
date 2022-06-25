
/**
 * initialize tooltip
 */
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});


/**
 * Active Links
 */
$('#main_menu_popup ul li a[href="'+window.location.pathname+'"]').parent().addClass('selected');

/*
 * When buy product button is clicked
 *
 */
$(".buy-product").click(function(event){
    event.preventDefault();
    var productid = $(this).attr("data-id");
    var productprice = parseFloat($(this).attr("data-price"));
    if(authenticated){
        if(productprice > 0){
            showCardPaymentForm({
                buttonClass: "submit-button",
                callback: "stripeToken('buyproduct("+productid+", response.id)')"
            });
            $(".payment-modal #amount").html('Your amout due today: <strong>$'+productprice+'</strong>');
        }else{
            buyproduct(productid, 'NULL');
        }
    }else{
        $("#createaccount").modal("show");
    }
});

/*
 * Vote for an applicant
 *
 */
$(".vote-now").click(function(event){
    event.preventDefault();
    if(authenticated){
        var votes = parseInt($(this).attr("data-votes"));
        if($(this).hasClass("voted")){
            votes = votes - 1;
            $(this).removeClass("voted");
        }else{
            votes = votes + 1;
            $(this).addClass("voted");
        }
        $(this).find(".votes").text(votes);
        $(this).attr("data-votes", votes);
        var applicationid = $(this).attr("data-id");
        server({ 
            url: voteUrl,
            data: {
                "applicationid": applicationid
            },
            loader: false
        });
    }else{
        $("#createaccount").modal("show");
    }

});

/*
 * Appoint winner
 *
 */
$(".appoint-winner").click(function(event){
    event.preventDefault();
    $("input[name=winner]").val($(this).attr("data-id"));
    $("#appointwinner").modal("show");
});

/*
 * Add listing button
 *
 */
$(".add-listing").click(function(event){
    event.preventDefault();
    if(authenticated){
        $("#addlisting").modal("show");
    }else{
        $("#createaccount").modal("show");
    }
});

/*
 * When buy product button is clicked
 *
 */
$(".enroll-now").click(function(event){
    event.preventDefault();
    if(authenticated){
        var courseid = $(this).attr("data-id");
        var price = parseFloat($(this).attr("data-price"));
        var gyftid = $(this).attr("data-gyft")
        console.log('gyft',gyftid)

        if($(this).hasClass("masterclass")){
           classenroll(courseid,gyftid);
        }else if(price > 0){
            showCardPaymentForm({
                buttonClass: "submit-button",
                callback: "stripeToken('enroll("+courseid+", response.id,"+gyftid+")')"
            });
        }else{
            enroll(courseid, 'token', gyftid);
        }
    }else{
        $(".login-modal").show();
        $("#createaccount").modal("show");
    }
});
 
 
/*
 * Enroll to a class
 */
 function classenroll(courseid,gyftid){
    showLoader();
    server({ 
        url: classenrollUrl,
        data: {
            "courseid": courseid,
            "gyftid":gyftid
        },
        loader: true
    });
 }
 
 
/*
 * Buy course
 */
 function enroll(courseid, token,gyftid){
    showLoader();
    server({ 
        url: buycourseUrl,
        data: {
           "courseid": courseid,
            "token": token,
            "gyftid":gyftid
        },
        loader: true
    });
 }
 
 
/*
 * Buy product
 */
 function buyproduct(productid, token){
    showLoader();
    server({ 
        url: buyproductUrl,
        data: {
            "productid": productid,
            "token": token
        },
        loader: true
    });
 }


 function reedem(userId,courseId,gyftId){
    
   
    showLoader();
    $.ajax({
        url: reedemUrl,
        type: "POST",
        data:  {
            "userId":userId,
            "courseId":courseId,
            "gyftId": gyftId
        },
        success: function (response) {
           hideLoader();
            if(response){
                var res = JSON.parse(response);
                if(res.msg == 'success'){
                    toastr.success('success', "Gyft Card Reedemed !");

                    setTimeout(function(){ location.reload(); }, 3000);

                }else{
                    toastr.error('error', "Oops!");
                }
            }    
        },
        error: function (xhr, status, error) {
            hideLoader();
            toastr.error(error, "Oops!");
        }
    });

}

/*
 * When buy product button is clicked
 *
 */
$(".book-office").click(function(event){
    event.preventDefault();
    var officespaceid = $(this).attr("data-id");
    if(authenticated){
        $("#officebooking").modal("show");
    }else{
        $("#createaccount").modal("show");
    }
});

/*
 * launch booking payment
 *
 */

 $(".booking-payment").click(function(event){
    event.preventDefault();
    $(".booking-form").parsley().validate();
        var item_code = $("input[name=credit_check]").val();
        var name = $("input[name=name]").val();
         var price = $("input[name=price]").val();
        var officespaceid = $("input[name=officespaceid]").val();
        var token = $("input[name=token]").val();
        var booking_date = $("input[name=booking_date]").val();
        var booking_time = $("input[name=booking_time]").val();
     
          var credit = $("input[name=credit_point]").val();
          var total= price - credit;
            
    if (($(".booking-form").parsley().isValid())) {
     if(  $('input[name="credit_check"]').is(':checked') && total=='0' ||  credit > price ) {
       showLoader();
    server({ 
        url: boorking,
        data: {
            "credit":credit,
            "name":name,
            "price":price,
            "item_code":item_code,
            "officespaceid":officespaceid,
            "booking_date":booking_date,
            "booking_time":booking_time
            
        },
        loader: true
    });
        }
       else{
      
            swal({
            title: "Heads-up!",
            text: "We'll take your card information but you will not be charged until the booking is confirmed.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e53b24",
            confirmButtonText: "Proceed!",
            closeOnConfirm: true
        }, function() {
            showCardPaymentForm({
                buttonClass: "submit-button",
                callback: "stripeToken('bookoffice(response.id)')"
            });
        });
       }
    }
});
 
/*
 * Book Office
 */
 function bookoffice(token){
    $("input[name=token]").val(token);
    $(".booking-form").submit();
 }

/*
 * get stripe token
 */
 function stripeToken(callback){
    showLoader();
    var $form = $(".card-payment-form");
    // Reset the token first
    Stripe.card.createToken($form, function(status, response) {
    if (response.error) {
        hideLoader();
        toastr.clear();
        toastr.error(response.error.message, "Oops!", {
            closeButton: true
        });
        return false;
    } else {
        hideLoader();
        eval(callback);
    }
    });
 }


/*
 * Choose swag option
 */
$(".swag-option").click(function(event){
    event.preventDefault();
    $("input[name=swag_name]").val($(this).attr("swag-title"));
    $("input[name=image_url]").val($(this).attr("swag-url"));
    $("#swagmodal").modal("show");
});


/*
 * submitted filter form
 */
$(".filter-form").submit(function(event){
    event.preventDefault();
    showLoader();
    $(".pagify-pagination").remove();
    if($("input[name=price]").val() !== ""){
       // $(".booking-list").html('<div class="loader-box"><div class="circle-loader"></div></div>');
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (response) {
                $(".booking-list").html(response);
                $(".pagify-parent").pagify(10, ".pagify-child");
                hideLoader();
            },
            error: function (xhr, status, error) {
                hideLoader();
                toastr.error(error, "Oops!");
            }
        });
    }
    
});

/*
 * submit filter form
 */
function startFilter(){
    $(".filter-form").submit()
}

/*
 * load More Pins
 */
function loadMorePins(lastPin){
    showLoader();
    $.ajax({
        url: loadPinsUrl,
        type: "POST",
        data: { "lastpin": lastPin },
        success: function (response) {
            $(".container-masonry").append(response);
            hideLoader();
        },
        error: function (xhr, status, error) {
            hideLoader();
            toastr.error(error, "Oops!");
        }
    });
}


/*
 * view teemill product
 */
$(".teemill-form").submit(function(event){
    event.preventDefault();
    $(this).parsley().validate();
    if (($(this).parsley().isValid())) {
        showLoader();
        var item_code = $("select[name=item_code]").val();
        var image_url = $("input[name=image_url]").val();
        var product_name = $("input[name=swag_name]").val();
        $.get("https://teemill.co.uk/api-access-point/?api_key="+teemilApiKey+"&item_code="+item_code+"&product_name="+product_name+"&colour=White&image_url="+image_url, function(data, status){
        //   hideLoader();
          redirect(data);
        });
    }
});


/*
 * view teemill product
 */
$(document).on("click", ".next-step", function(event){
    event.preventDefault();
    var validateSec = $(this).attr("validate");
    var nextSec = $(this).attr("href");
    $(validateSec).parsley().validate();
    if (($(validateSec).parsley().isValid())) {
        $(".tab-pane").removeClass("in active show");
        $(nextSec).addClass("in active show");
    }
});


/*
 * view teemill product
 */
$(document).on("click", ".back-step", function(event){
    event.preventDefault();
    var nextSec = $(this).attr("href");
    $(".tab-pane").removeClass("in active show");
    $(nextSec).addClass("in active show");
});



/*
 * When request mentorship button is clicked
 *
 */
$(".request-mentorship").click(function(event){
    event.preventDefault();
    var mentorid = $(this).attr("data-id");
    var mentorname = $(this).attr("data-name");
    if(authenticated){
        $("input[name=mentorname]").val(mentorname);
        $("input[name=mentorid]").val(mentorid);
        $("textarea[name=message]").val('');
        $("#requestmentorship").modal("show");
    }else{
        $("#createaccount").modal("show");
    }
});


/*
 * Close mentorship request modal
 *
 */
function closeRequestModal(){
    $("#requestmentorship").modal("hide");
}



/*
 * Mouse over on stars
 */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
/*
 * Mouse click on stars
 */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    document.getElementById("rating").value = ""+ratingValue;

    
  });
  
  
  
/*
 * get stripe token
 */
 function subscribeStripe(plan, token){
     showLoader();
    server({ 
        url: subscribeUrl,
        data: {
            "plan": plan,
            "token": token,
            "promocode": $("input[name=promocode]").val(),
             "product": $("input[name=product]").val(),
            "fname": $("input[name=fname]").val(),
            "lname": $("input[name=lname]").val(),
            "phone": $("input[name=phone]").val(),
            "email": $("input[name=email]").val(),
            "password": $("input[name=password]").val(),
            "cycle": $("input[name=billingcycle]:checked").val(),
            "status":$("input[name=packageStatus]").val()
        },
        loader: true
    });
 }

/*
 * Redeem promo code
 */
 function redeem(type, off_by, code){
     price = parseFloat($(".selected-plan h3").attr("price"));
     if(type === "Amount"){
         newPrice = parseFloat(price - off_by);
     }else{
         newPrice = parseFloat(((100 - off_by) * price) / 100);
     }
     $(".selected-plan h3 span").text(newPrice.toFixed(2));
     $("input[name=promocode]").val(code);
 }
 
 
 /*
 * when billing cycle is changed
 */
$("input[name=billingcycle]").change(function(){
    var billingcycle = $("input[name=billingcycle]:checked").val();
    $(".selected-plan .selected-plan-cycle").text(billingcycle);
    if(billingcycle === "Monthly"){
        $(".per-month").show();
        $(".per-year").hide();
    }else{
        $(".per-month").hide();
        $(".per-year").show();
    }
})

$(".demo").click(function(){
	  
    var id = $(this).attr("data-id");
    var plyalist = $(this).attr("plyalist"); 
	    showLoader();
    server({ 
        url: subscribeUrl,
        data: {
            "data-id": id,
            "plyalist": plyalist
          
        },
        loader: true
    });
	
	
	
});
/*
 * when subscribe button is clicked
 */
$(".subscribe").click(function(){
    
    var planName = $(this).attr("plan-name");
    var planId = $(this).attr("plan-id"); 
	var productId = $(this).attr("data-product");
	var productname = $(this).attr("product-title");
	 var productimg = $(this).attr("product-img"); 
    var planPrice = parseFloat($(this).attr("plan-price"));
    var features = $(this).closest(".plan-card").find(".plan-features").html();

    swal({
        title: "Subscribe to "+planName+"!",
        text: "Click subscribe now to proceed",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Subscribe Now!",
        closeOnConfirm: true
    }, function () {
        if(planPrice > 1 && stripe_card_id === ''){
            $(".selected-plan h2").text(planName);
			 if(productname){
			 $(".limit-reached-title p b span.product_title").text('Subscribe Now and get the ' +productname+ ' absolutely Free');
			 }
			 if(productimg){
            $(".img_sec img").attr('src','https://myceo.com/uploads/shop/'+productimg);
			 }
			$(".selected-plan h3 span").text(planPrice);
            $(".selected-plan h3").attr("price", planPrice);
            $(".selected-plan .plan-features").html(features);
            $("input[name=selected_plan_id]").val(planId); 
			$("input[name=product]").val(productId);
            $(".limit-reached").show();
        }else{
            subscribeStripe(planId, '');
        }
    });
});

/*
 * when subscribe button is clicked
 */
$(".payment-form").submit(function(event){
    event.preventDefault();
    showLoader();
    var $form = $(".payment-form");
    var planId = $("input[name=selected_plan_id]").val();
    // Reset the token first
    Stripe.card.createToken($form, function(status, response) {
    if (response.error) {
        hideLoader();
        toastr.clear();
        toastr.error(response.error.message, "Oops!", {
            closeButton: true
        });
        return false;
    } else {
        hideLoader();
        subscribeStripe(planId, response.id);
    }
    });
});

/*
 * when redeem button
 */
$(".reddem-form").submit(function(event){
    event.preventDefault();
    showLoader();
    var planId = $("input[name=selected_plan_id]").val();
    subscribeStripe(planId, 'redeem');
});


/*
 * send email
 */
$(".send-email").click(function(event){
    event.preventDefault();
    $("input[name=email]").val($(this).attr("data-email"));
    $("#sendemail").modal("show");
});


(function($) {
    var pagify = {
        items: {},
        container: null,
        totalPages: 1,
        perPage: 3,
        currentPage: 0,
        createNavigation: function() {
            this.totalPages = Math.ceil(this.items.length / this.perPage);

            $('.pagify-pagination', this.container.parent()).remove();
            var pagination = $('<div class="pagify-pagination"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

            for (var i = 0; i < this.totalPages; i++) {
                var pageElClass = "page";
                if (!i)
                    pageElClass = "page current";
                var pageEl = '<a class="' + pageElClass + '" data-page="' + (
                i + 1) + '">' + (
                i + 1) + "</a>";
                pagination.append(pageEl);
            }
            pagination.append('<a class="nav next" data-next="true">></a>');

            this.container.after(pagination);

            var that = this;
            $("body").off("click", ".nav");
            this.navigator = $("body").on("click", ".nav", function() {
                var el = $(this);
                that.navigate(el.data("next"));
            });

            $("body").off("click", ".page");
            this.pageNavigator = $("body").on("click", ".page", function() {
                var el = $(this);
                that.goToPage(el.data("page"));
            });
        },
        navigate: function(next) {
            // default perPage to 5
            if (isNaN(next) || next === undefined) {
                next = true;
            }
            $(".pagify-pagination .nav").removeClass("disabled");
            if (next) {
                this.currentPage++;
                if (this.currentPage > (this.totalPages - 1))
                    this.currentPage = (this.totalPages - 1);
                if (this.currentPage == (this.totalPages - 1))
                    $(".pagify-pagination .nav.next").addClass("disabled");
                }
            else {
                this.currentPage--;
                if (this.currentPage < 0)
                    this.currentPage = 0;
                if (this.currentPage == 0)
                    $(".pagify-pagination .nav.prev").addClass("disabled");
                }

            this.showItems();
        },
        updateNavigation: function() {

            var pages = $(".pagify-pagination .page");
            pages.removeClass("current");
            $('.pagify-pagination .page[data-page="' + (
            this.currentPage + 1) + '"]').addClass("current");
        },
        goToPage: function(page) {

            this.currentPage = page - 1;

            $(".pagify-pagination .nav").removeClass("disabled");
            if (this.currentPage == (this.totalPages - 1))
                $(".pagify-pagination .nav.next").addClass("disabled");

            if (this.currentPage == 0)
                $(".pagify-pagination .nav.prev").addClass("disabled");
            this.showItems();
        },
        showItems: function() {
            this.items.hide();
            var base = this.perPage * this.currentPage;
            this.items.slice(base, base + this.perPage).show();

            this.updateNavigation();
        },
        init: function(container, items, perPage) {
            this.container = container;
            this.currentPage = 0;
            this.totalPages = 1;
            this.perPage = perPage;
            this.items = items;
            this.createNavigation();
            this.showItems();
        }
    };

    // stuff it all into a jQuery method!
    $.fn.pagify = function(perPage, itemSelector) {
        var el = $(this);
        var items = $(itemSelector, el);

        // default perPage to 5
        if (isNaN(perPage) || perPage === undefined) {
            perPage = 3;
        }

        // don't fire if fewer items than perPage
        if (items.length <= perPage) {
            return true;
        }

        pagify.init(el, items, perPage);
    };
})(jQuery);

 






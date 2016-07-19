$(document).ready(function(){

	$( ".updateprice" ).change(function() {
		attrs =  $(this).attr("id");
		color = $('#cart-color').val();
		width = $('#cart-width').val();
		size = $('#cart-size').val();
		changed = 0;
		if(attrs == "cart-size"){
			$("#cart-width option").remove()
			$("#cart-color option").remove();
			$("#cart-quantity option").remove();
			$('#cart-width').append("<option value=''>Select Width</option> ");
			$('#cart-color').append("<option value=''>Select Color</option> ");
			$('#cart-quantity').append("<option value=''>Select Quantity</option> ");
		}else if(attrs == "cart-width"){
			$("#cart-color option").remove();
			$("#cart-quantity option").remove();
			$('#cart-color').append("<option value=''>Select Color</option> ");
			$('#cart-quantity').append("<option value=''>Select Quantity</option> ");
		}


		if(typeof varients[size] != 'undefined'){

			$.each( varients[size], function( key1, value1 ) {
				if (attrs == "cart-size") {
					$('#cart-width').append("<option value='" + key1 + "'>" + value1.width_val + "</option> ");
				}
			});
			if ((attrs == "cart-width") && (width != '') && (typeof varients[size][width] != 'undefined') ) {

				$.each(varients[size][width], function (key2, value2) {
					if (key2 != 'width_val') {
						$('#cart-color').append("<option value='" + key2 + "'>" + value2.color_val + "</option> ");
					}
				});
			}

			if ((attrs == "cart-color") && (color != "" && size != "" && width != "") && (typeof varients[size][width][color] != 'undefined') ) {
				//console.log(varients[size][width][color]);

				$('.red-color').html('<i class="fa fa-inr"></i>' + varients[size][width][color]['price']);
				$('#cart-quantity').empty();
				$('#cart-quantity').append($("<option/>", {
					value: '',
					text: 'Select Quantity'
				}));
				for (i = 1; i <= varients[size][width][color]['quantity']; i++) {
					$('#cart-quantity').append($("<option/>", {
						value: i,
						text: i
					}));
				}

				//alert(value.price);
				changed = 1;


			}
		}

		if(changed == 0){
			$('.red-color').html('<i class="fa fa-inr"></i>'+product_price);
		}
	});



			$(".enable-checkout-login").click(function(){
				$(".checkout-guest").fadeIn('slow');
			});


			$("#register_btn").click(function(){
				$("#logindiv").show();
				$("#registerdiv").hide();
			});
			$("#login_btn").click(function(){
				$("#logindiv").hide();
				$("#registerdiv").show();
			});

			var shipping_form = $('#shipping-address-form').html();
			$('#shipping-address-form').empty();
			$('#shipaddbtn').change(function(){
				if(this.checked){
					$('#shipping-address-form').html(shipping_form);
					$('#shipping-address-form').fadeIn('slow');
				}
				else {
					$('#shipping-address-form').empty();
					$('#shipping-address-form').fadeOut('slow');
				}

			});

			var account_form = $('#new-account-form').html();
			$('#new-account-form').empty();
			$('#newaccountbtn').change(function(){
				if(this.checked){
					$('#new-account-form').empty();
					$('#new-account-form').html(account_form);
					$('#new-account-form').fadeIn('slow');
				}
				else {
					$('#new-account-form').empty();
					$('#new-account-form').fadeOut('slow');
				}

			});

			$('nav#menu').mmenu({
				extensions	: [ 'effect-slide-menu', 'pageshadow' ],
				searchfield	: true,
				counters	: true,
				navbar 		: {
					title		: 'Menu'
				},
				navbars		: [
					{
						position	: 'top',
						content		: [ 'searchfield' ]
					}, {
						position	: 'top',
						content		: [
							'prev',
							'title',
							'close'
						]
					}
				]
			});



			$("body").show();

			if($(".address li span").length){
				$(".address li span").on('click',function(event){
					if ( $( this ).hasClass( "open" ) ) {
						var target = $(event.target).next().is(':visible');
						if (target) {
							$(this).next().slideUp();
							$("i", this).removeClass("fa-minus").addClass("fa-plus");

							$(this).removeClass("active");
							return;
						}
						else {
							$(".address li span").next().slideUp();
							$(".address li span i").removeClass("fa-minus").addClass("fa-plus");

							$(this).next().slideDown();
							$("i", this).addClass("fa-minus").removeClass("fa-plus");
							$(".address li span").removeClass("active");
							$(this).addClass("active");


						}
					}

				});
				$(".address li.step2 button").on('click',function(event){

						var target = $(event.target).next().is(':visible');
						if (target) {
							$(this).next().slideUp();
							$("i", this).removeClass("fa-minus").addClass("fa-plus");

							$(this).removeClass("active");
							return;
						}
						else {



							$(".address li.step3 span").removeClass("close").addClass("open");
							$(".address li.step2 span").next().slideUp();
							$(".address li.step2 span i").removeClass("fa-minus").addClass("fa-plus");

							$(".address li.step3 span").next().slideDown();
							$("i",".address li.step3 span").addClass("fa-minus").removeClass("fa-plus");
							$(".address li span").removeClass("active");
							$(".address li.step3 span").addClass("active");
						}


				});

			}


			
			var winwid = window.innerWidth;
			if($('.bxslider').length){
				$('.bxslider').bxSlider({
					auto: true,
					autoControls: true,
					pager:true,			
				});
			}
			if($('.bxslider-2').length){
				$('.bxslider-2').bxSlider({
				 minSlides: 2,
				  maxSlides: 6,
				  slideWidth: 320,
				  moveSlides:1,
				  
				}); 
			}
			if($('.bxslider-1').length){
				$('.bxslider-1').bxSlider({
					infiniteLoop: false,
					minSlides: 1,
				  maxSlides: 6,
				  slideWidth: 270,
				  moveSlides:1
				}); 
			}
			if($( '#example3' ).length){
				$( '#example3' ).sliderPro({
					width: 960,
					height: 500,
					fade: true,
					arrows: true,
					buttons: false,
					fullScreen: true,
					shuffle: true,
					smallSize: 500,
					mediumSize: 1000,
					largeSize: 3000,
					thumbnailArrows: true,
					autoplay: false
				});
			}
			function myscrool(){
				if(topval>0)
				{
					winheight = $(".slider-area").height();

					$(".slider-area").css({
						"height":winheight,
						"position":"relative",
					});
					$(".rel-box").css({
						"height":"0",
					});
				}
				else{
					$(".slider-area").css({
						"height":"100%",
						"position":"fixed",
					});
					$(".rel-box").css({
						"height":winheight,
					});
				}
			};


			var topval = $(this).scrollTop();

			var winheight = $(".slider-area").height();

			
			
			function runcode(imgheight) {
					
					var imgheight;

				if($(".imgs").length){
				 imgheight = $(".imgs").height();
				}
				else{
				 imgheight = winheight;
				}
				var winw = window.innerWidth;



				if (winheight >= imgheight || winw < 768) {

					$(".slider-area").css({
						"height": imgheight,
						"position": "relative",
					});

				}
				else {

					$(window).resize(function () {
						if (screen.width > window.innerWidth) {
							var winheight = $(".slider-area").height();
						} else {
							var winheight = $(".slider-area").height();
						}
					});
					if (!$( ".rel-box" ).length ) {

						$("<div class='rel-box'></div>").insertBefore(".slider-area").css("height", winheight);

					}
					if($(".main-slider>.bx-wrapper").length)
					{
						$(".main-slider>.bx-wrapper").css("height", winheight);
					}

					if($(".portfolio-slider").length)
					{
						$(".portfolio-slider").css("height", winheight);
					}


					myscrool();

					$(window).scroll(function () {
						topval = $(this).scrollTop();
						myscrool();
						stopnav();

					});
				}
			}

			var high = $('.free-shipping').outerHeight();
           $("<div>").insertAfter('.free-shipping').css("height",high);
			
            function stopnav(){
				
			
				var imgheight1;

				if($(".imgs").length){
				 imgheight1 = $(".imgs").height();
				}
				else{
				 imgheight1 = 0;
				}
				
				 if ($(this).scrollTop() > imgheight1-high-high) {
                    $('.free-shipping').css({
                        position: "fixed",
                        top: "0",
                    });
                    
                } else {
                    $('.free-shipping').css({
                        position: "absolute",
                        top: "auto",
                    });
                }
			}
			

			/*if($(".imgs").length){
				var theImage = new Image();
				theImage.src = $(".imgs").attr("src");
				theImage.onload = function() {
					imgheight = $(".imgs").height();
					runcode(imgheight);
					stopnav();
				};
			}
			else{
				imgheight = winheight;
				runcode(imgheight);
				stopnav();
			}*/
			
			 $(".imgs").ready(function(){
				runcode();
				stopnav();
				setTimeout(function(){
					runcode();
					stopnav();
					
				}, 500);
			 });

		 
			 
            
            
        });   
		
		  $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
		
		if($('#back-to-top').length){
			
        	$('#back-to-top').tooltip('show'); 
		}




$(document).on("click",".addToWishlist",function(e){
	var id = $(this).attr("data-id");
	var ajaxloading  = false;
	var current_element = $(this);
	var isadded = $(this).attr("data-is-enabled");
	if(ajaxloading==false){
		ajaxloading = true; //prevent further ajax loading
		$('i',this).attr('class','fa fa-spinner fa-pulse'); //show loading image

		//load data from the server using a HTTP POST request
		$.post(baseurl+"/wishlist/add",{'pid':id,'isadded':isadded}, function(data){
			//append received data into the element
			$(".flash span").html(data.result);
			$(".flash").fadeIn(100);
			setTimeout(function(){
				$(".flash").fadeOut();
			},3000);
			setTimeout(function(){
				$(".flash span").html("");
			},4000);
			if(data.success==true){
				$('#fav_fruits').html(data.counts[0]);
				$('#fav_vegetables').html(data.counts[1]);
			}
			$(current_element).attr('title',data.label);
			$(current_element).attr('data-is-enabled',data.enabled);
			//hide loading image
			$('.animation_image').hide(); //hide loading image once data is received
			//loaded group increment
			ajaxloading = false;

		}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

			alert(thrownError); //alert with HTTP error
			$('.animation_image').hide(); //hide loading image
			ajaxloading = false;

		});
	}

});

		

		
		
		
		
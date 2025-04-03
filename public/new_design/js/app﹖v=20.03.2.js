"use strict";
$(document).ready(function () {
	grecaptcha.ready(function () {
		grecaptcha.execute('6Lc61LgUAAAAAM4O_24pDfhzJc0MzdyG4Wt0gvgb', { action: 'contact' }).then(function (token) {
			$('.recaptchaResponse').val(token);
		});
		setInterval(function(){
			grecaptcha.execute('6Lc61LgUAAAAAM4O_24pDfhzJc0MzdyG4Wt0gvgb', { action: 'contact' }).then(function (token) {
				$('.recaptchaResponse').val(token);
			});
		},60000)

    });
	
    $(".select_c_days .decrement").click(function(){
        var t = $(this).closest(".select_c_days").find(".text");
        var tval = parseInt(t.text());
        if (tval>1) {
            t.text(--tval);
            detox(tval)
        }
    }); 
    $(".select_c_days .increment").click(function(){
        var t = $(this).closest(".select_c_days").find("span.text");
        var tval = parseInt(t.text());
        if (tval<3) {
            t.text(++tval);
            detox(tval)
        }
    });
    
	
    setTimeout(function () {
        $(".spinner").fadeOut(1000, function () {
            $('body').removeClass('hide_page');
        });
    }, 1500);

    setTimeout(function () {
        $(".spinner").remove();
    }, 7000);
	var wow = new WOW(
        {
            boxClass:     'wow',      // default
            animateClass: 'animated', // default
            offset:       200,          // default
            mobile:       true,       // default
            live:         true        // default
        }
    );
    wow.init();
	var $sale="";
	var $minsum=0;
	var $sale_type=0;
	var $sale_summary=1;
	var $order_sum=0;
	var $order_sum_with_promo=0;
	var $count_days=1;
	var $cost_before=0;


    var d_arr = ["день", "дня", "дней"];
    function names(a, arr) {
        var d = a % 100;
        if (d > 19) {
            d = d % 10;
        }
        switch (d) {
            case 1: {
                return arr[0];
            }
            case 2:
            case 3:
            case 4: {
                return arr[1];
            }
            default: {
                return arr[2];
            }
        }
    }
	
	function detox(v){
		var price = $(".select_c_days .text").data("sum");
        $(".order_info_price_detox b").text(numberWithSpaces(v*price) +" ₽");
		$(".select_c_days_info span").text(v + " "+names(v,d_arr));
        $("input[name='count-detox']").val(v);
        $("input[name='sum-detox']").val(v*price);
    }
	
	var ration_chosen = 0,
	current_date = (new Date()).getFullYear()+'-'+("0"+((new Date()).getMonth()+1)).slice(-2)+'-'+("0"+(new Date()).getDate()).slice(-2),
	days_arr, tarif_id_for_foods,
	calories_arr, current_calories_id = 0, current_tarif, date_arr = [],
	current_foods_arr = [], select_date = 0, foods_arr = 0;
    var chose_target = 1;
	var _tariffs, tariffs = [];

	var foods = ''; 
    function get_tarifs(){
        $.ajax({
            method: "GET",
            url: "/tarifs_source.json",
            dataType: "json",
            success: function(res){
                $(".select_program_block,.menu_block").css("display", "block");
                _tariffs = res;
				//console.log(_tariffs);
								
				_tariffs[ration_chosen].foods.forEach(function(item,i,arr){
				    date_arr.push(item.date);
					if(item.date === current_date) current_foods_arr.push(item);
				});				
				date_arr = deleteDuplicate(date_arr);
				days_arr = JSON.parse(_tariffs[ration_chosen].days)
				//console.log(days_arr);
				viewRations();
				viewRationCalories();
				viewTarifDays();
				dayNames();
				viewFoods();
				calcCost(0)
				viewOrderInfo();
				days_sly();
				dish_sly();
				my_program();
				
				
				lalalend();


            }
        });
    }
	get_tarifs();
	/*function get_foods(){
        $.ajax({ 
            method: "GET",
            url: "/foods",
            dataType: "json",
            success: function(res){
                foods = res;
				console.log(tarifs);		
				foods_arr = foods;
				foods.forEach(function(item,i,arr){
				    date_arr.push(item.date);
					if(item.date === current_date&&item.section==current_tarif.section[0]) current_foods_arr.push(item);
				});
				date_arr = deleteDuplicate(date_arr);
                date_arr = date_arr.filter(function(item){
					//return item >= current_date;
					return item;
				});	
				viewOrderInfo();
				viewRations();
				viewRationCalories();
				viewTarifDays();
				calcCost(current_calories_id);
				viewFoods();
				dayNames();
				
				my_program();
				days_sly();
				dish_sly();
            }
        });
    }
    get_tarifs();*/

    
    function getFoodsFromDate(date){
        current_foods_arr = [];
        _tariffs[ration_chosen].foods.forEach(function(item,i){
            if(item.date === date) current_foods_arr.push(item);
        });
    }
    function viewRations() {
        var html = "";
        var html1 = "";
        var html2 = "";
		/*var tn = "";
		var ts = tarifs[0].tarifs_sections;
		ts.forEach(function(tarif,i){
			$(".my_target ul").append("<li><i></i><span>"+tarif.name+"</span></li>");
		});*/
        _tariffs.forEach(function(item){
			/*ts.forEach(function(tarif,i){	
				var arr = JSON.parse(tarif.tarifs);
				var h = arr.indexOf(item.tarifs[0].id);
				if (h != -1) {
					tn = tarif.name;
				}
			});*/
			
			if(item.hasOwnProperty("tarifs")){
				html +=  "<div class=\"ration_item\" data-section-id='"+item.tarifs[0].section_id+"' data-tarif-id='"+item.tarifs[0].tarif_id+"' data-id='"+item.tarifs[0].id+"'>\n" +
                "         <div class='h5'>"+item.name+"</div>\n" +
                "         <p>"+item.name_eng+"<span>"+item.tarifs[0].tarif_num+"-"+item.tarifs[item.tarifs.length - 1].tarif_num+" кКал</span></p>\n" +
                "         <div class=\"ration_img\">\n" +
                "             <img data-src=\"//perfectbalance.ru/admin/uploads/tarifs_source/"+item.image+"\" class=\"lazyload\" src=\"\" alt=\"\">\n" +
                "         </div>\n" +
                "         <div class=\"check_icon\"></div>\n" +
                "     </div>";
				
				html1 += "<p><i></i><span>"+item.name+"</span></p>";
				html2 +=  `<li><a href="javascript:void(0)">${item.name}</a></li>`;

				//$(".my_target ul").append("<li><i></i><span>"+item.name+"</span></li>")
			}
            
           /* */
        });
        $(".ration_box").html(html);
        $(".chose_program_list").html(html1);
        $(".foot_menu_nav").html(html2);
        $(".ration_box .ration_item").eq(ration_chosen).addClass("active");
        $(".chose_program_list p").eq(ration_chosen).addClass("active");

    } 	
	
	//get hash 
	function lalalend(){
		if(window.location.hash) {
			var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			//alert (hash);
			if(hash == "vegan") {
				//console.log(_tariffs);
				_tariffs.forEach(function(item, i){
					if(item.name == "Веганское/Постное" || item.name == "Вегетарианское" 
						|| item.name == "Постное (Vegan)" || item.name == "Веган") {
						//console.log(i);	
						$(".ration_box .ration_item").eq(i).trigger("click");
						let box = $("#select")[0].getBoundingClientRect();
						//console.log(box);
						$(window).scrollTop(box.top - 94);
					}
					
				})
			}
		}
	}
	
	
    function viewOrderInfo(){
        $(".ration_info i").text(_tariffs[ration_chosen].name_eng);
        $(".ration_info b").text(_tariffs[ration_chosen].tarifs[current_calories_id].tarif_num);
        var dd = $(".days_count p.checked").index();
        $(".ration_info span").text((parseInt(days_arr[dd]))+" "+names(parseInt(days_arr[dd]),d_arr));

        $(".menu .menu_title_inner span").text(_tariffs[ration_chosen].name_eng+" / "+_tariffs[ration_chosen].tarifs[current_calories_id].tarif_num);

        //вывод информации на форму заказа
        //$(".order_info_text b").text(current_ration.tarifs_sections[0].name);
		//$("h5.ration_name").text(current_ration.tarifs_sections[0].name);
        $(".order_info_text span").text(_tariffs[ration_chosen].name_eng+" / "+_tariffs[ration_chosen].tarifs[current_calories_id].tarif_num);


        $(".order_info_text i").text((parseInt(days_arr[dd])+parseInt($count_extra_days))+" "+names(parseInt(days_arr[dd])+parseInt($count_extra_days),d_arr));


		$(".order_right input[name=days]").val(parseInt(days_arr[dd])+parseInt($count_extra_days));
		$(".order_right input[name=tarif]").val(_tariffs[ration_chosen].name_eng+" / "+_tariffs[ration_chosen].tarifs[current_calories_id].tarif_num);
    }
    
    function viewRationCalories(){
        var html = "";
        _tariffs[ration_chosen].tarifs.forEach(function(item){
            html += "<p data-id='"+item.id+"'>"+item.tarif_num+"</p>";
        });
        $(".daily_kk,.chose_calories").html(html);
        $(".daily_kk p").eq(current_calories_id).addClass("checked");
        $(".chose_calories p").eq(current_calories_id).addClass("checked");
    }
    
    function viewTarifDays(){
        var html = "";
        eval(_tariffs[ration_chosen].days).forEach(function(item){
            html += "<p>"+item+"</p>";
        });
        $(".days_count ").html(html);
        $(".days_count  p").eq(select_date).addClass("checked");
    }
    
    $(document).on("click",".ration_item, .chose_program_list p,.foot_menu_nav li",function () {
        if (!$(this).hasClass("active")) {
            //console.log($(this).index());
            $(".ration_item").removeClass("active");
            $(".chose_program_list p").removeClass("active");
            $(".ration_item").eq($(this).index()).addClass("active");
            $(".chose_program_list p").eq($(this).index()).addClass("active");
            ration_chosen = $(this).index();
            //current_ration = tarifs[ration_chosen];
            days_arr = JSON.parse(_tariffs[ration_chosen].days);
            current_calories_id = 0;
            current_tarif = _tariffs[ration_chosen].tarifs[current_calories_id];
            viewRationCalories();
            viewTarifDays();
			
			var date = $(".days_slider .day_slide.active").data("date");
			getFoodsFromDate(date);
			
            viewFoods();
            calcCost(select_date);
            viewOrderInfo();
			dish_sly();
			$(".order_info_text b").text($(this).find(".h5").text());
            $(".h5.ration_name").text($(this).find(".h5").text());
        }
    });
    $(document).on('click','.foot_menu_nav li a',function (e) {
        e.preventDefault();
        $("#menu_block")[0].scrollIntoView({behavior : 'smooth'});
    })
    $(document).on("click",".daily_kk p, .chose_calories p",function(){
       if(!$(this).hasClass("checked")) {
           $(".daily_kk p,.chose_calories p").removeClass("checked");
           $(".daily_kk p").eq($(this).index()).addClass("checked");
           $(".chose_calories p").eq($(this).index()).addClass("checked");
           current_calories_id = $(this).index();
           current_tarif = _tariffs[ration_chosen].tarifs[current_calories_id];
           // console.log(current_calories_id);
           // console.log(select_date);
           //viewTarifDays();
           viewFoods();
           calcCost(select_date);
           viewOrderInfo();		   
		   dish_sly();
       }
    });
    function calcCost(i){
    //    current_calories_id
        //console.log(select_date);
        var cost = JSON.parse(_tariffs[ration_chosen].tarifs[current_calories_id].money),
            count_days = days_arr[i], //days_arr[i],
            cost_one_day = cost[0].money,
            cost_before = count_days * cost_one_day,
            cost_diff = cost[i].money - cost_before;
			
			$order_sum = cost[i].money;
            if($(".my_order_price .h5").length) {
                $order_sum = $(".my_order_price .h5").text().replace(/[^+\d]/g, '');
            }
            if($('.my_order_program p span').length) {
                $count_days = $('.my_order_program p span').text().replace(/[^+\d]/g, '')
            }
			$count_days = count_days;
            if($(".my_order_program p").length) {
                $count_days = $(".my_order_program p span").text().replace(/[^+\d]/g, '')
            }

			$cost_before = count_days * cost_one_day;
            if($(".my_order_price .h5").length){
                $cost_before = $(".my_order_price .h5").text().replace(/[^+\d]/g, '')
            }
        if(cost_before == cost[i].money) {
            $(".price b,.order_info_price b").text(numberWithSpaces(cost[i].money)+" ₽");
			
			$(".order_right input[name=sum]").val(numberWithSpaces(cost[i].money)+" ₽");
            $(".price strike,.price i,.order_info_price span").text("");
            $(".price").next("p").text("");
        }
        else {
            $(".price b,.order_info_price b").text(numberWithSpaces(cost[i].money)+" ₽");
            $(".price strike").text(numberWithSpaces(parseInt(cost_before))+" ₽");
            $(".price i").text(numberWithSpaces(cost_diff)+" ₽");
            $(".price").next("p").text(numberWithSpaces(cost[i].money/count_days)+" ₽ в день");
            $(".order_info_price span").text(numberWithSpaces(cost[i].money/count_days)+" ₽ в день");
			$(".order_right input[name=sum]").val(numberWithSpaces(cost[i].money)+" ₽");
        }
		hasPromo();
    }
    var $count_extra_days=0;
	function hasPromo(){
		if($sale&&$sale_type)
		{
            $count_extra_days=0;

            //todo order_sum

            if(!$sale_summary){
                $order_sum = $cost_before;
                // console.log($order_sum);
            }
            console.log($order_sum);

            if($order_sum>=$minsum)
            {
                if($sale_type==1)//руб
                {
                    $order_sum_with_promo=$order_sum-$sale;
                }
                else if($sale_type==3)//бесплатные дни
                {
                    //TODO Здесь поставить функционал бесплатных дней
                    if($count_days<5)
                    {
                        $order_sum_with_promo=$order_sum;
                        $count_extra_days=0;
                    }
                    else
                    {
                        $order_sum_with_promo=$order_sum
                        $count_extra_days=parseInt($sale);
                        viewOrderInfo()
                    }
                }
                else//%
                {
                    $order_sum_with_promo=$order_sum*(1-$sale/100);
                }
            }
			else
            {
                $order_sum_with_promo=$order_sum;
            }

            $(".order_info_price b, .my_order_price .h5").text(numberWithSpaces($order_sum_with_promo)+" ₽");
			$(".order_info_price strike").text(numberWithSpaces(parseInt($order_sum)+parseInt($count_extra_days*$order_sum/$count_days))+" ₽");
			$(".order_info_price span,.my_order_price p.day_price").text(numberWithSpaces($order_sum_with_promo/(parseInt($count_days)+parseInt($count_extra_days)))+" ₽ в день");

		}
	}
	
	
	$(document).on( 'click' , '.promocode .remove_promocode', function(event){
        $('#promocode_error').html('');
        $('.promocode input[name="promocode"]').val('');
		$(".order_info_price b").text($(".order_info_price strike").text());
		$(".order_info_price strike").text('');
		$(".order_info_price span").text('');
		
		$('.order_form input[name="promo"],.my_order_info input[name="promo"]').removeAttr("value");
		$('.order_form input[name="sale"],.my_order_info input[name="sale"]').removeAttr("value");
		$('.order_form input[name="sum_w_s"],.my_order_info input[name="sum_w_s"]').removeAttr("value");

        $(".my_order_price .h5").text(numberWithSpaces($cost_before) + "₽");
        $(".my_order_price .day_price").text(Math.floor($cost_before / $count_days) + "₽ в день");


	})
	
    $(document).on("click",".days_count p",function(){
        if(!$(this).hasClass("checked")) {
            $(".days_count p").removeClass("checked");
            $(this).addClass("checked");
            // current_tarif = tarifs[ration_chosen].tarifs[current_calories_id];
            var i = $(this).index();
            select_date = i;
            viewOrderInfo();
            calcCost(select_date);
        }

    });
	
    function viewFoods() {
        var html = "",
			meal_arr = ["завтрак","ланч","обед","полдник","ужин","поздний ужин"];
		current_foods_arr.forEach(function(item,i){
            //console.log(item);
            var j = i+1;
            var f = eval("_tariffs[ration_chosen].tarifs[current_calories_id].food_"+j);
           // if( f != null) {
            if( f >0) {
                if(item.composition) {
                    html += "<div class=\"dish_slide\">\n" +
                        "    <div class=\"dish_slide_img\">\n" +
                        "        <img class=\"lazyload\" src=\"\" data-src=\"//perfectbalance.ru/admin/uploads/myfoods/"+item.image+"\" alt=\"\">\n" +
                        "        <div class=\"composition\">Состав:&nbsp; "+item.composition+"</div>"+
                        "    </div>\n" +
                        "    <span>"+meal_arr[i]+"</span>\n" +
                        "    <p><b>"+item.name+"</b></p>\n" +
                        "    <div class=\"dish_info\">\n" +
                        "        <p><span>"+Math.floor(item.calories*f)+"</span>кКал</p>\n" +
                        "        <p><span>"+Math.floor(item.proteins *f)+" г</span>белков</p>\n" +
                        "        <p><span>"+Math.floor(item.fats *f)+" г</span>жиров</p>\n" +
                        "        <p><span>"+Math.floor(item.carbohydrates *f)+" г</span>углеводов</p>\n" +
                        "    </div>\n" +
                        "</div>";
                }
                else {
                    html += "<div class=\"dish_slide\">\n" +
                        "    <div class=\"dish_slide_img\">\n" +
                        "        <img class=\"lazyload\" src=\"\" data-src=\"//perfectbalance.ru/admin/uploads/myfoods/"+item.image+"\" alt=\"\">\n" +
                        "    </div>\n" +
                        "    <span>"+meal_arr[i]+"</span>\n" +
                        "    <p><b>"+item.name+"</b></p>\n" +
                        "    <div class=\"dish_info\">\n" +
                        "        <p><span>"+Math.floor(item.calories*f)+"</span>кКал</p>\n" +
                        "        <p><span>"+Math.floor(item.proteins *f)+" г</span>белков</p>\n" +
                        "        <p><span>"+Math.floor(item.fats *f)+" г</span>жиров</p>\n" +
                        "        <p><span>"+Math.floor(item.carbohydrates *f)+" г</span>углеводов</p>\n" +
                        "    </div>\n" +
                        "</div>";
                }

            }

        });
        $(".dishes_slider").html(html);
        //return html;
    }

    $(document).on('click','.dish_slide',function (){
        console.log($(this));
        $(this).toggleClass("clicked");
    })

    function dayNames(){
        var arr = ["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],
            html = '';
        date_arr.forEach(function(item){
            var dd = new Date(item);
            var str = dd.getDate()+"."+("0"+(dd.getMonth()+1)).slice(-2)+" / "+arr[dd.getDay()];
            html += "<div class=\"day_slide\" data-date=\""+item+"\">"+str+"</div>";
        });

        $(".days_slider").html(html);

        // return arrDays;
        return true;
    }
    
    function deleteDuplicate(arr){
        var obj = {};
        return arr.filter(function(a){
            return a in obj ? 0 : obj[a]=1
        })
    }

    function numberWithSpaces(x) {
		var x = +x;
        return x.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    $(".mobile_toggle").click(function(){
        var width_scroll = 0;
        if ($(".mobile_toggle").hasClass("active")) {
            //$(".navTrigger").removeClass("active");
           // $(".header_box").css('display','none');
            $('body').removeAttr('style');
            //$(".h_right").toggleClass("active");

        }
        else {
            close_city_prev_box();
            if ( is_scroll() ) {
                width_scroll = getScrollbarWidth();
            }
            $("body").css("cssText", "overflow: hidden; position: relative; height: 100%; " +
                "padding-right:" + width_scroll + "px");

            //$(".navTrigger").addClass("active");
           //$(".header_box").css('display','flex');
            //$(".h_right").toggleClass("active");

        }
        $(".mobile_toggle,header").toggleClass("active");
    });

    // $(".main_slider").slick({
    //     infinite: false,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     autoplay: true,
    //     autoplaySpeed: 5000,
    //     lazyLoad: 'ondemand',
    //     prevArrow: $(".arrow_prev"),
    //     nextArrow: $(".arrow_next"),
    // });

    $('.main_slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 641,
                settings: {
                }
            }
        ]
    });



	
	/*if($(window).width() < 440 ) {
		$(".client_reviews_box").slick({
			infinite: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			lazyLoad: 'ondemand',
			//prevArrow: $(".arrow_prev"),
			//nextArrow: $(".arrow_next"),
		});
	}*/
	
	
	
	
	if($(".main_slide").length) {
		$(".main_slider_info_box p i").html($(".main_slide:not(.slick-cloned)").length);
		$(".main_slider").on('beforeChange', function(event, slick, currentSlide, nextSlide){
			$('.main_slider_info_box p span ').html(nextSlide+1);
		});
	}
	else {
		$(".main_slider_info_box p").fadeOut(0);
	}
    
    // var input_phone = $('input[name=phone]');
    // if(input_phone.length) {
    //     input_phone.mask('+7 (000) 000-00-00');
	//
	// 	input_phone.on('focus', function () {
	// 		if ($(this).val().length == 0) {
	// 			$(this).val('+7 (');
	// 		}
	// 	});
    // }

    var lg_box = $(".client_reviews_box");
    if(lg_box.length) {
        lg_box.lightGallery({
            thumbnail: false,
            hash: false,
            animateThumb: false,
            showThumbByDefault: false,
            selector: '.client_reviews_box a',
            counter: false,
            zoom: false,
            fullScreen: false,
            share: false,
            autoplayControls: false,
            download: false
        });
    }

    function is_scroll() {
        return $(document).height() > $(window).height();
    }


    if($(window).width() <= 480) {
        $(".about_menu_box_sly").sly({
            horizontal: 1,
            itemNav: 'basic',
            smart: 1,
            activateOn: 'click',
            mouseDragging: 1,
            touchDragging: 1,
            releaseSwing: 1,
            startAt: 0,
            // scrollBar: $(".dishes_sly").next('.scrollbar'),
            scrollBy: 0,
            activatePageOn: 'click',
            speed: 500,
            elasticBounds: 1,
            // easing: 'easeOutExpo',
            dragHandle: 1,
            dynamicHandle: 1,
            // clickBar: 1,
            // prev: $('.days_arrows .prev'),
            // next: $('.days_arrows .next')
        });
    }

	function days_sly(){
		$(".days_sly").sly({
			horizontal: 1,
			itemNav: 'basic',
			smart: 1,
			activateOn: 'click',
			mouseDragging: 1,
			touchDragging: 1,
			releaseSwing: 1,
			startAt: 0,
			// scrollBar: $(".dishes_sly").next('.scrollbar'),
			scrollBy: 0,
			activatePageOn: 'click',
			speed: 300,
			elasticBounds: 1,
			// easing: 'easeOutExpo',
			dragHandle: 1,
			dynamicHandle: 1,
			clickBar: 1,
			prev: $('.days_arrows .prev'),
			next: $('.days_arrows .next')
		});

        var di = date_arr.indexOf(current_date);

        $(".days_sly").sly('activate', di);
		$(".days_sly").sly('on','active', function (eventName,itemIndex ) {
			var date = $(".days_slider .day_slide").eq(itemIndex).data("date");
			getFoodsFromDate(date);
			viewFoods();
		});
		
		
	}
    function dish_sly() {
        $(".dishes_sly").sly(false);
        $(".dishes_sly").sly({
            horizontal: 1,
            itemNav: 'basic',
            smart: 1,
            activateOn: 'click',
            mouseDragging: 1,
            touchDragging: 1,
            releaseSwing: 1,
            startAt: 0,
            scrollBar: $(".dishes_sly").next('.scrollbar'),
            scrollBy: 0,
            activatePageOn: 'click',
            speed: 300,
            elasticBounds: 1,
            // easing: 'easeOutExpo',
            dragHandle: 1,
            dynamicHandle: 0,
            clickBar: 1,
        });
        $(".dishes_sly").sly('on','change',function(eventName){
            //console.log(eventName);
        })
        if ($(".dishes_slider").width() > $(".dishes_sly").width()) {
            $(".scrollbar").addClass("visible");
        }
        else {
            $(".scrollbar").removeClass("visible");
        }


    }
    $(".reset_btn").click(function(){
        $(".ration_item").eq(0).trigger("click");
        $(".days_count p").eq(0).trigger("click");
        $(".daily_kk p").eq(0).trigger("click");
    });
    $(".nav_mobile_box li a, nav ul li a,.scroll_to,.f_up").click(function () {
        var block = $(this).attr("href");
        if (block.charAt(0) == "#") {
            $('html, body').dequeue().stop().animate({
                scrollTop: $(block).offset().top - $("header").height()
            }, 1000);
            $("header, .mobile_toggle").removeClass("active");
            $("body").removeAttr("style");
        }
    });

    $(".close_city_prev").click(function () {
        close_city_prev_box();
    });
    function close_city_prev_box(){
        $(".h_city_box").fadeOut(300);
    }
    $(".close_btn").click(function () {
        close_popup();
    });


    $(".popup_wrapper,.black_layout").click(function (e) {
        if (!$(e.target).closest(".popup").length) close_popup();
    });

    function close_popup() {
        $(".popup_wrapper").fadeOut(200, function () {
            $("body").removeAttr("style");
            $(".black_layout").fadeOut(200);
        });
    }
    $(".go_order_r").click(function(){
        close_popup();
        $('html, body').dequeue().stop().animate({
            scrollTop: $("#menu_block").offset().top - $("header").height()
        }, 1000);
    });
    function open_popup(a) {
        scroll = $(window).scrollTop();
        // $("body").css("cssText", "overflow: hidden; position: relative; height: 100%; " +
        //     "padding-right:" + getScrollbarWidth() + "px");

        //$("body").css("cssText", "overflow: hidden; position: relative; height: 100%; " +
        //"padding-right:" + getScrollbarWidth() + "px");
        $(".black_layout").fadeIn(200, function () {
            $("#" + a).css("top", scroll + "px").fadeIn(300);
            //$("#" + a).fadeIn(200);
        });
    }

    $(".open_popup").click(function (e) {
        e.preventDefault();
        var obj = $(this).data("popup");
        open_popup(obj);
    });




    $('.select_box').click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $('.select_box.active').removeClass('active');
            $(this).addClass('active');
            $(this).closest('.select_box').children('ul').children('li').click(function (e) {
                $(this).closest('.select_box').children('ul').find('li').removeClass("active");
                $(e.target).closest("li").addClass("active");
                $(this).closest('.select_box').children('p').html($(this).find("span").text());
                //chose_target = $(this).index();
				my_program();

                //alert(chose_target);
                //$(".calc_r2 i").text($(this).find("span").text());
                //$(this).removeClass('active');
            })
        }
    });
    $(document).click(function (event) {
        if ($(event.target).closest(".select_box").length) {
        }
        else {
            if ($(event.target).closest(".select_box").length) {
            }
            else {
                if ($(".select_box").hasClass("active")) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                $('.select_box').removeClass('active');
            }
        }
    });


    function my_program() {
        var sex, _activity, activity, age, weight, height, total, target_name;
        target_name = $(".my_target p").text();
        sex = ($(".sex_toggle_box").hasClass("active")) ? 1 : 0;
        _activity = $(".activity input:checked").val();
        age = ($(".my_age .handle").attr("data-value") === undefined) ? 30 : $(".my_age .handle").attr("data-value");
        weight = ($(".my_weight .handle").attr("data-value") === undefined) ? 70 : $(".my_weight .handle").attr("data-value");
        height = ($(".my_height .handle").attr("data-value") === undefined) ? 170 : $(".my_height .handle").attr("data-value");
        switch (_activity) {
            case '1':
                activity = 1.2;
                break;
            case '2':
                activity = 1.375;
                break;
            case '3':
                activity = 1.55;
                break;
            case '4':
                activity = 1.725;
                break;
            case '5':
                activity = 1.9;
                break;
            default:
                activity = 1;
        }
        // alert(activity);
        // 0 - женщина
        // 1 - мужчина
        (sex == 1) ?
            total = (88.36 + (4.8 * height) + (13.4 * weight) - (5.7 * age)) * 0.72 * activity
            :
            total = (447.6 + (3.1 * height) + (9.2 * weight) - (4.3 * age)) * 0.72 * activity;

        /*if(chose_target == 1) {
            total = total * 1;
        }
        else if (chose_target == 0) {
            total = total - (total * .15);
        }
        else {
            total = total + (total * .50);
        }*/

        $(".calc_program_list").html("");
        var i = 0;
        //var ts = tarifs[0].tarifs_sections;
        var ci = {
            name : "",
            tarifs : []
        };
        var html = "";


        var _nt = [];
        //console.log(_tariffs);
        _tariffs.forEach(function(item){
            /*_tariffs.tarifs.forEach(function(i){
                //var arr = JSON.parse(tarif.tarifs);
                var h = arr.indexOf(item1.tarifs[0].id);
                if (h != -1) {
                    ci.name = tarif.name;
                }
            });*/

            let _nti_name = item.name;
            let _nti_name_eng = item.name_eng;
            let _nti_img = item.image;

            item.tarifs.forEach(function(item2){

                let _nti = { name : _nti_name, name_eng : _nti_name_eng, num : item2.tarif_num, image : _nti_img };

                _nt.push(_nti);

                /*if(item2.tarif_num >= total*.8 && item2.tarif_num <= total*1.2) {
					if(target_name == "Любая" || target_name == item.name ) {
						ci.name = item.name;
						//console.log(item2);
						i++;
						ci.tarifs.push({ name : item.name_eng, ccal : item2.tarif_num});
					}
                }*/
            });
            /*if(ci.tarifs.length > 0) {
                //console.log(ci);
                html = "<h5><i>"+ci.name+"</i><span>";
                ci.tarifs.forEach(function(item3){
                    html += item3.name+" / "+item3.ccal+" кКал<br>";
                });
                html += "</span></h5>";
                $(".calc_r2").append(html);
            }

            ci = {
                name : "",
                tarifs : []
            };
            html = "";*/
        });
        _nt.sort(function(a,b){
            return a.num > b.num;
        })
        let na = [];
        if(target_name != "Похудеть") {
            na = _nt.filter(function(item){
                return item.num > total;
            })
            if(na.length == 0) {
                na.push(_nt.pop());
            }
        }
        else {
            na = _nt.filter(function(item){
                return item.num < total;
            })
            na.reverse();
        }

        //console.log(_nt);
        //console.log(na);
        na.forEach(function(item){
            if(item.num == na[0].num){
                //html += "<h5><i>"+item.name+"</i><span> "+item.name_eng+" / "+item.num+" кКал</span></h5>";

                html+= `<div class="program_item_head">
                            <p>${item.name}</p>
                            <span>${item.name_eng}<br>${item.num} кКал</span>
                            <img src="//perfectbalance.ru/admin/uploads/tarifs_source/${item.image}" alt="">
                        </div>`;
            }

        })
        $(".calc_program_list").append(html);

        /*if (i==0) {
            $(".calc_r2").append("<h5>Ничего не найдено!<h5>");
        }*/

        $(".calories_calc_right > .h4").text(Math.floor(total) + " кКал");

    }

    $(".phoneTrigger").click(function(){
        //	$(this).toggleClass("active");
        //$(".h_right").toggleClass("active");
    });


    $(".sex_toggle_box").click(function () {
        $(this).closest(".sex_toggle_box").toggleClass("active");
        my_program();
    });

    $(".activity label").click(function () {
        $(this).closest(".activity").find("span").text($(this).attr("title"));
    });
    $(".activity input").change(function () {
        my_program();
    });
    //sliders
    $(".my_slider").each(function () {
        var $this = $(this);
        var handle = $this.find(".handle");
        $this.slider({
            min: $this.data("min"),
            max: $this.data("max"),
            value: $this.data("current"),
            create: function () {
                handle.attr("data-value", $this.slider("value"));
            },
            slide: function (event, ui) {
                handle.attr("data-value", ui.value);
            },
            change: function (ui) {
                handle.attr("data-value", $this.slider("value"));
                handle.attr("data-value", ui.value);
                my_program();
                //alert(handle.data("value"));
            }
        })
    });

    $(".reset_calc_btn").click(function(){
        resetCalc();
    });

    function resetCalc(){
        $(".my_target.select_box ul li").eq(1).trigger("click");
        $(".my_target.select_box ul li").eq(1).trigger("click");

        $(".sex_toggle_box").removeClass("active");
        $(".activity input").eq(2).prop("checked",true);

        $(".my_weight").slider({value: 70});
        $(".my_height").slider({value: 180});
        $(".my_age").slider({value: 35});
    }


    /*$(document).on("click",".go_popup",function(e){
        e.preventDefault();
        $("input[name=form_info]").val($(this).data("info"));
        $("#back_call").find(".popup_title").text($(this).data("title"));
        $("body").css( "cssText", "overflow: hidden; position: relative; height: 100%; padding-right:"+getScrollbarWidth()+"px" );
        $(".black_layout").fadeIn(300);
        $("#back_call").fadeIn(300);
    });
    $(".black_layout,.popup_wrapper").click(function(e){
        if($(e.target).closest(".popup_body").length)  return 0;
        else close();
    });    
    $(".close_btn").click(function(){
        close();
    });
	function close(){
        $(".black_layout").fadeOut(300);
        $(".popup_wrapper").fadeOut(300);
        $("body").removeAttr("style");
    }
    $(document).on("click",".nav_icon",function(){
        $(this).toggleClass("active");
        $("nav").toggleClass("active");

    });*/
	$('input').focus(function () {
        if ($(this).hasClass('invalid')) {
            $(this).removeClass('invalid');
        }
    });

    function nonWorkingDates(date){
        let day = date.getDay(), Sunday = 0, Monday = 1, Tuesday = 2, Wednesday = 3, Thursday = 4, Friday = 5, Saturday = 6;
        let closedDates = $('.dis_date').data('disabled');
        let closedDays = [[Tuesday], [Thursday], [Saturday]];
        for (var i = 0; i < closedDays.length; i++) {
            if (day == closedDays[i][0]) {
                return [false];
            }
        }
        for (i = 0; i < closedDates.length; i++) {
            //console.log(date);
            //.log(new Date(closedDates[i]));
            //if(date = new Date(closedDates[i])) return false;
            let cur_date = closedDates[i].split('-');
            if (date.getMonth() == cur_date[1] - 1 &&
                date.getDate() == cur_date[2] &&
                date.getFullYear() == cur_date[0]) {
                return [false];
            }
        }
        return [true];
    }
    $(".datepicker").datepicker({
        beforeShowDay: nonWorkingDates,
        showOtherMonths: true,
        selectOtherMonths: true,
        minDate: 1,
        maxDate: "+3M",
        constrainInput: true,
    });

    $.datepicker.setDefaults({
        closeText: "Закрыть",
        prevText: "Пред",
        nextText: "След",
        currentText: "Сегодня",
        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
            "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн",
            "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек" ],
        dayNames: [ "воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота" ],
        dayNamesShort: [ "вск", "пнд", "втр", "срд", "чтв", "птн", "сбт" ],
        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
        weekHeader: "Нед",
        dateFormat: "dd.mm.yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ""
    });




    $("input[name=pay_online]").click(function (e){
        let t = $(this).val();
        let email_input = $(this).closest("form").find("input[name=email]");
        let email_group = email_input.closest(".input_wrapper ")
        if(Number(t) === 1) {
            email_input.removeClass("req");
            email_group.css('display','none');
        }
        else {
            email_input.addClass("req");
            email_group.css('display','block');
        }
    })


    $(".get_new_order_btn").click(function () {
        let card = $('.my_program');
        let ration = $('.ration_item.active');
        let order_data = {
            data : {
                city_id : $("#select").data('city-id'),
                tariff_name : card.find('.ration_name').text(),
                img : $(".ration_item.active .ration_img img").attr("src"),
                tariff_name_eng : card.find('.ration_info i').text(),
                days : card.find('.ration_info span').text(),
                days_index : $('.days_count p.checked').index(),
                section_id : ration.data('section-id'),
                tarif_id : ration.data('tarif-id'),
                menu_id : $('.daily_kk p.checked').data('id'),
                calories : card.find('.ration_info b').text().replace(/[^0-9]/g,""),
                price : card.find('.price b').text().replace(/[^0-9]/g,""),
                price_day : (!card.find('.h5.price + p').text()) ? card.find('.price b').text().replace(/[^0-9]/g,"") : card.find('.h5.price + p').text().replace(/[^0-9]/g,"")
            }
        };
        $.ajax({
            type : "post",
            url : "/site/order",
            data : order_data,
            success : function (res){
                // console.log(res);
                window.location.href = "/site/order";
            }
        })
    })


	var in_progress=false;
    $("form").submit(function () {
		
        var this1 = $(this);
        var form_data = $(this).serialize(); //собераем все данные из формы
        if (is_empty(this1)) {
			if(!this1.hasClass('promocode')){
				//close_popup();
			}
			if(in_progress) {				
				return false;
			}
			in_progress=true;
			$(".loader_block").fadeIn(300);
            $.ajax({
                type: "POST", //Метод отправки
                url: this1.attr('action'), //путь до php фаила отправителя
                data: form_data,
				dataType: 'text',
                success: function (res) {
					if(this1.hasClass('promocode')) {						
						res = JSON.parse(res);
						if(res) {
							$(".loader_block").fadeOut(300);
						//	this1.trigger('reset');
							$('#promocode_error').html('<span class="success">Спасибо! Промокод принят <br><a href="javascript:void(0)" class="remove_promocode">Удалить промокод</a></span>');
							$sale = res.value;
							$sale_type = res.type;
							$sale_summary = res.summary;
							$minsum=res.minsum;
							$('input[name="promo"]').val(res.code);
							if($order_sum>=res.minsum)
                            {
                                if($sale_type==1)
                                    $('input[name="sale"]').val(res.value+' ₽');
                                else if($sale_type==3)
                                {
                                    if($count_days<5)
                                    {
                                        $('#promocode_error').html('<span class="error">Ошибка, промокод действует только от 5 дней и более</span>');
                                    }
                                    else
                                    {
                                        $('input[name="sale"]').val(res.value+'бесплатные дни');
                                        $('#promocode_error').html('<span class="success">Спасибо! Промокод принят. Вам добавлено '+res.value+' '+names(res.value,d_arr)+' <br><a href="javascript:void(0)" class="remove_promocode">Удалить промокод</a></span>');

                                    }
                                }
                                else
                                    $('input[name="sale"]').val(res.value+'%');
                            }
							else
                            {
                                $('#promocode_error').html('<span class="error">Ошибка, минимальная сумма заказа: '+res.minsum+'Руб</span>');
                            }

							hasPromo();
							
							var $s_w_s = ($(".order_info_price b").text()) ? $(".order_info_price b").text() : $(".my_order_price .h5");
                            console.log($s_w_s);
                            $('input[name="sum_w_s"]').val($s_w_s);
						}
						else {
							$('#promocode_error').html('<span class="error">Промокод неверен, или истек его срок</span>');
						}
					}
					else {
                        let ya_id = $("body").data("ya_id");

						//console.log(res);
						//open_popup('thanks_popup');
						if(this1.hasClass('footer_form'))
						{
                            if(ya_id) {
                                ym(ya_id,'reachGoal','f-footer_form');
                            }
							window.location.pathname = "thankscallfooter";

						}
						else if(this1.hasClass('order_form') || this1.hasClass('new_order_form'))
                        {
                            //console.log(this1.find('input[name=pay_online]:checked').val());
                            console.log(res);
                            if(res == '"sum_fail"') {
                                alert('Ошибка оформления заказа! Оформите заказа заново!');
                                window.location.href = '/';
                                return;
                            }
                            if(res.length>10)
                            {
                                if(this1.find('input[name=pay_online]:checked').val()==3)
                                {
                                    document.location.href = res.replace(/['"]+/g, '');
                                    //$('.order_right').append(res)
                                }
                                if(this1.find('input[name=pay_online]:checked').val()==4)
                                {
                                    //document.location.href = res.replace(/['"]+/g, '');
                                    //$('.order_right').append(res)
                                    console.log(res);
                                    
                                    $("body").append(JSON.parse(res));
                                    
                                }
                                else
                                    document.location.href = res.replace(/['"]+/g, '');
                            }
                            else {
                                if(ya_id) {
                                    ym(ya_id,'reachGoal','f-order_form');
                                }
                                window.location.pathname = "thanks";
                            }
                        }
						else if(this1.hasClass('sale_form'))
						{
                            if(ya_id) {
                                ym(ya_id,'reachGoal','f-sale_form');
                            }
							window.location.pathname = "thankssale";
						}
						else if(this1.hasClass('help_form'))
						{
                            if(ya_id) {
                                ym(ya_id,'reachGoal','f-help_form');
                            }
							window.location.pathname = "thankshelp";
						}
                        else if(this1.hasClass('detox_form'))
                        {
                            if(res.length>10)
                            {
                                if(this1.find('input[name=pay_online]:checked').val()==3)
                                {
                                    document.location.href = res.replace(/['"]+/g, '');
                                    //$('.order_right').append(res)
                                }
                                if(this1.find('input[name=pay_online]:checked').val()==4)
                                {
                                    //document.location.href = res.replace(/['"]+/g, '');
                                    //$('.order_right').append(res)
                                    console.log(res);

                                    $("body").append(JSON.parse(res));

                                }
                                else
                                    document.location.href = res.replace(/['"]+/g, '');
                            }
                            else {
                                if(ya_id) {
                                    ym(ya_id,'reachGoal','f_detox-form');
                                }
                                window.location.pathname = "thanks";
                            }



                        }
						else if(res=='"call"'){
                            if(ya_id) {
                                ym(ya_id,'reachGoal','f-header_form');
                            }
							window.location.pathname = "thankscall";
						}
						else {
							window.location.pathname = "thanks";
						}
                        //this1.trigger('reset');
					}
					in_progress=false;
					$(".loader_block").fadeOut(300);
					grecaptcha.execute('6Lc61LgUAAAAAM4O_24pDfhzJc0MzdyG4Wt0gvgb', { action: 'contact' }).then(function (token) {
        				$('.recaptchaResponse').val(token);
        			});
                    // alert('Ваше сообщение успешно отправлено');
                    //код в этом блоке выполняется при успешной отправке сообщения
                }
            });
        }
        else {
            //alert("Все поля обязательны к заполенению")
            if($(".my_order_box").length) {
                const y = this1.find('.req.invalid')[0].getBoundingClientRect().top + window.scrollY;
                console.log(y);
                window.scroll({
                    top: y-200,
                    behavior: 'smooth'
                });
            }

        }
        return false;
    });
    // var input_phone = $('input[name=phone]');
    // if(input_phone.length) {
    //     input_phone.mask('+7 (000) 000-00-00');
	//
	// 	input_phone.on('focus', function () {
	// 		if ($(this).val().length == 0) {
	// 			$(this).val('+7 (');
	// 		}
	// 	});
    // }
    const dadata = $(".dadata").data("dadata");
    $(".dadata").suggestions({
        // Замените на свой API-ключ
        token: dadata,
        type: "ADDRESS",
        // Вызывается, когда пользователь выбирает одну из подсказок
        onSelect: function(suggestion) {
            //console.log(suggestion);

            $("[name='address_extra']").val(JSON.stringify(suggestion))
            //console.log($("[name='address_extra']").val());
        }
    });

    var customOptions = {
      onKeyPress: function(val, e, field, options) {
    
        if (val.replace(/\D/g, '').length===2)
        {
            ///[0-8]/gm
            val = val.replace('8','');
            field.val(val);
         }
         field.mask("+7 (999) 999-99-999", options);
        },
        placeholder: "+7 (000) 000-00-00" 
    };
    
    $("input[name='phone']").mask("+7 (999) 999-99-999", customOptions);
    
    
    /*var input_phone = $('input[name=phone]');
    if(input_phone.length) {
        input_phone.on('focus', function () {
            if ($(this).val().length == 0) {
                $(this).val('+7');
            }
        });
    }*/

});

function is_empty(elem) {
    var a;
    elem.find('.req').each(function () {
        if ($(this).val().length == 0 || !$(this).val().replace(/\s+/g, '')) {
            $(this).addClass('invalid');
            a = 0;
        }
        else if (($(this).hasClass("phone") || $(this).attr("name") == "phone" ) && !validatePhone($(this).val())) {
            $(this).addClass('invalid');
            a = 0;
        }
        else if ($(this).hasClass("mail") && !validateEmail($(this).val())) {
            $(this).addClass('invalid');
            a = 0;
        }
        else if($(this).hasClass("dis_date") && !isValidCustomDateFormat($(this).val())) {
            alert("Неверный формат даты");
            $(this).addClass('invalid');
            a = 0;
        }

        else $(this).removeClass('invalid');
    });


    if (a != 0) a = 1;


    return a;
}

function isValidCustomDateFormat(dateString) {
    const regex = /^\d{2}\.\d{2}\.\d{4}$/;
    if (!regex.test(dateString)) return false;

    const [day, month, year] = dateString.split('.').map(Number);
    const date = new Date(year, month - 1, day);
    return (
        date.getFullYear() === year &&
        date.getMonth() + 1 === month &&
        date.getDate() === day
    );
}
function validatePhone($phone) {
	if($phone.length>=18)
		return true;
	else 
		return false;
    let phoneReg = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{0,6}$/im;
    return phoneReg.test($phone)
}
function validatePhone1($phone) {
    //let phoneReg = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{0,6}$/im;
    let phoneReg = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/im;
    return phoneReg.test($phone)
}
function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}


function getScrollbarWidth() {
    var outer = document.createElement("div");
    outer.style.visibility = "hidden";
    outer.style.width = "100px";
    outer.style.msOverflowStyle = "scrollbar";
    document.body.appendChild(outer);
    var widthNoScroll = outer.offsetWidth;
    outer.style.overflow = "scroll";
    var inner = document.createElement("div");
    inner.style.width = "100%";
    outer.appendChild(inner);
    var widthWithScroll = inner.offsetWidth;
    outer.parentNode.removeChild(outer);
    return widthNoScroll - widthWithScroll;
}
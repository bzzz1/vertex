Array.prototype['show'] = function() {console.table(this)};

Scroll = 0;
Items = [];
Nps = [];
Cities = [];
Offices = [];
runItemHovering();
checkCartBtn();
getXHRData();

// MUST be declared here
$('.cart-btn').off().on('click', function() {
	runCart();
	saveScroll();
});

//tooltip
$('#name').tooltip();


$('.open-cart-btn').off().on('click', function(evt2) {
	evt2.preventDefault();
	var id = $(this).closest('.item').data('id');
	Cart.push(id);
	writeCartToCookie(Cart);
	enableCartBtn();
	runCart();
});

/*----------------------------------------------*/
function postPurchase(data) { 
	$.post("/postPurchase", data);
}

function getXHRData() { 
	$.getJSON('/ajaxItems', function (data) {
		Items = data;
	});

	setTimeout(function() { 
		$.getJSON('/ajaxNp', function (data) {
			Nps = data;
			embedNps();
		})
	}, 1000);

	$('.item-page').load('async/async.html .item-page-ctnt');
}

function checkCartBtn() {
	if ($.cookie('Cart')) {
		Cart = $.parseJSON($.cookie('Cart'));
		if (Cart.length == 0) {
			Cart = [];
			disableCartBtn();
		} else {
			setTimeout(function() { 
				enableCartBtn();
			}, 1000);
		}
	} else {
		Cart = [];
		disableCartBtn();
	}
}

function embedNps() {
	for (var i=0; i<Nps.length; i++) {
		Cities.push(Nps[i].cityRu);
	}
	Cities = _.uniq(Cities).sort();

	// Embedding Cities
	var $city = $('#city_id');
	for (var i=0; i<Cities.length; i++) {
		var $option = $('<option>'+Cities[i]+'</option>');
		$city.append($option.clone());		
	}

	$('#city_id').change(function() { 
		var city = $(this).val();
		var $office = $('#office_id');
		Offices = _.where(Nps, {cityRu: city});

		// Embeding Offices
		$office.empty();
		for (var i=0; i<Offices.length; i++) {
			var $option = $('<option data-office='+Offices[i].number+'>Отделение №'+Offices[i].number+'</option>');
			$office.append($option.clone());		
		}

		$('#office_id').trigger('change');
	});

	$('#office_id').change(function() { 
		var number = $('#office_id').find(":selected").data('office');
		var office = _.where(Offices, {number: number.toString()});
		$('p.office-address').text(office[0].addressRu);
	});

	$('#city_id').trigger('change');
}

function runItemHovering() {
	$('.item-img-div').hover(function() { 
		$(this).find('.item-img').clearQueue().animate({
		  transform: 'scale(1.1)'
		}, 600);

		$(this).find('.item-shadow').clearQueue().delay(200).fadeIn(400);

		$(this).find('p.item-name').clearQueue().animate({
			'margin-left' : '-290px'
		}, 400);

	}, function() { 
		$(this).find('p.item-name').clearQueue().animate({
			'margin-left' : '290px'
		}, 400);

		$(this).find('.item-shadow').clearQueue().fadeOut(400);

		$(this).find('.item-img').clearQueue().animate({
		  transform: 'scale(1)'
		}, 600);	

	});
}

function disableCartBtn() {
	if (Cart.length == 0) {
		$('.cart-btn').attr('disabled', 'disabled');
	}
}

function enableCartBtn() {
	$('.cart-btn').removeAttr("disabled");
}

function runCart() { 
	$('.cart').fadeIn(400);
	$('html, body').stop(true, false).animate({
		scrollTop: 0
	}, 600);


	insertAmounts();
	runCheckout();
	runCloseIconForCart();
}
/*----------------------------------------------*/
	function insertAmounts() {
		var $container = $('<div class="cont"></div>');
		var $close = $('<img src="icons/close.png" class="close-icon"/>');
		var $checkout = $('<button class="checkout-btn">Оформить Заказ</button>');
		var $total = $('<p class="total"></p>');

		$container.append($close);
		$container.append($checkout);
		$container.append($total);

		var amounts = [];
		var Copy = Cart.slice();

		for (var i=0; i<Copy.length; i++) {
			amounts.push(1);
		}

		for (var i=0; i<Copy.length; i++) {
			for (var j=i+1; j<Copy.length; j++) {
				if (Copy[i] == Copy[j]) {
					amounts[i] += 1;
					amounts.splice(j,1);
					Copy.splice(j,1);
					j--;
				}
			}
		}

		for (var i=0; i<Copy.length; i++) {
			var id = Copy[i];
			var price = _.first(_.where(Items, {id: id})).price;
			var $box = $('<div class="item-box" data-id="'+id+'"></div>');

			var $img = $('<img src="img/vsx'+id+'.jpg" class="cart-img"/>');
			var $amount = $('<p class="amount"></p>');
			var $price = $('<p class="price">'+price+'</p>');
			var $subtotal = $('<p class="subtotal"></p>');

			$box.append($img);
			$box.append($amount);
			$box.append($price);
			$box.append($subtotal);
			$container.append($box);
			$('.cart-ctnt').empty().append($container);

			$('.amount').filter(function(index) {
					return $(this).closest('.item-box').data('id') == Copy[i];
				}).html(amounts[i]);
		}
	}

	function runCheckout() {
		$('.checkout-btn').on('click', function() {
			$('.cart .checkout').slideDown(600);

			$('html, body').animate({
				scrollTop: 400
			}, 600);
		});
	}

	function runCloseIconForCart() {
		$('.close-icon').on('click', function() {
			$('.cart').fadeOut(400);
			$('.checkout').fadeOut(400);
			$('html, body').stop(true, false).animate({
				scrollTop: Scroll
			}, 600);
		});
	}
/*----------------------------------------------*/
function runCloseIconForItem() {
	$('.close-icon').on('click', function() {
		$('.item-page').fadeOut(400);
		$('html, body').stop(true, false).animate({
			scrollTop: Scroll
		}, 600);
	});
}

function saveScroll() {
	Scroll = $(window).scrollTop();
}

function clearCart() {
	Cart = [];
	writeCartToCookie(Cart);
}

function writeCartToCookie(Cart) {
	$.cookie('Cart', JSON.stringify(Cart), { expires: 365 });
}
(function ($) {
	$subcategories = $('.subcategory_block');
	$('.category_icon_block').on('click', function() {
		var $this = $(this);
		var category = $this.data('category');
		var $subcategory = $subcategories.filter(function(index) {
			return $(this).data('category') === category;
		});
		var url = $this.css('background-image');
		var new_url = url.replace("0", "1");
		var new_url = new_url.replace("http://localhost:8100/", "http://localhost:8000/");
		console.log(new_url);
		$this.css('background-image', new_url);
		$this.trigger('mouseenter');
		$subcategories.slideUp();
		$subcategory.delay(400).slideDown();
		// console.log($subcategories);
	});	
})(jQuery);
(function ($) {
	function run_subcategories() {
		$subcategories = $('.subcategory_block');
		$categories = $('.category_icon_block');
		$('.category_icon_block').on('click', function() {
			var $this = $(this);
			var category = $this.data('category');
			var classes = $this.attr('class');
			var was_shown = !!(classes.indexOf('_hover') > 0);
			var deselect = classes.slice(0, classes.length-6);
			var select = classes + '_hover';
			var $subcategory = $subcategories.filter(function(index) {
				return $(this).data('category') === category;
			});

			// first, hide all opened subcategories and deselect
			$.each($categories, function(index, value) {
				var $this = $(this);
				var classes = $this.attr('class');
			 	var deselect = classes.slice(0, classes.length-6);
				var was_shown = !!(classes.indexOf('_hover') > 0);

				if (was_shown) {
					$this.attr('class', deselect);
				}
			});

			$subcategories.clearQueue().slideUp();
			// if this was selected
			if (was_shown) {
				$this.attr('class', deselect);
			} else { // else show appropriate subcategories
				$this.attr('class', select);
				$subcategory.clearQueue().delay(400).slideDown();
			}

			// var url = $this.css('background-image');
			// var new_url = url.replace("0", "1");
			// var new_url = new_url.replace("http://localhost:8100/", "http://localhost:8000/");
			// var splitted = select.split(/\s/); // get all classes
			// var space_index = select.indexOf(' ');
			// console.log('space_index: ', space_index);
			// select = select.substring(space_index, selecting.length);

		});
	}

	function run_article_button_read() {
		$('.article_button_read').on('click', function() {
			var $this = $(this);
			var $p = $this.prev();

			if ($this.hasClass('shown')) {
				$this.removeClass('shown');
				$this.text('Читать');
				$p.css({
					'overflow-y': 'hidden',
					'height': '290px'
				});
			} else {
				$this.addClass('shown');
				$this.text('Скрыть');
				$p.css({
					'overflow-y': 'initial',
					'height': 'auto'
				});
			}
		});
	}

	function run_deleting_confirm() {
		$('.confirm_delete').on('click', function() {
			if (confirm('Подтвердить удаление')) {
				$form = $(this).closest('.confirm_form');
				$form.trigger('sumbmit');
			} else {
				return false;
			}
		});
	}

	function run_angular_preview() {
		var app = angular.module('preview', []);
		/*------------------------------------------------
		| CHANGE TEMPLATE BRACKETS
		------------------------------------------------*/
		app.config(function($interpolateProvider) {
			$interpolateProvider.startSymbol('[[');
			$interpolateProvider.endSymbol(']]');
		});
		/*----------------------------------------------*/

		app.controller('PreviewController', function($scope, $http) {

			$scope.origin = location.origin;
			$scope.categories = [
				'Барное',
				'Нейтральное',
				'Посуда и инвентарь',
				'Посудомоечное',
				'Технологическое',
				'Упаковочное',
				'Хлебопекарное',
				'Холодильное'
			];

			// wrong location.href for admin
			$http.post(location.href).success(function(data) {
				$scope.element = data;
			});
		});
	}

	run_deleting_confirm();
	run_angular_preview();
	run_subcategories();
	run_article_button_read();

})(jQuery);
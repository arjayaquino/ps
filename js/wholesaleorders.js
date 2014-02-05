(function($){
	$(function(){
		
		var $wholesaleContent = $("#wholesale-content");
		var $wholesaleCatContainer = $wholesaleContent.find("#wholesale-category-container");
		var $placeOrderButton = $wholesaleContent.find("button#placeorder");
		var isFormSubmitting = false;
		var currFormIndex = 0;
		var formsToSubmit = [];
		
		
		function init(){
			setTimeout(function(){
				//$wholesaleCatContainer.find(".single_add_to_cart_button").addClass("add_to_cart_button product_type_simple");
				$wholesaleCatContainer.find("input[name='quantity']").attr("value", "0")
			}, 500);
			initCategorySelection();
			initPlaceOrder();
		}
		init();
		
		function initCategorySelection(){
			$wholesaleContent.find(".cat-item input[type='checkbox']").each(function(index){
				var $catCheckbox = $(this);
				var catName = $catCheckbox.attr("name");
				var $catContent = $wholesaleCatContainer.find("#cat-"+catName);
				//check first item
				if(index == 0){
					$catCheckbox.prop("checked", true);
					$catContent.show().animate({opacity:1}, 500);
				}
				$catCheckbox.on("change", function(e){
					e.preventDefault();
					if($catCheckbox.prop("checked")){
						$catContent.stop().show().css("height", "auto").animate({opacity:1}, 500);
					} else {
						$catContent.stop().animate({opacity:0, height:0}, 500, function(){
							$catContent.hide();
						});
					}
				})
			});
		}
		
		function initPlaceOrder(){
			$placeOrderButton.on("click", function(e){
				e.preventDefault();
				if(isFormSubmitting) return;
				
				addItemsToCart();
			});
		}
		
		//get each product that has a quantity of more than 0 and add each to the cart
		function addItemsToCart(){
			formsToSubmit = [];
			currFormIndex = 0;
			
			$wholesaleCatContainer.find(".wholesale-product form input[name='quantity']:visible").each(function(index){
				var $quantityInput = $(this);
				var $form = $quantityInput.parents("form");
				
				if($quantityInput.val() > 0){
					var formVals = $form.serialize();
					var formUrl = $form.attr("action");
					formsToSubmit.push($form);
				}
			});	
			
			//if there's something to submit
			if(formsToSubmit.length > 0){
				var promise = submitAddToCartForms();

				//when all items have been added to cart 
				$.when(promise).then(function(status) {
					allItemsAddedToCart();
				});
			} 
		}
		
		//submit forms one by one
		function submitAddToCartForms(){
			isFormSubmitting = true;
			$placeOrderButton.prop("disabled", isFormSubmitting).text("Submitting...");
			$(".fr-loading").show();
			
	  		var allFormsSubmittedDeferred = new $.Deferred();
			
			//submit first form
			submitForm(formsToSubmit[currFormIndex], allFormsSubmittedDeferred);
			
			return allFormsSubmittedDeferred.promise();
		}
		
		function submitForm($form, allFormsSubmittedDeferred){
			var vals = $form.serialize();
			var url = $form.attr("action");
			
			$.post(url, vals, 
				function(data){ 
					onFormSubmitted(allFormsSubmittedDeferred); 
				}
			);
		}
		
		function onFormSubmitted(allFormsSubmittedDeferred){
			currFormIndex++;
			if(currFormIndex < formsToSubmit.length){
				submitForm(formsToSubmit[currFormIndex], allFormsSubmittedDeferred);
			} else {
				allFormsSubmittedDeferred.resolve("Done adding all items");
			}
		}
		
		//when all items are added to cart, send directly to checkout page
		function allItemsAddedToCart(){
			/*isFormSubmitting = false;
			$placeOrderButton.prop("disabled", isFormSubmitting).text("Place Order");
			$(".fr-loading").hide();*/
			window.location = $wholesaleContent.data("checkouturl");
		}
		
	});
})(jQuery);
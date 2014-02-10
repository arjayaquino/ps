(function($){
	$(function(){
		
		var $wholesaleContent = $("#wholesale-content");
		var $wholesaleCatContainer = $wholesaleContent.find("#wholesale-category-container");
		var $placeOrderButton = $wholesaleContent.find("button#placeorder");
		var isFormSubmitting = false;
		var isNeedToShowQuantity = false;
		var currFormIndex = 0;
		var formsToSubmit = [];
		
		
		function init(){
			setTimeout(function(){
				//$wholesaleCatContainer.find(".single_add_to_cart_button").addClass("add_to_cart_button product_type_simple");
				isNeedToShowQuantity = true;
				$wholesaleCatContainer.find("input[name='quantity']").attr("value", "0").trigger("change");
				$wholesaleCatContainer.find(".variations_form .single_variation_wrap").trigger("show_variation");
			}, 500);
			initCategorySelection();
			initPlaceOrder();
			initTotalPriceCalculation();
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
		
		
		
	/**
	 *                            TOTAL CALCULATION
	 * ----------------------------------------
	 */
		
		function initTotalPriceCalculation(){
			if($("#global_wrapper").hasClass("hide-price")){
				return;
			}
			
			$wholesaleCatContainer.find(".quantity input[name='quantity']").each(function(index){
				var $quantityInput = $(this);
				var $parent = $quantityInput.parents(".wholesale-product");
				var $productTotal = $parent.find(".product-total");
				
				$quantityInput.on("change", function(e){
					var amount = getAmountForQuantityClick($quantityInput, $parent);
					var total = getTotal(amount,$quantityInput.val());
					
					showTotal($productTotal, total);
				});
			});
			
			//variation select change
			$wholesaleCatContainer.find(".variations_form").each(function(index){
				var $variationsForm = $(this);
				var $parent = $variationsForm.parents(".wholesale-product");
				var $productTotal = $parent.find(".product-total");
		        var $singleVariationWrap = $variationsForm.find('.single_variation_wrap');
				var productVariations = $variationsForm.data("product_variations");
				
				$singleVariationWrap.on("show_variation", function(e){
					var $quantityInput = $singleVariationWrap.find("input[name='quantity']");
					var $select = $variationsForm.find(".variations select");
					var amount = getAmountForVariationChange(productVariations, $select[0].selectedIndex);
					
					if(amount != null){
						var total = getTotal(amount, $quantityInput.val());
						showTotal($productTotal, total);
					}
				});
			});
		}
		
		function showTotal($productTotal, total){
			$productTotal.find("span").text("$"+total);
			if(isNeedToShowQuantity && !$productTotal.is(":visible")){
				$productTotal.show();
			}
		}
		
		function getAmountForQuantityClick($quantityInput, $parent){
			var $amountText;
			//use variation amount
			if($quantityInput.parents(".variations_button").length > 0){
				$amountText = $parent.find(".product-actions .amount");
			} else {
				$amountText = $parent.find(".product-info .amount");
			}
			return $amountText.text().replace("$", "");
		}
		
		function getAmountForVariationChange(productVariations, selectedIndex){
			var amount = null;
			for(var i=0; i<productVariations.length; i++){
				var variation = productVariations[i];
				if(selectedIndex == (i+1)){
					var $amountHtml = $(variation.price_html).find(".amount");
					amount = $amountHtml.text().replace("$", "");
				}
			}
			return amount;
		}
		
		function getTotal(amount, quantity){
			var total = parseFloat(amount * quantity);
			return total.toFixed(2);
		}
		
		
	/**
	 *                            PLACING ORDER
	 * ----------------------------------------
	 */
		
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
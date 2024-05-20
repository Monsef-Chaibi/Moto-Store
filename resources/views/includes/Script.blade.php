
<!--===============================================================================================-->
<script src="{{ asset('TemplateFile/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('TemplateFile/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('TemplateFile/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{ asset('TemplateFile/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('TemplateFile/vendor/select2/select2.min.js')}}"></script>

<!--===============================================================================================-->
<script src="{{ asset('TemplateFile/vendor/daterangepicker/moment.min.js')}}"></script>
<script src="{{ asset('TemplateFile/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
<script src="{{ asset('TemplateFile/vendor/slick/slick.min.js')}}"></script>
<script src="{{ asset('TemplateFile/js/slick-custom.js')}}"></script>
<!--===============================================================================================-->
<script src="{{ asset('TemplateFile/vendor/parallax100/parallax100.js')}}"></script>
<script>
    $('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>

<!--===============================================================================================-->
<script src="{{ asset('TemplateFile/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('TemplateFile/vendor/sweetalert/sweetalert.min.js')}}"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="{{ asset('TemplateFile/js/main.js')}}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

	</script>
<!--===============================================================================================-->

	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check for success message
        @if(session('success'))
            iziToast.success({
                title: 'Success',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        @endif

        // Check for error message
        @if(session('error'))
            iziToast.error({
                title: 'Error',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        @endif
    });
</script>

<script>
     function updateCartItemCount() {
        $.ajax({
            url: '/cart-item-count',
            method: 'GET',
            success: function(response) {
                $('.js-show-cart').attr('data-notify', response.count);
            },
            error: function() {
                console.error('Failed to fetch cart item count.');
            }
        });
    }
</script>

<script>
    $(document).ready(function(){
        updateCartItemCount();
        fetchCartItems();
     // Add to cart with AJAX
     $('.js-addcart-detail').on('click', function(){
        var quantity = $(this).closest('.size-204').find('.num-product').val();
        var productId = $('#product-id').val();

        // Check if user is logged in
        $.ajax({
            url: '/check-login', // Endpoint to check login status
            method: 'GET',
            success: function(response) {
                if(response.loggedIn) {
                    // User is logged in, add to cart
                    $.ajax({
                        url: '/add-to-cart', // Endpoint to add product to cart
                        method: 'POST',
                        data: {
                            product_id: productId,
                            quantity: quantity,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                iziToast.success({
                                    title: 'Success',
                                    message: data.message,
                                    position: 'topRight'
                                });
                                updateCartItemCount();
                                fetchCartItems();
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: data.message,
                                    position: 'topRight'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            iziToast.error({
                                title: 'Error',
                                message: 'Failed to add product to cart.',
                                position: 'topRight'
                            });
                        }
                    });
                } else {
                    // User is not logged in, show login prompt
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Please log in to add products to your cart.',
                        position: 'topRight'
                    });
                }
            },
            error: function(xhr, status, error) {
                iziToast.error({
                    title: 'Error',
                    message: 'Failed to check login status.',
                    position: 'topRight'
                });
            }
        });
    });

function fetchCartItems() {
    $.ajax({
        url: '/cart-items',
        method: 'GET',
        success: function(response) {
            var cartItems = response.cartItems;
            var cartContent = $('.header-cart-wrapitem');
            cartContent.empty(); // Clear existing cart items
            var total = 0;

            // Populate cart content with fetched cart items
            cartItems.forEach(function(item) {
                var product = item.product;
                var itemHtml = `
                <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="{{ asset('storage') }}/${product.image}" alt="Product Image">
                    </div>
                    <div class="header-cart-item-txt p-t-8">
                        <a href="/Product-Details/${product.id}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">${product.name}</a>
                        <span class="header-cart-item-info">${item.quantity} x ${product.price} MAD</span>
                    </div>
                    <div class="header-cart-item-remove ml-auto">
                        <button class="btn-remove-from-cart" data-product-id="${product.id}">Supprimer</button>
                    </div>
                </li>
                `;
                cartContent.append(itemHtml);
                total += (product.price * item.quantity);
            });

            // Update total cart price
            $('.header-cart-total').text('Total: ' + total.toFixed(2)+ ' MAD');
        },
        error: function() {
            console.error('Failed to fetch cart items.');
        }
    });
}


// Function to remove product from cart
function removeProductFromCart(productId) {
    $.ajax({
        url: '/remove-from-cart', // Endpoint to remove product from cart
        method: 'POST',
        data: {
            product_id: productId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Product removed successfully
                // Reload or update the cart content as needed
                fetchCartItems(); // Example function to fetch and update cart items
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
                updateCartItemCount();
                fetchCartItems();
                fetchCartItemsCheck();
                calculateTotal();
            } else {
                // Failed to remove product
                iziToast.error({
                    title: 'Error',
                    message: response.message,
                    position: 'topRight'
                });
            }
        },
        error: function(xhr, status, error) {
            // Error handling
            iziToast.error({
                title: 'Error',
                message: 'Failed to remove product from cart.',
                position: 'topRight'
            });
        }
    });
}

// Event delegation to handle click event for dynamically added buttons
$('.header-cart-wrapitem').on('click', '.btn-remove-from-cart', function() {
    var productId = $(this).data('product-id');
    // Call the function to remove the product from the cart
    removeProductFromCart(productId);
});

});
</script>

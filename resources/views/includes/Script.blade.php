
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

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Shoping Cart</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    @include('includes.HeadLink')



</head>
<body class="animsition">

	    @include('includes.navbar&cart')

	<!-- breadcrumb -->
	<div class="container mt-24">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="/" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>


	<!-- Shoping Cart -->
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
                                <thead>
                                    <tr class="table_head">
                                        <th class="column-1">Product</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Price</th>
                                        <td class="column-4">QUANTITY</td>
                                        <th class="column-5">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items-body">
                                    <!-- Cart items will be dynamically added here -->
                                </tbody>
                            </table>

						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart
						</h4>



                        @if(Auth::check())
                        <form action="{{ route('CheckoutPaid') }}" method="POST">
                            @csrf

                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">Info :</span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <div class="p-t-15">
                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="email" value="{{ Auth::user()->email }}" >
                                        </div>

                                        <div class="bor8 bg0 m-b-22">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" value="{{ Auth::user()->name }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-t p-t-27 p-b-33">
                                <div class="size-208">
                                    <span class="mtext-101 cl2">Total:</span>
                                </div>

                                <div class="size-209 p-t-1">
                                    <span class="mtext-110 cl2" id="total-price"></span>
                                </div>
                            </div>

                            <input type="hidden" name="amount" value="" id='totalprice'>

                            <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Pay
                            </button>
                        </form>
                    @else
                        <p>You need to <a href="{{ route('login') }}">log in</a> to proceed with the checkout.</p>
                    @endif


					</div>
				</div>
			</div>
		</div>





    @include('includes.Footer')

    <script>
        // Fetch cart items from the server
        function fetchCartItemsCheck() {
    $.ajax({
        url: '/fetch-cart-items', // Endpoint to fetch cart items
        method: 'GET',
        success: function(response) {
            // Clear existing items in the table
            $('#cart-items-body').empty();

            // Initialize total price
            var totalPrice = 0;

            // Iterate through each cart item and populate the table
            response.forEach(function(item) {
                var itemTotal = item.product.price * item.quantity;
                totalPrice += itemTotal;

                var itemHtml = `
                    <tr class="table_row">
                        <td class="column-1">
                            <div class="how-itemcart1">
                                <img src="/storage/${item.product.image}" alt="Product Image">
                            </div>
                        </td>
                        <td class="column-2">${item.product.name}</td>
                        <td class="column-3">${item.product.price} MAD</td>
                        <td class="column-4">${item.quantity}</td>
                        <td class="column-5">${itemTotal} MAD</td>
                    </tr>
                `;
                $('#cart-items-body').append(itemHtml);
            });

            // Update the total price in the span
            $('#total-price').text(`${totalPrice.toFixed(2)} MAD`);
            $('#totalprice').val(totalPrice * 100);
        },
            error: function(xhr, status, error) {
                console.error('Error fetching cart items:', error);
            }
        });
    }

    // Call fetchCartItems initially to populate the table on page load
    $(document).ready(function() {
        fetchCartItemsCheck();
    });



    </script>

	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

    @include('includes.Script')

</body>
</html>


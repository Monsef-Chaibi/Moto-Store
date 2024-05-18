<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    @include('FrontEnd.AdminDash.FrontEnd.Include.HeadLink')

  </head>

  <body>
     <script>
        @if (session('success'))
            iziToast.success({
                title: 'Success',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        @endif

        @if (session('error'))
            iziToast.error({
                title: 'Error',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        @endif
    </script>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- Menu -->
            @include('FrontEnd.AdminDash.FrontEnd.Include.SideBar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Navbar -->
            @include('FrontEnd.AdminDash.FrontEnd.Include.NavBar')
          <!-- / Navbar -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Produit </h4>
                  <!-- Basic Layout & Basic with Icons -->
                  <div class="card">
                    <div class="p-4 flex justify-between w-full">
                        <div>
                            <input type="text" id="searchInput" placeholder="Search" class="p-2 border-1 border-gray-300 rounded">
                        </div>
                        <div class="flex">
                            <select id="defaultSelect" class="form-select w-20 mr-4">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                <!-- Products will be injected here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
              <!--/ Basic Bootstrap Table -->
        </div>

        @include('FrontEnd.AdminDash.FrontEnd.Include.Script')

  </body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const defaultSelect = document.getElementById('defaultSelect');
        const productTableBody = document.getElementById('productTableBody');

        function fetchProducts() {
            const searchQuery = searchInput.value;
            const limit = defaultSelect.value;

            fetch(`/admin/api/products?search=${searchQuery}&limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    productTableBody.innerHTML = '';
                    data.data.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><img src="/storage/${product.image}" alt="${product.name}" class="rounded-circle" style="width: 50px; height: 50px;"></td>
                            <td>${product.name}</td>
                            <td>${product.description}</td>
                            <td>${product.price}</td>
                            <td>${product.quantity}</td>
                        `;
                        productTableBody.appendChild(row);
                    });

                    // Handle pagination (optional)
                    // You might want to add pagination controls and handle them similarly.
                });
        }
        // Initial fetch
        fetchProducts();

        // Fetch products on search or limit change
        searchInput.addEventListener('input', fetchProducts);
        defaultSelect.addEventListener('change', fetchProducts);
    });
    </script>

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    @include('FrontEnd.AdminDash.FrontEnd.Include.HeadLink')

  </head>

  <body>
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
                                    <th>Action</th>
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

        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Modifier le produit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="col mb-2">
                                <label for="productName" class="form-label">Nom</label>
                                <input type="text" id="productName" class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="col mb-2">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea id="productDescription" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="col mb-2">
                                <label for="productPrice" class="form-label">Price</label>
                                <input type="number" id="productPrice" class="form-control" placeholder="Enter Price">
                            </div>
                            <div class="col mb-2">
                                <label for="productQuantity" class="form-label">Quantity</label>
                                <input type="number" id="productQuantity" class="form-control" placeholder="Enter Quantity">
                            </div>
                            <div class="col mb-2">
                                <label for="productImage" class="form-label">Image</label>
                                <input type="file" id="productImage" class="form-control">
                            </div>
                    </div>
                    <input type="hidden" id="productId" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn" onclick="saveProductChanges()">Save changes</button>
                    </div>
                </div>
            </div>
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
                    const imageUrl = `{{ asset('storage') }}/${product.image}`;
                    row.innerHTML = `
                        <td><img src="${imageUrl}" alt="${product.name}" class="rounded-circle" style="width: 50px; height: 50px;"></td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>
                        <td>${product.quantity}</td>
                        <td>
                            <div class="flex">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="editProduct(${product.id})"><i class="bx bx-edit-alt me-1"></i></a>
                                <a href="javascript:void(0);" onclick="deleteProduct(${product.id})"><i class="bx bx-trash me-1"></i></a>
                            </div>
                        </td>
                    `;
                    productTableBody.appendChild(row);
                });
            });
    }

    window.editProduct = function(productId) {
        fetch(`/admin/api/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productDescription').value = product.description;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productQuantity').value = product.quantity;
            });
    };

    window.saveProductChanges = function() {
        const productId = document.getElementById('productId').value;
        const productName = document.getElementById('productName').value;
        const productDescription = document.getElementById('productDescription').value;
        const productPrice = document.getElementById('productPrice').value;
        const productQuantity = document.getElementById('productQuantity').value;
        const productImage = document.getElementById('productImage').files[0];

        const formData = new FormData();
        formData.append('name', productName);
        formData.append('description', productDescription);
        formData.append('price', productPrice);
        formData.append('quantity', productQuantity);
        if (productImage) {
            formData.append('image', productImage);
        }

        fetch(`/admin/products/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                iziToast.success({
                    title: 'Success',
                    message: 'Product updated successfully',
                    position: 'topRight'
                });
                fetchProducts();
                document.getElementById('closeModalButton').click();
            } else {
                iziToast.error({
                    title: 'Error',
                    message: 'Failed to update product',
                    position: 'topRight'
                });
            }
        })
    };

    window.deleteProduct = function(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            fetch(`/admin/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Product deleted successfully',
                        position: 'topRight'
                    });
                    fetchProducts();
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: 'Failed to delete product',
                        position: 'topRight'
                    });
                }
            })
            .catch(error => {
                iziToast.error({
                    title: 'Error',
                    message: 'An error occurred',
                    position: 'topRight'
                });
            });
        }
    };

    // Initial fetch
    fetchProducts();

    // Fetch products on search or limit change
    searchInput.addEventListener('input', fetchProducts);
    defaultSelect.addEventListener('change', fetchProducts);
});


</script>

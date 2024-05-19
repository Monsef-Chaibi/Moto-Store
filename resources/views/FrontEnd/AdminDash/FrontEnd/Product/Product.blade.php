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
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Ajouter Produit</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('StoreProduct')}}" enctype="multipart/form-data">
                            @csrf <!-- This is important for Laravel to prevent CSRF attacks -->
                            <div class="mb-3 flex">
                                <label class="col-sm-2 col-form-label" for="Category">Categories</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="Category" name="category" aria-label="Default select example" required>
                                        <option value="" class="hidden" disabled selected>Choisir une catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" name="name" placeholder="Moto" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="basic-default-company" name="price" placeholder="10" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-email">Quantité</label>
                                <div class="col-sm-10">
                                    <input type="number" id="basic-default-email" class="form-control" name="quantity" placeholder="8" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="formFile" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="formFile" name="image" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                                <div class="col-sm-10">
                                    <textarea id="basic-default-message" class="form-control" name="description" required></textarea>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </form>
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

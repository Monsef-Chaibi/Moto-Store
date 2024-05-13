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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Catégorie </h4>

              <!-- Basic Bootstrap Table -->
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
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="openSidebar()">+ Add Category</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Nom</th>
                        <th>Produits totaux</th>
                        <th>Gain total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
              <!--/ Basic Bootstrap Table -->
        </div>


        <!-- Sidebar -->
        <div id="mySidebar" class="fixed right-0 top-0 w-[25rem] h-full bg-white shadow-xl  translate-x-full duration-300 ease-in-out " style="z-index: 1075 !important">
            <div class="flex justify-between m-4">
                <h2 class="text-xl font-semibold">Ajouter une catégorie</h2>
                <button onclick="closeSidebar()" type="button" class="btn btn-icon btn-outline-primary">
                    X
                </button>
            </div>
            <!-- Form content -->
            <form class="px-4" method="POST" id="saveCategoryForm">
                @csrf
                <label for="NameInEnglish" class="form-label">Nom</label>
                <input
                  type="text"
                  class="form-control mb-2"
                  name="NameInEnglish"
                  id="NameInEnglish"
                  oninput="translateText()"
                  aria-describedby="defaultFormControlHelp"
                />
                <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Category
                </button>
            </form>
        </div>
        <!-- Overlay -->
        <div id="overlay" class="hidden fixed inset-0 bg-gray-200 bg-opacity-30 z-30"></div>

        @include('FrontEnd.AdminDash.FrontEnd.Include.Script')


         <!-- Modal -->
         <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Modifier la catégorie</h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameWithTitle" class="form-label">Nom</label>
                      <input
                        type="text"
                        id="nameWithEn"
                        class="form-control"
                        placeholder="Enter Name"
                      />
                    </div>
                  </div>
                </div>
                <input type="hidden" id="categoryId" value="">
                <div class="modal-footer">
                  <button type="button" id="closeModalButton"class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                  </button>
                  <button type="button" class="btn btn-primary" id="saveChangesBtn" onclick="saveCategoryChanges()">Save changes</button>

                </div>
              </div>
            </div>
          </div>
  </body>
</html>

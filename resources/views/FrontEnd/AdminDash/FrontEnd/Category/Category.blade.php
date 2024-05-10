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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="p-2 flex justify-between w-full">
                    <div>
                        <input type="text" name="" id="" placeholder="Search" class="p-2 border-1 border-gray-300 rounded">
                    </div>
                    <div class="flex">
                        <select id="defaultSelect" class="form-select w-20 mr-4">
                            <option>7</option>
                            <option value="1">10</option>
                            <option value="2">25</option>
                            <option value="2">50</option>
                            <option value="3">100</option>
                        </select>
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="openSidebar()">+ Add Category</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Users</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
                        <td>Albert Cook</td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Lilian Fuller"
                            >
                              <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Sophia Wilkerson"
                            >
                              <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Christina Parker"
                            >
                              <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                          </ul>
                        </td>
                        <td><span class="badge bg-label-primary me-1">Active</span></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
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
                <h2 class="text-xl font-semibold">Add Category</h2>
                <button onclick="closeSidebar()" type="button" class="btn btn-icon btn-outline-primary">
                    X
                </button>
            </div>
            <!-- Form content -->
            <form class="px-4" method="POST" action="{{ route('categories.store') }}">
                @csrf
                <label for="NameInEnglish" class="form-label">Name In English</label>
                <input
                  type="text"
                  class="form-control mb-2"
                  name="NameInEnglish"
                  id="NameInEnglish"
                  oninput="translateText()"
                  aria-describedby="defaultFormControlHelp"
                />

                <label for="NameInFrench" class="form-label">Name In French</label>
                <input
                  type="text"
                  class="form-control"
                  name="NameInFrench"
                  id="NameInFrench"
                  aria-describedby="defaultFormControlHelp"
                />
                <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Category
                </button>
            </form>
        </div>
        <!-- Overlay -->
        <div id="overlay" class="hidden fixed inset-0 bg-gray-200 bg-opacity-30 z-30"></div>



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('AdminDash/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('AdminDash/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('AdminDash/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('AdminDash/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{ asset('AdminDash/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('AdminDash/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('AdminDash/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('AdminDash/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
  </body>
</html>
<script>
function openSidebar() {
    document.getElementById("mySidebar").style.transform = "translateX(0%)";
    document.getElementById("overlay").classList.remove("hidden");
    document.getElementById("layout-navbar").style.zIndex = "0";
}

function closeSidebar() {
    document.getElementById("mySidebar").style.transform = "translateX(100%)";
    document.getElementById("overlay").classList.add("hidden");
    document.getElementById("layout-navbar").style.zIndex = "1075";

}

// Add click event listener to overlay to close sidebar
document.getElementById("overlay").addEventListener('click', function() {
    closeSidebar();
});

    function translateText() {
        const input = document.getElementById('NameInEnglish').value;
        fetch('/translate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text: input, target_language: 'fr' })  // Adjust target language as needed
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('NameInFrench').value = data.translatedText; // Consider renaming this ID to match the language
            } else {
                console.error('Translation failed:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>

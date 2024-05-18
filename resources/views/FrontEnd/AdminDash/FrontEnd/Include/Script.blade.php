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

    <script>

        // Function To Open Or Close Side bar

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


    document.getElementById("overlay").addEventListener('click', function() {
        closeSidebar();
    });

    // Function To translate a name of category to french

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

    //  Function to Store A new Category

    document.getElementById('saveCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('{{ route("categories.store") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            iziToast.success({
                title: 'Success',
                message: data.message,
                position: 'topRight'
            });
            loadCategories();
            document.getElementById('NameInEnglish').value = '';
            document.getElementById('NameInFrench').value = '';
        })
        .catch((error) => {
            iziToast.error({
                title: 'Error',
                message: 'Failed to save category',
                position: 'topRight'
            });
        });
    });


    // Show All Category in table

    function loadCategories() {
        const search = document.getElementById('searchInput').value;
        const limit = document.getElementById('defaultSelect').value;

        fetch(`{{ route('categories.index') }}?search=${search}&limit=${limit}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('categoryTableBody');
            tableBody.innerHTML = '';
            data.data.forEach(category => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${category.name_en}</td>
                    <td>${category.total_products || 0}</td>
                    <td>${category.total_earning || '0.00'}</td>
                    <td>
                        <div>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalCenter" onclick="editCategory(${ category.id })">
                                <i class="bx bx-edit-alt me-1"></i>
                            </a>
                            <a href="javascript:void(0);" onclick="deleteCategory(${category.id})">
                                <i class="bx bx-trash-alt me-1"></i>
                            </a>
                        </div>
                    </td>
                `;
            });
        })
        .catch(error => console.error('Error:', error));
    }

    document.getElementById('searchInput').addEventListener('input', loadCategories);
    document.getElementById('defaultSelect').addEventListener('change', loadCategories);


    // Initially load categories when the page loads
    window.onload = function() {
        loadCategories();
    };




    // Delete Category
    function deleteCategory(categoryId) {
        fetch(`/admin/categories/${categoryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            iziToast.success({
                title: 'Success',
                message: data.message,
                position: 'topRight'
            });
            loadCategories();
        })
        .catch(error => {
            iziToast.error({
                title: 'Error',
                message: 'Failed to delete category',
                position: 'topRight'
            });
        });
    }


    // Show Data in modal
    function editCategory(categoryId) {
        fetch(`/admin/categories/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('categoryId').value = data.id;
            document.getElementById('nameWithEn').value = data.name_en; // Adjust according to your data object keys
            document.getElementById('nameWithFr').value = data.name_fr;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


    function saveCategoryChanges(){
    var categoryId = document.getElementById('categoryId').value;
    var nameEn = document.getElementById('nameWithEn').value;
    var nameFr = document.getElementById('nameWithFr').value;

    fetch(`/admin/categories/${categoryId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
        },
        body: JSON.stringify({ name_en: nameEn, name_fr: nameFr })
    })
    .then(response => response.json())
    .then(data => {
        iziToast.success({
                title: 'Success',
                message: data.message,
                position: 'topRight'
            });
            loadCategories();
            document.getElementById('closeModalButton').click();

    })
    .catch(error => {
        iziToast.error({
                title: 'Error',
                message: 'Failed to updtate category',
                position: 'topRight'
            });
    });
    };


    </script>

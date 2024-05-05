@extends('layouts.app')
@section('title', 'User Management')
@section('content')

    <head>
        <style>
            /* Custom CSS to change link color */
            .user-link {
                color: black !important;
                text-decoration: none;
                position: relative;
            }

            .user-link::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: -5px;
                width: 0%;
                height: 2px;
                background-color: #012F12;
                transition: width 0.3s ease, left 0.3s ease;
                /* Added left transition */
            }

            .user-link.click::after {
                width: 100%;
                left: 0;
                /* Reset position */
            }

            .userLink {
                cursor: pointer;
                display: block;
                padding: 0.5rem 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                margin-bottom: 0.5rem;
                color: white;
                text-decoration: none;
            }

            .userLink:focus {
                background-color: #ffc107 !important;
                /* Change background color when link is clicked */
                color: black !important;
                /* Change text color when link is clicked */
            }

            .btn-success {
                border: none !important;
            }

            .btn-success.active {
                border: none;
                background-color: #ffc107 !important;
                /* Change background color when link is clicked */
                color: black !important;
            }

            /* Adjust checkbox size */
            input[type="checkbox"] {
                transform: scale(1.5);
                /* Increase checkbox size */
                margin-right: 5px;
                border: none;
                /* Add spacing between checkbox and label */
            }

            /* Make text bigger and bold */
            .form-check-label {
                font-size: 18px;
                font-weight: bold;
            }

            /* Hide content by default */
            .user-content {
                display: none;
            }

            /* Slide animation */
            .user-content.show {
                display: block;
                animation: slideIn 0.5s ease forwards;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <!-- Content Header (Page header) -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Navbar -->
                <div class="nav justify-content-center">
                    <h5><a href="#" class="nav-link user-link click"
                            onclick="toggleUnderline(event, this); toggleContent('usersDetail')">Users Detail</a></h5>
                    <h5><a href="#" class="nav-link user-link"
                            onclick="toggleUnderline(event, this); toggleContent('usersPermission')">Users Permission</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    {{-- Table for User Management --}}


    <!-- Content for Users Detail -->
    <div class="user-content show" id="usersDetail">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h1 class="">{{ __('Users') }}</h1>
                        <div class="btn btn-success" id="addNewUser">New Users</div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        @include('modals.user.add_user')
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table col-12" id="usersTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>User Name</th>
                                <th>Roles</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table data goes here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Content for Users Permission -->
    <div class="user-content p-5" id="usersPermission">
        <!------- This is the User Permission Section ------>
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">Users</h5>
                        </div>
                        <!-- HTML input for searching user names -->
                        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                            <!-- Add max-height and overflow-y -->
                            <input type="text" id="searchInput" class="form-control mb-4" placeholder="Search Users" />
                            <!-- List of all users -->
                            <div id="userList">
                                <!-- Users will be populated dynamically -->
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <!-- User Name display -->
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0" id="userName"></h5>
                        </div>
                        <!-- Descriptions and Actions table -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="descriptionTable">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th style="width: 70%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Description and actions will be populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success" id="logValuesBtn">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample user data
        const users = [{
                user_id: 1,
                role_id: 1,
                name: "Vhinz John",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
            {
                user_id: 2,
                role_id: 2,
                name: "John Doe",
                description: [{
                        title: "Masterlist",
                        privileges: ["read"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            // Add more dummy users
            {
                user_id: 3,
                role_id: 3,
                name: "Alice Smith",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write", "delete"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 4,
                role_id: 4,
                name: "Bob Johnson",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 5,
                role_id: 5,
                name: "Eva Green",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
            {
                user_id: 6,
                role_id: 6,
                name: "Michael Brown",
                description: [{
                        title: "Masterlist",
                        privileges: ["read"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 7,
                role_id: 7,
                name: "Sophia Martinez",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 8,
                role_id: 8,
                name: "William Wilson",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
            {
                user_id: 9,
                role_id: 9,
                name: "Emma Taylor",
                description: [{
                        title: "Masterlist",
                        privileges: ["read"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 10,
                role_id: 10,
                name: "James Anderson",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
            {
                user_id: 4,
                role_id: 4,
                name: "Bob Johnson",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 5,
                role_id: 5,
                name: "Eva Green",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
            {
                user_id: 6,
                role_id: 6,
                name: "Michael Brown",
                description: [{
                        title: "Masterlist",
                        privileges: ["read"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 7,
                role_id: 7,
                name: "Sophia Martinez",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 8,
                role_id: 8,
                name: "William Wilson",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
            {
                user_id: 9,
                role_id: 9,
                name: "Emma Taylor",
                description: [{
                        title: "Masterlist",
                        privileges: ["read"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update", "delete"]
                    },
                ],
            },
            {
                user_id: 10,
                role_id: 10,
                name: "James Anderson",
                description: [{
                        title: "Masterlist",
                        privileges: ["read", "write"]
                    },
                    {
                        title: "Projects",
                        privileges: ["read", "update", "delete"]
                    },
                    {
                        title: "Transactions",
                        privileges: ["read", "update"]
                    },
                ],
            },
        ];


        // Function to render users list
        function renderUserList() {
            const userList = $("#userList");
            userList.empty();
            users.forEach((user) => {
                const userLink = $("<a>")
                    .attr("href", "#")
                    .text(user.name)
                    .addClass("userLink btn btn-success")
                    .click(function() { // Change to regular function
                        // Remove "active" class from all buttons
                        $(".btn-success").removeClass("active");
                        // Add "active" class to the clicked button
                        $(this).addClass("active");
                        $("#userName").text(user.name);
                        renderDescriptionTable(user);
                    });
                userList.append(userLink);
            });
        }





        // Function to render description and actions table
        function renderDescriptionTable(user) {
            const descriptionTable = $("#descriptionTable tbody");
            descriptionTable.empty();
            user.description.forEach((desc) => {
                const row = $("<tr>");
                const titleCell = $("<td>").text(desc.title);
                const actionCell = $("<td>").addClass("row"); // Make actions cell a row
                const privileges = ["read", "write", "update", "delete"];
                let counter = 0;
                const checkboxDiv = $("<div>").addClass("col-md-6"); // Create a column for each checkbox
                privileges.forEach((privilege) => {
                    const checkbox = $("<input>")
                        .attr("type", "checkbox")
                        .attr("name", privilege)
                        .addClass("form-check-input")
                        .prop("checked", desc.privileges.includes(privilege));
                    const label = $("<label>")
                        .addClass("form-check-label mb-0") // Add Bootstrap class to label
                        .text(privilege.charAt(0).toUpperCase() + privilege.slice(1))
                        .click(() => {
                            // Toggle checkbox state when label is clicked
                            checkbox.prop("checked", !checkbox.prop("checked"));
                        })
                        .css("cursor", "pointer"); // Add cursor pointer to label
                    const checkboxContainer = $("<div>").addClass(
                        "form-check form-check-inline"); // Add Bootstrap class to checkbox container
                    checkboxContainer.append(checkbox, label);
                    checkboxDiv.append(checkboxContainer);
                    counter++;
                    if (counter % 2 === 0) {
                        actionCell.append(checkboxDiv.clone()); // Clone the column for the next row
                        checkboxDiv.empty(); // Clear the cloned column
                    }
                });
                // Check if there's an odd number of privileges and append the remaining checkboxDiv
                if (privileges.length % 2 !== 0) {
                    actionCell.append(checkboxDiv);
                }
                row.append(titleCell, actionCell);
                descriptionTable.append(row);
            });
        }


        // Function to filter users based on search input
        function filterUsers(searchQuery) {
            return users.filter((user) =>
                user.name.toLowerCase().includes(searchQuery.toLowerCase())
            );
        }

        // Initialize the page
        $(document).ready(function() {
            // Render initial user list
            renderUserList();

            // Bind input event to search input field
            $("#searchInput").on("input", function() {
                const searchQuery = $(this).val();
                const filteredUsers = filterUsers(searchQuery);
                const userList = $("#userList");
                userList.empty(); // Clear existing user list
                filteredUsers.forEach((user) => {
                    const userLink = $("<a>")
                        .attr("href", "#")
                        .text(user.name)
                        .addClass("userLink btn btn-success")
                        .click(function() { // Change to regular function
                            // Remove "active" class from all buttons
                            $(".btn-success").removeClass("active");
                            // Add "active" class to the clicked button
                            $(this).addClass("active");
                            $("#userName").text(user.name);
                            renderDescriptionTable(user);
                        });
                    userList.append(userLink);
                });
            });

        });
    </script>

    <script>
        function toggleUnderline(event, element) {
            event.preventDefault(); // Prevent default link behavior

            // Remove 'click' class from all links
            document.querySelectorAll('.user-link').forEach(link => {
                link.classList.remove('click');
            });

            // Add 'click' class to the clicked link
            element.classList.add('click');
        }

        function toggleContent(contentId) {
            // Toggle the display of content
            document.getElementById('usersDetail').classList.toggle('show', contentId === 'usersDetail');
            document.getElementById('usersPermission').classList.toggle('show', contentId === 'usersPermission');
        }
    </script>


    <script>
        $('#addNewUser').click(function() {
            console.log('Hello World');
            $('#addUsersModal').modal('show');
            // Show modal after
            // addusersModal is the id
        });

        $("#usersTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "searching": true,
            "ordering": true,
            "paging": true,
        });
        refreshUsersTable();

        function refreshUsersTable() {
            // Check if data is already cached in localStorage
            const cachedData = localStorage.getItem('usersData');

            if (cachedData) {
                // If cached data exists, parse and use it
                displayUsers(JSON.parse(cachedData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('users.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('usersData', JSON.stringify(data));
                    // Display the fetched data
                    displayUsers(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function displayUsers(data) {
            const table = $('#usersTable').DataTable();
            table.clear().draw();

            data.forEach(function(user, index) {
                const editButton =
                    `<button type="button" class="btn bg-success mr-2" data-id="${user.user_id}" data-name="${user.first_name}" data-pay-item="${user.middle_name}"><i class="fas fa-edit"></i></button>`;
                const deleteButton =
                    `<button type="button" class="btn bg-danger" data-id="${user.user_id}"><i class="fas fa-trash-alt"></i></button>`;
                const buttonsContainer = '<div class="text-center d-flex">' + editButton + deleteButton + '</div>';

                const newRow = table.row.add([
                    user.first_name,
                    user.middle_name,
                    user.last_name,
                    user.user_name,
                    user.roles,
                    user.email,
                    // user.password,
                    buttonsContainer
                ]).node();
            });

            table.draw();

            // Add event listeners for dynamically created buttons
            // $('#particularTable').on('click', '.editParticularButton', function() {
            //     const particularId = $(this).data('id');
            //     const particularName = $(this).data('name');

            //     const payItem = $(this).data('pay-item');
            //     openParticularModal(particularId, particularName, payItem);
            // });

            // $('#particularTable').on('click', '.deleteParticularButton', function() {
            //     const particularId = $(this).data('id');
            //     deleteParticular(particularId);
            // });
        }



        $(document).ready(function() {
            // Handle Adding of Paticular
            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                // Get form data
                let firstName = $('#add_first_name').val();
                let middleName = $('#add_middle_name').val();
                let lastName = $('#add_last_name').val();
                let userName = $('#add_user_name').val();
                let email = $('#add_email').val();
                let password = $('#add_password').val();
                let role = $('#add_role').val();

                // Make AJAX request to add new paticular
                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    data: {
                        firstName: firstName,
                        middleName: middleName,
                        lastName: lastName,
                        userName: userName,
                        email: email,
                        password: password,
                        roles: role,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // toastr.options.progressBar = true;
                        // toastr.success('Project Added Successfully!');
                        console.log(response); // Log response for debugging

                        if (response) {
                            $('#addUserForm')[0].reset();
                            $('#addUsersModal').modal('hide');

                            console.log('successfully added');

                            refreshUsersTable();

                        } else {
                            // Show error message if material addition fails
                            alert('Failed to add project: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        toastr.error('Name/Email already existed');
                    }
                });
            });

            // Handle Editing of Paticular
            $('#editParticularForm').submit(function(e) {
                console.log('Form submit')
                e.preventDefault();

                // Get form data
                let particularID = $('#edit_particular_id').val();
                let particularName = $('#edit_particular_name').val();
                let description = $('#edit_description').val();


                // Make AJAX request to update the project
                $.ajax({
                    url: "{{ route('particulars.update', ['id' => ':id']) }}".replace(':id',
                        particularID),
                    type: "PUT", // Assuming you are using PUT method for update, change it if needed
                    data: {
                        particular_name: particularName,
                        description: description,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Project Updated Successfully!');
                        console.log(response); // Log response for debugging

                        if (response) {
                            // Optionally, you can reset the form and close the modal here
                            $('#editParticularForm')[0].reset();
                            $('#editParticularModal').modal('hide');

                            refreshParticularTable(); // Update the materials table
                        } else {
                            // Show error message if project update fails
                            alert('Failed to update project: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });

            // Add event listener for the button
            $("#logValuesBtn").click(() => {
                // Get the current user details
                const userName = $("#userName").text();
                const currentUser = users.find(user => user.name === userName);
                if (!currentUser) {
                    alert("Please select a user");
                    return;
                }

                // Initialize the table values object
                const tableValues = {
                    user_name: currentUser.name,
                    user_id: currentUser.user_id,
                    role_id: currentUser.role_id,
                    descriptions: []
                };

                // Accumulate descriptions and actions
                $("#descriptionTable tbody tr").each(function() {
                    const description = $(this).find("td:first-child").text();
                    const actions = [];
                    $(this).find("input[type='checkbox']").each(function() {
                        const privilege = $(this).attr("name");
                        const isChecked = $(this).prop("checked");
                        if (isChecked) {
                            actions.push(privilege);
                        }
                    });
                    tableValues.descriptions.push({
                        description,
                        actions
                    });
                });

                // Log the table values
                console.log("Table Values:");
                console.log(tableValues);
            });

        });
    </script>


@endsection

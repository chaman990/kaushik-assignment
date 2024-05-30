<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .form-group .error{
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <form id="userForm">
            <div class="form-group">
                <label for="name">Name:</label><br>
                <input class="form-control" type="text" id="name" name="name" required><br>
            </div>

            <div class="form-group">
                <label for="email">Email:</label><br>
                <input type="email" class="form-control" id="email" name="email" required><br>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label><br>
                <input type="text" class="form-control" id="phone" name="phone" required><br>
            </div>

            <div class="form-group">

                <label for="description">Description:</label><br>
                <textarea id="description" name="description" class="form-control" required></textarea><br>
            </div>


            <div class="form-group">

                <label for="roleId">Role ID:</label><br>
                <input class="form-control" type="number" id="roleId" name="roleId" required><br>
            </div>


            <div class="form-group">

                <label for="profileImage">Profile Image:</label><br>
                <input type="file" id="profileImage" name="profileImage" accept="image/*" required><br>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <div id="userData"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            $.validator.addMethod("indianPhone", function(phoneNumber, element) {
                phoneNumber = phoneNumber.replace(/\s+/g, "");
                return this.optional(element) || /^[6-9]\d{9}$/.test(phoneNumber);
            }, "Please enter a valid Indian phone number");



            $('#userForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        indianPhone: true
                    },
                    description: {
                        required: true
                    },
                    roleId: {
                        required: true
                    },
                    profileImage: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: 'Name is required'
                    }
                },
                submitHandler: function(form) {
                    // Client-side validation
                    // Perform validation here

                    // AJAX request
                    $.ajax({
                        url: '/api/users',
                        type: 'POST',
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            // Clear form fields
                            $('#userForm')[0].reset();

                            // Display success message or handle as needed

                            // Fetch and display all users
                            fetchUsers();
                        },
                        error: function(xhr, status, error) {
                            console.warn(xhr);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = '';
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorMessage += errors[key][0] + '\n';
                                    }
                                }
                                alert(errorMessage);
                            } else {
                                // Handle other errors
                                alert('Error: ' + xhr.responseText);
                            }
                        }
                    });
                    return false; // Prevent default form submission
                }
            });

            // Function to fetch and display all users
            function fetchUsers() {
                $.ajax({
                    url: '/api/users',
                    type: 'GET',
                    success: function(data) {
                        // Display user data in a table
                        var tableHtml = '<table class="table mt-2" border="1"><tr><th>Name</th><th>Email</th><th>Phone</th><th>Description</th><th>Role ID</th><th>Profile Image</th></tr>';

                        $.each(data, function(index, user) {
                            tableHtml += '<tr>';
                            tableHtml += '<td>' + user.name + '</td>';
                            tableHtml += '<td>' + user.email + '</td>';
                            tableHtml += '<td>' + user.phone + '</td>';
                            tableHtml += '<td>' + user.description + '</td>';
                            tableHtml += '<td>' + user?.role?.name + '</td>';
                            tableHtml += '<td><img src="' + user.profile_image + '" alt="Profile Image" width="100"></td>';
                            tableHtml += '</tr>';
                        });

                        tableHtml += '</table>';

                        $('#userData').html(tableHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                        // Handle error
                    }
                });
            }

            // Fetch and display users on page load
            fetchUsers();
        });
    </script>

</body>

</html>
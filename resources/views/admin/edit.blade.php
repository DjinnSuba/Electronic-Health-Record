<!DOCTYPE html>
<html>
<head>
    <!-- Include your common meta tags, stylesheets, and JavaScript here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <!-- Include Bootstrap CSS (Make sure you have Bootstrap CSS linked here) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
          .form-control {
            height: 30%; /* Adjust the height to make the inputs smaller */
            font-size: 14px; /* Adjust the font size */
            width: 30%; /* Adjust the width to make it narrower */
        }

        .container {
            overflow-y: auto; /* Add vertical scroll if content overflows */
            max-height: none; /* Set a fixed max-height for scrolling */
        }

        
        /* Style for custom scrollbar */
        .container::-webkit-scrollbar {
            width: 7px; /* Set the width of the scrollbar */
            height: 1px;
        }

        .container::-webkit-scrollbar-thumb {
             background-color: #B4B4B3; /* Set the color of the scrollbar thumb */
             border-radius: 3px; /* Set the border radius of the thumb */
        }

        .container::-webkit-scrollbar-track {
             background-color: lightgray; /* Set the color of the scrollbar track */
        }

        .form-group {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-bottom: 10px;
}

.form-group label {
    flex: 1;
    text-align: left; /* Align labels to the left */
    font-weight: bold; /* Make labels bold */
}

.form-group .form-control {
    flex: 2;
    height: 30px; /* Adjust the height of the input */
    font-size: 14px; /* Adjust the font size of the input */
    width: 100%; /* Adjust the width of the input */
}

.submit-button {
    text-align: right;
    border-radius: 20px; /* Adjust the border radius as needed */
    border-color: #57ba98 !important; /* Set border color to #57ba98 */
}

form {
    background-color: white; /* Set the form background color to white */
    padding: 20px; /* Add some padding for spacing inside the form */
    border-radius: 10px;
    width: 60%; /* Adjust the width of the form */
    margin: auto; /* Center the form horizontally */
}

    .header {
        background: #17252a;
        border-radius: 10px;
        text-align: center;
        padding: 10px;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .header h1 {
        margin: 0;
    }

    </style>
</head>
<body>
    @include('admin.common') 

    <div class="container">
        
        <!-- Physician Information Form -->
        <div class="mt-4 mx-auto">
        <div class="header">
            <h1 class="text-center">Update Physician Details</h1>
        </div>
            <form method="POST" action="{{url('/admin/update/'.$data->id)}}">
            @csrf
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" value = "{{$data->lastName}}" class="form-control">
                        @error('lastName')<p class="text text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" value = "{{$data->firstName}}" class="form-control">
                        @error('firstName')<p class="text text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="middleName">Middle Name</label>
                    <input type="text" name="middleName" value = "{{$data->middleName}}" class="form-control">
                        @error('middleName')<p class="text text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="cnumber">Contact Number</label>
                    <input type="text" name="cnumber" value = "{{$data->cnumber}}" class="form-control">
                        @error('cnumber')<p class="text text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" value = "{{$data->address}}" class="form-control">
                        @error('address')<p class="text text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <select class="form-control" id="department" name="department">
                        <option {{old('department',$data->department)=="Family Medicine"? 'selected':''}} value="Family Medicine">Family Medicine</option>
                        <option {{old('department',$data->department)=="Physical Therapist"? 'selected':''}} value   ="Physical Therapist">Physical Therapist</option>
                    </select>
                        @error('department')<p class="text text-danger">{{$message}}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option selected="selected" select disabled>----Select Account Status----</option>
                        <option {{old('status',$data->status)=="Active"? 'selected':''}} value="Active">Active</option>
                        <option {{old('status',$data->status)=="Inactive"? 'selected':''}} value="Inactive">Inactive</option>
                    </select>
                        @error('status')<p class="text text-danger">{{$message}}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="license">License Number</label>
                    <input type="text" name="license" value = "{{$data->license}}" class="form-control">
                        @error('license')<p class="text text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="submit-button">
                    <button type="submit" class="btn btn-primary" style="background-color: #57ba98; color: black;">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Bootstrap JavaScript (Make sure you have Bootstrap JS linked here) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
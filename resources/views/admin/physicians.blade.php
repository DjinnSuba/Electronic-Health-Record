<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS for center-aligning column labels and creating gaps */
        th {
            text-align: center; /* Center-align column labels */
            background-color: #17252a; /* Set background color to dark */
            color: white; /* Set text color to white */
        }
        td, th {
            padding: 10px; /* Add padding to create gaps between columns */
        }
        tr {
            background-color: white; /* Set table rows to white background color */
        }

        .rounded-button {
            border-radius: 10px; /* Adjust the border radius as needed */
            border-color: #57ba98 !important; /* Set border color to #57ba98 */
        }

        .table-bordered{
            overflow-y: auto;
            
        }
        .selected-row {
            background-color: #57ba98 !important; /* Set background color to #57ba98 for selected rows */
        }

        .container{
        overflow: scroll;
        margin: 5% 1% 5% 5%;
        background-color: #2b7a78;
        padding: 3%;
        width: 90%;
        height: 500px;
        }
        .name, .td{
          overflow: scroll;
          overflow-x: auto;
          max-height: 400px; 
          
        }
        .td::-webkit-scrollbar {
        width: 5px; /* Adjust the width as needed */
    }

    .td::-webkit-scrollbar-thumb {
        background-color: white; /* Color of the thumb */
        border-radius: 10px; /* Roundness of the thumb */
    }

    .td::-webkit-scrollbar-track {
        background-color: #f1f1f1; /* Color of the track */
    }

    .td label {
        color: #feffff; /* Set font color to white */
        font-size: 14px;
    }
    </style>
</head>
<body>
    @include('admin.common')

    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <ul class="navbar-nav ml-auto"> <!-- Use an unordered list for button placement -->
                <h3>Staff Roster</h3>

                    <li class="nav-item">
                        <!-- Use <a> tag to link to the Register page -->
                        <a href="{{ route('admin.register') }}" class="btn btn-primary rounded-button" style="margin-right: 10px; background-color:#17252a;">Register</a>
                    </li>
                    
                </ul>
            </div>
        </nav>
        <div class="mt-4"></div> <!-- Add margin to separate buttons from the table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Staff Code</th> <!-- Remove inline background-color and text color -->
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th colspan ="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $datum)
                <tr>
                    <td>{{$datum->physicianCode}}</td>
                    <td>{{$datum->firstName}}</td>
                    <td>{{$datum->email}}</td>
                    <td>{{$datum->department}}</td>
                    <td>{{$datum->status}}</td>
                    <td><a href="{{url('/admin/edit/'.$datum->id)}}" class = "btn btn-primary">Edit</a></td>
                    <td><a href="{{url('/admin/delete/'.$datum->id)}}" class = "btn btn-danger">Delete</a></td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JavaScript and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const editButtons = document.querySelectorAll('.edit-button');
        const tableRows = document.querySelectorAll('tbody tr');

        // Add a click event listener to each table row to handle selection
        tableRows.forEach(row => {
            row.addEventListener('click', () => {
                // Remove the selected-row class from all rows
                tableRows.forEach(r => {
                    r.classList.remove('selected-row');
                });

                // Add the selected-row class to the clicked row
                row.classList.add('selected-row');

                // Enable or disable edit buttons based on selection
                editButtons.forEach(button => {
                    button.style.display = row.classList.contains('selected-row') ? 'block' : 'none';
                });
            });
        });

        // Initially, disable all edit buttons
        editButtons.forEach(button => {
            button.style.display = 'none';
        });
    </script>
 
</body>
</html>

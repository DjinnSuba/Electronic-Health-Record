<!DOCTYPE html>
<html>
<head>
    <!-- Include your common meta tags, stylesheets, and JavaScript here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for the first row */
        /* Custom CSS for the table header */
        .table thead th {
            background-color: #17252a; /* Dark teal background color */
            color: #feffff; /* White text color */
            border: none; /* Remove border */
            text-align: center; /* Center-align text in header cells */
            border-bottom: 3px solid #55BDCA; /* Add a bottom border to header cells */
            border-right: 1px solid #ffffff; /* Add a white right border to separate columns */
            /* top: 100px; */
        }

        /* Custom CSS for alternating rows and pointer cursor on hover */
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa; /* Light gray background color for even rows */
        }

        /* Hover effect */
        .table tbody tr:hover {
            background-color: rgba(57, 168, 168, 0.3); /* Faint background color on hover */
            color: #333; /* Dark gray text color on hover */
            border: 1px solid #55BDCA; /* Add a border to cells on hover */
        }

        #patsearch {
            position: absolute;
            color: #333; /* Dark gray text color */
            top: 20px; /* Adjust as needed to position it */
            right: 10px; /* Adjust as needed to position it */
        }
        

        /* Change the border color and add rounded borders to the patient search input, and increase the padding */
        #patsearch input {
            border: 3px solid #ddd; /* Light gray border color */
            border-radius: 6px; /* Slightly rounded border */
            padding: 10px; /* Increase padding for larger boxes */
            background-color: #fff; /* White background color */
            margin-right: 8px;
            color: #333; /* Dark gray text color */
        }

        /* Add custom CSS for the filter button to remove rounded border */
        #patsearch button {
            border: 2px solid #ddd; /* Light gray border color */
            border-radius: 8px; /* Slightly rounded border */
            padding: 10px; /* Increase padding for larger button */
            background-color: #17252A; /* White background color */
            margin-right: 20px;
            color: white; /* Dark gray text color */
            cursor: pointer; /* Add a pointer cursor */
        }

        /* On hover, add a subtle box shadow to create a lifting effect */
        #patsearch input:hover,
        #patsearch button:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Subtle box shadow on hover */
        }

        .list-heading {
            position: absolute;
            color: #333; /* Dark gray text color */
            top: 50px; /* Adjust as needed to position it */
            left: 30px; /* Adjust as needed to position it */
            font-size: 20px; /* Set the font size */
            font-weight: bold; /* Set font weight to bold */
        
        }

        /* Position the table below the patsearch div */
        .table {
            margin-top: 10%; /* Adjust as needed to position the table below the patsearch div */
        }

        .container {
            overflow-y: auto;
            max-height: none;
            position: absolute;
            left: -8px;
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

        .table-container {
            margin-top: 10px;
            max-height: 70vh; 
            /* overflow-y: auto;  */
        }

    </style>
</head>
<body>
    @include('admin.common') <!-- Include the common header and sidebar -->
    <div class="container">
        <div id="patsearch">
            <input type="text" placeholder="Patient Code">
            <button type="button">Filter</button>
        </div>
        <div class="list-heading">
            List of Clinic Patients
        </div>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)

                    <tr class="custom-row" onclick="selectRow(this)">
                        <td>1</td>
                        <td>{{$patient->patientCode}}</td>
                        <td>{{$patient-> lastName}}, {{$patient-> firstName}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

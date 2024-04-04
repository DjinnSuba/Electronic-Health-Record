<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">



    <style>
        body {
            margin: 0;
            font-size: 28px;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #3aafa9;
        }

        #navbar {
            overflow: hidden;
            background-color: #17252a;
            border-radius: 0px 0px 15px 15px;
        }

        #navbar a {
            float: right;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 21.5px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        #navbar a:hover {
            background-color: #2b7a78;
            color: #feffff;
        }

        #navbar a.active {
            background-color: #04AA6D;
            color: white;
        }

        #navbar a.logo {
            padding: 14px;
            float: left;
            font-size: 30px;
        }

        #navbar img {
            border-radius: 50%;
        }

        .content {
            padding: 16px;
        }

        .filter-section {
            
            padding: 16px;
            background-color: #17252a;
            border-radius: 0px 15px 15px 0px;
            height: 100%;
            margin-top: 100px;
            
        }

        .filter-section .form-check label {
            color: #feffff; /* Set font color to white */
            font-size: 16px;
        }

        .filter-section h4 {
            color: #feffff;
        }

        .filter-section .form-check {
            margin-bottom: 10px;
        }

        .filter-section .btn-primary {
            background-color: #2b7a78;
            border: 3px solid #57ba98;
            color: white;
        }

        .filter-section .btn-primary:hover {
            border: 3px solid white;
            color: white;
        }

        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .sticky+.content {
            padding-top: 60px;
        }

        .sidenav {
            width: 9%;
            position: fixed;
            z-index: 1;
            top: 7%;
            background: #17252a;
            overflow-x: hidden;
            padding: 8px 0;
            margin-top: 50px;
            border-radius: 0px 15px 15px 0px;
            height: 83%;
            padding: 0px;
        }

        .sidenav li {
            padding: 0px;
            margin: 0px;
            display: flex;
            flex-direction: column;
        }

        .sidenav a {
            padding: 18% 8px 18% 16px;
            text-decoration: none;
            font-size: 15px;
            color: #feffff;
            display: block;
            text-align: center;
        }

        .sidenav i {
            font-size: 35px;
        }

        .sidenav a:hover {
            background-color: #2b7a78;
            border-style: solid;
            border-radius: 0px 15px 15px 0px;
        }

        .container {
            overflow: scroll;
            margin: 5% 1% 5% 5%;
            background-color: #2b7a78;
            padding: 3%;
            width: 90%;
            height: 500px;
        }

        .container h3 {
            color: #feffff;
        }

        .card {
            width: 500px;
            margin: 10px;
            text-align: center;
            color: #17252a;
            border-style: none;
        }

        .card-header {
            background-color: #17252a;
            color: #feffff;
        }

        .col-container {
            float: left;
        }

        .row-container:after {
            display: table;
        }

        .sidenav li {
            padding: 0px;
            margin: 0px;
            display: flex;
            flex-direction: column;
        }

        .container a {
            float: right;
            margin: 0 0 0 5px;
        }

        .btn {
            background-color: #17252a;
            border: 3px solid #57ba98;
            color: white;
        }

        .btn:hover {
            border: 3px solid white;
            color: white;
        }

        .table thead th {
            background-color: #17252a;
            color: #feffff;
        }

        .custom-row {
            border-radius: 15px;
            background: #feffff;
            color: #17252a;
            cursor: pointer; /* Add a pointer cursor on hover */
        }
        .custom-row:hover {
            background-color: #57ba98; /* Change background color on hover */
            color: #feffff; /* Change text color on hover */
        }

        .col-md-3.filter-section::-webkit-scrollbar {
            width: 5px; /* Adjust the width as needed */
        }

        .col-md-3.filter-section::-webkit-scrollbar-thumb {
            background-color: #888; /* Color of the thumb */
            border-radius: 10px; /* Roundness of the thumb */
        }

        .col-md-3.filter-section::-webkit-scrollbar-track {
            background-color: #f1f1f1; /* Color of the track */
        }

        .col-md-3.filter-section label {
            color: #feffff; /* Set font color to white */
            font-size: 14px;
        }

        .table th, .table td {
            max-width: 100px; /* Adjust the max-width as needed */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Adjust the font size of the table header labels */
        .table th {
            font-size: 16px; /* Adjust the font size as needed */
        }

        /* Adjust the font size of the table header labels */
        .table td {
            font-size: 16px; /* Adjust the font size as needed */
        }

        /** */
        .container {
                position: absolute;
                top: 45%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
        }

        .table-container {
    overflow-x: auto;
    max-width: 100%;
    margin-bottom: 20px; /* Add some margin to separate the table from the filter section */
    border-radius: 15px;
    background: transparent;
}

.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.5); /* Transparent white scrollbar thumb */
    border-radius: 10px;
}

.table-container::-webkit-scrollbar-track {
    background-color: transparent;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    max-width: 300px; /* Adjust the max-width as needed */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


/* Adjust the font size of the table header labels */
.table th {
    font-size: 16px; /* Adjust the font size as needed */
}

/* Adjust the font size of the table data */
.table td {
    font-size: 14px; /* Adjust the font size as needed */
}

.custom-row:hover {
    background-color: #57ba98; /* Change background color on hover */
    color: #feffff; /* Change text color on hover */
}

    </style>
    
</head>

<body>

    @include('physician.template')

    <div class="content">
        <div class="container">
        <h3>All Patient Records</h3>

        <div class="mt-4 mx-auto">
            <button class="btn btn-primary" onclick="exportTableToPDF()">Export to PDF</button>
            <button class="btn btn-primary" onclick="exportTableToCSV()">Export to CSV</button>

            <div class="row">
                <!-- Filter Section -->
                <div class="col-md-3 filter-section mt-2" style="max-height: 400px; overflow-y: auto;">
                  <form action="{{ route('records.filter') }}" method="GET" id="filterForm">
                    @csrf <!-- Add CSRF token for security -->
                    <div class="row">
                        <div class ="col-xl-5">
                            <h4>Filter Options</h4>                         
                        </div>
                        <div class ="col-xl-5">
                            <button class="btn btn-primary" type="submit">Apply</button>
                        </div>
                    </div>

                        <div class="form-group">
                          <label for="ageFilter" style="color: #feffff;">Age:</label>
                          <input type="range" class="form-range" id="ageFilter" name="ageFilter" min="0" max="100" value="0" oninput="updateAgeValue(this.value)">
                          <output for="ageFilter" id="ageValue" style="color: #feffff; font-size:18px;">0</output>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="maleFilter" name="maleFilter">
                            <label class="form-check-label" for="maleFilter">Male</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="femaleFilter" name="femaleFilter">
                            <label class="form-check-label" for="femaleFilter">Female</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hypertensionFilter" name="hypertensionFilter">
                            <label class="form-check-label" for="hypertensionFilter">Hypertension</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="diabetesFilter" name="diabetesFilter">
                            <label class="form-check-label" for="diabetesFilter">Diabetes</label>
                        </div>

                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="a00b99Filter" name="a00b99Filter">
                          <label class="form-check-label" for="a00b99Filter">A00-B99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="c00d48Filter" name="c00d48Filter">
                            <label class="form-check-label" for="c00d48Filter">C00-D48</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="d50d89Filter" name="d50d89Filter">
                            <label class="form-check-label" for="d50d89Filter">D50-D89</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="e00e90Filter" name="e00e90Filter">
                            <label class="form-check-label" for="e00e90Filter">E00-E90</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="f00f99Filter" name="f00f99Filter">
                            <label class="form-check-label" for="f00f99Filter">F00-F99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="g00g99Filter" name="g00g99Filter">
                            <label class="form-check-label" for="g00g99Filter">G00-G99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="h00h59Filter" name="h00h59Filter">
                            <label class="form-check-label" for="h00h59Filter">H00-H59</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="h60h95Filter" name="h60h95Filter">
                            <label class="form-check-label" for="h60h95Filter">H60-H95</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="i00i99Filter" name="i00i99Filter">
                            <label class="form-check-label" for="i00i99Filter">I00-I99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="j00j99Filter" name="j00j99Filter">
                            <label class="form-check-label" for="j00j99Filter">J00-J99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="k00k93Filter" name="k00k93Filter">
                            <label class="form-check-label" for="k00k93Filter">K00-K93</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="l00l99Filter" name="l00l99Filter">
                            <label class="form-check-label" for="l00l99Filter">L00-L99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="m00m99Filter" name="m00m99Filter">
                            <label class="form-check-label" for="m00m99Filter">M00-M99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="n00n99Filter" name="n00n99Filter">
                            <label class="form-check-label" for="n00n99Filter">N00-N99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="o00o99Filter" name="o00o99Filter">
                            <label class="form-check-label" for="o00o99Filter">O00-O99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="p00p96Filter" name="p00p96Filter">
                            <label class="form-check-label" for="p00p96Filter">P00-P96</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="q00q99Filter" name="q00q99Filter">
                            <label class="form-check-label" for="q00q99Filter">Q00-Q99</label>
                        </div>
                    
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="r00r99Filter" name="r00r99Filter">
                            <label class="form-check-label" for="r00r99Filter">R00-R99</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="s00t98Filter" name="s00t98Filter">
                            <label class="form-check-label" for="s00t98Filter">S00-T98</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="v01y98Filter" name="v01y98Filter">
                            <label class="form-check-label" for="v01y98Filter">V01-Y98</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="z00z99Filter" name="z00z99Filter">
                            <label class="form-check-label" for="z00z99Filter">Z00-Z99</label>
                        </div>

                        <!-- Add more checkboxes for other filter options -->

                        <button class="btn btn-primary" type="submit">Apply</button>
                    </form>
                </div>

                <!-- Your existing table code -->
                <div class="col-md-9">

                <div class="table-container">
                    <table id="patientTable" class="table table-bordered">
                        <thead>
                          <tr> 
                            <th>#</th>
                            <th>Patient Code</th>
                            <th>Patient Name</th>
                            <th>Date of Consult</th>
                            <th>Age</th>
                            <th>Diagnosis</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="custom-row" onclick="selectRow(this)">
                            @php $i = 1 @endphp
                            @foreach($data as $datum)
                              <tr class="custom-row" onclick="selectRow(this)">
                                <td>{{$i++}}</td>
                                <td>{{$datum->patientCode}}</td>
                                <td>{{$datum->lastName}} , {{$datum->firstName}}</td>
                                <td>{{$datum->dateOfConsult}}</td>
                                <td>{{$datum->age}}</td>
                                <td>{{$datum->workingImpression}}</td>
                            @endforeach
                            
                          </tr>
                        </tbody>
                      </table>
                </div>
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap JS and any additional scripts you may need -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    window.onscroll = function () {
        myFunction()
    };

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }

    function updateAgeValue(value) {
        var ageValueElement = document.getElementById('ageValue');
        ageValueElement.innerText = value;
    }

    function exportTableToPDF() {
        var element = document.getElementById("patientTable"); // Adjust the ID based on your table's ID
        html2pdf(element, {
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            },
            output: 'dataurl',
            margin: 10,
            filename: 'patient_records.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        });
    }

    function exportTableToCSV() {
        var csvContent = [];
        var rows = document.querySelectorAll("#patientTable tr"); // Adjust the ID based on your table's ID

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }

            csvContent.push(row.join(";"));
        }

        var csvData = csvContent.join("\n");
        var blob = new Blob([csvData], { type: "text/csv;charset=utf-8;" });
        var link = document.createElement("a");

        if (navigator.msSaveBlob) {
            // IE 10+
            navigator.msSaveBlob(blob, "patient_records.csv");
        } else {
            // Other browsers
            link.href = URL.createObjectURL(blob);
            link.download = "patient_records.csv";
            link.style.visibility = "hidden";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
    </script>

</body>

</html>

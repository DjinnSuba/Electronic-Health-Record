<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
body {
  margin: 0;
  font-size: 28px;
  font-family: Arial, Helvetica, sans-serif;
  background-color: #3aafa9;
}

/* .header {
  background-color: #f1f1f1;
  padding: 30px;
  text-align: center;
} */

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

#navbar a.logo{
  padding: 14px;
  float: left;
  font-size: 30px;
}

#navbar img{
  border-radius: 50%;
}

.content {
  padding: 16px;
  margin-left: 9%;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
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

.sidenav li{
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
.sidenav i{
  font-size: 35px;
}

.sidenav a:hover {
  background-color: #2b7a78;
  border-style: solid;
  border-radius: 0px 15px 15px 0px;
}

.container{
  overflow: scroll;
  margin: 5% 1% 5% 5%;
  background-color: #2b7a78;
  padding: 3%;
  width: 90%;
  height: 500px;
}

.container h3{
  color: #feffff;
}

.card {
  width: 500px;
  margin: 10px;
  text-align: center;
  color: #17252a;
  border-style: none;
}

.card-header{
  background-color: #17252a;
  color: #feffff;
}

.col-container{
  float: left;
}

.row-container:after{
  display: table;
}

.sidenav li{
  padding: 0px;
  margin: 0px;
  display: flex;
  flex-direction: column;
}
.container a{
  float: right;
  margin: 0 0 0 5px;
}
.btn{
  background-color: #17252a;
  border: 3px solid #57ba98;
  color: white;
}
.btn:hover{
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
/** */
.nav-pills {
            background-color: #17252a; /* Set the background color of the step indicators to white */
            /*z-index: 100;*/
            border-radius: 10px 10px 0px 0px;
        }
        .header {
            background: #17252a;
            border-radius: 10px 10px 0px 0px; 
            /*z-index: 100;*/
        }


        .header p {
            color: white;
            padding: 10px 0px 0px 0px;
        }

        .container {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;

        }
        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
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

<!-- <div class="header">
  <h1><b>Scroll Down</b></h1>
  <p>Scroll down to see the sticky effect.</p>
</div> -->

@include('physician.template') 



<div class="container" >
  <div class="mt-4 mx-auto">
    <div class="header" style = "padding: 0px 0px 5px 0px"><p style="font-size: 30px;">Patient Records</p>

    <!-- Step Indicators -->
      <ul class="nav nav-pills">
          <li class="nav-item">
              <a class="nav-link active" data-toggle="pill" href="#step1">Details</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="pill" href="#step2">Consultations</a>
          </li>

      </ul>
    </div>
    <form action="{{ route('records.search') }}" method="GET">
      <div class="row" style = "padding: 15px 0px; color: white;">
        <div class="col-xl-3">
            <label style = "font-size:20px">Patient Code</label>
        </div>
        <div class="col-xl-3 text-right mt-1">
          <input type="text" name="search" class="form-control" required>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
        <div div class="col-sm-4">
          <a class="btn" href="{{ route('physician.register') }}">REGISTER</a>
        </div>
      </div>
    </form>
    <div class="tab-content">
      <!-- Step 1: General Data -->
      <div id="step1" class="tab-pane fade show active">
        <div class ="name">
        <table class="table table-bordered">
          <thead>
            <tr> 
              <th>#</th>
              <th>Patient Code</th>
              <th>Date of Last Consult</th>
              <th colspan="1">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="custom-row" onclick="selectRow(this)">
              @php $i = 1 @endphp
              @foreach($data as $datum)
              <tr class="custom-row" onclick="selectRow(this)">
                <td>{{$i++}}</td>
                <td>{{$datum->patientCode}}</td>
                <td>{{$datum->dateOfConsult}}</td>
                <td><a href="{{url('view_patient/'.$datum->patientId)}}" class = "btn">View</a></td>
              </tr>
              @endforeach
            </tr>
          </tbody>
        </table>
        </div>
      </div>
      <div id="step2" class="tab-pane fade">
      <div class ="name">

        <table class="table table-bordered">
          <thead>
            <tr> 
              <th>#</th>
              <th>Patient Code</th>
              <th>Date of Last Consult</th>
              <th colspan="1">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="custom-row" onclick="selectRow(this)">
              @php $i = 1 @endphp
              @foreach($dataConsultation as $datum)
              <tr class="custom-row" onclick="selectRow(this)">
                <td>{{$i++}}</td>
                <td>{{$datum->patientCode}}</td>
                <td>{{$datum->dateOfConsult}}</td>
                <td><a href="{{url('view_patient/'.$datum->patientId)}}" class = "btn">View</a></td>
              </tr>
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
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

/** */
function validateAndNext(nextTab) {
            // Get the current active step
            var currentTab = $('.nav-pills .nav-link.active').attr('href');

            // Check if all required fields in the current step are filled
            var currentFields = $(currentTab + ' [required]');
            var isValid = true;

            currentFields.each(function () {
                if (!$(this).val().trim()) {
                    isValid = false;
                    return false; // Break the loop if any field is empty
                }
            });

            if (isValid) {
                // If all required fields are filled, proceed to the next tab
                $('.nav-pills a[href="#' + nextTab + '"]').tab('show');
            } else {
                // If any required field is empty, display an alert
                alert('Please fill in all required fields before proceeding.');
            }
        }

        function nextStep(nextTab) {
            // Validate and proceed to the next tab
            validateAndNext(nextTab);
        }
    
        function prevStep(prevTab) {
            // Simply go to the previous tab without validation
            $('.nav-pills a[href="#' + prevTab + '"]').tab('show');
        }
</script>

</body>
</html>

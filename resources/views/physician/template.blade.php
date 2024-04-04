<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('styles.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>

  /* Hide scrollbar for Firefox */
.container {
  scrollbar-width: thin;
  scrollbar-color: transparent transparent;
}

/* Hide scrollbar for Webkit (Chrome, Safari) */
.container::-webkit-scrollbar {
  width: 6px; /* Adjust the width as needed */
}

.container::-webkit-scrollbar-thumb {
  background-color: transparent; /* Color of the thumb */
}

.container::-webkit-scrollbar-track {
  background-color: transparent; /* Color of the track */
}


/* Hide scrollbar for Firefox */
.sidenav {
  scrollbar-width: thin;
  scrollbar-color: transparent transparent;
}

/* Hide scrollbar for Webkit (Chrome, Safari) */
.sidenav::-webkit-scrollbar {
  width: 6px; /* Adjust the width as needed */
}

.sidenav::-webkit-scrollbar-thumb {
  background-color: transparent; /* Color of the thumb */
}

.sidenav::-webkit-scrollbar-track {
  background-color: transparent; /* Color of the track */
}

  
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
  display: flex;
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
  height: 75%;
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
.container {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;

        }
</style>


</head>
<body>


<div id="mySidebar" class="sidenav">
  <li>
    <a href="{{ route('physician.patients') }}"><img src="{{ asset('patient.png') }}" alt="patient" width="40" height="40"><br>Patients</a>
  </li>
  <li class>
    <a href="{{ route('physician.records') }}"><img src="{{ asset('records.png') }}" alt="records" width="40" height="40"><br>Records</a>
  </li>
  <li>
    <a href="{{ route('physician.files') }}"><img src="{{ asset('files.png') }}" alt="files" width="40" height="40"><br>Files</a>
  </li>
 <!--li>
    <a href="uploads"><img src="upload.png" alt="upload" width="40" height="40"><br>Upload</a>
  </li-->
  <li>
    <a href="{{ route('physician.clinic_records') }}"><img src="{{ asset('clinic_records.png') }}" alt="clinic records" width="40" height="40"><br>Records and<br>Requests</a>
  </li>

  <li>
    <a href="{{ route('records.filter') }}"><img src="{{ asset('upload.png') }}" alt="generate report" width="40" height="40"><br>Generate<br>Report</a>
  </li>
</div>

<div id="navbar">
  @if ($doc -> profile)
    <a class="profile-picture" href="{{ route('physician.pfp') }}"><img src="{{ asset('storage/images/'.$doc->profile) }}"  alt="profile" width="30" height="30"></a>
    @else
    <a class="profile-picture" href="profile"><img src="phyfp.png" alt="profile" width="30" height="30" ></a>
  @endif  
  <a href="{{asset('logouts')}}"><img src="{{ asset('logout.png') }}" alt="logout" width="30" height="30"> Logout</a>
  <a href="{{ route('physician.dashboard') }}"><img src="{{ asset('dashboard.png') }}" alt="dashboard"width="30" height="30"> Dashboard</a>
  <a class="logo" href="{{ route('physician.dashboard') }}"><img src="{{ asset('ehr-logo.png') }}" alt="ehr"width="50" height="50">EHR</a>
</div>

</body>
</html>
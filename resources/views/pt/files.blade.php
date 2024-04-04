<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('styles.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
  /** */
  .container {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;

    }
  /** */  

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
  float: left;
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

.custom-row a{}

</style>
</head>
<body>

<!-- <div class="header">
  <h1><b>Scroll Down</b></h1>
  <p>Scroll down to see the sticky effect.</p>
</div> -->

@include('physician.template') 


<div class="content">
  <div class="container">
    <h3>Files</h3>
    <table class="table table-bordered">
      <thead>
        <tr> 
          <th>#</th>
          <th>Form Name</th>
          <th>Use</th>
          <th>Logs</th>
        </tr>
      </thead>
      <tbody>
        <tr class="custom-row" onclick="selectRow(1)" data-href="{{URL::to('register_patient')}}">
          <td>1</td>
          <td><a href="{{route('physician.register')}}">Assessment Report</a></td>
          <td>Patient Registration</td>
          <td>PT1-Log</td>
        </tr>
        <tr class="custom-row" onclick="selectRow(2)">
          <td>2</td>
          <td><a href="{{route('pt.progress_report')}}">Progress Report</a></td>
          <td>Patient Consultation</td>
          <td>PT2-Log</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

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
var url = '{{URL::to('register_patient')}}';
var url2 = '{{URL::to('mprogress-report')}}';

function selectRow(num){
  if(num == 1)
    window.location.href =url;
  else if(num == 2)
    window.location.href =url2;

}

</script>

</body>
</html>

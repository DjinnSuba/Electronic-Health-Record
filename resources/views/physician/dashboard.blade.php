<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

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
  padding: 18% 8px 18.7% 16px;
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

/*
.container{
  overflow: scroll;
  margin: 5% 1% 5% 5%;
  background-color: #2b7a78;
  padding: 3%;
  width: 90%;
  max-height: 500px;
}*/

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
  float: right;
}

.row-container:after{
  display: table;
}

.tdContents{
  font-size: 20px;

}

</style>
</head>
<body>

<!-- <div class="header">
  <h1><b>Scroll Down</b></h1>
  <p>Scroll down to see the sticky effect.</p>
</div> -->

@include('physician.template') 



<div class="content" >
  <div class="container">
    <h3>Physician Dashboard</h3>
    <div class="row-container">
      <div class ="col-container col-lg-6">
        
        <div class="card">
          <div class="card-header">Record Requests</div>
          <div class="card-body">
            
            @if (!empty($accesses -> first()))
            <table class="table tdContents">
              <thead>
              <tr> 
                <th class="tdContents">Patient Code</th>
                <th class="tdContents">Patient</th>
                <th class="tdContents">Doctor</th>
                <th class="tdContents" colspan="3">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($accesses as $access)
                <tr class="custom-row" onclick="selectRow(this)">

                  <td class="tdContents">{{$access->patientCodez}}</td>
                  <td class="tdContents">{{$access->lastName}}</td>
                  <td class="tdContents">{{$access->name}}</td>
                  <td class="tdContents">
                    <a href="{{url('/accept_access/'.$access->patientId.'/'.$access->attendingId.'/'.$access->accessId)}}" class = "btn">Accept</a> 
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <p>No Requests</p>
            @endif
          </div>
        </div>
        <div class="card">
            <div class="card-header">Patient Summary</div>
            <div class="card-body">
              Patient Registrations: {{$count1}} <br>
              Patient Consultations: {{$count2}}
            </div>
          </div>
        </div>
      </div>

      <div class ="col-container col-lg-6">
        <div>
          <div class="card">
            <div class="card-header">Today's Updates</div>
            <div class="card-body">
            @if (!empty($today1 -> first()))
            <label for="registrations">Registrations</label>
            <table class="table tdContents" name="registrations">
              <thead>
              <tr> 
                <th class="tdContents">Patient Code</th>
                <th class="tdContents">Patient</th>
              </tr>
              </thead>
              <tbody>
                @foreach($today1 as $t)
                <tr class="custom-row" onclick="selectRow(this)">

                  <td class="tdContents">{{$t->patientCodez}}</td>
                  <td class="tdContents">{{$t->lastName}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <p>No Updates</p>
            @endif
            @if (!empty($today2 -> first()))
            <label for="consultations">Consultations</label>
            <table class="table tdContents" name="consultations">
              <thead>
              <tr> 
                <th class="tdContents">Patient Code</th>
                <th class="tdContents">Patient</th>
              </tr>
              </thead>
              <tbody>
                @foreach($today2 as $t)
                <tr class="custom-row" onclick="selectRow(this)">

                  <td class="tdContents">{{$t->patientCodez}}</td>
                  <td class="tdContents">{{$t->lastName}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <p>No Updates</p>
            @endif
            </div>
          </div>
      </div>
    </div>
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
</script>

</body>
</html>

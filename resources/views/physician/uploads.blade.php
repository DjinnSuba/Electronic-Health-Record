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
  padding: 5px;
}

.row-container:after{
  display: table;
}

.col-container img{
  border-radius: 50%;
  width: 100px;
  height: 100px;
}

.btn{
    border-radius: 10px;
    border-style: none;
    display: block;
}
.btn:hover{
    background-color: #3aafa9;
}
hr{
  border: 3px solid #000000;
}

.sidenav li{
  padding: 0px;
  margin: 0px;
  display: flex;
  flex-direction: column;
}
</style>
</head>
<body>

<!-- <div class="header">
  <h1><b>Scroll Down</b></h1>
  <p>Scroll down to see the sticky effect.</p>
</div> -->

<div class="sidenav">
  <li class>
    <a href="records"><img src="records.png" alt="records" width="40" height="40"><br>Records</a>
  </li>
  <li>
    <a href="patients"><img src="patients.png" alt="patient" width="40" height="40"><br>Patients</a>
  </li>
  <li>
    <a href="files"><img src="files.png" alt="files" width="40" height="40"><br>Files</a>
  </li>
  <li>
    <a href="uploads"><img src="upload.png" alt="upload" width="40" height="40"><br>Upload</a>
  </li>
  <li>
    <a href="clinic_records"><img src="clinic_records.png" alt="clinic record" width="40" height="40"><br>Clinic<br>Records</a>
  </li>
</div>
<div id="navbar">
  <a class="profile-picture" href="profile"><img src="profile.png" alt="profile" width="30" height="30"></a>
  <a href="{{asset('logouts')}}"><img src="logout.png" alt="logout" width="30" height="30"> Logout</a>
  <a href="dashboard"><img src="dashboard.png" alt="dashboard" width="30" height="30"> Dashboard</a>
  <a class="logo" href="dashboard">EHR</a>
</div>

<div class="content">
  <div class="container">
    <h3>File Uploads</h3>
    <div class="row-container">
      <div class ="col-container">
        <div class="card">
          <div class="card-header">Personal Information</div>
          <div class="card-body">
            <div class="form-group">
                <label>The uploaded files will found in Files. For patient records, if correctly typed, it will be reflected on Records and/ or Patients <br><br>
                    Only [csv, pdf, word] files will be accepted 
                </label>
                <input type="file" name="image" value = "{{old('image')}}" class="form-control">
                @error('image')<p class="text text-danger">{{ $message }}</p> @enderror
                <a class="btn" href="">UPLOAD</a>
            </div>
          </div>
        </div>
      </div>

      <div class ="col-container">
        <div class="card">
          <div class="card-header">Profile Picture</div>
          <div class="card-body">
            <div class="row-container">
                <div class="col-container">
                    <a class="profile-picture" href="profile"><img src="phyfp.png" alt="profile"></a>
                </div>
                <div class="col-container">
                    <a href="#" class="btn">View</a>
                    <a href="#" class="btn">Take a Photo</a>
                    <a href="#" class="btn">Upload</a>
                    <a href="#" class="btn">Delete</a>
                </div>
            </div>
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

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
  color: #17252a;
  border-style: none;
}

.card-header{
  text-align: center;

  background-color: #17252a;
  color: #feffff;
  align: left;
}

.col-container{
  text-align: left;
  float: left;
  padding: 5px 5px 5px 10px;
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
#uploadDiv{
    display: none;
}

form {
            background-color: white;
            padding: 20px;
            border-radius: 0px 0px 10px 10px; 
        }

</style>
</head>
<body>
  @include('physician.template') 
  <div class="content">
    <div class="container">
      <h3>Personal Profile</h3>
      <div class="row-container">
        <div class ="col-container col-lg-6">
          <div class="card">
            <div class="card-header">Personal Information</div>
            <!--div class="card-body">
              <hr>
              Name        Doc, John Christian <br>
              Age         26 <br>
              Birthday    February 7, 1997 <br>
              Contact #   09xxxxxxxx <br>
              Address     Blk 4 Street St., <br>
              Department  DPTMT <br>
            </div-->
            <div class="col-container"><span class =" pull-left">
              <p>Name: {{$doc -> lastName}}, {{$doc -> firstName}} </p>
              <p>Age: {{\Carbon\Carbon::parse($doc->birthday)->diffInYears(now(), false)}}</p>
              <p>Birthday: {{$doc -> birthday}}</p>
              <p>Contact Number: {{$doc -> cnumber}}</p>
              <p>Address: {{$doc -> address}}</p>
              <p>License No.: {{$doc -> license}}</p>
              </span>
            </div>
          </div>
        </div>

        <div class ="col-container col-lg-6">
          <div class="card">
            <div class="card-header">Profile Picture</div>
            <div class="card-body">
              <div class="col-container">
                @if ($doc -> profile)
                  <img width="30%" class="img-circle" src="{{ asset('storage/images/'.$doc->profile) }}">
                  @else
                  <a class="profile-picture" href="profile"><img src="phyfp.png" alt="profile"></a>
                @endif  
              </div>

              <div class="col-container">
                <!--a href="#" class="btn">View</a-->
                <a href="{{url('/profile/delete/'.$doc->id.'/'.$doc->profile)}}" class = "btn btn-danger">Delete</a></td>

                <!--a href="{{url('profile-upload/'.$doc->physicianCode)}}" class="btn">Upload</a-->
                <button type="button" class="btn btn-secondary" onclick="addUpload()">Edit</button>

                <div class="row" id="uploadDiv">
                  <form method="POST" action="{{ route('uploadSave') }}" enctype="multipart/form-data">
                  @csrf
                    <div class="col-xl-12 text-right mt-3">
                      <input type="file" class="form-control" id="image" name="image" @error("image") is-invalid @enderror>
                      <!--a href="{{url('/profile-upload')}}" class="btn">ME</a-->
                    </div>
                    <div class="col-xl-3 text-right mt-1">
                      <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">Department</div>
            <div class="card-body">
              @if($doc -> department == 'Physical Therapist')
                <p>Physical Therapy</p>
              @else
                <p>{{$doc -> department}}</p>
              @endif
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>

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
function addUpload(){
  var x = document.getElementById("uploadDiv");

  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

}
</script>


</body>
</html>

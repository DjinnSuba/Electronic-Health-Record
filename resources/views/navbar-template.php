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

.container{
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

.btn{
  background-color: #17252a;
  border: 3px solid #57ba98;
  color: white;
}
.btn:hover{
  border: 3px solid white;
  color: white;
}

</style>
</head>
<body>

<!-- <div class="header">
  <h1><b>Scroll Down</b></h1>
  <p>Scroll down to see the sticky effect.</p>
</div> -->
<div id="navbar">
  @if ($data -> profile)
    <img width="30%" class="img-circle" src="{{ asset('storage/images/'.$data->profile) }}">
    @else
    <a class="profile-picture" href="profile"><img src="phyfp.png" alt="profile"></a>
  @endif   
  <a href="#"><img src="logout.png" alt="logout" width="30" height="30"> Logout</a>
  <a href="dashboard"><img src="dashboard.png" alt="dashboard" width="30" height="30"> Dashboard</a>
  <a class="logo" href="dashboard">EHR</a>
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

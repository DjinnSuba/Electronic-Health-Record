<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale 1.0">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Portland', sans-serif;
}

body {
    min-height: 100vh;
    background-color: #F2F2F2;
}

li {
    list-style: none;
    color: white;
}

h1 {
    color: white;
    margin-left: -25px;
    float: left;
    font-size: 25px;
}


/**
.side-bar li:hover {
  background-color: rgba(57, 168, 168, 0.3);
  border-style: solid;
  border-radius: 0px 15px 15px 0px;
}
 */

/* Updated CSS for nav-bar */
.nav-bar {
    background:#55BDCA;
    display: flex;
    align-items: center; /* Center vertically */
    height: 50px;
    justify-content: space-between;
    padding: 10px 50px;
    /* border-radius: 0px 0px 8px 8px; */
}

.nav-bar a {
    font-size: 15px;
}

.nav {
    display: flex;
    align-items: center;
    justify-content: center; /* Center horizontally */

}



.nav-link {
    color: #fff; 
    padding: 5px 10px; /* Add some padding for better appearance */
    text-decoration: none; /* Remove the default link underline */
    border: none; 
    font-size: 15px;
    cursor: pointer; /* Change the cursor to a pointer on hover to indicate it's clickable */
}

/* If you want to change the font size of the text only, excluding the image */
.nav-link span {
    font-size: 100px; /* Set your desired font size */

}

.nav-link span:hover {
    background-color: rgba(57, 168, 168, 0.3);
    border-style: solid;
    border-radius: 0px 15px 15px 0px;
}


.container {
    background-color:white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    width: 82%;
    min-width: none;
    height: 80%;
    max-height: 100% ;
    position: fixed;
    margin-top: 2%;
    margin-left: 14%;
    border-radius: 10px;


}

 /* Highlight the active list item */
 /* .side-bar ul li.active {
    background-color: #2b7a78; 
} */



.nav a {
    color: white;
    text-decoration: none;
    margin-left: 15px; /* Adjust margin as needed for spacing */
    font-size: 14px;

}

.nav-link img {
    vertical-align: middle;
    margin-right: 10px;
    width: 25px; /* Set the desired width */
    height: 25px; /* Set the desired height */
}

.nav-link {
    color: #fff;
    padding: 5px 10px;
    text-decoration: none;
    border: none;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.3s; /* Add transition for a smooth effect */
}

.nav-link:hover {
    background-color: rgba(57, 168, 168, 0.3); /* Faint background color on hover */
    color: #333; /* Dark gray text color on hover */
    border: 1px solid #55BDCA; 
}


        body {
            margin: 0;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            background-color: #3aafa9;
        }

        /* .container {
            overflow-y: auto;
            max-height: none;
            position: absolute;
            left: -8px;
        } */

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

        .card {
            width: 40%; /* Adjust width as needed */
            margin: 10px;
            text-align: left;
            color: #17252a;
            border: 1px solid #17252a;
            border-radius: 5px;
            overflow: hidden;
            float: center; /* Float the cards left for side-by-side arrangement */
            margin: auto;
            top: 85px;

        }

        .card-header {
            background-color: #17252A;
            color: #feffff;
            padding: 10px;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            padding:20px;
            text-align: left;
            
        }

        .center-card {
            width: 100%;
            text-align: left;
            margin-top: 100px; /* Adjust margin-top as needed */
            clear: both; /* Clear the float to ensure the third card is below the first two */
            
        }

        .center-card .card {
            display: inline-block;
            width: 300px; /* Adjust width as needed */
            height: 325px;
            border: 1px solid #17252a;
            border-radius: 5px;
            overflow: hidden;
            /* margin: 150px;  */
            margin-top: 1px;
            top: -340px;

            
        }

        .center-card .card-body {
            padding: 30px;

        }

        .container h3 {
            position: absolute;
            color: #333;
            top: 50px;
            left: 30px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        </style>

</head>
<body style="background-color:#F2F2F2">
    <div class="nav-bar">
        <div class="logo-name">
            <h1>EHR</h1>
        </div>
        <div class="nav">
            
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><img src="{{ asset('dashbl.png') }}" alt="">Dashboard</a>
            <a href="{{asset('logouts')}}" class="nav-link"><img src="{{ asset('logbl.png') }}" alt="">Logout</a> 
        </div>        
        
    </div>
    <div class="side-bar">
        <ul>
            <li class="{{ Request::is('admin/physicians') ? 'active' : '' }}">
                <a href="{{ route('admin.physicians') }}">
                    <img src="{{ asset('phybl.png') }}" alt="">
                    <span class="nav-link"><p>Staff Roster<p></span>
                </a>
            </li>
            <!-- removed-->
            <!--li class="{{ Request::is('admin/patients') ? 'active' : '' }}">
                <a href="{{ route('admin.patients') }}">
                    <img src="{{ asset('haert.png') }}" alt="">
                    <span class="nav-link">Patients</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/requests') ? 'active' : '' }}">
                <a href="{{ route('admin.requests') }}">
                    <img src="{{ asset('reqbl.png') }}" alt="">
                    <span class="nav-link">Requests</span>
                </a>
            </li-->
        </ul>
    </div>
    <!-- <footer>
        <div class="footer-content">
            
            <p>&copy; 2023 Electronic Health Records System. All rights reserved.</p>
           
        </div>
    </footer> -->
   
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>

    </style>
</head>
<body style="background-color:#F2F2F2">
@include('admin.common') 

    <div class="content">
        <div class="container">
            <h3>Dashboard</h3>
            <div class="card">
                <div class="card-header">Staff Summary</div>
                <div class="card-body" >
                    <p>
                    <!-- Your Physician Summary table content here -->
                    @if (!empty($count))
                        Number of Staff: {{$count}} <br>
                        Number of Total Physicians: {{$fcm}} (Active: {{$activeFCM}})<br>
                        Number of Total Physical Therapists: {{$pt}}  (Active: {{$activePT}})<br>
                    @else
                    <p>No Staff</p>
                    @endif
                    </p>

                </div>
            </div>
            <!-- removed-->
                <!--div class="col-container">
                    <div class="card">
                        <div class="card-header">Patient Summary</div>
                        <div class="card-body">
                            <Your Patient Summary table content here >
                            Number of Current Patients: 100 <br>
                            Relevant Data 1 <br>
                            Relevant Data 2

                        </div>
                    </div>
                </div>
            </div>

            
            <div class="center-card">
                <div class="card" style= "margin-left: auto; margin-right: auto'">
                    <div class="card-header">Disease Chart</div>
                    <div class="card-body">
                    <canvas id="diseaseChart" width="200" height="200"></canvas>
                    </div>
                </div>
            </div-->
        </div>
    </div>
    <!-- removed-->    
    <!--script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById("diseaseChart").getContext("2d");

            // Mock data for demonstration
            var data = {
                labels: ["Disease 1", "Disease 2", "Disease 3"],
                datasets: [{
                    data: [30, 50, 20],
                    backgroundColor: ["#3498db", "#e74c3c", "#2ecc71"],
                    hoverOffset: 4, // Increase the hover offset for better visibility
                    radius: 80, // Adjust the radius to make the pie chart smaller
                }],
            };

            // Create a pie chart
            var myPieChart = new Chart(ctx, {
                type: "pie",
                data: data,
                responsive: true,
            });
        });
    </script-->
</body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>

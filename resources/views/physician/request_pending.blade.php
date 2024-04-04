<!DOCTYPE html>
<html>
<head>
    <!-- Include your common meta tags, stylesheets, and JavaScript here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .header {
            background: #17252a;
            border-radius: 10px; 
            /*z-index: 100;*/
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 0px 0px 10px 10px; 
        }

        .header p {
            color: white;
            padding: 10px 0px 0px 0px;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        #allergiesInput{
        display: none;
        }

        #allergiesCheckbox:checked ~ #allergiesInput{
            display: block;
        }

        #hpn_Input{
            display: none;
        }

        #hpn_Checkbox:checked ~ #hpn_Input{
            display: block;
        }
        #dm_Input{
            display: none;
        }

        #dm_Checkbox:checked ~ #dm_Input{
            display: block;
        }

        #ptb_Input{
            display: none;
        }

        #ptb_Checkbox:checked ~ #ptb_Input{
            display: block;
        }

        #asthma_Input{
            display: none;
        }

        #asthma_Checkbox:checked ~ #asthma_Input{
            display: block;
        }

        #smoker_Input{
            display: none;
        }

        #smoker_Checkbox:checked ~ #smoker_Input{
            display: block;
        }

        #alcohol_Input{
            display: none;
        }

        #alcohol_Checkbox:checked ~ #alcohol_Input{
            display: block;
        }

        .nav-pills {
            background-color: #17252a; /* Set the background color of the step indicators to white */
            /*z-index: 100;*/
            border-radius: 10px 10px 0px 0px;
        }

        /** */
        #hypertension_Input{
            display: none;
        }

        #hypertension_Checkbox:checked ~ #hypertension_Input{
            display: block;
        }

        #diabetes_Input{
            display: none;
        }

        #diabetes_Checkbox:checked ~ #diabetes_Input{
            display: block;
        }

    </style>
</head>
<body>
    @include('physician.template') 

    <div class="container">

        <div class="mt-4 mx-auto">
        <div class="header"><p style="font-size: 30px;">Access Pending</p>

            <!-- Step Indicators -->
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#step1">General Data</a>
                </li>
            </ul>
            </div>
            <!-- Form Steps -->
            <form method="POST" action="{{ url('/update-patient/'.$data->id) }}">
                @csrf

                <div class="tab-content">
                    <!-- Step 1: General Data -->
                    <div id="step1" class="tab-pane fade show active">
                        <!-- Add your General Data fields here -->
                        <!-- Example: -->
                        <div class="form-group row">
                            <label for="patientId" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Patient ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="patientId" name="patientId" value="{{$data->id}}"  readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="patientCodez" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Patient Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="patientCodez" name="patientCodez" value="{{$data->patientCode}}"readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="physicianId" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Attending ID</label>
                            @foreach($accesses as $access)
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="physicianId" name="physicianId" value="{{$access->attendingId}}"readonly>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group row">
                            <label for="physicianCodez" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Physician Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="physicianCodez" name="physicianCodez" value="{{$doc->physicianCode}}"readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="physicianId" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Access ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="physicianId" name="physicianId" value="{{$doc->id}}"readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Status</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="status" name="status" value="{{$access->status}}"readonly>
                            </div>
                        </div>
                    </div>                
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and any additional scripts you may need -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

    <script>
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

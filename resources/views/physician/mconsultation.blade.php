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
        <div class="header"><p style="font-size: 30px;">New Consultation</p>

            <!-- Step Indicators -->
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#step1">General Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="pill" href="#step2">Consultation Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#step3">Subjective Findings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#step4">Objective Findings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#step5">Assessment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#step6">Plan</a>
                </li>

            </ul>
            </div>
            <!-- Form Steps -->
            <form method="POST" action="{{ url('/mnewConsult') }}">
                @csrf

                <div class="tab-content">
                    <!-- Step 1: General Data -->
                    <div id="step1" class="tab-pane fade show active">
                        <!-- Add your General Data fields here -->
                        <!-- Example: -->
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lastName" name="lastName" value=""  required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstName" name="firstName" value=""required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="middleName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Middle Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="middleName" name="middleName" value=""required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="age" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Age</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="age" name="age" required>
                                    @for ($i = 1; $i <= 100; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sex" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Sex</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="sex" name="sex" required>
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nationality" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Nationality</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nationality" name="nationality" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="civilstatus" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Civil Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="civilstatus" name="civilstatus" required>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthday" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Birthday</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="birthday" name="birthday" value= required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="presentaddress" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Present Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="presentaddress" name="presentaddress" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="occupation" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Occupation</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="occupation" name="occupation" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="religion" class="col-sm-3 col-form-label text-right" style="font-size: 18px;" default value="christian">Religion</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="religion" name="religion" required>
                                    <option  value="romancatholic">Roman Catholic</option>
                                    <option  value="christian">Christian</option>
                                    <option  value="islam">Islam</option>
                                    <option  value="inc">Iglesia Ni Cristo</option>  
                                </select>
                            </div>
                        </div>
                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step2')">Next</button>
                    </div>
                    <div id="step2" class="tab-pane fade">
                        <div class="form-group row">
                            <label for="dateOfConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Date of Consult</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="dateOfConsult" name="dateOfConsult" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timeOfConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Time of Consult</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="timeOfConsult" name="timeOfConsult" value="" required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="prevStep('step1')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step3')">Next</button>
                    </div>

                    <!-- Step 3: Vital Signs -->
                    <div id="step3" class="tab-pane fade">
                    <div class="form-group row">
                            <label for="subFindings" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Subjective Findings</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="subFindings" name="subFindings" placeholder="..."required style="height: 100px;">
                            </div>
                        </div>
                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step2')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step4')">Next</button>
                    </div>

                    <!-- Step 4: Clinical History -->
                    <div id="step4" class="tab-pane fade">
                        <!-- Add your Clinical History fields here -->
                        <!-- Example: -->
                        <div class="form-group row">
                            <label for="objFindings" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Objective Findings</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="objFindings" name="objFindings" required style="height: 100px;">
                            </div>
                        </div>
                       
                        
                        <!-- Add more fields as needed -->

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step3')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step5')">Next</button>
                    </div>

                    <!-- Step 5: Past Medical History -->
                    <div id="step5" class="tab-pane fade">
                        <div class="form-group row">
                                <label for="assessment" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Assessment</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="assessment" name="assessment" required style="height: 100px;">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Hypertension</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="hypertension_Checkbox" id="hypertension_Checkbox" style="margin-right: 1000px;">
                                <select class="form-control" id="hypertension_Input" name="hypertension_Input">
                                            <!-- Add options for different vaccines -->
                                            <option value="controlled">Controlled</option>
                                            <option value="uncontrolled">Uncontrolled</option>
                                </select>                            
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diabetes</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="diabetes_Checkbox" id="diabetes_Checkbox" style="margin-right: 1000px;">
                                <select class="form-control" id="diabetes_Input" name="diabetes_Input">
                                    <!-- Add options for different vaccines -->
                                    <option value="controlled">Controlled</option>
                                    <option value="uncontrolled">Uncontrolled</option>
                                </select>                               
                            </div>
                        </div>
                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step4')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step6')">Next</button>
                    </div>

                <div id="step6" class="tab-pane fade">
                <div class="form-group row">
                            <label for="diagnostics" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diagnostics</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="diagnostics" name="diagnostics" required style="height: 150px;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="drugs" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Drugs</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="drugs" name="drugs" required style="height: 150px;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diet" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diet</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="diet" name="diet" required style="height: 150px;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="disposition" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Disposition</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="disposition" name="disposition" required style="height: 150px;">
                            </div>
                        </div>
                    <!-- Navigation buttons -->
                     <button type="button" class="btn btn-secondary" onclick="prevStep('step5')">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
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

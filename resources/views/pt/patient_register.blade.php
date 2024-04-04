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
        input + span {
        padding-right: 30px;
        }

        input:invalid + span::after {
        content: "✖";
        padding-left: 5px;
        color: #8b0000;
        }

        input:valid + span::after {
        content: "✓";
        padding-left: 5px;
        color: #009000;
        }

    </style>
</head>
<body>
    @include('physician.template') 

    <div class="container">
        <div class="mt-4 mx-auto">
            <div class="header"><p style="font-size: 30px;">Assessment Report</p>

                <!-- Step Indicators -->
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#step1">General Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="pill" href="#step2">Consultation Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step3">Client Concerns and Therapy Goals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step4">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step5">Examinations and Evaluations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step6">References</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step7">Attachment</a>
                    </li>
                </ul>
            </div> 
            <!-- Form Steps -->
            <form method="POST" action="{{ route('storePTPatient') }}" enctype="multipart/form-data">
                @csrf

                <div class="tab-content">
                    <!-- Step 1: General Data -->
                    <div id="step1" class="tab-pane fade show active">
                        <!-- Add your General Data fields here -->
                        <!-- Example: -->
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="middleName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Middle Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="middleName" name="middleName" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="medicalDiagnosis" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Medical Diagnosis</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="medicalDiagnosis" name="medicalDiagnosis" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="sex" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Sex</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="sex" name="sex" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Birthday</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Cellphone Number</label>
                            <div class="col-sm-9">
                            <input type="tel" id="phone" name="phone" class="form-control" pattern="[0][9][0-9]{9}" required />
                            <span class="validity"></span>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Email Address</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="presentaddress" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Present Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="presentaddress" name="presentaddress" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="refMD" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Referring MD</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="refMD" name="refMD" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="refUnit" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Referring Unit</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="refUnit" name="refUnit" required>
                            </div>
                        </div>
                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step2')">Next</button>
                    </div>
                    <div id="step2" class="tab-pane fade">

                        <div class="form-group row">
                            <label for="dateOfConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Date of Consult</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="dateOfConsult" name="dateOfConsult" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timeOfConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Time of Consult</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="timeOfConsult" name="timeOfConsult" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timeOfEndConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Time of End Consult</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="timeOfEndConsult" name="timeOfEndConsult" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="attendees" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Attendees</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="attendees" name="attendees" required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="prevStep('step1')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step3')">Next</button>
                    </div>

                    <!-- Step 3: Client Concerns and Therapy Goals -->
                    <div id="step3" class="tab-pane fade">
                        
                        <div class="form-group row">
                            <label for="complaints" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Chief Complaints</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="complaints" name="complaints" required style="height: 100px; " placeholder="Pt. complains of having...">
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="goals" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Goals</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="goals" name="goals"required style="height: 100px; " placeholder="Pt. aims to decrease..." >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hpi" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">HPI</label>
                            <div class="col-sm-9">
                                <textarea placeholder="The patient was diagnosed with..."  class="form-control" id="hpi" name="hpi" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>


                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step2')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step4')">Next</button>
                    </div>

                    <!-- Step 4: Client MPSE History -->
                    <div id="step4" class="tab-pane fade">
                        <!-- Add your Clinical History fields here -->
                        <!-- Example: -->
                        <div class="form-group row">
                            <label for="pshx" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">P/SHx</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="pshx" name="pshx" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="ehx" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">EHx</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="ehx" name="ehx" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pmhx" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">PMHx</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="pmhx" name="pmhx" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fmhx" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">FMHx</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="fmhx" name="fmhx" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="medications" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Medications</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="medications" name="medications" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        
                        <!-- Add more fields as needed -->

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step3')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step5')">Next</button>
                    </div>

                    <!-- Step 5: Examinations and Evaluations -->
                    <div id="step5" class="tab-pane fade">
                        <table id="vitalsTable"  style = "margin-left:auto; margin-right:auto; border: 1px solid black;">
                            <p>Vital Signs</P>
                            <thead>
                                <tr >
                                    <th style ="border: 1px solid black;"> </th>
                                    <th style = "font-size: 18px; border: 1px solid black;">BP (mmHg)</th>
                                    <th style = "font-size: 18px; border: 1px solid black;">HR (bpm)</th>
                                    <th style = "font-size: 18px; border: 1px solid black;">O2 sat (%)</th>
                                    <th style = "font-size: 18px; border: 1px solid black;">RR (cpm)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style ="border: 1px solid black;"><input type="text" class="form-control " id="text" name="text[]" placeholder="text" required style="width: 100px; "></td>
                                    <td style ="border: 1px solid black;"><input type="text" class=" form-control" id="bp" name="bp[]" placeholder="61/100" required style="width: 100px; "></td>
                                    <td style ="border: 1px solid black;"><input type="number" class=" form-control " id="hr" name="hr[]" placeholder="61" required style="width: 100px;"></td>
                                    <td style ="border: 1px solid black;"><input type="number" class=" form-control " id="osat" name="osat[]" placeholder="61" required style="width: 100px;"></td>
                                    <td style ="border: 1px solid black;"><input type="number" class=" form-control" id="rr" name="rr[]" placeholder="61" required style="width: 100px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <button type="button"  class="btn btn-primary" onclick="addVitals()">Add Row</button> <!--id = "addVitals" onclick="addVitals()"-->
                        </div>      
                        <div class="form-group row">
                            <label for="significance" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Significance</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="significance" name="significance" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <table id="assessmentsTable"  style = "margin-left:auto; margin-right:auto; border: 1px solid black; width: 75%">
                            <p>Assessments</P>
                            <tbody >
                                <tr>
                                <td style ="border: 1px solid black; text-align:left;" class="col-sm-3 col-form-label text-left"><label for="assess" style="font-size: 18px;">Assessment Procedure</label></td>
                                </tr>
                                <tr>
                                    <td style ="border: 1px solid black;"><input type="text" class="form-control " id="procedureTitle" name="procedureTitle[]" placeholder="Procedure Title" required></td>
                                </tr>
                                <tr>
                                    <td style ="border: 1px solid black;"><textarea class="form-control" id="openText" name="openText[]" placeholder="Description" required style="height: 100px; " ></textarea></td>
                                </tr>
                                <tr>
                                    <td style ="border: 1px solid black;"><textarea class="form-control" id="procedureSignificance" name="procedureSignificance[]" placeholder="Significance" required style="height: 100px; " ></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        <div id = "tableDiv" style = "margin-left:auto; margin-right:auto; width:75%"></div>
                        <button type="button"  class="btn btn-primary" onclick="addAssessments()">Add Assessments</button> <!--id = "addVitals" onclick="addVitals()"-->
                        <div class="form-group row">
                            <label for="diagnosis" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diagnosis</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="diagnosis" name="diagnosis" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prognosis" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Prognosis and Goals</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="prognosis" name="prognosis" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="plan" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Management Plan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="plan" name="plan" placeholder="Pt. complains of having..." required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step4')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step6')">Next</button>
                    </div>

                    <!-- Step 6: References -->
                    <div id="step6" class="tab-pane fade">
                        
                        <div class="form-group row">
                            <label for="references" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">References</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="references" name="references" style="height: 50px;">
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step5')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step7')">Next</button>
                    </div>

                    <!-- Step 7: Attachment -->
                    <div id="step7" class="tab-pane fade">
                    
                        <div class="form-group row">
                            <label for="attachment" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Attachment</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="attachment" name="attachment" style="height: 35px">
                            </div>
                        </div>

                        <!--div class="form-group row">
                            <label for="license" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">License No.</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="license" name="license" required >
                            </div>
                        </div-->

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step6')">Previous</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                <!--/div-->

            </form>
        </div>
    </div>

    <!-- Bootstrap JS and any additional scripts you may need -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script-->

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

        function addVitals() {
            var table = document.getElementById("vitalsTable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            cell1.innerHTML = '<td style ="border: 1px solid black;"><input type="text" class="form-control " id="text" name="text[]" placeholder="text" required style="width: 100px; "></td>';
            cell2.innerHTML = '<td style ="border: 1px solid black;"><input type="text" class=" form-control" id="bp" name="bp[]" placeholder="61/100" required style="width: 100px; "></td>';
            cell3.innerHTML = '<td style ="border: 1px solid black;"><input type="number" class=" form-control " id="hr" name="hr[]" placeholder="61" required style="width: 100px;"></td>';
            cell4.innerHTML = '<td style ="border: 1px solid black;"><input type="number" class=" form-control " id="osat" name="osat[]" placeholder="61" required style="width: 100px;"></td>';
            cell5.innerHTML = '<td style ="border: 1px solid black;"><input type="number" class=" form-control" id="rr" name="rr[]" placeholder="61" required style="width: 100px;"></td>';
        }

        function addAssessments() {
            var tableDiv = document.getElementById("tableDiv");
            var table = document.createElement('TABLE');
            //table.innerHTML = '<table style= "margin-left:auto; margin-right:auto; border: 1px solid black; width: 75%"></table>';
            table.innerHTML = '<table style= "margin-left:auto; margin-right:auto; border: 1px solid black; width: 25%"><tr><td style ="border: 1px solid black; text-align:left;" class="col-sm-3 col-form-label text-left"><label for="assess" style="font-size: 18px;">Assessment Procedure</label></td></tr><tr><td style ="border: 1px solid black;"><input type="text" class="form-control " id="procedureTitle" name="procedureTitle[]" placeholder="Procedure Title" required></td></tr><tr><td style ="border: 1px solid black;"><textarea class="form-control" id="openText" name="openText[]" placeholder="Description" required style="height: 100px; " ></textarea></td></tr><tr><td style ="border: 1px solid black;"><textarea class="form-control" id="procedureSignificance" name="procedureSignificance[]" placeholder="Significance" required style="height: 100px; " ></textarea></td></tr>';

            tableDiv.appendChild(table);
        }

        
    </script>
    


   
   
</body>
</html>

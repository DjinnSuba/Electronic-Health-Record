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
            <div class="header"><p style="font-size: 30px;">Patient Registration</p>

                <!-- Step Indicators -->
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#step1">General Data*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="pill" href="#step2">Consultation Details*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step3">Vital Signs*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step4">Clinical History*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step5">Past Medical History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step6">Family History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step7">Personal and Social History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step8" id="step7-tab">OB-Gynecological History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step9">Review of Systems</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step10">Physical Examination*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step11">Working Impression*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#step12">Plan*</a>
                    </li>
                </ul>
            </div>
            <!-- Form Steps -->
            <form method="POST" action="{{ route('storePatient') }}">
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
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nationality" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Nationality</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nationality" name="nationality" required>
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
                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="presentaddress" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Present Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="presentaddress" name="presentaddress" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="occupation" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Occupation</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="occupation" name="occupation" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="religion" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Religion</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="romancatholic">Roman Catholic</option>
                                    <option value="christian">Christian</option>
                                    <option value="islam">Islam</option>
                                    <option value="inc">Iglesia Ni Cristo</option>
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
                                <input type="date" class="form-control" id="dateOfConsult" name="dateOfConsult" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timeOfConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Time of Consult</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="timeOfConsult" name="timeOfConsult" required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="prevStep('step1')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step3')">Next</button>
                    </div>
                    
                    <!-- Step 3: Vital Signs -->
                    <div id="step3" class="tab-pane fade">
                        
                        <div class="form-group row">
                            <label for="bp" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Blood Pressure</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="bp" name="bp" placeholder="mmHg"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pulserate" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Pulse Rate</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="pulserate" name="pulserate" placeholder="bpm"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="respirationrate" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Respiration Rate</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="respirationrate" name="respirationrate" placeholder="bpm"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="temperature" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Temperature</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="temperature" name="temperature" placeholder="Celsius"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="weight" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Weight</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="weight" name="weight" placeholder="kg"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="height" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Height</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="height" name="height" placeholder="cm"required>
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
                            <label for="chiefComplaint" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Chief Complaint</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="chiefComplaint" name="chiefComplaint" required style="height: 100px;" >
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="historyillness" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">History of Present Illness</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="historyillness" name="historyillness" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        
                        <!-- Add more fields as needed -->

                        <!-- Navigation buttons -->
                         <button type="button" class="btn btn-secondary" onclick="prevStep('step3')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step5')">Next</button>
                    </div>

                    <!-- Step 5: Past Medical History -->
                    <div id="step5" class="tab-pane fade">
                        <!-- Checkbox for Allergies -->
                        <!-- Allergies -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Allergies</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="allergiesCheckbox" id="allergiesCheckbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="allergiesInput" name="allergiesInput" placeholder="Specify allergies">
                            </div>
                        </div>

                        <!-- Hypertension (HPN) -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Hypertension (HPN)</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="hpn_Checkbox" id="hpn_Checkbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="hpn_Input" name="hpn_Input" placeholder="Specify HPN details">
                            </div>
                        </div>

                        <!-- Diabetes Mellitus (DM) -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diabetes Mellitus (DM)</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="dm_Checkbox" id="dm_Checkbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="dm_Input" name="dm_Input" placeholder="Specify DM details">
                            </div>
                        </div>

                        <!-- Pulmonary Tuberculosis (PTB) -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Pulmonary Tuberculosis (PTB)</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="ptb_Checkbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="ptb_Input" name="ptb_Input" placeholder="Specify PTB details">
                            </div>
                        </div>

                        <!-- Bronchial Asthma -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Bronchial Asthma</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="asthma_Checkbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="asthma_Input" name="asthma_Input" placeholder="Specify asthma details">
                            </div>
                        </div>

                        <!-- COVID-19 Section -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">COVID-19</label>
                            <div class="col-sm-9">
                                <!-- 1st Dose -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="covidFirstDose" class="col-form-label" style="font-size: 18px;">1st dose</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="covidFirstDose" name="covidFirstDose">
                                            <!-- Add options for different vaccines -->
                                            <option value="sinovac">Sinovac</option>
                                            <option value="sputnikv">Sputnik V</option>
                                            <option value="astrazeneca">AstraZeneca</option>
                                            <option value="moderna">Moderna</option>
                                            <option value="pfizer">Pfizer</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="covidFirstDoseDate" name="covidFirstDoseDate">
                                    </div>
                                </div>

                                <!-- 2nd Dose -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="covidSecondDose" class="col-form-label" style="font-size: 18px;">2nd dose</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="covidSecondDose" name="covidSecondDose">
                                            <!-- Add options for different vaccines -->
                                            <option value="sinovac">Sinovac</option>
                                            <option value="sputnikv">Sputnik V</option>
                                            <option value="astrazeneca">AstraZeneca</option>
                                            <option value="moderna">Moderna</option>
                                            <option value="pfizer">Pfizer</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="covidSecondDoseDate" name="covidSecondDoseDate">
                                    </div>
                                </div>

                                <!-- Booster Dose -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="covidBoosterDose" class="col-form-label" style="font-size: 18px;">Booster</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="covidBoosterDose" name="covidBoosterDose">
                                            <!-- Add options for different vaccines -->
                                            <option value="sinovac">Sinovac</option>
                                            <option value="sputnikv">Sputnik V</option>
                                            <option value="astrazeneca">AstraZeneca</option>
                                            <option value="moderna">Moderna</option>
                                            <option value="pfizer">Pfizer</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="covidBoosterDoseDate" name="covidBoosterDoseDate">
                                    </div>
                                </div>

                                <!-- Others -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="otherDetails" class="col-form-label" style="font-size: 18px;">Others</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="otherDetails" name="otherDetails" placeholder="Specify other details">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step4')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step6')">Next</button>
                    </div>

                    <div id="step6" class="tab-pane fade">
                        
                        <div class="form-group row">
                            <label for="father" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Father</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="father" name="father" style="height: 50px;">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="mother" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Mother</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="mother" name="mother" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="siblings" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Siblings</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="siblings" name="siblings"  style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="spouse" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Spouse</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="spouse" name="spouse" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="children" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Children</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="children" name="children" style="height: 50px;">
                            </div>
                        </div>
                    


                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step5')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step7')">Next</button>
                    </div>

                    <div id="step7" class="tab-pane fade">
                    
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Smoker</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="smoker_Checkbox" id="smoker_Checkbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="smoker_Input" name="smoker_Input" placeholder="Specify sticks per day and years of smoking">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Alcohol</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="alcohol_Checkbox" id="alcohol_Checkbox" style="margin-right: 1000px;">
                                <input type="text" class="form-control" id="alcohol_Input" name="alcohol_Input" placeholder="How often? How many bottles per session? Alcohol match?">
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step6')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step8')">Next</button>
                    </div>

                    <div id="step8" class="tab-pane fade">
                        <!-- ... Existing content ... -->
                    
                        <!-- OB-Gynecological History -->
                        <div class="form-group row">
            
                            <div class="col-sm-9">
                                <!-- Last Menstrual Period (LMP) -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="lmp" class="col-form-label" style="font-size: 18px;">Last Menstrual Period</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="lmp" name="lmp">
                                    </div>
                                </div>
                    
                                <!-- Previous Menstrual Period (PMP) -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="pmp" class="col-form-label" style="font-size: 18px;">Previous Menstrual Period</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="pmp" name="pmp">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="pmp2" name="pmp2">
                                    </div>
                                </div>
                    
                                <!-- Last Sexual Contact (LSC) -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="lsc" class="col-form-label" style="font-size: 18px;">Last Sexual Contact</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="lsc" name="lsc">
                                    </div>
                                </div>
                    
                                <!-- Family Planning Technique Practiced -->
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="fpTechnique" class="col-form-label" style="font-size: 18px;">FP Technique Practiced</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="fpTechnique" name="fpTechnique" placeholder="Specify FP technique practiced">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="gp" class="col-form-label" style="font-size: 18px;">GTPAL</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="gp" name="gp" placeholder="Specify GTPAL">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="g1" class="col-form-label" style="font-size: 18px;">G1</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="g1" name="g1" placeholder="CS/NSD, Term/Preterm, Complications">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="g2" class="col-form-label" style="font-size: 18px;">G2</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="g2" name="g2" placeholder="CS/NSD, Term/Preterm, Complications">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="g3" class="col-form-label" style="font-size: 18px;">G3</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="g3" name="g3" placeholder="CS/NSD, Term/Preterm, Complications">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="g4" class="col-form-label" style="font-size: 18px;">G4</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="g4" name="g4" placeholder="CS/NSD, Term/Preterm, Complications">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label for="g5" class="col-form-label" style="font-size: 18px;">G5</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="g5" name="g5" placeholder="CS/NSD, Term/Preterm, Complications">
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step7')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step9')">Next</button>
                    </div>
                

                    <div id="step9" class="tab-pane fade">
                        <!-- Constitutional Symptoms -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Constitutional Symptoms</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="weightLossCheckbox" name="weightLossCheckbox">
                                    <label class="form-check-label" for="weightLossCheckbox" style="font-size: 15px;">Weight Loss</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="headacheCheckbox" name="headacheCheckbox">
                                    <label class="form-check-label" for="headacheCheckbox" style="font-size: 15px;">Headache</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="chillsCheckbox" name="chillsCheckbox">
                                    <label class="form-check-label" for="chillsCheckbox" style="font-size: 15px;">Chills</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="appetiteLossCheckbox" name="appetiteLossCheckbox">
                                    <label class="form-check-label" for="appetiteLossCheckbox" style="font-size: 15px;">Loss of Appetite</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="bodyWeaknessCheckbox" name="bodyWeaknessCheckbox">
                                    <label class="form-check-label" for="bodyWeaknessCheckbox" style="font-size: 15px;">Body Weakness</label>
                                </div>
                            </div>
                    
                            <!-- Remarks -->
                            <div class="form-group row">
                                <label for="constitutionalSymptomsRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="constitutionalSymptomsRemarks" name="constitutionalSymptomsRemarks" style="height: 50px;">
                                </div>
                            </div>
                        </div>
                

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Skin</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dryness/sweatingCheckbox" name="dryness/sweatingCheckbox">
                                    <label class="form-check-label" for="dryness/sweatingCheckbox" style="font-size: 15px;">Excessive Dryness/Sweating</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="pallorCheckbox" name="pallorCheckbox">
                                    <label class="form-check-label" for="pallorCheckbox" style="font-size: 15px;">Pallor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="rashesCheckbox" name="rashesCheckbox">
                                    <label class="form-check-label" for="rashesCheckbox" style="font-size: 15px;">Rashes on both hands</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="skinRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="skinRemarks" name="skinRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Ears</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="earacheCheckbox" name="earacheCheckbox">
                                    <label class="form-check-label" for="earacheCheckbox" style="font-size: 15px;">Earache</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="eardischargeCheckbox" name="eardischargeCheckbox">
                                    <label class="form-check-label" for="eardischargeCheckbox" style="font-size: 15px;">Ear Discharge</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="deafnessCheckbox" name="deafnessCheckbox">
                                    <label class="form-check-label" for="deafnessCheckbox" style="font-size: 15px;">Deafness</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tinnitusCheckbox" name="tinnitusCheckbox">
                                    <label class="form-check-label" for="tinnitusCheckbox" style="font-size: 15px;">Tinnitus</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="earsRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="earsRemarks" name="earsRemarks" style="height: 50px;">
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Nose and Sinuses</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="epistaxisCheckbox" name="epistaxisCheckbox">
                                    <label class="form-check-label" for="epistaxisCheckbox" style="font-size: 15px;">Epistaxis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="nasalobstructionCheckbox" name="nasalobstructionCheckbox">
                                    <label class="form-check-label" for="nasalobstructionCheckbox" style="font-size: 15px;">Nasal Obstruction</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="nasaldischargeCheckbox" name="nasaldischargeCheckbox">
                                    <label class="form-check-label" for="nasaldischargeCheckbox" style="font-size: 15px;">Nasal Discharge</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="paranasalCheckbox" name="paranasalCheckbox">
                                    <label class="form-check-label" for="paranasalCheckbox" style="font-size: 15px;">Paranal Sinus Pain</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="noseRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="noseRemarks" name="noseRemarks" style="height: 50px;">
                            </div>
                        </div>
                    

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Mouth and Throat</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="toothacheCheckbox" name="toothacheCheckbox">
                                    <label class="form-check-label" for="toothacheCheckbox" style="font-size: 15px;">Epistaxis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="gumbleedingCheckbox" name="gumbleedingCheckbox">
                                    <label class="form-check-label" for="gumbleedingCheckbox" style="font-size: 15px;">Gum Bleeding</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sorethroatCheckbox" name="sorethroatCheckbox">
                                    <label class="form-check-label" for="sorethroatCheckbox" style="font-size: 15px;">Sore Throat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sorenessCheckbox" name="sorenessCheckbox">
                                    <label class="form-check-label" for="sorenessCheckbox" style="font-size: 15px;">Soreness</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="mouthRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="mouthRemarks" name="mouthRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Neck</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="painCheckbox" name="painCheckbox">
                                    <label class="form-check-label" for="painCheckbox" style="font-size: 15px;">Pain</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="limitationCheckbox" name="limitationCheckbox">
                                    <label class="form-check-label" for="limitationCheckbox" style="font-size: 15px;">Limitation of Movement</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="massCheckbox" name="massCheckbox">
                                    <label class="form-check-label" for="massCheckbox" style="font-size: 15px;">Mass</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="neckRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="neckRemarks" name="neckRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Respiratory System</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="hemoptysisCheckbox" name="hemoptysisCheckbox">
                                    <label class="form-check-label" for="hemoptysisCheckbox" style="font-size: 15px;">Hemoptysis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="breathingCheckbox" name="breathingCheckbox">
                                    <label class="form-check-label" for="breathingCheckbox" style="font-size: 15px;">Difficulty of Breathing</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="respiratoryRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="respiratoryRemarks" name="respiratoryRemarks" style="height: 50px;">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Cardiovascular System</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="palpitationsCheckbox" name="palpitationsCheckbox">
                                    <label class="form-check-label" for="palpitationsCheckbox" style="font-size: 15px;">Palpitations</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="orthopneaCheckbox" name="orthopneaCheckbox">
                                    <label class="form-check-label" for="orthopneaCheckbox" style="font-size: 15px;">Orthopnea</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dsypneaCheckbox" name="dsypneaCheckbox">
                                    <label class="form-check-label" for="dsypneaCheckbox" style="font-size: 15px;">Dyspnea</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="chestpainCheckbox" name="chestpainCheckbox">
                                    <label class="form-check-label" for="chestpainCheckbox" style="font-size: 15px;">Chest Pain</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="cardiovascularRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="cardiovascularRemarks" name="cardiovascularRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>GIT</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="abdominalpainCheckbox" name="abdominalpainCheckbox">
                                    <label class="form-check-label" for="abdominalpainCheckbox" style="font-size: 15px;">Abdominal Pain</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dysphagiaCheckbox" name="dysphagiaCheckbox">
                                    <label class="form-check-label" for="dysphagiaCheckbox" style="font-size: 15px;">Dysphagia</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="diarrheaCheckbox" name="diarrheaCheckbox">
                                    <label class="form-check-label" for="diarrheaCheckbox" style="font-size: 15px;">Diarrhea</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="constipationCheckbox" name="constipationCheckbox">
                                    <label class="form-check-label" for="constipationCheckbox" style="font-size: 15px;">Constipation</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="hematemesisCheckbox" name="hematemesisCheckbox">
                                    <label class="form-check-label" for="hematemesisCheckbox" style="font-size: 15px;">Hematemesis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="melenaCheckbox" name="melenaCheckbox">
                                    <label class="form-check-label" for="melenaCheckbox" style="font-size: 15px;">Melena</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="vomitingCheckbox" name="vomitingCheckbox">
                                    <label class="form-check-label" for="vomitingCheckbox" style="font-size: 15px;">Vomiting</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="gitRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="gitRemarks" name="gitRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>GUT</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dysuriaCheckbox" name="dysuriaCheckbox">
                                    <label class="form-check-label" for="dysuriaCheckbox" style="font-size: 15px;">Dysuria</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="urinaryCheckbox" name="urinaryCheckbox">
                                    <label class="form-check-label" for="urinaryCheckbox" style="font-size: 15px;">Urinary Frequency</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="urgencyCheckbox" name="urgencyCheckbox">
                                    <label class="form-check-label" for="urgencyCheckbox" style="font-size: 15px;">Urgency</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="polyuriaCheckbox" name="polyuriaCheckbox">
                                    <label class="form-check-label" for="polyuriaCheckbox" style="font-size: 15px;">Polyuria</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="hesitancyCheckbox" name="hesitancyCheckbox">
                                    <label class="form-check-label" for="hesitancyCheckbox" style="font-size: 15px;">Hesitancy</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="incontinenceCheckbox" name="incontinenceCheckbox">
                                    <label class="form-check-label" for="incontinenceCheckbox" style="font-size: 15px;">Incontinence</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="urineoutputCheckbox" name="urineoutputCheckbox">
                                    <label class="form-check-label" for="urineoutputCheckbox" style="font-size: 15px;">Decreased Urine Output</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="gutRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="gutRemarks" name="gutRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Extremeties</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="jointpainCheckbox" name="jointpainCheckbox">
                                    <label class="form-check-label" for="jointpainCheckbox" style="font-size: 15px;">Joint Pain</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="stiffnessCheckbox" name="stiffnessCheckbox">
                                    <label class="form-check-label" for="stiffnessCheckbox" style="font-size: 15px;">Stiffness</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edemaCheckbox" name="edemaCheckbox">
                                    <label class="form-check-label" for="edemaCheckbox" style="font-size: 15px;">Edema</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="extremitiesRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="extremitiesRemarks" name="extremitiesRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Nervous System</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="confusionCheckbox" name="confusionCheckbox">
                                    <label class="form-check-label" for="confusionCheckbox" style="font-size: 15px;">Confusion</label>
                                </div>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="nervousRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nervousRemarks" name="nervousRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Hematopoietic System</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="bleedingCheckbox" name="bleedingCheckbox">
                                    <label class="form-check-label" for="bleedingCheckbox" style="font-size: 15px;">Bleeding Tendencies</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="bruisingCheckbox" name="bruisingCheckbox">
                                    <label class="form-check-label" for="bruisingCheckbox" style="font-size: 15px;">Bruising</label>
                                </div>
                            </div>
                            
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="hematopoieticRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="hematopoieticRemarks" name="hematopoieticRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;"><strong>Endocrine System</strong> </label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="heat/coldCheckbox" name="heat/coldCheckbox">
                                    <label class="form-check-label" for="heat/coldCheckbox" style="font-size: 15px;">Heat/Cold Intolerance</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="nocturiaCheckbox" name="nocturiaCheckbox">
                                    <label class="form-check-label" for="nocturiaCheckbox" style="font-size: 15px;">Nocturia</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="polyphagiaCheckbox" name="polyphagiaCheckbox">
                                    <label class="form-check-label" for="polyphagiaCheckbox" style="font-size: 15px;">Polyphagia</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="polydipsiaCheckbox" name="polydipsiaCheckbox">
                                    <label class="form-check-label" for="polydipsiaCheckbox" style="font-size: 15px;">Polydipsia</label>
                                </div>
                            </div>
                            
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row">
                            <label for="endocrineRemarks" class="col-sm-3 col-form-label text-right" style="font-size: 15px;">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="endocrineRemarks" name="endocrineRemarks" style="height: 50px;">
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step8')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep('step10')">Next</button>
                    </div>


                    <div id="step10" class="tab-pane fade">
                    
                        <div class="form-group row">
                            <label for="generalSurvey" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">General Survey</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="generalSurvey" name="generalSurvey" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="head-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Head</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="headExam" name="headExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="face-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Face</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="faceExam" name="faceExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="eyes-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Eyes</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="eyesExam" name="eyesExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ears-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Ears</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="earsExam" name="earsExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nose-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Nose and Paranasal Sinuses</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="noseExam" name="noseExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="neck-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Neck</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="neckExam" name="neckExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cardiovascular-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Cardiovascular</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="cardiovascularExam" name="cardiovascularExam" required style="height: 100px; " >
                                </textarea>                            
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="chest-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Chest/Lungs</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="chestExam" name="chestExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skin-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Skin</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="skinExam" name="skinExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="extremities-exam" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Extremities</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="extremitiesExam" name="extremitiesExam" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
            

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step9')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step11')">Next</button>
                    </div>

                    <div id="step11" class="tab-pane fade">
                        <div class="form-group row">
                            <label for="workingImpression" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Working Impression</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="workingImpression" name="workingImpression" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Hypertension</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="hypertension_Checkbox" id="hypertension_Checkbox" style="margin-right: 1000px;">
                                <select class="form-control" id="hypertension_Input" name="hypertension_Input">
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
                                    <option value="controlled">Controlled</option>
                                    <option value="uncontrolled">Uncontrolled</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">A00-B99 Certain infectious and parasitic diseases
                            </label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="a00-b99_Checkbox" id="a00-b99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">C00-D48 Neoplasms</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="c00-d48_Checkbox" id="c00-d48_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">D50-D89 Diseases of the blood and blood-forming organs and certain disorders involving the immune mechanism</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="d50-d89_Checkbox" id="d50-d89_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">E00-E90 Endocrine, nutritional and metabolic diseases </label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="e00-e90_Checkbox" id="e00-e90_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">F00-F99 Mental and behavioural disorders</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="f00-f99_Checkbox" id="f00-f99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">G00-G99 Diseases of the nervous system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="g00-g99_Checkbox" id="g00-g99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">H00-H59 Diseases of the eye and adnexa</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="h00-h59_Checkbox" id="h00-h59_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">H60-H95 Diseases of the ear and mastoid process</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="h60-h95_Checkbox" id="h60-h95_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">I00-I99 Diseases of the circulatory system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="i00-i99_Checkbox" id="i00-i99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">J00-J99 Diseases of the respiratory system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="j00-j99_Checkbox" id="j00-j99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">K00-K93 Diseases of the digestive system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="k00-k93_Checkbox" id="k00-k93_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">L00-L99 Diseases of the skin and subcutaneous tissue</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="l00-l99_Checkbox" id="l00-l99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">M00-M99 Diseases of the musculoskeletal system and connective tissue</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="m00-m99_Checkbox" id="m00-m99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">N00-N99 Diseases of the genitourinary system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="n00-n99_Checkbox" id="n00-n99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">O00-O99 Pregnancy, childbirth and the puerperium</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="o00-o99_Checkbox" id="o00-o99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">P00-P96 Certain conditions originating in the perinatal period</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="p00-p96_Checkbox" id="p00-p96_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Q00-Q99 Congenital malformations, deformations and chromosomal abnormalities</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="q00-p99_Checkbox" id="q00-p99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">R00-R99 Symptoms, signs and abnormal clinical and laboratory findings, not elsewhere classified</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="r00-r99_Checkbox" id="r00-r99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">S00-T98 Injury, poisoning and certain other consequences of external causes</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="s00-t98_Checkbox" id="s00-t98_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">V01-Y98 External causes of morbidity and mortality</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="v01-y98_Checkbox" id="v01-y98_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Z00-Z99 Factors influencing health status and contact with health services</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="z00-z99_Checkbox" id="z00-z99_Checkbox" style="margin-right: 1000px;">
                            </div>
                        </div>



                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step10')">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNext('step12')">Next</button>
                    </div>
                    

                    <div id="step12" class="tab-pane fade">
                        
                        <div class="form-group row">
                            <label for="diagnostics" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diagnostics</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="diagnostics" name="diagnostics" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="drugs" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Drugs</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="drugs" name="drugs" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diet" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diet</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="diet" name="diet" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="disposition" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Disposition</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="disposition" name="disposition" required style="height: 100px; " >
                                </textarea>
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <button type="button" class="btn btn-secondary" onclick="prevStep('step11')">Previous</button>
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

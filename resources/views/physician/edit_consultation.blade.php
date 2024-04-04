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
        <div class="header"><p style="font-size: 30px;">Edit Follow Up Consult</p>

            <!-- Step Indicators -->
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#step1">General Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#step2">Consultation Details</a>
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
            <form method="POST" action="{{url('/update-follow-consult/'.$data->patientId.'/'.$data->dateOfConsult)}}">
                @csrf

                <div class="tab-content">
                    <!-- Step 1: General Data -->
                    <div id="step1" class="tab-pane fade show active">
                        <!-- Add your General Data fields here -->
                        <!-- Example: -->
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{$data->lastName}}"  required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{$data->firstName}}"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="middleName" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Middle Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="middleName" name="middleName" value="{{$data->middleName}}"required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="age" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Age</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="age" name="age" value="{{$data->age}}"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sex" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Sex</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="sex" name="sex" required >
                                    <option {{old('sex',$data->sex)=="female"? 'selected':''}} value="female">Female</option>
                                    <option {{old('sex',$data->sex)=="male"? 'selected':''}} value="male">Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nationality" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Nationality</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nationality" name="nationality" value="{{$data->nationality}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="civilstatus" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Civil Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="civilstatus" name="civilstatus" required >
                                    <option {{old('civilstatus',$data->civilstatus)=="single"? 'selected':''}} value="single">Single</option>
                                    <option {{old('civilstatus',$data->civilstatus)=="married"? 'selected':''}} value="married">Married</option>
                                    <option {{old('civilstatus',$data->civilstatus)=="divorced"? 'selected':''}} value="divorced">Divorced</option>
                                    <option {{old('civilstatus',$data->civilstatus)=="widowed"? 'selected':''}} value="widowed">Widowed</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthday" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Birthday</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="birthday" name="birthday" value="{{\Illuminate\Support\Carbon::parse($data->birthday)->format("Y-m-d")}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="presentaddress" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Present Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="presentaddress" name="presentaddress" value="{{$data->presentaddress}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="occupation" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Occupation</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="occupation" name="occupation" value="{{$data->occupation}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="religion" class="col-sm-3 col-form-label text-right" style="font-size: 18px;" default value="christian">Religion</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="religion" name="religion" required >
                                    <option {{old('religion',$data->religion)=="romancatholic"? 'selected':''}} value="romancatholic">Roman Catholic</option>
                                    <option {{old('religion',$data->religion)=="christian"? 'selected':''}} value="christian">Christian</option>
                                    <option {{old('religion',$data->religion)=="islam"? 'selected':''}} value="islam">Islam</option>
                                    <option {{old('religion',$data->religion)=="inc"? 'selected':''}} value="inc">Iglesia Ni Cristo</option>  
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
                                <input type="date" class="form-control" id="dateOfConsult" name="dateOfConsult" value="{{\Illuminate\Support\Carbon::parse($data->dateOfConsult)->format("Y-m-d")}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timeOfConsult" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Time of Consult</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="timeOfConsult" name="timeOfConsult" value="{{$data->timeOfConsult}}" required>
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
                                <textarea class="form-control" id="subFindings" name="subFindings" required style="height: 100px; " >
                                {{$data->subFindings}}
                                </textarea>
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
                                <textarea class="form-control" id="objFindings" name="objFindings" required style="height: 100px; " >
                                {{$data->objFindings}}
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
                        <div class="form-group row">
                                <label for="assessment" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Assessment</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="assessment" name="assessment" required style="height: 100px; " >
                                    {{$data->assessment}}
                                    </textarea>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Hypertension</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="hypertension_Checkbox" id="hypertension_Checkbox" required  style="margin-right: 1000px;" {{$data->hypertension != 0 ? 'checked' : ''}} > 
                                <select class="form-control" id="hypertension_Input" name="hypertension_Input" required >
                                            <!-- Add options for different vaccines -->
                                            <option  {{old('hypertension',$data->hypertension)=="controlled"? 'selected':''}} value="controlled">Controlled</option>
                                            <option  {{old('hypertension',$data->hypertension_Input)=="uncontrolled"? 'selected':''}} value="uncontrolled">Uncontrolled</option>
                                </select>                            
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diabetes</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="diabetes_Checkbox" id="diabetes_Checkbox"  required  style="margin-right: 1000px;"  {{$data->diabetes != 0 ? 'checked' : ''}}>
                                <select class="form-control" id="diabetes_Input" name="diabetes_Input" required >
                                    <!-- Add options for different vaccines -->
                                    <option {{old('diabetes',$data->diabetes)=="controlled"? 'selected':''}} value="controlled">Controlled</option>
                                    <option {{old('diabetes',$data->diabetes)=="controlled"? 'selected':''}} value="uncontrolled">Uncontrolled</option>
                                </select>                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">A00-B99 Certain infectious and parasitic diseases
                            </label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="a00_b99Checkbox" id="a00_b99Checkbox"   style="margin-right: 1000px;" {{$data->icdUmbrella['a00-b99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">C00-D48 Neoplasms</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="c00_d48Checkbox" id="c00_d48Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['c00-d48'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">D50-D89 Diseases of the blood and blood-forming organs and certain disorders involving the immune mechanism</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="d50_d89Checkbox" id="d50_d89Checkbox"     style="margin-right: 1000px;"{{$data->icdUmbrella['d50-d89'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">E00-E90 Endocrine, nutritional and metabolic diseases </label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="e00_e90Checkbox" id="e00_e90Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['e00-e90'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">F00-F99 Mental and behavioural disorders</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="f00_f99Checkbox" id="f00_f99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['f00-f99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">G00-G99 Diseases of the nervous system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="g00_g99Checkbox" id="g00_g99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['g00-g99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">H00-H59 Diseases of the eye and adnexa</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="h00_h59Checkbox" id="h00_h59Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['h00-h59'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">H60-H95 Diseases of the ear and mastoid process</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="h60_h95Checkbox" id="h60_h95Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['h60-h95'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">I00-I99 Diseases of the circulatory system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="i00_i99Checkbox" id="i00_i99Checkbox" reqred  style="margin-right: 1000px;"{{$data->icdUmbrella['i00-i99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">J00-J99 Diseases of the respiratory system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="j00_j99Checkbox" id="j00_j99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['j00-j99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">K00-K93 Diseases of the digestive system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="k00_k93Checkbox" id="k00_k93Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['k00-k93'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">L00-L99 Diseases of the skin and subcutaneous tissue</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="l00_l99Checkbox" id="l00_l99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['l00-l99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">M00-M99 Diseases of the musculoskeletal system and connective tissue</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="m00_m99Checkbox" id="m00_m99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['m00-m99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">N00-N99 Diseases of the genitourinary system</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="n00_n99Checkbox" id="n00_n99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['n00-n99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">O00-O99 Pregnancy, childbirth and the puerperium</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="o00_o99Checkbox" id="o00_o99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['o00-o99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">P00-P96 Certain conditions originating in the perinatal period</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="p00_p96Checkbox" id="p00_p96Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['p00-p96'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Q00-Q99 Congenital malformations, deformations and chromosomal abnormalities</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="q00_q99Checkbox" id=q00_q99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['q00-q99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">R00-R99 Symptoms, signs and abnormal clinical and laboratory findings, not elsewhere classified</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="r00_r99Checkbox" id="r00_r99Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['r00-r99'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">S00-T98 Injury, poisoning and certain other consequences of external causes</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="s00_t98Checkbox" id="s00_t98Checkbox"   style="margin-right: 1000px;"{{$data->icdUmbrella['s00-t98'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">V01-Y98 External causes of morbidity and mortality</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="v01_y98Checkbox" id="v01_y98Checkbox"   style="margin-right: 1000px; "{{$data->icdUmbrella['v01-y98'] == 'true' ? 'checked' : ''}}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Z00-Z99 Factors influencing health status and contact with health services</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="z00_z99Checkbox" id="z00_z99Checkbox"  style="margin-right: 1000px;"{{$data->icdUmbrella['z00-z99'] == 'true' ? 'checked' : ''}}>
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
                                <textarea class="form-control" id="diagnostics" name="diagnostics" required style="height: 100px; " >
                                    {{$data->diagnostics}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="drugs" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Drugs</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="drugs" name="drugs" required style="height: 100px; " >
                                    {{$data->drugs}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diet" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Diet</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="diet" name="diet" required style="height: 100px; " >
                                    {{$data->diet}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="disposition" class="col-sm-3 col-form-label text-right" style="font-size: 18px;">Disposition</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="disposition" name="disposition" required style="height: 100px; " >
                                    {{$data->disposition}}
                                </textarea>
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

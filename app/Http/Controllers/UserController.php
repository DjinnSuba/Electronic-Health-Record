<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient; //PatientCodes
use App\Models\fcmPatient; //FCM Patient Registration
use App\Models\AddConsult; //FCM Patient Consultation
use App\Models\Access; //FCM + PT patitent access

use App\Models\ptPatient; //PT Patient Registration
use App\Models\ProgressReport; // PT Patient Consultation
use App\Models\VitalSign; //PT Patient Vital Sign
use App\Models\Assessment; //PT Patient Assessment

use Carbon\Carbon;


use Hash;
use Session;
use DB;


class UserController extends Controller
{
    //====================================================================================================================
    public function register(){
        return view('register-user');
    }

    public function registerUser(Request $request){
        $request -> validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user -> username = $request -> username;
        $user -> email = $request -> email;
        $user -> password = Hash::make($request -> password);
        $res = $user -> save();
        return redirect('/logins') -> withSuccess('User successefully created!');

    }
    //====================================================================================================================

    //==============================================LOGIN LOGOUT==========================================================
    //====================================================================================================================
    public function login(){
        return view('login-user');
    }
    public function loginUser(Request $request){
        //$input = $request -> all();
        $request->validate([
            'email' => 'required|email',
            'password' =>'required|min:6',
        ]);

        $user = User::where('email', '=', $request -> email)-> first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $request-> session() ->put('loginId', $user -> id);
                $doc = User::where('id', '=', Session::get('loginId'))-> first();
                if($doc -> department == 'Admin'){
                    return redirect('/admin/dashboard');
                }
                else if($doc -> department == 'Family Medicine'||'Physical Therapist'){
                    $accesses1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 2)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                    $accesses2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                                    ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                                    ->where('accesses.attendingId', Session::get('loginId'))
                                    ->where('accesses.formType', 0)
                                    ->where('accesses.status', '=','pending')->distinct()
                                    ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                    $accesses3 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                                    ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                                    ->where('accesses.attendingId', Session::get('loginId'))
                                    ->where('accesses.status', '=', 'pending')
                                    ->where('accesses.formType', 1)->distinct()
                                    ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                    $accesses4 = Access::join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                                    ->join('users', 'users.id', 'accesses.attendingId')     
                                    ->where('accesses.attendingId', Session::get('loginId'))
                                    ->where('accesses.status', '=','pending')->distinct()
                                    ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                    $accesses1 = $accesses1 -> toBase()->merge($accesses2);
                    $accesses1 = $accesses1 -> toBase()->merge($accesses4);
                    $accesses = $accesses1 -> toBase()->merge($accesses3);
                    if($doc -> department == 'Family Medicine'){
                        $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                        ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                                        ->where('accesses.attendingId', Session::get('loginId'))
                                        ->where('accesses.formType', 0)
                                        ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                        ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                        $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                        ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                                        ->where('accesses.attendingId', Session::get('loginId'))
                                        ->where('accesses.formType', 1)
                                        ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                        ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                                        $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();  
                    }else{
                        $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                        ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                                        ->where('accesses.attendingId', Session::get('loginId'))
                                        ->where('accesses.formType', 2)
                                        ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                        ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                        $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                        ->join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                                        ->where('accesses.attendingId', Session::get('loginId'))
                                        ->where('accesses.formType', 3)
                                        ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                        ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                                        $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();    
                    }
                    return view('physician.dashboard', compact(['doc', 'accesses', 'today1', 'today2', 'count1', 'count2']));
                }
            }
            else{
                return back()-> with('fail', 'Password DNM.');
            }
        }else{
            return back()-> with('fail', 'Email DNE.');
        }
    }

    public function home(){
        $data = array();
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        return view('home-user', compact('doc'));
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('logins');
        }
        return view('logins', compact('doc'));
    }

    public function physician_dashboard(){
        if(Session::has('loginId')){
            $doc = User::where('id',Session::get('loginId'))->first();
            $accesses1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 2)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 0)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses3 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.status', '=', 'pending')
                            ->where('accesses.formType', 1)->distinct()
                            ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses4 = Access::join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                            ->join('users', 'users.id', 'accesses.attendingId')     
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses1 = $accesses1 -> toBase()->merge($accesses2);
            $accesses1 = $accesses1 -> toBase()->merge($accesses4);
            $accesses = $accesses1 -> toBase()->merge($accesses3);
            if($doc -> department == 'Family Medicine'){
                $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 0)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 1)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();                                
            }else{
                $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 2)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 3)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 2)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 3)->where('status', null)->count();
            }
            //$today = $today1-> toBase()->merge($today2);
            //echo Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();

            return view('physician.dashboard', compact(['doc', 'accesses', 'today1', 'today2', 'count1', 'count2']));
        }
    }

    public function acceptAccess(string $patientid, string $attendingid, string $accessid)
    {
        if(Session::has('loginId')){
            $doc = User::where('id',Session::get('loginId'))->first();
            $accesses1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 2)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 0)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses3 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.status', '=', 'pending')
                            ->where('accesses.formType', 1)->distinct()
                            ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses4 = Access::join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                            ->join('users', 'users.id', 'accesses.attendingId')     
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses1 = $accesses1 -> toBase()->merge($accesses2);
            $accesses1 = $accesses1 -> toBase()->merge($accesses4);
            $accesses = $accesses1 -> toBase()->merge($accesses3);
            if($doc -> department == 'Family Medicine'){
                $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 0)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 1)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();    
            }else{
                $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 2)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 3)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                                $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();    
            }
            Access::where('patientId', $patientid)->where('attendingId', $attendingid)->where('accessId', $accessid)->update([
                'status' => "accepted"
            ]);
            return redirect()->route('physician.dashboard')->with(['doc'=>$doc, 'accesses'=>$accesses, 'today1'=>$today1, 'today2'=>$today2, 'count1'=>$count1, 'count2'=>$count2]);
        }   
    }
    //====================================================================================================================

    //===================================================SIDE BAR=========================================================
    //====================================================================================================================
    
    public function physician_pfp(){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
            //echo $data -> physicianCode;
            
            // $info = Patient::all()->last();
            // $id = $info -> id;
            // echo $info -> id;
            // echo $id;
        }
        return view('physician.profile', compact('doc'));
    }


////
  
    public function uploadSave(Request $request) {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        //$request->image->move(public_path('images'), $imageName);
        $request->image->storeAs('public/images', $imageName);
  
        /* Store $imageName name in DATABASE from HERE */
        $user = User::where('id', '=', Session::get('loginId'))-> first();
        $user->profile = $imageName;
        $user->save();
        $doc = $user;
        return redirect() -> route('physician.pfp') -> with(['doc' => $doc]);

        
        /*
        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName); */
    }
    public function deleteProfile($id, $profile){
        $doc = User::where('id', $id)->first();
        $doc -> profile = null;
        $doc -> save();
        return redirect() -> route('physician.pfp') -> with(['doc' => $doc]);
    }
    
////

    public function physician_records(){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();

        }
        $data1 = ptPatient::get(['patientId', 'dateOfConsult', 'patientCode', 'formType']);
        $data2 = fcmPatient::get(['patientId', 'dateOfConsult', 'patientCode','formType']);
        $data = $data1 -> toBase()->merge($data2);

        $data3 = AddConsult::get(['patientId', 'dateOfConsult', 'patientCode', 'formType']);
        $data4 = ProgressReport::get(['patientId', 'dateOfConsult', 'patientCode','formType']);

        $dataConsultation = $data3 -> toBase()->merge($data4);

        //echo $data1;
        //echo $data2;
        //echo $data;
        return view('physician.records', compact('data', 'dataConsultation','doc'));
    }
    //view all patient Registration
    public function physician_patients(){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        
        $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.accessId', null)
                            ->where('accesses.formType', 2)
                            ->get(['accesses.physicianCodez', 
                            'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.attendingId', Session::get('loginId'))
                    ->where('accesses.accessId', null)
                    ->where('accesses.formType', 0)
                    ->get(['accesses.physicianCodez', 
                    'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);
    
        $info = Patient::all()->last();
        return view('physician.patients', compact('accesses', 'doc'));
    }

    //updated
    public function physician_files(){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();
            if($doc -> department == 'Family Medicine'){
                return view('physician.files', compact('doc'));
            }
            else if($doc -> department == 'Physical Therapist'){
                return view('pt.files', compact('doc'));
            }
        //return view('physician.files');
    }

    
    public function viewPatientRecords(String $patientCode){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();

        }
        //$add_consult = AddConsult::where('patientCode', '=', $patientCode)-> get();
        if(AddConsult::where('patientCode', '=', $patientCode)->exists()){
            $add_consult = AddConsult::where('patientCode', '=', $patientCode)-> first();
        }else {
            $add_consult = ProgressReport::where('patientCode', '=', $patientCode)->first();
        }

        if(fcmPatient::join('add_consult', 'add_consult.patientCode', '=', 'fcm_patients.patientCode', 'full outer')
            ->where('fcm_patients.patientCode',$patientCode)->exists()){
                $patients = fcmPatient::join('add_consult', 'add_consult.patientCode', '=', 'fcm_patients.patientCode', 'full outer')
                ->where('fcm_patients.patientCode',$patientCode)
                ->get(['fcm_patients.patientCode', 'fcm_patients.lastName','fcm_patients.firstName', 'fcm_patients.middleName','fcm_patients.patientId', 'add_consult.patientId','fcm_patients.dateOfConsult','add_consult.dateOfConsult']);
        }else{
            $patients = ptPatient::join('progress_report', 'progress_report.patientCode', '=', 'pt_patients.patientCode', 'full outer')
            ->where('pt_patients.patientCode', $patientCode)
            ->get(['pt_patients.patientCode', 'pt_patients.lastName', 'pt_patients.firstName', 'pt_patients.middleName', 'pt_patients.patientId', 'progress_report.patientId', 'progress_report.dateOfConsult', 'progress_report.dateOfConsult']);
        }
        
        //return view('physician.clinic_records', compact('accesses'));
        //$patients = $patientz::where('patientCode', '=', $patientCode)-> get();

        return view('physician.patient_records_view', compact('patients','doc'));
    }
    //

    public function physician_uploads(){
        if(Session::has('loginId')){
            $doc= User::where('id', '=', Session::get('loginId'))-> first();
        }
        return view('physician.uploads', compact('doc'));
    }

    public function physician_clinic_records(){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
            //$data= User::where('id', '=', Session::get('loginId'))-> first();

            //echo $doc -> physicianCode;
        }
        $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.accessId', Session::get('loginId'))
                            ->where('accesses.status', "!=", null)
                            ->get(['accesses.physicianCodez', 'accesses.status', 'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.accessId', Session::get('loginId'))
                    ->where('accesses.status', "!=", null)
                    ->get(['accesses.physicianCodez','accesses.status','fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);
        return view('physician.clinic_records', compact('accesses','doc'));
        //$data = Patient::whereBetween('dateOfConsult', [Carbon::now()->subDays(7),Carbon::now()])->orderBy('dateOfConsult', 'DESC') -> get();
    }

    //====================================================================================================================

    //================================================POST Functions======================================================
    //====================================================================================================================
    //Blade view for registering patient
    public function physician_register_patients(){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();
            if($doc -> department == 'Family Medicine'){
                return view('physician.patient_register',compact('doc'));
            }
            else if($doc -> department == 'Physical Therapist'){
                return view('pt.patient_register',compact('doc'));
            }
    }

    //Generate Patient Code function
    private function generatePatientCode(){
        // Get the current year and month
        $yearMonth = now()->format('Y-m');
    
        // Get the last patient code for the current year and month
        $lastPatient = Patient::where(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"), '=', $yearMonth)
            ->orderBy('patientCode', 'desc')
            ->first();
    
        // Extract the sequential number and increment it
        $sequenceNumber = $lastPatient ? (int)substr($lastPatient->patientCode, -5) + 1 : 1;
    
        // Format the sequential number with leading zeros
        $formattedSequence = str_pad($sequenceNumber, 5, '0', STR_PAD_LEFT);
    
        // Combine the year, month, and sequential number to create the patient code
        $patientCode = "{$yearMonth}-{$formattedSequence}";
    
        return $patientCode;
    }
    
    //Blade view see personal patient
    public function physician_view_patient(string $patientid){
        $data = array();
        if(Session::has('loginId')){
            $doc = User::where('id', Session::get('loginId'))->first();
            
            if(fcmPatient::where('patientId', '=', $patientid)->exists()){
                $data = fcmPatient::where('patientId', '=', $patientid)-> first();
            }else{
                $data = ptPatient::where('patientId','=',$patientid)->first();
            }

            if(Access::join('users', 'users.id', '=', 'accesses.attendingId')
                        ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                        ->where('accesses.patientId', $patientid)
                        ->where('accesses.attendingId', Session::get('loginId'))->exists()){//access to attended patient
                return view('physician.patient_view', compact(['data','doc']));
            } 
            else if(Access::join('users', 'users.id', '=', 'accesses.attendingId')
                    ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.patientId', $patientid)
                    ->where('accesses.attendingId', Session::get('loginId'))->exists()){
                        $vs = VitalSign::where('id', $data->vsId)->first();
                        $texts = [];
                        foreach($vs['text'] as $text){
                            //echo $text;
                            //echo " ";
                            array_push($texts, $text);
                        }
                        $bps = [];
                        foreach($vs['bp'] as $bp){
                            array_push($bps, $bp);
                        }
                    
                        $hrs = [];
                        foreach($vs['hr'] as $hr){
                            array_push($hrs, $hr);
                        }
                        $osats = [];
                        foreach($vs['osat'] as $osat){
                            array_push($osats, $osat);
                        }
                        $rrs = [];
                        foreach($vs['rr'] as $rr){
                            array_push($rrs, $rr);
                        }
                        $vscount = count($texts);

                        $as = Assessment::where('id', $data->asId)->first();
                        $procedureTitles = [];
                        foreach($as['procedureTitle'] as $procedureTitle){
                            array_push($procedureTitles, $procedureTitle);
                        }
                        $openTexts = [];
                        foreach($as['openText'] as $openText){
                            array_push($openTexts, $openText);
                        }
                        
                        $procedureSignificances = [];
                        foreach($as['procedureSignificance'] as $procedureSignificance){
                            array_push($procedureSignificances, $procedureSignificance);
                        }
                        $ascount = count($procedureTitles);
                        for($i = 0; $i < $ascount; $i++){
                            //echo $procedureTitles[$i];
                            //echo $openTexts[$i];
                            //echo $procedureSignificances[$i];
                        }
                        return view('pt.patient_view', compact(['doc','data', 'texts', 'bps', 'hrs', 'osats', 'rrs', 'vscount','procedureTitles', 'openTexts', 'procedureSignificances','ascount']));
            }
            else{
                //echo " hi";
                if(Access::join('users', 'users.id', '=', 'accesses.attendingId')
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.patientId', $patientid)
                    ->where('accesses.accessId', Session::get('loginId'))->exists())
                    {
                        //cho " hellofcm";
                        $accesses = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                            ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.patientId', $patientid)
                            ->where('accesses.accessId', Session::get('loginId'))
                            ->get(['accesses.physicianCodez', 'accesses.attendingId','accesses.accessId',  'accesses.status','fcm_patients.patientId', 'accesses.formType']);
                        //echo $accesses;
                        foreach($accesses as $a){
                            //echo $a -> status;
                            if($a->status == 'accepted'){
                                return view('physician.patient_view', compact(['data', 'doc']));
                            }elseif($a->status == 'pending'){
                                //echo " nihaofcm";
                                return view('physician.request_pending', compact(['data', 'doc','accesses']));
                            }else{
                                //echo " sayonarafcm";
                            }
                        }
                    }
                elseif(Access::join('users', 'users.id', '=', 'accesses.attendingId')
                    ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.patientId', $patientid)
                    ->where('accesses.accessId', Session::get('loginId'))->exists())
                    {
                        //echo " bonjour";
                        $accesses = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                                ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                                ->where('accesses.patientId', $patientid)
                                ->where('accesses.accessId', Session::get('loginId'))
                                ->get(['accesses.physicianCodez', 'accesses.attendingId','accesses.accessId',  'accesses.status','pt_patients.patientId']);
                        foreach($accesses as $a){
                            //echo $a -> status;
                            if($a->status == 'accepted'){
                                //echo " adobo";
                                //echo $data->vsId;
                                $vs = VitalSign::where('id', $data->vsId)->first();
                                $texts = [];
                                foreach($vs['text'] as $text){
                                    array_push($texts, $text);
                                }

                                $bps = [];
                                foreach($vs['bp'] as $bp){
                                    array_push($bps, $bp);
                                }
                            
                                $hrs = [];
                                foreach($vs['hr'] as $hr){
                                    array_push($hrs, $hr);
                                }
                                $osats = [];
                                foreach($vs['osat'] as $osat){
                                    array_push($osats, $osat);
                                }
                                $rrs = [];
                                foreach($vs['rr'] as $rr){
                                    array_push($rrs, $rr);
                                }
                                $vscount = count($texts);

                                $as = Assessment::where('id', $data->asId)->first();
                                $procedureTitles = [];
                                foreach($as['procedureTitle'] as $procedureTitle){
                                    array_push($procedureTitles, $procedureTitle);
                                }
                                $openTexts = [];
                                foreach($as['openText'] as $openText){
                                    array_push($openTexts, $openText);
                                }
                                $procedureSignificances = [];
                                foreach($as['procedureSignificance'] as $procedureSignificance){
                                    array_push($procedureSignificances, $procedureSignificance);
                                }
                                $ascount = count($procedureTitles);
                                return view('pt.patient_view', compact(['doc','data', 'texts', 'bps', 'hrs', 'osats', 'rrs', 'vscount','procedureTitles', 'openTexts', 'procedureSignificances','ascount']));
                            }elseif($a->status == 'pending'){
                                //echo " nihaopt";
                                return view('physician.request_pending', compact(['doc','data', 'doc','accesses']));
                            }else{
                               // echo " sayonara";
                            }
                    }
                }else{
                    //echo $data->formType;
                    //echo " annyeong";
                    if($data->formType == 0){
                         $record = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                         ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                         ->where('accesses.patientId', $patientid)
                         ->where('accesses.accessId', null)
                         ->where('accesses.formType', 0)
                         ->get(['accesses.physicianCodez', 'accesses.attendingId','accesses.accessId',  'accesses.status','fcm_patients.patientId','fcm_patients.formType'])->first();
                         //echo " ";
                         //echo $record;
                         return view('physician.request_access', compact(['data', 'doc', 'record']));
                    }
                    elseif($data->formType == 1){
                        //echo "thus";
                        $record = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                         ->join('add_consult', 'add_consult.patientId', '=', 'accesses.patientId')
                         ->where('accesses.patientId', $patientid)
                         ->where('accesses.accessId', null)
                         ->get(['accesses.physicianCodez', 'accesses.attendingId','accesses.accessId',  'accesses.status','add_consult.patientId','add_consult.formType'])->first();
                         //echo $record;
                         return view('physician.request_access', compact(['data', 'doc', 'record']));
                    }
                    elseif($data->formType == 2){
                        //echo " this guy";
                        $record = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                        ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                        ->where('accesses.patientId', $patientid)
                        ->where('accesses.accessId', null)
                        ->get(['accesses.physicianCodez', 'accesses.attendingId','accesses.accessId',  'accesses.status','pt_patients.patientId', 'accesses.formType'])->first();
                        //echo $record;
                        return view('physician.request_access', compact(['data', 'doc', 'record']));
                    }
                }
            }    
        }
    }

    //create request record in access table
    //status not working has bugs
    public function physician_request_access(Request $request){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();

        $dataStore = [];
        
        $dataStore['patientId'] = $request->input('patientId');
        $dataStore['patientCodez'] = $request->input('patientCodez');
        $dataStore['attendingId'] = $request->input('attendingId');
        $dataStore['physicianCodez'] = $request->input('physicianCodez');
        $dataStore['accessId'] = $request->input('accessId');
        $dataStore['status'] = $request->input('status');
        $dataStore['formType'] = $request -> input('formType');

        Access::create($dataStore);
        $accesses1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 2)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
        $accesses2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                        ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                        ->where('accesses.attendingId', Session::get('loginId'))
                        ->where('accesses.formType', 0)
                        ->where('accesses.status', '=','pending')->distinct()
                        ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
        $accesses3 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                        ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                        ->where('accesses.attendingId', Session::get('loginId'))
                        ->where('accesses.status', '=', 'pending')
                        ->where('accesses.formType', 1)->distinct()
                        ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
        $accesses4 = Access::join('users', 'users.id', 'accesses.attendingId')   
                        ->join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                        ->where('accesses.attendingId', Session::get('loginId'))
                        ->where('accesses.status', '=','pending')->distinct()
                        ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
        $accesses1 = $accesses1 -> toBase()->merge($accesses2);
        $accesses1 = $accesses1 -> toBase()->merge($accesses4);
        $accesses = $accesses1 -> toBase()->merge($accesses3);
        if($doc -> department == 'Family Medicine'){
            $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                            ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 0)
                            ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                            ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                            ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 1)
                            ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                            ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                            $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                            $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();    
        }else{
            $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                            ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 2)
                            ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                            ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                            ->join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 3)
                            ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                            ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
        }
                    return redirect()->route('physician.dashboard')->with(['doc'=>$doc, 'accesses'=>$accesses, 'today1'=>$today1, 'today2'=>$today2]);
                }

    //Blade see certain patient consultations
    public function viewConsultation(string $patientid, $dateOfConsult){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();
            if($doc -> department == 'Family Medicine'){
                $data = array();
                $doc = User::where('id', Session::get('loginId'))->first();
                $data = AddConsult::where('patientId', '=', $patientid)->where('add_consult.dateOfConsult', $dateOfConsult)-> first();
                $accesses = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                                ->join('add_consult', 'add_consult.patientId', '=', 'accesses.patientId')
                                ->where('accesses.patientId', $patientid)
                                ->where('add_consult.dateOfConsult', $dateOfConsult)
                                ->where('accesses.accessId', Session::get('loginId'))
                                ->get(['accesses.physicianCodez', 'accesses.attendingId','accesses.accessId',  'accesses.status']);   
                                //echo $data;
                                return view('physician.consultation_view', compact(['data','doc']));
                 }
            else if($doc -> department == 'Physical Therapist'){
                $data = array();

                $doc = User::where('id', Session::get('loginId'))->first();
                $data = ProgressReport::where('patientId', '=', $patientid)->where('progress_report.dateOfConsult', $dateOfConsult)-> first();
                $accesses = Access::join('users', 'users.id', '=', 'accesses.attendingId')
                                ->join('progress_report', 'progress_report.patientId', '=', DB::raw('CAST(accesses."patientId" AS BIGINT)'))
                                ->where('accesses.patientId', $patientid)
                                ->where('progress_report.dateOfConsult', $dateOfConsult)
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.status', null)
                                ->get()->first();
                        echo $data-> asId;
                        $vs = VitalSign::where('id', $data->vsId)->first();
                        $texts = [];
                        foreach($vs['text'] as $text){
                            //echo $text;
                            //echo " ";
                            array_push($texts, $text);
                        }
                        $bps = [];
                        foreach($vs['bp'] as $bp){
                            array_push($bps, $bp);
                        }
                    
                        $hrs = [];
                        foreach($vs['hr'] as $hr){
                            array_push($hrs, $hr);
                        }
                        $osats = [];
                        foreach($vs['osat'] as $osat){
                            array_push($osats, $osat);
                        }
                        $rrs = [];
                        foreach($vs['rr'] as $rr){
                            array_push($rrs, $rr);
                        }
                        $vscount = count($texts);
                //echo $data;
                return view('pt.progress_view', compact(['doc','data', 'texts', 'bps', 'hrs', 'osats', 'rrs', 'vscount']));
        }
    
    }

 
    //Blade of Edit Patient
    public function editPatient(string $patientid){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();
            if($doc -> department == 'Family Medicine'){
                $data = fcmPatient::where('patientId', '=', $patientid)-> first();
                if($data == null){
                    $data = ptPatient::where('patientId', '=', $patientid)-> first();
                    //echo $data->vsId;
                    $vs = VitalSign::where('id', $data->vsId)->first();
                    $texts = [];
                    foreach($vs['text'] as $text){
                        //echo $text;
                        //echo " ";
                        array_push($texts, $text);
                    }
                    $bps = [];
                    foreach($vs['bp'] as $bp){
                        array_push($bps, $bp);
                    }
                
                    $hrs = [];
                    foreach($vs['hr'] as $hr){
                        array_push($hrs, $hr);
                    }
                    $osats = [];
                    foreach($vs['osat'] as $osat){
                        array_push($osats, $osat);
                    }
                    $rrs = [];
                    foreach($vs['rr'] as $rr){
                        array_push($rrs, $rr);
                    }
                    $vscount = count($texts);

                    $as = Assessment::where('id', $data->asId)->first();
                            $procedureTitles = [];
                            foreach($as['procedureTitle'] as $procedureTitle){
                                array_push($procedureTitles, $procedureTitle);
                            }
                            $openTexts = [];
                            foreach($as['openText'] as $openText){
                                array_push($openTexts, $openText);
                            }
                            $procedureSignificances = [];
                            foreach($as['procedureSignificance'] as $procedureSignificance){
                                array_push($procedureSignificances, $procedureSignificance);
                            }
                            $ascount = count($procedureTitles);
                    return view('pt.patient_edit', compact(['doc','data', 'texts', 'bps', 'hrs', 'osats', 'rrs', 'vscount','procedureTitles', 'openTexts', 'procedureSignificances','ascount']));
                }
                //echo $data -> diabetes;
                return view('physician.patient_edit', compact(['data','doc']));// Create a 'requests.blade.php' view file
                }
            else if($doc -> department == 'Physical Therapist'){
                $data = ptPatient::where('patientId', '=', $patientid)-> first();
                if($data == null){
                    $data = fcmPatient::where('patientId', '=', $patientid)-> first();
                    return view('physician.patient_edit', compact(['doc', 'data']));
                }
                //echo $data->vsId;
                $vs = VitalSign::where('id', $data->vsId)->first();
                $texts = [];
                foreach($vs['text'] as $text){
                    //echo $text;
                    //echo " ";
                    array_push($texts, $text);
                }
                $bps = [];
                foreach($vs['bp'] as $bp){
                    array_push($bps, $bp);
                }
            
                $hrs = [];
                foreach($vs['hr'] as $hr){
                    array_push($hrs, $hr);
                }
                $osats = [];
                foreach($vs['osat'] as $osat){
                    array_push($osats, $osat);
                }
                $rrs = [];
                foreach($vs['rr'] as $rr){
                    array_push($rrs, $rr);
                }
                $vscount = count($texts);

                $as = Assessment::where('id', $data->asId)->first();
                        $procedureTitles = [];
                        foreach($as['procedureTitle'] as $procedureTitle){
                            array_push($procedureTitles, $procedureTitle);
                        }
                        $openTexts = [];
                        foreach($as['openText'] as $openText){
                            array_push($openTexts, $openText);
                        }
                        $procedureSignificances = [];
                        foreach($as['procedureSignificance'] as $procedureSignificance){
                            array_push($procedureSignificances, $procedureSignificance);
                        }
                        $ascount = count($procedureTitles);
                return view('pt.patient_edit', compact(['doc','data', 'texts', 'bps', 'hrs', 'osats', 'rrs', 'vscount','procedureTitles', 'openTexts', 'procedureSignificances','ascount']));// Create a 'requests.blade.php' view file
            }
        // $data = array();
        // if(Session::has('loginId')){
        //     $data = fcmPatient::where('patientId', '=', $patientid)-> first();
        // }
    }
    //POST update/edit FCM patient Details
    public function updatePatient(Request $request, string $patientid){
        $data = array();
        if(Session::has('loginId')){
            $data = fcmPatient::where('patientId', '=', $patientid) -> first();
            
            $lastName = $request -> lastName;
            $firstName = $request -> firstName;
            $middleName = $request -> middleName;
            $dateOfConsult = $request -> dateOfConsult;
            $timeOfConsult = $request -> timeOfConsult;
            
            $sex = $request -> sex;
            $nationality = $request -> nationality;
            $civilstatus = $request -> civilstatus;
            $birthday = $request -> birthday;
            $age = \Carbon\Carbon::parse($birthday)->diffInYears(now(), false);
            $presentaddress = $request -> presentaddress;
            $occupation = $request -> occupation;
            $religion = $request -> religion;
            $bp = $request -> bp;
            $pulserate = $request -> pulserate;
            $respirationrate = $request -> respirationrate;
            $temperature = $request -> temperature;
            $weight = $request -> weight;
            $height = $request -> height;
            $chiefComplaint = $request -> chiefComplaint;
            $historyillness = $request -> historyillness;
            $allergiesInput = $request -> allergiesInput;
            $hpn_Input = $request -> hpn_Input;
            $dm_Input = $request -> dm_Input;
            $ptb_Input = $request -> ptb_Input;
            $asthma_Input = $request -> asthma_Input;
            $covidFirstDose = $request -> covidFirstDose;
            $covidFirstDoseDate = $request -> covidFirstDoseDate;
            $covidSecondDose = $request -> covidSecondDose;
            $covidSecondDoseDate = $request -> covidSecondDoseDate;
            $covidBoosterDose = $request -> covidBoosterDose;
            $covidBoosterDoseDate = $request -> covidBoosterDoseDate;
            $otherDetails = $request -> otherDetails;
            $father = $request -> father;
            $mother = $request -> mother;
            $siblings = $request -> siblings;
            $spouse = $request -> spouse;
            $children = $request -> children;
            $smoker_Input = $request -> smoker_Input;
            $alcohol_Input = $request -> alcohol_Input;
            $lmp = $request -> lmp;
            $pmp = $request -> pmp;
            $pmp2 = $request -> pmp2;
            $lsc = $request -> lsc;
            $fpTechnique = $request -> fpTechnique;
            $gp = $request -> gp;
            $g1 = $request -> g1;
            $g2 = $request -> g2;
            $g3 = $request -> g3;
            $g4 = $request -> g4;
            $g5 = $request -> g5;
            //constitutionalSymptoms update
            $weightLossCheckbox = $request -> weightLossCheckbox ? true : null;
            $headacheCheckbox = $request -> headacheCheckbox ? true : null;
            $chillsCheckbox = $request -> chillsCheckbox ? true : null;
            $appetiteLossCheckbox = $request -> appetiteLossCheckbox ? true : null;
            $bodyWeaknessCheckbox = $request -> bodyWeaknessCheckbox ? true : null;
            $constitutionalSymptomsRemarks = $request -> constitutionalSymptomsRemarks;

            //skin update
            $drynessSweatingCheckbox = $request -> drynessSweatingCheckbox ? true : null;
            $pallorCheckbox = $request -> pallorCheckbox ? true : null;
            $rashesCheckbox = $request -> rashesCheckbox ? true : null;
            $skinRemarks = $request -> skinRemarks;

            //ear update
            $earacheCheckbox = $request -> earacheCheckbox ? true : null;
            $eardischargeCheckbox = $request -> eardischargeCheckbox ? true : null;
            $deafnessCheckbox = $request -> deafnessCheckbox ? true : null;
            $tinnitusCheckbox = $request -> tinnitusCheckbox ? true : null;
            $earsRemarks = $request -> earsRemarks;

            //noseAndSinuses update
            $epistaxisCheckbox = $request -> epistaxisCheckbox ? true : null;
            $nasalObstructionCheckbox  = $request -> nasalobstructionCheckbox ? true : null;
            $nasalDischargeCheckbox = $request -> nasaldischargeCheckbox ? true : null;
            $paranasalCheckbox  = $request -> paranasalCheckbox ? true : null;
            $noseAndSinusesRemarks  = $request -> noseRemarks;
            
            //mouthAndThroat update
            $toothacheCheckbox = $request -> toothacheCheckbox ? true : null;
            $gumBleedingCheckbox = $request -> gumbleedingCheckbox ? true : null;
            $soreThroatCheckbox = $request -> soreThroatCheckbox ? true : null;
            $sorenessCheckbox = $request -> sorenessCheckbox ? true : null;
            $mouthAndThroatRemarks = $request -> mouthAndThroatRemarks;
            
            //neck update
            $painCheckbox = $request -> painCheckbox ? true : null;
            $limitationCheckbox  = $request -> limitationCheckbox ? true : null;
            $massCheckbox  = $request -> massCheckbox ? true : null;
            $neckRemarks  = $request -> neckRemarks;

            //respiratory update
            $hemoptysisCheckbox  = $request ->  hemoptysisCheckbox ? true : null;
            $breathingCheckbox  = $request ->  breathingCheckbox ? true : null;
            $respiratoryRemarks  = $request ->  respiratoryRemarks;

            //cardiovascular update
            $palpitationsCheckbox  = $request ->  palpitationsCheckbox ? true : null;
            $orthopneaCheckbox  = $request ->  orthopneaCheckbox ? true : null;
            $dsypneaCheckbox  = $request ->  dsypneaCheckbox ? true : null;
            $chestpainCheckbox  = $request ->  chestpainCheckbox ? true : null;
            $cardiovascularRemarks  = $request ->  cardiovascularRemarks;

            //git update
            $abdominalpainCheckbox  = $request ->  abdominalpainCheckbox ? true : null;
            $dysphagiaCheckbox  = $request ->  dysphagiaCheckbox ? true : null;
            $diarrheaCheckbox  = $request ->  diarrheaCheckbox ? true : null;
            $constipationCheckbox  = $request ->  constipationCheckbox ? true : null;
            $hematemesisCheckbox  = $request ->  hematemesisCheckbox ? true : null;
            $melenaCheckbox  = $request ->  melenaCheckbox ? true : null;
            $vomitingCheckbox  = $request ->  vomitingCheckbox ? true : null;
            $gitRemarks  = $request ->  gitRemarks;

            //gut update
            $dysuriaCheckbox  = $request ->  dysuriaCheckbox ? true : null;
            $urinaryCheckbox  = $request ->  urinaryCheckbox ? true : null;
            $urgencyCheckbox  = $request ->  urgencyCheckbox ? true : null;
            $polyuriaCheckbox  = $request ->  polyuriaCheckbox ? true : null;
            $hesitancyCheckbox  = $request ->  hesitancyCheckbox ? true : null;
            $incontinenceCheckbox  = $request ->  incontinenceCheckbox ? true : null;
            $urineoutputCheckbox  = $request ->  urineoutputCheckbox ? true : null;
            $gutRemarks  = $request ->  gutRemarks;

            //extremities update
            $jointpainCheckbox  = $request ->  jointpainCheckbox ? true : null;
            $stiffnessCheckbox  = $request -> stiffnessCheckbox ? true : null;
            $edemaCheckbox  = $request -> edemaCheckbox ? true : null;
            $extremitiesRemarks  = $request -> extremitiesRemarks;

            //nervousSystem update
            $confusionCheckbox  = $request ->  confusionCheckbox ? true : null;
            $nervousRemarks  = $request ->  nervousRemarks;

            //hematopoietic update
            $bleedingCheckbox  = $request ->  bleedingCheckbox ? true : null;
            $bruisingCheckbox  = $request ->  bruisingCheckbox ? true : null;
            $hematopoieticRemarks  = $request ->  hematopoieticRemarks;

            //endocrine update
            $heatColdCheckbox  = $request ->  heatColdCheckbox ? true : null;
            $nocturiaCheckbox  = $request ->  nocturiaCheckbox ? true : null;
            $polyphagiaCheckbox  = $request ->  polyphagiaCheckbox ? true : null;
            $polydipsiaCheckbox  = $request ->  polydipsiaCheckbox ? true : null;
            $endocrineRemarks  = $request ->  endocrineRemarks;

            $generalSurvey  = $request ->  generalSurvey;
            $headExam  = $request -> headExam;
            $faceExam  = $request -> faceExam;
            $eyesExam  = $request -> eyesExam; 
            $earsExam  = $request -> earsExam;
            $noseExam  = $request -> noseExam;
            $neckExam  = $request ->  neckExam;
            $cardiovascularExam  = $request ->  cardiovascularExam;
            $skinExam  = $request ->  skinExam;
            $extremitiesExam  = $request ->  extremitiesExam;

            $workingImpression  = $request ->  workingImpression;
            $hypertension = $request -> hypertension_Input;
            $diabetes = $request -> diabetes_Input;
            //icdUmbrella
            $a00_b99Checkbox = $request -> a00_b99Checkbox ? true : null;
            $c00_d48Checkbox = $request -> c00_d48Checkbox ? true : null;
            $d50_d89Checkbox = $request -> d50_d89Checkbox ? true : null;
            $e00_e90Checkbox = $request -> e00_e90Checkbox ? true : null;
            $f00_f99Checkbox = $request -> f00_f99Checkbox ? true : null;
            $g00_g99Checkbox = $request -> g00_g99Checkbox ? true : null;
            $h00_h59Checkbox = $request -> h00_h59Checkbox ? true : null;
            $h60_h95Checkbox = $request -> h60_h95Checkbox ? true : null;
            $i00_i99Checkbox = $request -> i00_i99Checkbox ? true : null;
            $j00_j99Checkbox = $request -> j00_j99Checkbox ? true : null;
            $k00_k93Checkbox = $request -> k00_k93Checkbox ? true : null;
            $l00_l99Checkbox = $request -> l00_l99Checkbox ? true : null;
            $m00_m99Checkbox = $request -> m00_m99Checkbox ? true : null;
            $n00_n99Checkbox = $request -> n00_n99Checkbox ? true : null;
            $o00_o99Checkbox = $request -> o00_o99Checkbox ? true : null;
            $p00_p96Checkbox = $request -> p00_p96Checkbox ? true : null;
            $q00_q99Checkbox = $request -> q00_q99Checkbox ? true : null;
            $r00_r99Checkbox = $request -> r00_r99Checkbox ? true : null;
            $s00_t98Checkbox = $request -> s00_t98Checkbox ? true : null;
            $v01_y98Checkbox = $request -> v01_y98Checkbox ? true : null;
            $z00_z99Checkbox = $request -> z00_z99Checkbox ? true : null;

            $diagnostics  = $request ->  diagnostics;
            $drugs  = $request ->  drugs;
            $diet  = $request ->  diet;
            $disposition = $request -> disposition;

            fcmPatient::where('id', '=', $patientid) -> update([
                'lastName' => $lastName,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'dateOfConsult' => $dateOfConsult,
                'timeOfConsult' => $timeOfConsult,
                'age' => $age,
                'sex' => $sex,
                'nationality' => $nationality,
                'civilstatus' => $civilstatus,
                'birthday' => $birthday,
                'presentaddress' => $presentaddress,
                'occupation' => $occupation,
                'religion' => $religion,
                'bp' => $bp,
                'pulserate' => $pulserate,
                'respirationrate' => $respirationrate,
                'temperature' => $temperature,
                'weight' => $weight,
                'height' => $height,
                'chiefComplaint' => $chiefComplaint,
                'historyillness' => $historyillness,
                'allergiesInput' => $allergiesInput,
                'hpn_Input' => $hpn_Input,
                'dm_Input' => $dm_Input,
                'ptb_Input' => $ptb_Input,
                'asthma_Input' => $asthma_Input,
                'covidFirstDose' => $covidFirstDose,
                'covidFirstDoseDate' => $covidFirstDoseDate,
                'covidSecondDose' => $covidSecondDose,
                'covidSecondDoseDate' => $covidSecondDoseDate,
                'covidBoosterDose' => $covidBoosterDose,
                'covidBoosterDoseDate' => $covidBoosterDoseDate,
                'otherDetails' => $otherDetails,
                'father' => $father,
                'mother' => $mother,
                'siblings' => $siblings,
                'spouse' => $spouse,
                'children' => $children,
                'smoker_Input' => $smoker_Input,
                'alcohol_Input' => $alcohol_Input,
                'lmp' => $lmp,
                'pmp' => ['pmp' => $pmp, 'pmp2' => $pmp2],
                'lsc' => $lsc,
                'fpTechnique' => $fpTechnique,
                'gp' => $gp,
                'g1' => $g1,
                'g2' => $g2,
                'g3' => $g3,
                'g4' => $g4,
                'g5' => $g5,
                'constitutionalSymptoms' => ["weightLoss" => $weightLossCheckbox,
                                             "headache" => $headacheCheckbox,
                                             "chills" => $chillsCheckbox,
                                             "appetiteLoss" => $appetiteLossCheckbox,
                                             "bodyWeakness" => $bodyWeaknessCheckbox,
                                             "constitutionalSymptomsRemarks" => $constitutionalSymptomsRemarks,],
                'skin' => ["drynessSweating" => $drynessSweatingCheckbox,
                            "pallor" => $pallorCheckbox,
                            "rashes" => $rashesCheckbox,
                            "skinRemarks" => $skinRemarks,],
                'ears' => ["earache" => $earacheCheckbox,
                           "eardischarge" => $eardischargeCheckbox,
                           "deafness" => $deafnessCheckbox,
                           "tinnitus" => $tinnitusCheckbox,
                           "earsRemarks" => $earsRemarks,],
                'noseAndSinuses' => ["epistaxis" => $epistaxisCheckbox,
                                    "nasalObstruction" => $nasalObstructionCheckbox,
                                    "nasalDischarge" => $nasalDischargeCheckbox,
                                    "paranasal" => $paranasalCheckbox,
                                    "noseAndSinusesRemarks" => $noseAndSinusesRemarks,],
                'mouthAndThroat' => ["toothache" => $toothacheCheckbox,
                                    "gumBleeding" => $gumBleedingCheckbox,
                                    "soreThroat" => $soreThroatCheckbox,
                                    "soreness" => $sorenessCheckbox,
                                    "mouthAndThroatRemarks" => $mouthAndThroatRemarks],
                'neck' => ["pain" => $painCheckbox,
                           "limitation" => $limitationCheckbox,
                           "mass" => $massCheckbox,
                           "neckRemarks" => $neckRemarks],
                'respiratorySystem' => ["hemoptysis" => $hemoptysisCheckbox,
                                        "breathing" => $breathingCheckbox,
                                        "respiratoryRemarks" => $respiratoryRemarks,],
                'cardiovascular' => ["palpitations" => $palpitationsCheckbox,
                                     "orthopnea" => $orthopneaCheckbox,
                                     "dsypnea" => $dsypneaCheckbox,
                                     "chestpain" => $chestpainCheckbox,
                                     "cardiovascularRemarks" => $cardiovascularRemarks],
                'git' => ["abdominalpain" => $abdominalpainCheckbox,
                          "dysphagia" => $dysphagiaCheckbox,
                          "diarrhea" => $diarrheaCheckbox,
                          "constipation" => $constipationCheckbox,
                          "hematemesis" => $hematemesisCheckbox,
                          "melena" => $melenaCheckbox,
                          "vomiting" => $vomitingCheckbox,
                          "gitRemarks" => $gitRemarks,],
                'gut' => ["dysuria" => $dysuriaCheckbox,
                          "urinary" => $urinaryCheckbox,
                          "urgency" => $urgencyCheckbox,
                          "polyuria" => $polyuriaCheckbox,
                          "hesitancy" => $hesitancyCheckbox,
                          "incontinence" => $incontinenceCheckbox,
                          "urineoutput" => $urineoutputCheckbox,
                          "gutRemarks" => $gutRemarks,],
                'extremities' => ["jointpain" => $jointpainCheckbox,
                                  "stiffness" => $stiffnessCheckbox,
                                  "edema" => $edemaCheckbox,
                                  "extremitiesRemarks" => $extremitiesRemarks,],
                'nervousSystem' => ["confusion" => $confusionCheckbox,
                                    "nervousRemarks" => $nervousRemarks],
                'hematopoietic' => ["bleeding" => $bleedingCheckbox,
                                    "bruising" => $bruisingCheckbox,
                                    "hematopoieticRemarks" => $hematopoieticRemarks],
                'endocrine' => ["heatCold" => $heatColdCheckbox,
                                "nocturia" => $nocturiaCheckbox,
                                "polyphagia" => $polyphagiaCheckbox,
                                "polydipsia" => $polydipsiaCheckbox,
                                "endocrineRemarks" => $endocrineRemarks],
                'generalSurvey' => $generalSurvey,
                'headExam' =>  $headExam,
                'faceExam' => $faceExam,
                'eyesExam' => $eyesExam,
                'earsExam' => $earsExam,
                'noseExam' => $noseExam,
                'neckExam' => $neckExam,
                'cardiovascularExam' =>  $cardiovascularExam,
                'skinExam' => $skinExam,
                'extremitiesExam' => $extremitiesExam,
                'workingImpression' => $workingImpression,
                'hypertension' => $hypertension,
                'diabetes' => $diabetes,
                'icdUmbrella'=>["a00-b99"=> $a00_b99Checkbox,
                                "c00-d48"=> $c00_d48Checkbox,
                                "d50-d89"=> $d50_d89Checkbox,
                                "e00-e90"=> $e00_e90Checkbox,
                                "f00-f99"=> $f00_f99Checkbox,
                                "g00-g99"=> $g00_g99Checkbox,
                                "h00-h59"=> $h00_h59Checkbox,
                                "h60-h95"=> $h60_h95Checkbox,
                                "i00-i99"=> $i00_i99Checkbox,
                                "j00-j99"=> $j00_j99Checkbox,
                                "k00-k93"=> $k00_k93Checkbox,
                                "l00-l99"=> $l00_l99Checkbox,
                                "m00-m99"=> $m00_m99Checkbox,
                                "n00-n99"=> $n00_n99Checkbox,
                                "o00-o99"=> $o00_o99Checkbox,
                                "p00-p96"=> $p00_p96Checkbox,
                                "q00-q99"=> $q00_q99Checkbox,
                                "r00-r99"=> $r00_r99Checkbox,
                                "s00-t98"=> $s00_t98Checkbox,
                                "v01-y98"=> $v01_y98Checkbox,
                                "z00-z99"=> $z00_z99Checkbox,
                                 
                                ],
                'diagnostics' => $diagnostics,
                'drugs' => $drugs,
                'diet' => $diet,
                'disposition' => $disposition,
                
            ]);
        }
        $doc = User::where('id', '=', Session::get('loginId'))-> first();
        return redirect('/patients')->with( ['doc' => $doc]);
    }
    
    //POST
    public function updateAssessmentReport(Request $request, string $patientId){
        if(Session::has('loginId')){
            $data = ptPatient::where('patientId', $patientId)->first();
            $doc = User::where('id', Session::get('loginId'))->first();

            $lastName = $request-> lastName;
            $firstName = $request-> firstName;
            $middleName = $request-> middleName;
            $medicalDiagnosis = $request-> medicalDiagnosis;
            $sex = $request-> sex;
            $birthday = $request->  birthday;
            $phone = $request->  phone;
            $email = $request->  email;
            $presentaddress = $request->  presentaddress;
            $refMD = $request->  refMD;
            $refUnit = $request->  refUnit;
            $dateOfConsult = $request-> dateOfConsult;
            $timeOfConsult = $request-> timeOfConsult;
            $timeOfEndConsult = $request-> timeOfEndConsult;
            
            $attendees = $request-> attendees;
            $complaints = $request-> complaints;
            
            $goals = $request-> goals;
            $hpi = $request-> hpi;
            $pshx = $request-> pshx;
            $ehx = $request-> ehx;
            $pmhx = $request-> pmhx;
            $fmhx = $request-> fmhx;
            $medications = $request-> medications;

            
            $text = $request -> text;
            $bp = $request -> bp;
            $hr = $request -> hr;
            $osat = $request ->osat;
            $rr = $request -> rr;
            
            $vsId = $data->vsId;
            VitalSign::where('id', $vsId)->update([
                'text' => $text,
                'bp' => $bp,
                'hr' => $hr,
                'osat' => $osat,
                'rr' => $rr
            ]);

            $significance = $request -> significance;

            $asId = $data->asId;
            $procedureTitle = $request -> procedureTitle;
            $openText = $request -> openText;
            $procedureSignificance = $request -> procedureSignificance;

            Assessment::where('id', $asId)->update([
                'procedureTitle' => $procedureTitle,
                'openText' => $openText,
                'procedureSignificance' => $procedureSignificance,
            ]);
            $diagnosis = $request -> diagnosis;
            $prognosis = $request -> prognosis;
            $plan = $request -> plan;
            $references = $request -> references;
            
            ptPatient::where('patientId', $patientId)->update([
                'lastName' => $lastName,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'medicalDiagnosis' => $medicalDiagnosis,
                'sex' => $sex,
                'birthday' => $birthday,
                'phone' => $phone,
                'email' => $email,
                'presentaddress' => $presentaddress,
                'refMD' => $refMD,
                'refUnit' => $refUnit,
                'dateOfConsult' => $dateOfConsult,
                'timeOfConsult' => $timeOfConsult,
                'timeOfEndConsult' => $timeOfEndConsult,

                'attendees' => $attendees,
                'complaints' => $complaints,

                'goals' => $goals,
                'hpi' => $hpi,
                'pshx' => $pshx,
                'ehx' => $ehx,
                'pmhx' => $pmhx,
                'fmhx' => $fmhx,
                'medications' => $medications,
                'significance' => $significance,
                'diagnosis' => $diagnosis,
                'prognosis' => $prognosis,
                'plan' => $plan,
                'references' => $references,
            ]);

            if($request -> hasFile('attachment')){////
                $imageName = time().'.'.$request->attachment->extension();  
         
                //$request->image->move(public_path('images'), $imageName);
                $request->attachment->storeAs('public/images', $imageName);
                $attachment = $imageName;
                ptPatient::where('patientId', $patientId)->update([
                    'attachment' => $attachment,
                ]);
    
            }
            
            $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.accessId', null)
                            ->where('accesses.formType', 2)
                            ->get(['accesses.physicianCodez', 
                            'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.attendingId', Session::get('loginId'))
                    ->where('accesses.accessId', null)
                    ->where('accesses.formType', 0)
                    ->get(['accesses.physicianCodez', 
                    'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);
       
        //echo $accesses;
        //echo $access;
        $info = Patient::all()->last();
        //echo $info;
        //echo $info->id;
        //return view('physician.patients', compact('accesses', 'doc'));
        return redirect() -> route('physician.patients') -> with(['doc' => $doc, 'accesses' => $accesses]);

        }
        //return view('physician.dashboard', compact('doc'));
    }

    public function storePatient(Request $request){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }

        $accesses = new Access();
        if(fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif(AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif($patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }
        else{
            $patient = ProgressReport::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }

        if($patient != null){
            $patientCode = $patient -> patientCode;
        }
        else{
            $dataPatient = [];
            $patientCode = $this->generatePatientCode();
            $dataPatient['patientCode'] = $patientCode;
            Patient::create($dataPatient);
            // Add the patient code to the request data
            $request->merge(['patientCode' => $patientCode]);
        }
        $dataStore = [];

        $info = Patient::all()->last();
        $id = $info->id;

        //$patientCode = $this->generatePatientCode();

        // Add the patient code to the request data
        $request->merge(['patientCode' => $patientCode]);
    

        $dataToStore = [];
        $dataToStore['patientId'] = $id;
        $dataToStore['patientCode'] = $patientCode;
        
        $dataToStore['lastName'] = $request->input('lastName');
        $dataToStore['firstName'] = $request->input('firstName');
        $dataToStore['middleName'] = $request->input('middleName');

        $dataToStore['dateOfConsult'] = $request->input('dateOfConsult');
        $dataToStore['timeOfConsult'] = $request->input('timeOfConsult');
        $dataToStore['age'] = \Carbon\Carbon::parse($request->input('birthday'))->diffInYears(now(), false);
        $dataToStore['sex'] = $request->input('sex');
        $dataToStore['nationality'] = $request->input('nationality');
        $dataToStore['civilstatus'] = $request->input('civilstatus');
        $dataToStore['birthday'] = $request->input('birthday');
        $dataToStore['presentaddress'] = $request->input('presentaddress');
        $dataToStore['occupation'] = $request->input('occupation');
        $dataToStore['religion'] = $request->input('religion');
        $dataToStore['bp'] = $request->input('bp');
        $dataToStore['pulserate'] = $request->input('pulserate');
        $dataToStore['respirationrate'] = $request->input('respirationrate');
        $dataToStore['temperature'] = $request->input('temperature');
        $dataToStore['weight'] = $request->input('weight');
        $dataToStore['height'] = $request->input('height');
        $dataToStore['chiefComplaint'] = $request->input('chiefComplaint');
        $dataToStore['historyillness'] = $request->input('historyillness');

         // Check and include Allergies input if the checkbox is not checked
         if ($request->has('allergiesCheckbox')) {
            $dataToStore['allergiesInput'] = $request->input('allergiesInput');
        } else {
            $dataToStore['allergiesInput'] = null;
        }

        if ($request->has('hpn_Checkbox')) {
            $dataToStore['hpn_Input'] = $request->input('hpn_Input');
        } else {
            $dataToStore['hpn_Input'] = null;
        }

        if ($request->has('dm_Checkbox')) {
            $dataToStore['dm_Input'] = $request->input('dm_Input');
        } else {
            $dataToStore['dm_Input'] = null;
        }

        if ($request->has('ptb_Checkbox')) {
            $dataToStore['ptb_Input'] = $request->input('ptb_Input');
        } else {
            $dataToStore['ptb_Input'] = null;
        }

        if ($request->has('asthma_Checkbox')) {
            $dataToStore['asthma_Input'] = $request->input('asthma_Input');
        } else {
            $dataToStore['asthma_Input'] = null;
        }

        $dataToStore['covidFirstDose'] = $request->input('covidFirstDose');
        $dataToStore['covidFirstDoseDate'] = $request->input('covidFirstDoseDate');
        $dataToStore['covidSecondDose'] = $request->input('covidSecondDose');
        $dataToStore['covidSecondDoseDate'] = $request->input('covidSecondDoseDate');
        $dataToStore['covidBoosterDose'] = $request->input('covidBoosterDose');
        $dataToStore['covidBoosterDoseDate'] = $request->input('covidBoosterDoseDate');
        $dataToStore['otherDetails'] = $request->input('otherDetails');

        // Include additional personal information
        $dataToStore['father'] = $request->input('father');
        $dataToStore['mother'] = $request->input('mother');
        $dataToStore['siblings'] = $request->input('siblings');
        $dataToStore['spouse'] = $request->input('spouse');
        $dataToStore['children'] = $request->input('children');

    
         if ($request->has('smoker_Checkbox')) {
            $dataToStore['smoker_Input'] = $request->input('smoker_Input');
        } else {
            $dataToStore['smoker_Input'] = null;
        }

         // Check and include alcohol information if the checkbox is checked
         if ($request->has('alcohol_Checkbox')) {
            $dataToStore['alcohol_Input'] = $request->input('alcohol_Input');
        } else {
            $dataToStore['alcohol_Input'] = null;
        }

        $dataToStore['lmp'] = $request->input('lmp');

         // Combine "pmp" and "pmp2" into one array named "pmp"
         $dataToStore['pmp'] = [
            'pmp' => $request->input('pmp'),
            'pmp2' => $request->input('pmp2'),
        ];

        $dataToStore['lsc'] = $request->input('lsc');
        $dataToStore['fpTechnique'] = $request->input('fpTechnique');
        $dataToStore['gp'] = $request->input('gp');
        $dataToStore['g1'] = $request->input('g1');
        $dataToStore['g2'] = $request->input('g2');
        $dataToStore['g3'] = $request->input('g3');
        $dataToStore['g4'] = $request->input('g4');
        $dataToStore['g5'] = $request->input('g5');

         // Combine constitutional symptoms checkboxes and remarks into one array
         $constitutionalSymptoms = [
            'weightLoss' => $request->has('weightLossCheckbox') ? true : null,
            'headache' => $request->has('headacheCheckbox') ? true : null,
            'chills' => $request->has('chillsCheckbox') ? true : null,
            'appetiteLoss' => $request->has('appetiteLossCheckbox') ? true : null,
            'bodyWeakness' => $request->has('bodyWeaknessCheckbox') ? true : null,
            'constitutionalSymptomsRemarks' => $request->input('constitutionalSymptomsRemarks'),
        ];

        $dataToStore['constitutionalSymptoms'] = $constitutionalSymptoms;

        $skin = [
            'drynessSweating' => $request->has('drynessSweatingCheckbox') ? true : null,
            'pallor' => $request->has('pallorCheckbox') ? true : null,
            'rashes' => $request->has('rashesCheckbox') ? true : null,
            'skinRemarks' => $request->input('skinRemarks'),
        ];

        $dataToStore['skin'] = $skin;

        $ears = [
            'earache' => $request->has('earacheCheckbox') ? true : null,
            'eardischarge' => $request->has('eardischargeCheckbox') ? true : null,
            'deafness' => $request->has('deafnessCheckbox') ? true : null,
            'tinnitus' => $request->has('tinnitusCheckbox') ? true : null,
            'earsRemarks' => $request->input('earsRemarks'),
        ];

        $dataToStore['ears'] = $ears;

        $noseAndSinuses = [
            'epistaxis' => $request->has('epistaxisCheckbox') ? true : null,
            'nasalObstruction' => $request->has('nasalobstructionCheckbox') ? true : null,
            'nasalDischarge' => $request->has('nasaldischargeCheckbox') ? true : null,
            'paranasal' => $request->has('paranasalCheckbox') ? true : null,
            'noseAndSinusesRemarks' => $request->input('noseRemarks'),
        ];

        $dataToStore['noseAndSinuses'] = $noseAndSinuses;


        $mouthAndThroat = [
            'toothache' => $request->has('toothacheCheckbox') ? true : null,
            'gumBleeding' => $request->has('gumbleedingCheckbox') ? true : null,
            'soreThroat' => $request->has('sorethroatCheckbox') ? true : null,
            'soreness' => $request->has('sorenessCheckbox') ? true : null,
            'mouthAndThroatRemarks' => $request->input('mouthRemarks'),
        ];

        $dataToStore['mouthAndThroat'] = $mouthAndThroat;

        $neck = [
            'pain' => $request->has('painCheckbox') ? true : null,
            'limitation' => $request->has('limitationCheckbox') ? true : null,
            'mass' => $request->has('massCheckbox') ? true : null,
            'neckRemarks' => $request->input('neckRemarks'),
        ];

        $dataToStore['neck'] = $neck;

        $respiratorySystem = [
            'hemoptysis' => $request->has('hemoptysisCheckbox') ? true : null,
            'breathing' => $request->has('breathingCheckbox') ? true : null,
            'respiratoryRemarks' => $request->input('respiratoryRemarks'),
        ];

        $dataToStore['respiratorySystem'] = $respiratorySystem;

        // Combine cardiovascular checkboxes and remarks into one array
        $cardiovascular = [
            'palpitations' => $request->has('palpitationsCheckbox') ? true : null,
            'orthopnea' => $request->has('orthopneaCheckbox') ? true : null,
            'dsypnea' => $request->has('dsypneaCheckbox') ? true : null,
            'chestpain' => $request->has('chestpainCheckbox') ? true : null,
            'cardiovascularRemarks' => $request->input('cardiovascularRemarks'),
        ];

        $dataToStore['cardiovascular'] = $cardiovascular;


        // Combine GIT checkboxes and remarks into one array
            $git = [
                'abdominalpain' => $request->has('abdominalpainCheckbox') ? true : null,
                'dysphagia' => $request->has('dysphagiaCheckbox') ? true : null,
                'diarrhea' => $request->has('diarrheaCheckbox') ? true : null,
                'constipation' => $request->has('constipationCheckbox') ? true : null,
                'hematemesis' => $request->has('hematemesisCheckbox') ? true : null,
                'melena' => $request->has('melenaCheckbox') ? true : null,
                'vomiting' => $request->has('vomitingCheckbox') ? true : null,
                'gitRemarks' => $request->input('gitRemarks'),
            ];

            $dataToStore['git'] = $git;

            // Combine GUT checkboxes and remarks into one array
            $gut = [
                'dysuria' => $request->has('dysuriaCheckbox') ? true : null,
                'urinary' => $request->has('urinaryCheckbox') ? true : null,
                'urgency' => $request->has('urgencyCheckbox') ? true : null,
                'polyuria' => $request->has('polyuriaCheckbox') ? true : null,
                'hesitancy' => $request->has('hesitancyCheckbox') ? true : null,
                'incontinence' => $request->has('incontinenceCheckbox') ? true : null,
                'urineoutput' => $request->has('urineoutputCheckbox') ? true : null,
                'gutRemarks' => $request->input('gutRemarks'),
            ];

            $dataToStore['gut'] = $gut;

            // Combine extremities checkboxes and remarks into one array
            $extremities = [
                'jointpain' => $request->has('jointpainCheckbox') ? true : null,
                'stiffness' => $request->has('stiffnessCheckbox') ? true : null,
                'edema' => $request->has('edemaCheckbox') ? true : null,
                'extremitiesRemarks' => $request->input('extremitiesRemarks'),
            ];

            $dataToStore['extremities'] = $extremities;

            // Combine nervous system checkboxes and remarks into one array
            $nervousSystem = [
                'confusion' => $request->has('confusionCheckbox') ? true : null,
                'nervousRemarks' => $request->input('nervousRemarks'),
            ];

            $dataToStore['nervousSystem'] = $nervousSystem;

            // Combine hematopoietic checkboxes and remarks into one array
            $hematopoietic = [
                'bleeding' => $request->has('bleedingCheckbox') ? true : null,
                'bruising' => $request->has('bruisingCheckbox') ? true : null,
                'hematopoieticRemarks' => $request->input('hematopoieticRemarks'),
            ];

            $dataToStore['hematopoietic'] = $hematopoietic;

            // Combine endocrine checkboxes and remarks into one array
            $endocrine = [
                'heatCold' => $request->has('heatColdCheckbox') ? true : null,
                'nocturia' => $request->has('nocturiaCheckbox') ? true : null,
                'polyphagia' => $request->has('polyphagiaCheckbox') ? true : null,
                'polydipsia' => $request->has('polydipsiaCheckbox') ? true : null,
                'endocrineRemarks' => $request->input('endocrineRemarks'),
            ];

            $dataToStore['endocrine'] = $endocrine;

            // Add each field to the $dataToStore array
            $dataToStore['generalSurvey'] = $request->input('generalSurvey');
            $dataToStore['headExam'] = $request->input('head-exam');
            $dataToStore['faceExam'] = $request->input('face-exam');
            $dataToStore['eyesExam'] = $request->input('eyes-exam');
            $dataToStore['earsExam'] = $request->input('ears-exam');
            $dataToStore['noseExam'] = $request->input('nose-exam');
            $dataToStore['neckExam'] = $request->input('neck-exam');
            $dataToStore['cardiovascularExam'] = $request->input('cardiovascular-exam');
            $dataToStore['chestExam'] = $request->input('chest-exam');
            $dataToStore['skinExam'] = $request->input('skin-exam');
            $dataToStore['extremitiesExam'] = $request->input('extremities-exam');
            //filters
            $dataToStore['workingImpression'] = $request->input('workingImpression');
            if ($request->has('hypertension_Checkbox')) {
                $dataToStore['hypertension'] = $request->input('hypertension_Input');
            } else {
                $dataToStore['hypertension'] = null;
            }

            if ($request->has('diabetes_Checkbox')) {
                $dataToStore['diabetes'] = $request->input('diabetes_Input');
            } else {
                $dataToStore['diabetes'] = null;
            }

            

            // Combine icdUmbrella checkboxes and remarks into one array
            $icdUmbrella = [
                'a00-b99' => $request->has('a00_b99Checkbox') ? true : null,
                'c00-d48' => $request->has('c00_d48Checkbox') ? true : null,
                'd50-d89' => $request->has('d50_d89Checkbox') ? true : null,
                'e00-e90' => $request->has('e00_e90Checkbox') ? true : null,
                'f00-f99' => $request->has('f00_f99Checkbox') ? true : null,
                'g00-g99' => $request->has('g00_g99Checkbox') ? true : null,
                'h00-h59' => $request->has('h00_h59Checkbox') ? true : null,
                'h60-h95' => $request->has('h60_h95Checkbox') ? true : null,
                'i00-i99' => $request->has('i00_i99Checkbox') ? true : null,
                'j00-j99' => $request->has('j00_j99Checkbox') ? true : null,
                'k00-k93' => $request->has('k00_k93Checkbox') ? true : null,
                'l00-l99' => $request->has('l00_l99Checkbox') ? true : null,
                'm00-m99' => $request->has('m00_m99Checkbox') ? true : null,
                'n00-n99' => $request->has('n00_n99Checkbox') ? true : null,
                'o00-o99' => $request->has('o00_o99Checkbox') ? true : null,
                'p00-p96' => $request->has('p00_p96Checkbox') ? true : null,
                'q00-q99' => $request->has('q00_q99Checkbox') ? true : null,
                'r00-r99' => $request->has('r00_r99Checkbox') ? true : null,
                's00-t98' => $request->has('s00_t98Checkbox') ? true : null,
                'v01-y98' => $request->has('v01_y98Checkbox') ? true : null,
                'z00-z99' => $request->has('z00_z99Checkbox') ? true : null,
               
            ];

            $dataToStore['icdUmbrella'] = $icdUmbrella;

            $dataToStore['diagnostics'] = $request->input('diagnostics');
            $dataToStore['drugs'] = $request->input('drugs');
            $dataToStore['diet'] = $request->input('diet');
            $dataToStore['disposition'] = $request->input('disposition');

            fcmPatient::create($dataToStore);
            $data = fcmPatient::all();
            
            $info = fcmPatient::all()->last();
            $id = $info -> id;
            
            $accesses -> patientId = $info -> patientId;
            $accesses -> patientCodez = $patientCode;
            $accesses -> attendingId = $doc -> id;
            $accesses -> physicianCodez = $doc -> physicianCode;
            $accesses -> formType = $info -> formType;
            $res = $accesses -> save();
            $doc = User::where('id', Session::get('loginId'))->first();

            $accesses1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 2)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.formType', 0)
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses3 = Access::join('users', 'users.id', DB::raw('CAST(accesses."accessId" AS BIGINT)'))
                            ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.status', '=', 'pending')
                            ->where('accesses.formType', 1)->distinct()
                            ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses4 = Access::join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                            ->join('users', 'users.id', 'accesses.attendingId')     
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.status', '=','pending')->distinct()
                            ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
            $accesses1 = $accesses1 -> toBase()->merge($accesses2);
            $accesses1 = $accesses1 -> toBase()->merge($accesses4);
            $accesses = $accesses1 -> toBase()->merge($accesses3);
            if($doc -> department == 'Family Medicine'){
                $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('fcm_patients', 'fcm_patients.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 0)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "fcm_patients.lastName", "fcm_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('add_consult', 'add_consult.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 1)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "add_consult.lastName", "add_consult.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();    
            }else{
                $today1 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('pt_patients', 'pt_patients.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 2)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "pt_patients.lastName", "pt_patients.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                $today2 = Access::join('users', 'users.id', DB::raw('CAST(accesses."attendingId" AS BIGINT)'))
                                ->join('progress_report', 'progress_report.patientId', 'accesses.patientId')
                                ->where('accesses.attendingId', Session::get('loginId'))
                                ->where('accesses.formType', 3)
                                ->where('accesses.status', null)->whereBetween('dateOfConsult', [Carbon::now()->subDays(1),Carbon::now()])->distinct()-> limit(3)
                                ->get(["accesses.patientCodez", "progress_report.lastName", "progress_report.firstName", "accesses.attendingId","accesses.accessId", "accesses.patientId","users.lastName as name","accesses.status"]);
                                $count1 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 0)->where('status', null)->count();
                $count2 = Access::where('accesses.attendingId',Session::get('loginId'))->where('formType', 1)->where('status', null)->count();    
            }
            return view('physician.dashboard', compact(['data','accesses','doc', 'today1', 'today2', 'count1', 'count2']));

    }

    public function showVaccinationHistory()
    {
        $generalData = Session::get('generalData', []);
        return view('physician.vaccination_history', compact('generalData'));

    }

    //==============================================Physical Therapist PT codes==================================================
    //===========================================================================================================================
    public function storePTPatient(Request $request){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        $accesses = new Access();
        if(fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif(AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif($patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }
        else{
            $patient = ProgressReport::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }

        if($patient != null){
            $patientCode = $patient -> patientCode;
        }
        else{
            $dataPatient = [];
            $patientCode = $this->generatePatientCode();
            $dataPatient['patientCode'] = $patientCode;
            Patient::create($dataPatient);
            // Add the patient code to the request data
            $request->merge(['patientCode' => $patientCode]);
        }
        $dataStore = [];

        $info = Patient::all()->last();
        $id = $info->id;
        $dataStore['patientId'] = $id;
        $dataStore['patientCode'] = $info->patientCode;
        $dataStore['lastName'] = $request->input('lastName');
        $dataStore['firstName'] = $request->input('firstName');
        $dataStore['middleName'] = $request->input('middleName');
        $dataStore['medicalDiagnosis'] = $request->input('medicalDiagnosis');
        $dataStore['sex'] = $request->input('sex');
        $dataStore['birthday'] = $request->input('birthday');
        $dataStore['phone'] = $request->input('phone');
        $dataStore['email'] = $request->input('email');
        $dataStore['presentaddress'] = $request->input('presentaddress');
        $dataStore['refMD'] = $request->input('refMD');
        $dataStore['refUnit'] = $request->input('refUnit');
        $dataStore['dateOfConsult'] = $request->input('dateOfConsult');
        $dataStore['timeOfConsult'] = $request->input('timeOfConsult');
        $dataStore['timeOfEndConsult'] = $request->input('timeOfEndConsult');
        $dataStore['attendees'] = $request->input('attendees');
        $dataStore['complaints'] = $request->input('complaints');
        $dataStore['goals'] = $request->input('goals');
        $dataStore['hpi'] = $request->input('hpi');
        $dataStore['pshx'] = $request->input('pshx');
        $dataStore['ehx'] = $request->input('ehx');
        $dataStore['pmhx'] = $request->input('pmhx');
        $dataStore['fmhx'] = $request->input('fmhx');
        $dataStore['medications'] = $request->input('medications');

        // foreach($request->input('text[]') as $key => $value){
        //     VitalSign::create([
        //         'text' => $request -> input('text')[$key],
        //         'bp' => $request -> input('bp')[$key],
        //         'hr' => $request -> input('hr')[$key],
        //         'osat' => $request -> input('osat')[$key],
        //         'rr' => $request -> input('rr')[$key],
        //     ]);
        // }
        $dataStoreVS = [
            'text' => $request -> input('text'),
            'bp' => $request -> input('bp'),
            'hr' => $request -> input('hr'),
            'osat' => $request -> input('osat'),
            'rr' => $request -> input('rr'),
        ];
        
        VitalSign::create($dataStoreVS);
        $infoVS = VitalSign::all()->last();
        $vsId = $infoVS->id;
        
        $dataStore['vsId'] = $vsId;
        $dataStore['significance'] = $request->input('significance');

        $dataStoreAsmnt = [
            'procedureTitle' => $request -> input('procedureTitle'),
            'openText' => $request -> input('openText'),
            'procedureSignificance' => $request -> input('procedureSignificance'),
        ];
        
        Assessment::create($dataStoreAsmnt);
        $infoAsmnt = Assessment::all()->last(); 
        $asId = $infoAsmnt->id;
        
        $dataStore['asId'] = $asId;

        $dataStore['diagnosis'] = $request->input('diagnosis');
        $dataStore['prognosis'] = $request->input('prognosis');
        $dataStore['plan'] = $request->input('plan');
        $dataStore['references'] = $request->input('references');
        // if($request -> hasfile('attachment')){
        //     $file = $request -> file('attachment');
        //     $extention = $file -> getClientOriginalExtension();
        //     $filename = time().'.'.$extention;
        //     $file -> move('uploads/',$filename);
        //     $dataStore['attachment'] = $filename;
        // }else{
        //     $dataStore['attachment'] = "hello";
        // }
        if($request -> hasFile('attachment')){////
            // $request->validate([
            //     'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);
            $imageName = time().'.'.$request->attachment->extension();  
     
            //$request->image->move(public_path('images'), $imageName);
            $request->attachment->storeAs('public/images', $imageName);
            $dataStore['attachment'] = $imageName;

        }
        

        $dataStore['license'] = $doc->license;
        $dataStore['formType'] = 2;

        ptPatient::create($dataStore);
        $data = ptPatient::all();
            
        $info = ptPatient::all()->last();
        $id = $info -> id;
            
        $accesses -> patientId = $info -> patientId;
        $accesses -> patientCodez = $patientCode;
        $accesses -> attendingId = $doc -> id;
        $accesses -> physicianCodez = $doc -> physicianCode;
        $accesses -> formType = $info -> formType;
        //$accesses -> patientCode = $patientCode;

        $res = $accesses -> save();
        

        $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.accessId', null)
                            ->where('accesses.formType', 2)
                            ->get(['accesses.physicianCodez', 
                            'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.attendingId', Session::get('loginId'))
                    ->where('accesses.accessId', null)
                    ->where('accesses.formType', 0)
                    ->get(['accesses.physicianCodez', 
                    'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);
       
        //echo $accesses;
        //echo $access;
        $info = Patient::all()->last();
        //echo $info;
        //echo $info->id;
        //return view('physician.patients', compact('accesses', 'doc'));
        return redirect() -> route('physician.patients') -> with(['doc' => $doc, 'accesses' => $accesses]);
    }

    //BLADE form of progrep w/o assessment
    public function pt_mProgressReport(){
        $doc = User::where('id', Session::get('loginId'))->first();
        return view('pt.mprogress_report', compact('doc'));
    }

    //POST add progrep without assessment
    public function mstoreProgressReport(Request $request){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        $accesses = new Access();
        if(fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif(AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif($patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }
        else{
            $patient = ProgressReport::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }

        if($patient != null){
            $patientCode = $patient -> patientCode;
        }
        else{
            $dataPatient = [];
            $patientCode = $this->generatePatientCode();
            $dataPatient['patientCode'] = $patientCode;
            Patient::create($dataPatient);
            // Add the patient code to the request data
            $request->merge(['patientCode' => $patientCode]);
        }
        $dataStore = [];

        $info = Patient::all()->last();
        $id = $info->id;
        $dataStore['patientId'] = $id;
        $dataStore['patientCode'] = $info->patientCode;
        $dataStore['lastName'] = $request->input('lastName');
        $dataStore['firstName'] = $request->input('firstName');
        $dataStore['middleName'] = $request->input('middleName');
        $dataStore['medicalDiagnosis'] = $request->input('medicalDiagnosis');
        $dataStore['sex'] = $request->input('sex');
        $dataStore['birthday'] = $request->input('birthday');
        $dataStore['phone'] = $request->input('phone');
        $dataStore['email'] = $request->input('email');
        $dataStore['presentaddress'] = $request->input('presentaddress');
        $dataStore['refMD'] = $request->input('refMD');
        $dataStore['refUnit'] = $request->input('refUnit');
        $dataStore['dateOfConsult'] = $request->input('dateOfConsult');
        $dataStore['timeOfConsult'] = $request->input('timeOfConsult');
        $dataStore['timeOfEndConsult'] = $request->input('timeOfEndConsult');
        $start_time = \Carbon\Carbon::parse($request->input('timeOfConsult'));
        $finish_time = \Carbon\Carbon::parse($request->input('timeOfEndConsult'));
        $dataStore['duration'] = $start_time->diffInMinutes($finish_time, false);
        $dataStore['attendees'] = $request->input('attendees');
        $dataStore['modeOrVenue'] = $request -> input('modeOrVenue');
        $dataStore['changes'] = $request -> input('changes');
        $dataStore['focus'] = $request -> input('focus');

        $dataStoreVS = [
            'text' => $request -> input('text'),
            'bp' => $request -> input('bp'),
            'hr' => $request -> input('hr'),
            'osat' => $request -> input('osat'),
            'rr' => $request -> input('rr'),
        ];
        
        VitalSign::create($dataStoreVS);
        $infoVS = VitalSign::all()->last();
        $vsId = $infoVS->id;
        
        $dataStore['vsId'] = $vsId;
        $dataStore['significance'] = $request->input('significance');
        
        $dataStore['managementAct'] = $request -> input('managementAct');

        $dataStore['plan'] = $request -> input('plan');

        $dataStore['references'] = $request -> input('references');
        if($request -> hasFile('attachment')){////
            // $request->validate([
            //     'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);
            $imageName = time().'.'.$request->attachment->extension();  
     
            //$request->image->move(public_path('images'), $imageName);
            $request->attachment->storeAs('public/images', $imageName);
            $dataStore['attachment'] = $imageName;

        }        
        $dataStore['license'] = $doc->license;
        $dataStore['formType'] = 3;
        ProgressReport::create($dataStore);

        $latestinfo = ProgressReport::all()->last();
        $accesses = new Access();
        $accesses -> patientId = $latestinfo -> patientId;
        $accesses -> patientCodez = $patientCode;
        $accesses -> attendingId = $doc -> id;
        $accesses -> physicianCodez = $doc -> physicianCode;
        $accesses -> formType = $latestinfo -> formType;
        $res = $accesses -> save();
        $doc = User::where('id',Session::get('loginId'));
        return view('physician.dashboard', compact(['accesses','doc']));
    }

    //POST of add Progress report
    public function storeProgressReport(Request $request, $patientCode){
        $info = ptPatient::where('patientCode', '=', $patientCode)->first();
        $dataStore = [];
        //make if else for patientCode and manual input
        //'patientCode',
        $dataStore['patientId'] = $info->patientId;
        $dataStore['patientCode'] = $patientCode;
        $dataStore['lastName'] = $request->input('lastName');
        $dataStore['firstName'] = $request->input('firstName');
        $dataStore['middleName'] = $request->input('middleName');
        $dataStore['medicalDiagnosis'] = $request->input('medicalDiagnosis');
        $dataStore['sex'] = $request->input('sex');
        $dataStore['birthday'] = $request->input('birthday');
        $dataStore['phone'] = $request->input('phone');
        $dataStore['email'] = $request->input('email');
        $dataStore['presentaddress'] = $request->input('presentaddress');
        $dataStore['refMD'] = $request->input('refMD');
        $dataStore['refUnit'] = $request->input('refUnit');
        $dataStore['dateOfConsult'] = $request->input('dateOfConsult');
        $dataStore['timeOfConsult'] = $request->input('timeOfConsult');
        $dataStore['timeOfEndConsult'] = $request->input('timeOfEndConsult');
        $start_time = \Carbon\Carbon::parse($request->input('timeOfConsult'));
        $finish_time = \Carbon\Carbon::parse($request->input('timeOfEndConsult'));
        $dataStore['duration'] = $start_time->diffInMinutes($finish_time, false);
        $dataStore['attendees'] = $request->input('attendees');
        $dataStore['modeOrVenue'] = $request -> input('modeOrVenue');
        $dataStore['changes'] = $request -> input('changes');
        $dataStore['focus'] = $request -> input('focus');

        $dataStoreVS = [
            'text' => $request -> input('text'),
            'bp' => $request -> input('bp'),
            'hr' => $request -> input('hr'),
            'osat' => $request -> input('osat'),
            'rr' => $request -> input('rr'),
        ];
        
        VitalSign::create($dataStoreVS);
        $infoVS = VitalSign::all()->last();
        $vsId = $infoVS->id;
        
        $dataStore['vsId'] = $vsId;
        $dataStore['significance'] = $request->input('significance');
        
        $dataStore['managementAct'] = $request -> input('managementAct');

        $dataStore['plan'] = $request -> input('plan');

        $dataStore['references'] = $request -> input('references');

        if($request -> hasFile('attachment')){////
            // $request->validate([
            //     'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);
            $imageName = time().'.'.$request->attachment->extension();  
     
            //$request->image->move(public_path('images'), $imageName);
            $request->attachment->storeAs('public/images', $imageName);
            $dataStore['attachment'] = $imageName;

        }        
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        $dataStore['license'] = $doc->license;
        $dataStore['formType'] = 3;
        ProgressReport::create($dataStore);

        $latestinfo = ProgressReport::all()->last();
        $accesses = new Access();
        $accesses -> patientId = $latestinfo -> patientId;
        $accesses -> patientCodez = $patientCode;
        $accesses -> attendingId = $doc -> id;
        $accesses -> physicianCodez = $doc -> physicianCode;
        $accesses -> formType = $latestinfo -> formType;
        $res = $accesses -> save();
        $doc = User::where('id', Session::get('loginId'))->first();

        $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.accessId', null)
                            ->where('accesses.formType', 2)
                            ->get(['accesses.physicianCodez', 
                            'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.attendingId', Session::get('loginId'))
                    ->where('accesses.accessId', null)
                    ->where('accesses.formType', 0)
                    ->get(['accesses.physicianCodez', 
                    'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);

        return redirect() -> route('physician.patients') -> with(['doc' => $doc, 'accesses' => $accesses]);
        //return view('physician.dashboard', compact(['accesses','doc']));
        //return view('physician.patient_records_view', compact('accesses'));
    }
    // public function updateProgress(){

    // }
    //BLADE for Edits
    public function editConsultation(string $patientid, $dateOfConsult){
        if(Session::has('loginId')){
            //FCM add_consult edit
            $doc = User::where('id', Session::get('loginId'))->first();
            if(AddConsult::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->exists()){
                //echo "byoo ";
                $data = AddConsult::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->first();
                return view('physician.edit_consultation', compact(['data','doc']));
            }
            //PT progress_report edit
            else{
                $data = ProgressReport::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->first();
                //echo $data;
                $vs = VitalSign::where('id', $data->vsId)->first();
                $texts = [];
                foreach($vs['text'] as $text){
                    //echo $text;
                    //echo " ";
                    array_push($texts, $text);
                }
                $bps = [];
                foreach($vs['bp'] as $bp){
                    array_push($bps, $bp);
                }
            
                $hrs = [];
                foreach($vs['hr'] as $hr){
                    array_push($hrs, $hr);
                }
                $osats = [];
                foreach($vs['osat'] as $osat){
                    array_push($osats, $osat);
                }
                $rrs = [];
                foreach($vs['rr'] as $rr){
                    array_push($rrs, $rr);
                }
                $vscount = count($texts);
                return view('pt.edit_progress_report', compact(['doc','data','texts','bps','hrs','osats','rrs','vscount']));
            }
        }
    }

    public function updateFollowConsult(Request $request, string $patientid, string $dateOfConsult){
        if(Session::has('loginId')){
            $data = AddConsult::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->first();
            $doc = User::where('id', Session::get('loginId'))->first();
            $lastName = $request-> lastName;
            $firstName = $request-> firstName;
            $middleName = $request-> middleName;
            $dateOfConsults = $request-> dateOfConsult;
            $timeOfConsult = $request-> timeOfConsult;
            $sex = $request-> sex;
            $nationality = $request-> nationality;
            $civilstatus = $request-> civilstatus;
            $birthday = $request->  birthday;
            $age = \Carbon\Carbon::parse($birthday)->diffInYears(now(), false);
            $presentaddress = $request-> presentaddress;
            $occupation = $request-> occupation;
            $religion = $request-> religion;
            $subFindings = $request-> subFindings;
            $objFindings = $request-> objFindings;
            $assessment = $request-> assessment;

            $hypertension = $request -> hypertension_Input;
            $diabetes = $request -> diabetes_Input;
            //icdUmbrella
            $a00_b99Checkbox = $request -> a00_b99Checkbox ? true : null;
            $c00_d48Checkbox = $request -> c00_d48Checkbox ? true : null;
            $d50_d89Checkbox = $request -> d50_d89Checkbox ? true : null;
            $e00_e90Checkbox = $request -> e00_e90Checkbox ? true : null;
            $f00_f99Checkbox = $request -> f00_f99Checkbox ? true : null;
            $g00_g99Checkbox = $request -> g00_g99Checkbox ? true : null;
            $h00_h59Checkbox = $request -> h00_h59Checkbox ? true : null;
            $h60_h95Checkbox = $request -> h60_h95Checkbox ? true : null;
            $i00_i99Checkbox = $request -> i00_i99Checkbox ? true : null;
            $j00_j99Checkbox = $request -> j00_j99Checkbox ? true : null;
            $k00_k93Checkbox = $request -> k00_k93Checkbox ? true : null;
            $l00_l99Checkbox = $request -> l00_l99Checkbox ? true : null;
            $m00_m99Checkbox = $request -> m00_m99Checkbox ? true : null;
            $n00_n99Checkbox = $request -> n00_n99Checkbox ? true : null;
            $o00_o99Checkbox = $request -> o00_o99Checkbox ? true : null;
            $p00_p96Checkbox = $request -> p00_p96Checkbox ? true : null;
            $q00_q99Checkbox = $request -> q00_q99Checkbox ? true : null;
            $r00_r99Checkbox = $request -> r00_r99Checkbox ? true : null;
            $s00_t98Checkbox = $request -> s00_t98Checkbox ? true : null;
            $v01_y98Checkbox = $request -> v01_y98Checkbox ? true : null;
            $z00_z99Checkbox = $request -> z00_z99Checkbox ? true : null;

            $diagnostics = $request -> diagnostics;
            $drugs = $request -> drugs;
            $diet = $request -> diet;
            $disposition = $request -> disposition;

            AddConsult::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->update([
                'lastName' => $lastName,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'dateOfConsult' => $dateOfConsults,
                'timeOfConsult' => $timeOfConsult,
                'age' => $age,
                'sex' => $sex,
                'nationality' => $nationality,
                'civilstatus' => $civilstatus,
                'birthday' => $birthday,
                'presentaddress' => $presentaddress,
                'occupation' => $occupation,
                'religion' => $religion,
                'subFindings' => $subFindings,
                'objFindings' => $objFindings,
                'assessment' => $assessment,

                'hypertension' => $hypertension,
                'diabetes' => $diabetes,
                'icdUmbrella'=>["a00-b99"=> $a00_b99Checkbox,
                                "c00-d48"=> $c00_d48Checkbox,
                                "d50-d89"=> $d50_d89Checkbox,
                                "e00-e90"=> $e00_e90Checkbox,
                                "f00-f99"=> $f00_f99Checkbox,
                                "g00-g99"=> $g00_g99Checkbox,
                                "h00-h59"=> $h00_h59Checkbox,
                                "h60-h95"=> $h60_h95Checkbox,
                                "i00-i99"=> $i00_i99Checkbox,
                                "j00-j99"=> $j00_j99Checkbox,
                                "k00-k93"=> $k00_k93Checkbox,
                                "l00-l99"=> $l00_l99Checkbox,
                                "m00-m99"=> $m00_m99Checkbox,
                                "n00-n99"=> $n00_n99Checkbox,
                                "o00-o99"=> $o00_o99Checkbox,
                                "p00-p96"=> $p00_p96Checkbox,
                                "q00-q99"=> $q00_q99Checkbox,
                                "r00-r99"=> $r00_r99Checkbox,
                                "s00-t98"=> $s00_t98Checkbox,
                                "v01-y98"=> $v01_y98Checkbox,
                                "z00-z99"=> $z00_z99Checkbox,
                                 
                                ],
                'diagnostics' => $diagnostics,
                'drugs' => $drugs,
                'diet' => $diet,
                'disposition' => $disposition,
            ]);
        }
        $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.accessId', null)
                            ->where('accesses.formType', 2)
                            ->get(['accesses.physicianCodez', 
                            'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.attendingId', Session::get('loginId'))
                    ->where('accesses.accessId', null)
                    ->where('accesses.formType', 0)
                    ->get(['accesses.physicianCodez', 
                    'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);

        return redirect() -> route('physician.patients') -> with(['doc' => $doc, 'accesses' => $accesses]);
        //return view('physician.dashboard', compact('doc'));
    }

    public function updateProgressReport(Request $request, string $patientid, string $dateOfConsult){
        if(Session::has('loginId')){
            $data = ProgressReport::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->first();
            $doc = User::where('id', Session::get('loginId'))->first();
            $lastName = $request-> lastName;
            $firstName = $request-> firstName;
            $middleName = $request-> middleName;
            $medicalDiagnosis = $request-> medicalDiagnosis;
            $sex = $request-> sex;
            $birthday = $request->  birthday;
            $phone = $request->  phone;
            $email = $request->  email;
            $presentaddress = $request->  presentaddress;
            $refMD = $request->  refMD;
            $refUnit = $request->  refUnit;
            $dateOfConsults = $request-> dateOfConsult;
            $timeOfConsult = $request-> timeOfConsult;
            $timeOfEndConsult = $request-> timeOfEndConsult;
            $duration = \Carbon\Carbon::parse($request->input('timeOfConsult'))->diffInMinutes(\Carbon\Carbon::parse($request->input('timeOfEndConsult')), false);
            $attendees = $request -> attendees;
            $modeOrVenue = $request -> modeOrVenue;
            $changes = $request -> changes;
            $focus = $request -> focus;

            $text = $request -> text;
            $bp = $request -> bp;
            $hr = $request -> hr;
            $osat = $request ->osat;
            $rr = $request -> rr;
            
            $vsId = $data->vsId;
            VitalSign::where('id', $vsId)->update([
                'text' => $text,
                'bp' => $bp,
                'hr' => $hr,
                'osat' => $osat,
                'rr' => $rr
            ]);
            $significance = $request -> significance;
            $managementAct = $request -> managementAct;
            $plan = $request -> plan;
            $references = $request -> references;

            if($request -> hasFile('attachment')){////
                $imageName = time().'.'.$request->attachment->extension();  
         
                //$request->image->move(public_path('images'), $imageName);
                $request->attachment->storeAs('public/images', $imageName);
                $attachment = $imageName;
                ProgressReport::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->update([
                    'attachment' => $attachment,
                ]);
    
            }
            ProgressReport::where('patientId', $patientid)->where('dateOfConsult', $dateOfConsult)->update([
                'lastName' => $lastName,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'medicalDiagnosis' => $medicalDiagnosis,
                'sex' => $sex,
                'birthday' => $birthday,
                'phone' => $phone,
                'email' => $email,
                'presentaddress' => $presentaddress,
                'refMD' => $refMD,
                'refUnit' => $refUnit,
                'dateOfConsult' => $dateOfConsults,
                'timeOfConsult' => $timeOfConsult,
                'timeOfEndConsult' => $timeOfEndConsult,

                'attendees' => $attendees,
                'modeOrVenue' => $modeOrVenue,
                'changes' => $changes,
                'focus' => $focus,
                'significance' => $significance,
                'managementAct' => $managementAct,
                'plan' => $plan,
                'references' => $references,
            ]);
        }
        
        $accesses1 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                            ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                            ->where('accesses.attendingId', Session::get('loginId'))
                            ->where('accesses.accessId', null)
                            ->where('accesses.formType', 2)
                            ->get(['accesses.physicianCodez', 
                            'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);
        $accesses2 = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                    ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                    ->where('accesses.attendingId', Session::get('loginId'))
                    ->where('accesses.accessId', null)
                    ->where('accesses.formType', 0)
                    ->get(['accesses.physicianCodez', 
                    'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       $accesses = $accesses1 -> toBase()->merge($accesses2);

        return redirect() -> route('physician.patients') -> with(['doc' => $doc, 'accesses' => $accesses]);
        //return view('physician.dashboard', compact('doc'));
    }

    
    public function newConsultation(string $patientCodez){
        $data = array();
        if(Session::has('loginId')){
            //FCM add_consult new
            $doc = User::where('id', Session::get('loginId'))->first();
            if(fcmPatient::where('patientCode', '=', $patientCodez)->exists()){
                $data = fcmPatient::where('patientCode', '=', $patientCodez)->first();
                return view('physician.patient_consultation', compact(['data','doc']));
            }
            //PT progress_report new
            else{
                $data = ptPatient::where('patientCode', '=', $patientCodez)->first();
                return view('pt.progress_report', compact(['data','doc']));
            }
            
        } 
    }
    public function mnewConsultation(){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();

        return view('physician.mconsultation', compact('doc'));
    }
    //
     public function mstoreAddConsult(Request $request){
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        $accesses = new Access();
        if(fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = fcmPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif(AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = AddConsult::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }elseif($patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])->exists()){
            $patient = ptPatient::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }
        else{
            $patient = ProgressReport::where([['lastName', '=', $request -> input('lastName')], ['firstName', '=', $request -> input('firstName')], ['middleName', '=', $request -> input('middleName')]])-> first();
        }
        
        $dataStore = [];
        if($patient != null){
            $patientCode = $patient -> patientCode;
            $info = AddConsult::where('patientCode', $patientCode)->first();
            $dataStore['patientId'] = $info->patientId;
            $dataStore['patientCode'] = $patientCode;
        }
        else{
            $dataPatient = [];
            $patientCode = $this->generatePatientCode();
            $dataPatient['patientCode'] = $patientCode;
            Patient::create($dataPatient);
            // Add the patient code to the request data
            $request->merge(['patientCode' => $patientCode]);
            $info = Patient::all()->last();
            $id = $info->id;
            $dataStore['patientId'] = $id;
            $dataStore['patientCode'] = $info->patientCode;
        }
        
        $dataStore['lastName'] = $request->input('lastName');
        $dataStore['firstName'] = $request->input('firstName');
        $dataStore['middleName'] = $request->input('middleName');
        $dataStore['dateOfConsult'] = $request->input('dateOfConsult');
        $dataStore['timeOfConsult'] = $request->input('timeOfConsult');
        $dataStore['age'] = \Carbon\Carbon::parse($request->input('birthday'))->diffInYears(now(), false);
        $dataStore['sex'] = $request->input('sex');
        $dataStore['nationality'] = $request->input('nationality');
        $dataStore['civilstatus'] = $request->input('civilstatus');
        $dataStore['birthday'] = $request->input('birthday');
        $dataStore['presentaddress'] = $request->input('presentaddress');
        $dataStore['occupation'] = $request->input('occupation');
        $dataStore['religion'] = $request->input('religion');
        $dataStore['subFindings'] = $request->input('subFindings');
        $dataStore['objFindings'] = $request->input('objFindings');
        $dataStore['assessment'] = $request->input('assessment');
        $dataStore['diagnostics'] = $request->input('diagnostics');
        $dataStore['drugs'] = $request->input('drugs');
        $dataStore['diet'] = $request->input('diet');
        $dataStore['disposition'] = $request->input('disposition');

            if ($request->has('hypertension_Checkbox')) {
                $dataStore['hypertension'] = $request->input('hypertension_Input');
            } else {
                $dataStore['hypertension'] = null;
            }

            if ($request->has('diabetes_Checkbox')) {
                $dataStore['diabetes'] = $request->input('diabetes_Input');
            } else {
                $dataStore['diabetes'] = null;
            }

            $dataStore['formType'] = 1;

            //$dataStore = $request->all();
    //dd($dataStore);
        AddConsult::create($dataStore);
        
        $latestinfo = AddConsult::all()->last();
        $accesses = new Access();
        $accesses -> patientId = $latestinfo -> patientId;
        $accesses -> patientCodez = $patientCode;
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        $accesses -> attendingId = $doc -> id;
        $accesses -> physicianCodez = $doc -> physicianCode;
        $accesses -> formType = $latestinfo -> formType;
        $res = $accesses -> save();

        return redirect('/patients')->with( ['doc' => $doc]);

     }
    //FCM Add consult
    public function storeAddConsult(Request $request, $patientCode){
        $doc = User::where('id', '=', Session::get('loginId'))-> first();

        $info = fcmPatient::where('patientCode', '=', $patientCode)->first();
        $dataStore = [];
        $dataStore['patientId'] = $info->patientId;
        $dataStore['patientCode'] = $patientCode;
        $dataStore['lastName'] = $request->input('lastName');
        $dataStore['firstName'] = $request->input('firstName');
        $dataStore['middleName'] = $request->input('middleName');
        $dataStore['dateOfConsult'] = $request->input('dateOfConsult');
        $dataStore['timeOfConsult'] = $request->input('timeOfConsult');
        $dataStore['age'] = $request->input('age');
        $dataStore['sex'] = $request->input('sex');
        $dataStore['nationality'] = $request->input('nationality');
        $dataStore['civilstatus'] = $request->input('civilstatus');
        $dataStore['birthday'] = $request->input('birthday');
        $dataStore['presentaddress'] = $request->input('presentaddress');
        $dataStore['occupation'] = $request->input('occupation');
        $dataStore['religion'] = $request->input('religion');
        $dataStore['subFindings'] = $request->input('subFindings');
        $dataStore['objFindings'] = $request->input('objFindings');
        $dataStore['assessment'] = $request->input('assessment');

        if ($request->has('hypertension_Checkbox')) {
            $dataStore['hypertension'] = $request->input('hypertension_Input');
        } else {
            $dataStore['hypertension'] = null;
        }

        if ($request->has('diabetes_Checkbox')) {
            $dataStore['diabetes'] = $request->input('diabetes_Input');
        } else {
            $dataStore['diabetes'] = null;
        }

        $icdUmbrella = [
            'a00-b99' => $request->has('a00_b99Checkbox') ? true : null,
            'c00-d48' => $request->has('c00_d48Checkbox') ? true : null,
            'd50-d89' => $request->has('d50_d89Checkbox') ? true : null,
            'e00-e90' => $request->has('e00_e90Checkbox') ? true : null,
            'f00-f99' => $request->has('f00_f99Checkbox') ? true : null,
            'g00-g99' => $request->has('g00_g99Checkbox') ? true : null,
            'h00-h59' => $request->has('h00_h59Checkbox') ? true : null,
            'h60-h95' => $request->has('h60_h95Checkbox') ? true : null,
            'i00-i99' => $request->has('i00_i99Checkbox') ? true : null,
            'j00-j99' => $request->has('j00_j99Checkbox') ? true : null,
            'k00-k93' => $request->has('k00_k93Checkbox') ? true : null,
            'l00-l99' => $request->has('l00_l99Checkbox') ? true : null,
            'm00-m99' => $request->has('m00_m99Checkbox') ? true : null,
            'n00-n99' => $request->has('n00_n99Checkbox') ? true : null,
            'o00-o99' => $request->has('o00_o99Checkbox') ? true : null,
            'p00-p96' => $request->has('p00_p96Checkbox') ? true : null,
            'q00-q99' => $request->has('q00_q99Checkbox') ? true : null,
            'r00-r99' => $request->has('r00_r99Checkbox') ? true : null,
            's00-t98' => $request->has('s00_t98Checkbox') ? true : null,
            'v01-y98' => $request->has('v01_y98Checkbox') ? true : null,
            'z00-z99' => $request->has('z00_z99Checkbox') ? true : null,
           
        ];

        $dataStore['icdUmbrella'] = $icdUmbrella;

        $dataStore['diagnostics'] = $request->input('diagnostics');
        $dataStore['drugs'] = $request->input('drugs');
        $dataStore['diet'] = $request->input('diet');
        $dataStore['disposition'] = $request->input('disposition');

            $dataStore['formType'] = 1;

            //$dataStore = $request->all();
    //dd($dataStore);
        AddConsult::create($dataStore);
        
        $latestinfo = AddConsult::all()->last();
        $accesses = new Access();
        $accesses -> patientId = $latestinfo -> patientId;
        $accesses -> patientCodez = $patientCode;
        if(Session::has('loginId')){
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
        }
        $accesses -> attendingId = $doc -> id;
        $accesses -> physicianCodez = $doc -> physicianCode;
        $accesses -> formType = $latestinfo -> formType;
        $res = $accesses -> save();

        return redirect('/patients')->with( ['doc' => $doc]);

    }
    //


    public function addConsultation(Request $request, string $patientCode){
        $data = array();//still need hpxn dbtes icd
        if(Session::has('loginId')){
            $data = fcmPatient::where('id', '=', $patientCode) -> first();
            $doc = User::where('id', '=', Session::get('loginId'))-> first();

            $lastName = $request -> lastName;
            $firstName = $request -> firstName;
            $middleName = $request -> middleName;
            $dateOfConsult = $request -> dateOfConsult;
            $timeOfConsult = $request -> timeOfConsult;
            $sex = $request -> sex;
            $nationality = $request -> nationality;
            $civilstatus = $request -> civilstatus;
            $birthday = $request -> birthday;
            $age = \Carbon\Carbon::parse($birthday)->diffInYears(now(), false);
            $presentaddress = $request -> presentaddress;
            $occupation = $request -> occupation;
            $religion = $request -> religion;
            $bp = $request -> bp;
            $pulserate = $request -> pulserate;
            $respirationrate = $request -> respirationrate;
            $temperature = $request -> temperature;
            $weight = $request -> weight;
            $height = $request -> height;
            $chiefComplaint = $request -> chiefComplaint;
            $historyillness = $request -> historyillness;
            $allergiesInput = $request -> allergiesInput;
            $hpn_Input = $request -> hpn_Input;
            $dm_Input = $request -> dm_Input;
            $ptb_Input = $request -> ptb_Input;
            $asthma_Input = $request -> asthma_Input;
            $covidFirstDose = $request -> covidFirstDose;
            $covidFirstDoseDate = $request -> covidFirstDoseDate;
            $covidSecondDose = $request -> covidSecondDose;
            $covidSecondDoseDate = $request -> covidSecondDoseDate;
            $covidBoosterDose = $request -> covidBoosterDose;
            $covidBoosterDoseDate = $request -> covidBoosterDoseDate;
            $otherDetails = $request -> otherDetails;
            $father = $request -> father;
            $mother = $request -> mother;
            $siblings = $request -> siblings;
            $spouse = $request -> spouse;
            $children = $request -> children;
            $smoker_Input = $request -> smoker_Input;
            $alcohol_Input = $request -> alcohol_Input;
            $lmp = $request -> lmp;
            $pmp = $request -> pmp;
            $pmp2 = $request -> pmp2;
            $lsc = $request -> lsc;
            $fpTechnique = $request -> fpTechnique;
            $gp = $request -> gp;
            $g1 = $request -> g1;
            $g2 = $request -> g2;
            $g3 = $request -> g3;
            $g4 = $request -> g4;
            $g5 = $request -> g5;
            //constitutionalSymptoms update
            $weightLossCheckbox = $request -> weightLossCheckbox ? true : null;
            $headacheCheckbox = $request -> headacheCheckbox ? true : null;
            $chillsCheckbox = $request -> chillsCheckbox ? true : null;
            $appetiteLossCheckbox = $request -> appetiteLossCheckbox ? true : null;
            $bodyWeaknessCheckbox = $request -> bodyWeaknessCheckbox ? true : null;
            $constitutionalSymptomsRemarks = $request -> constitutionalSymptomsRemarks;

            //skin update
            $drynessSweatingCheckbox = $request -> drynessSweatingCheckbox ? true : null;
            $pallorCheckbox = $request -> pallorCheckbox ? true : null;
            $rashesCheckbox = $request -> rashesCheckbox ? true : null;
            $skinRemarks = $request -> skinRemarks;

            //ear update
            $earacheCheckbox = $request -> earacheCheckbox ? true : null;
            $eardischargeCheckbox = $request -> eardischargeCheckbox ? true : null;
            $deafnessCheckbox = $request -> deafnessCheckbox ? true : null;
            $tinnitusCheckbox = $request -> tinnitusCheckbox ? true : null;
            $earsRemarks = $request -> earsRemarks;

            //noseAndSinuses update
            $epistaxisCheckbox = $request -> epistaxisCheckbox ? true : null;
            $nasalObstructionCheckbox  = $request -> nasalobstructionCheckbox ? true : null;
            $nasalDischargeCheckbox = $request -> nasaldischargeCheckbox ? true : null;
            $paranasalCheckbox  = $request -> paranasalCheckbox ? true : null;
            $noseAndSinusesRemarks  = $request -> noseRemarks;
            
            //mouthAndThroat update
            $toothacheCheckbox = $request -> toothacheCheckbox ? true : null;
            $gumBleedingCheckbox = $request -> gumbleedingCheckbox ? true : null;
            $soreThroatCheckbox = $request -> soreThroatCheckbox ? true : null;
            $sorenessCheckbox = $request -> sorenessCheckbox ? true : null;
            $mouthAndThroatRemarks = $request -> mouthAndThroatRemarks;
            
            //neck update
            $painCheckbox = $request -> painCheckbox ? true : null;
            $limitationCheckbox  = $request -> limitationCheckbox ? true : null;
            $massCheckbox  = $request -> massCheckbox ? true : null;
            $neckRemarks  = $request -> neckRemarks;

            //respiratory update
            $hemoptysisCheckbox  = $request ->  hemoptysisCheckbox ? true : null;
            $breathingCheckbox  = $request ->  breathingCheckbox ? true : null;
            $respiratoryRemarks  = $request ->  respiratoryRemarks;

            //cardiovascular update
            $palpitationsCheckbox  = $request ->  palpitationsCheckbox ? true : null;
            $orthopneaCheckbox  = $request ->  orthopneaCheckbox ? true : null;
            $dsypneaCheckbox  = $request ->  dsypneaCheckbox ? true : null;
            $chestpainCheckbox  = $request ->  chestpainCheckbox ? true : null;
            $cardiovascularRemarks  = $request ->  cardiovascularRemarks;

            //git update
            $abdominalpainCheckbox  = $request ->  abdominalpainCheckbox ? true : null;
            $dysphagiaCheckbox  = $request ->  dysphagiaCheckbox ? true : null;
            $diarrheaCheckbox  = $request ->  diarrheaCheckbox ? true : null;
            $constipationCheckbox  = $request ->  constipationCheckbox ? true : null;
            $hematemesisCheckbox  = $request ->  hematemesisCheckbox ? true : null;
            $melenaCheckbox  = $request ->  melenaCheckbox ? true : null;
            $vomitingCheckbox  = $request ->  vomitingCheckbox ? true : null;
            $gitRemarks  = $request ->  gitRemarks;

            //gut update
            $dysuriaCheckbox  = $request ->  dysuriaCheckbox ? true : null;
            $urinaryCheckbox  = $request ->  urinaryCheckbox ? true : null;
            $urgencyCheckbox  = $request ->  urgencyCheckbox ? true : null;
            $polyuriaCheckbox  = $request ->  polyuriaCheckbox ? true : null;
            $hesitancyCheckbox  = $request ->  hesitancyCheckbox ? true : null;
            $incontinenceCheckbox  = $request ->  incontinenceCheckbox ? true : null;
            $urineoutputCheckbox  = $request ->  urineoutputCheckbox ? true : null;
            $gutRemarks  = $request ->  gutRemarks;

            //extremities update
            $jointpainCheckbox  = $request ->  jointpainCheckbox ? true : null;
            $stiffnessCheckbox  = $request -> stiffnessCheckbox ? true : null;
            $edemaCheckbox  = $request -> edemaCheckbox ? true : null;
            $extremitiesRemarks  = $request -> extremitiesRemarks;

            //nervousSystem update
            $confusionCheckbox  = $request ->  confusionCheckbox ? true : null;
            $nervousRemarks  = $request ->  nervousRemarks;

            //hematopoietic update
            $bleedingCheckbox  = $request ->  bleedingCheckbox ? true : null;
            $bruisingCheckbox  = $request ->  bruisingCheckbox ? true : null;
            $hematopoieticRemarks  = $request ->  hematopoieticRemarks;

            //endocrine update
            $heatColdCheckbox  = $request ->  heatColdCheckbox ? true : null;
            $nocturiaCheckbox  = $request ->  nocturiaCheckbox ? true : null;
            $polyphagiaCheckbox  = $request ->  polyphagiaCheckbox ? true : null;
            $polydipsiaCheckbox  = $request ->  polydipsiaCheckbox ? true : null;
            $endocrineRemarks  = $request ->  endocrineRemarks;

            $generalSurvey  = $request ->  generalSurvey;
            $headExam  = $request -> headExam;
            $faceExam  = $request -> faceExam;
            $eyesExam  = $request -> eyesExam; 
            $earsExam  = $request -> earsExam;
            $noseExam  = $request -> noseExam;
            $neckExam  = $request ->  neckExam;
            $cardiovascularExam  = $request ->  cardiovascularExam;
            $skinExam  = $request ->  skinExam;
            $extremitiesExam  = $request ->  extremitiesExam;
            $workingImpression  = $request ->  workingImpression;
            $diagnostics  = $request ->  diagnostics;
            $drugs  = $request ->  drugs;
            $diet  = $request ->  diet;
            $disposition = $request -> disposition;

            fcmPatient::where('patientId', '=', $patientid) -> update([
                'lastName' => $lastName,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'dateOfConsult' => $dateOfConsult,
                'timeOfConsult' => $timeOfConsult,
                'age' => $age,
                'sex' => $sex,
                'nationality' => $nationality,
                'civilstatus' => $civilstatus,
                'birthday' => $birthday,
                'presentaddress' => $presentaddress,
                'occupation' => $occupation,
                'religion' => $religion,
                'bp' => $bp,
                'pulserate' => $pulserate,
                'respirationrate' => $respirationrate,
                'temperature' => $temperature,
                'weight' => $weight,
                'height' => $height,
                'chiefComplaint' => $chiefComplaint,
                'historyillness' => $historyillness,
                'allergiesInput' => $allergiesInput,
                'hpn_Input' => $hpn_Input,
                'dm_Input' => $dm_Input,
                'ptb_Input' => $ptb_Input,
                'asthma_Input' => $asthma_Input,
                'covidFirstDose' => $covidFirstDose,
                'covidFirstDoseDate' => $covidFirstDoseDate,
                'covidSecondDose' => $covidSecondDose,
                'covidSecondDoseDate' => $covidSecondDoseDate,
                'covidBoosterDose' => $covidBoosterDose,
                'covidBoosterDoseDate' => $covidBoosterDoseDate,
                'otherDetails' => $otherDetails,
                'father' => $father,
                'mother' => $mother,
                'siblings' => $siblings,
                'spouse' => $spouse,
                'children' => $children,
                'smoker_Input' => $smoker_Input,
                'alcohol_Input' => $alcohol_Input,
                'lmp' => $lmp,
                'pmp' => ['pmp' => $pmp, 'pmp2' => $pmp2],
                'lsc' => $lsc,
                'fpTechnique' => $fpTechnique,
                'gp' => $gp,
                'g1' => $g1,
                'g2' => $g2,
                'g3' => $g3,
                'g4' => $g4,
                'g5' => $g5,
                'constitutionalSymptoms' => ["weightLoss" => $weightLossCheckbox,
                                             "headache" => $headacheCheckbox,
                                             "chills" => $chillsCheckbox,
                                             "appetiteLoss" => $appetiteLossCheckbox,
                                             "bodyWeakness" => $bodyWeaknessCheckbox,
                                             "constitutionalSymptomsRemarks" => $constitutionalSymptomsRemarks,],
                'skin' => ["drynessSweating" => $drynessSweatingCheckbox,
                            "pallor" => $pallorCheckbox,
                            "rashes" => $rashesCheckbox,
                            "skinRemarks" => $skinRemarks,],
                'ears' => ["earache" => $earacheCheckbox,
                           "eardischarge" => $eardischargeCheckbox,
                           "deafness" => $deafnessCheckbox,
                           "tinnitus" => $tinnitusCheckbox,
                           "earsRemarks" => $earsRemarks,],
                'noseAndSinuses' => ["epistaxis" => $epistaxisCheckbox,
                                    "nasalObstruction" => $nasalObstructionCheckbox,
                                    "nasalDischarge" => $nasalDischargeCheckbox,
                                    "paranasal" => $paranasalCheckbox,
                                    "noseAndSinusesRemarks" => $noseAndSinusesRemarks,],
                'mouthAndThroat' => ["toothache" => $toothacheCheckbox,
                                    "gumBleeding" => $gumBleedingCheckbox,
                                    "soreThroat" => $soreThroatCheckbox,
                                    "soreness" => $sorenessCheckbox,
                                    "mouthAndThroatRemarks" => $mouthAndThroatRemarks],
                'neck' => ["pain" => $painCheckbox,
                           "limitation" => $limitationCheckbox,
                           "mass" => $massCheckbox,
                           "neckRemarks" => $neckRemarks],
                'respiratorySystem' => ["hemoptysis" => $hemoptysisCheckbox,
                                        "breathing" => $breathingCheckbox,
                                        "respiratoryRemarks" => $respiratoryRemarks,],
                'cardiovascular' => ["palpitations" => $palpitationsCheckbox,
                                     "orthopnea" => $orthopneaCheckbox,
                                     "dsypnea" => $dsypneaCheckbox,
                                     "chestpain" => $chestpainCheckbox,
                                     "cardiovascularRemarks" => $cardiovascularRemarks],
                'git' => ["abdominalpain" => $abdominalpainCheckbox,
                          "dysphagia" => $dysphagiaCheckbox,
                          "diarrhea" => $diarrheaCheckbox,
                          "constipation" => $constipationCheckbox,
                          "hematemesis" => $hematemesisCheckbox,
                          "melena" => $melenaCheckbox,
                          "vomiting" => $vomitingCheckbox,
                          "gitRemarks" => $gitRemarks,],
                'gut' => ["dysuria" => $dysuriaCheckbox,
                          "urinary" => $urinaryCheckbox,
                          "urgency" => $urgencyCheckbox,
                          "polyuria" => $polyuriaCheckbox,
                          "hesitancy" => $hesitancyCheckbox,
                          "incontinence" => $incontinenceCheckbox,
                          "urineoutput" => $urineoutputCheckbox,
                          "gutRemarks" => $gutRemarks,],
                'extremities' => ["jointpain" => $jointpainCheckbox,
                                  "stiffness" => $stiffnessCheckbox,
                                  "edema" => $edemaCheckbox,
                                  "extremitiesRemarks" => $extremitiesRemarks,],
                'nervousSystem' => ["confusion" => $confusionCheckbox,
                                    "nervousRemarks" => $nervousRemarks],
                'hematopoietic' => ["bleeding" => $bleedingCheckbox,
                                    "bruising" => $bruisingCheckbox,
                                    "hematopoieticRemarks" => $hematopoieticRemarks],
                'endocrine' => ["heatCold" => $heatColdCheckbox,
                                "nocturia" => $nocturiaCheckbox,
                                "polyphagia" => $polyphagiaCheckbox,
                                "polydipsia" => $polydipsiaCheckbox,
                                "endocrineRemarks" => $endocrineRemarks],
                'generalSurvey' => $generalSurvey,
                'headExam' =>  $headExam,
                'faceExam' => $faceExam,
                'eyesExam' => $eyesExam,
                'earsExam' => $earsExam,
                'noseExam' => $noseExam,
                'neckExam' => $neckExam,
                'cardiovascularExam' =>  $cardiovascularExam,
                'skinExam' => $skinExam,
                'extremitiesExam' => $extremitiesExam,
                'workingImpression' => $workingImpression,
                'diagnostics' => $diagnostics,
                'drugs' => $drugs,
                'diet' => $diet,
                'disposition' => $disposition,
                
            ]);
        }
        return redirect('/patients')->with( ['doc' => $doc]);
    }

    //search in records
    public function search(Request $request){
        $patientCode = $request->input('search');
        $doc = User::where('id', '=', Session::get('loginId'))-> first();

        if ($patientCode) {
            $data1 = fcmPatient::where('patientCode','LIKE','%'.$patientCode.'%')->get(['patientId', 'dateOfConsult', 'patientCode', 'formType']);
            $data2 = ptPatient::where('patientCode','LIKE','%'.$patientCode.'%')->get(['patientId', 'dateOfConsult', 'patientCode', 'formType']);
            $data = $data1 -> toBase()->merge($data2);

            $data3 = AddConsult::where('patientCode','LIKE','%'.$patientCode.'%')->get(['patientId', 'dateOfConsult', 'patientCode', 'formType']);
            $data4 = ProgressReport::where('patientCode','LIKE','%'.$patientCode.'%')->get(['patientId', 'dateOfConsult', 'patientCode','formType']);

            $dataConsultation = $data3 -> toBase()->merge($data4);

            return view('physician.records', compact ('data', 'dataConsultation','doc'));
        }
        return view('physician.records');
    }

    //search in patients
    public function searchPatients(Request $request){
        $input = $request->input('search');

        if ($input) {
            $doc = User::where('id', '=', Session::get('loginId'))-> first();
            if($doc -> department == 'Family Medicine'){
                
                $accesses = Access::join('users', 'users.id', '=', 'accesses.attendingId')//FCM Registration Patient
                ->join('fcm_patients', 'fcm_patients.patientId', '=', 'accesses.patientId')
                ->where('accesses.attendingId', Session::get('loginId'))
                ->where('accesses.accessId', null)
                ->where('accesses.formType', 0)
                ->where('patientCode','LIKE','%'.$input.'%')
                ->orwhere('fcm_patients.lastName','ILIKE','%'.$input.'%')
                ->orwhere('fcm_patients.firstName','ILIKE','%'.$input.'%')
                ->distinct('accesses.patientId')
                ->get(['accesses.physicianCodez', 
                'fcm_patients.firstName','fcm_patients.middleName','fcm_patients.lastName', 'fcm_patients.patientCode', 'fcm_patients.dateOfConsult', 'fcm_patients.patientId','accesses.formType']);
       
                return view('physician.patients', compact('accesses','doc'));
        
            }
            else if($doc -> department == 'Physical Therapist'){
                $accesses = Access::join('users', 'users.id', '=', 'accesses.attendingId')//PT Registration Patient
                ->join('pt_patients', 'pt_patients.patientId', '=', 'accesses.patientId')
                ->where('accesses.attendingId', Session::get('loginId'))
                ->where('accesses.accessId', null)
                ->where('accesses.formType', 2)
                ->where('patientCode','LIKE','%'.$input.'%')
                ->orwhere('pt_patients.lastName','ILIKE','%'.$input.'%')
                ->orwhere('pt_patients.firstName','ILIKE','%'.$input.'%')
                ->distinct('accesses.patientId')
                ->get(['accesses.physicianCodez', 
                'pt_patients.firstName','pt_patients.middleName','pt_patients.lastName', 'pt_patients.patientCode', 'pt_patients.dateOfConsult', 'pt_patients.patientId', 'accesses.formType']);

                return view('physician.patients', compact('accesses','doc'));
            }
        }
    }

    public function filterRecords(Request $request)
    {
        $doc = User::where('id', '=', Session::get('loginId'))-> first();

        // Debug: Dump the request data
        //dd($request->all());

        // Retrieve filter parameters from the request
        $ageFilter = $request->input('ageFilter');
        $maleFilter = $request->input('maleFilter');
        $femaleFilter = $request->input('femaleFilter');
        $hypertensionFilter = $request->input('hypertensionFilter');
        $diabetesFilter = $request->input('diabetesFilter');
        $a00b99Filter = $request->input('a00b99Filter');
        $c00d48Filter = $request->input('c00d48Filter');
        $d50d89Filter = $request->input('d50d89Filter');
        $e00e90Filter = $request->input('e00e90Filter');
        $f00f99Filter = $request->input('f00f99Filter');
        $g00g99Filter = $request->input('g00g99Filter');
        $h00h59Filter = $request->input('h00h59Filter');
        $h60h95Filter = $request->input('h60h95Filter');
        $i00i99Filter = $request->input('i00i99Filter');
        $j00j99Filter = $request->input('j00j99Filter');
        $k00k93Filter = $request->input('k00k93Filter');
        $l00l99Filter = $request->input('l00l99Filter');
        $m00m99Filter = $request->input('m00m99Filter');
        $n00n99Filter = $request->input('n00n99Filter');
        $o00o99Filter = $request->input('o00o99Filter');
        $p00p96Filter = $request->input('p00p96Filter');
        $q00q99Filter = $request->input('q00q99Filter');
        $r00r99Filter = $request->input('r00r99Filter');
        $s00t98Filter = $request->input('s00t98Filter');
        $v01y98Filter = $request->input('v01y98Filter');
        $z00z99Filter = $request->input('z00z99Filter');


        // Add more filter parameters if needed
    
        // Perform the database query based on the filters
        $query = fcmPatient::query();
    
        // Apply AND logic for age, gender, and ICD umbrella filters
        $query->where(function ($query) use ($ageFilter, $maleFilter, $femaleFilter) {
            if ($ageFilter) {
                $query->where('age', '<=', $ageFilter);
            }
    
            if ($maleFilter && !$femaleFilter) {
                $query->where('sex', '=', 'male');
            } elseif ($femaleFilter && !$maleFilter) {
                $query->where('sex', '=', 'female');
            }
        });
    
        // ICD umbrella filter conditions
        if ($a00b99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['a00-b99' => true]);
        }
    
        if ($c00d48Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['c00-d48' => true]);
        }
    
        if ($d50d89Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['d50-d89' => true]);
        }

        if ($e00e90Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['e00-e90' => true]);
        }

        if ($f00f99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['f00-f99' => true]);
        }

        if ($g00g99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['g00-g99' => true]);
        }

        if ($h00h59Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['h00-h59' => true]);
        }

        if ($h60h95Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['h60-h95' => true]);
        }

        if ($i00i99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['i00-i99' => true]);
        }

        if ($j00j99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['j00-j99' => true]);
        }

        if ($k00k93Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['k00-k93' => true]);
        }

        if ($l00l99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['l00-l99' => true]);
        }

        if ($m00m99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['m00-m99' => true]);
        }

        if ($n00n99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['n00-n99' => true]);
        }

        if ($o00o99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['o00-o99' => true]);
        }

        if ($p00p96Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['p00-p96' => true]);
        }

        if ($q00q99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['q00-q99' => true]);
        }

        if ($r00r99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['r00-r99' => true]);
        }

        if ($s00t98Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['s00-t98' => true]);
        }

        if ($v01y98Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['v01-y98' => true]);
        }

        
        if ($z00z99Filter === 'on') {
            $query->whereJsonContains('icdUmbrella', ['z00-z99' => true]);
        }

        if ($hypertensionFilter === 'on') {
            $query->where(function ($query) {
                $query->where('hypertension', '=', 'controlled')
                    ->orWhere('hypertension', '=', 'uncontrolled');
            });
        }
    
        // Diabetes filter conditions
        if ($diabetesFilter === 'on') {
            $query->where(function ($query) {
                $query->where('diabetes', '=', 'controlled')
                    ->orWhere('diabetes', '=', 'uncontrolled');
            });
        }
    
        // Add more conditions for other keys if needed
    
        // Get the filtered data
        $data = $query->get();
    
        // Return the filtered data as HTML to be inserted into the table
        return view('physician.filter_records', compact('data','doc'))->render();
    }
}

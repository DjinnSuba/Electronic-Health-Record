<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Models\Patient;

use Session;
use DB;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function showDashboard(){
        $count = User::get()->count();
        $pt = User::where('department','=','Physical Therapist') ->get()->count();
        $activePT = User::where('department','=','Physical Therapist') -> where('status','=','Active') ->get() ->count();
        $fcm = User::where('department','=','Family Medicine') ->get()->count();
        $activeFCM = User::where('department','=','Family Medicine') -> where('status','=','Active')  ->get() ->count();
        return view('admin.dashboard', compact('pt','count','fcm','activePT','activeFCM'));
    }
    // public function physicians(){
    //     return view('admin.physicians'); // Create a 'physicians.blade.php' view file
    // }

    public function patients(){
        $patients = Patient::select('patientCode', 'lastName', 'firstName') -> distinct()
            ->get();

        return view('admin.patients', compact('patients')); // Create a 'patients.blade.php' view file
    }

    public function requests(){
        return view('admin.requests'); // Create a 'requests.blade.php' view file
    }

    public function register(){
        return view('admin.register'); // Create a 'register.blade.php' view file
    }

    public function edit(string $staffid){
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id', '=', $staffid)-> first();
        }
        return view('admin.edit', compact('data')); // Create a 'requests.blade.php' view file
    } 

    public function update(Request $request, string $staffid){
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id', '=', $staffid)-> first();

            $input = $request -> validate(['lastName' => 'required', 'firstName' => 'required', 'middleName' => 'required', 'cnumber' => 'required', 'address' => 'required', 'department' => 'required', 'status' => 'required', 'license' => 'required']);
            $staffid = $request -> id;
            $lastName = $request -> lastName;
            $firstName = $request -> firstName;
            $middleName = $request -> middleName;
            $cnumber = $request -> cnumber;
            $address = $request -> address;
            $department = $request -> department;
            $status = $request -> status;
            $license = $request -> license;
            
            User::where('id', '=', $staffid) -> update([
                'lastName' => $lastName, 'firstName' => $firstName, 'middleName' => $middleName, 'cnumber' => $cnumber, 'address' => $address, 'department' => $department, 'status' => $status, 'license' => $license
            ]);
        }
        return redirect('/admin/physicians')->withSuccess('Staff Update Successfully');
    }

    /**-----------------------------------------------------------------------------------------
            POST function for Admin to Register a User[Family Medicine, Physical Therapy]
    -----------------------------------------------------------------------------------------**/
    private function generateStaffCode(User $user)
    {
        // Get the current year and month
        $year = now()->format('Y');
    
        // Get the last patient code for the current year and month
        $lastPhysician= User::where(DB::raw("TO_CHAR(created_at, 'YYYY')"), '=', $year)
            ->orderBy('physicianCode', 'desc')
            ->first();
    
        // Extract the sequential number and increment it
        $sequenceNumber = $lastPhysician ? (int)substr($lastPhysician->physicianCode, -4) + 1 : 1;
    
        // Format the sequential number with leading zeros
        $formattedSequence = str_pad($sequenceNumber, 4, '0', STR_PAD_LEFT);
        
        if($user -> department == "Family Medicine"){
            $physicianCode = "FM-{$year}-{$formattedSequence}";

        }
        else if($user -> department == "Physical Therapist"){
            $physicianCode = "PT-{$year}-{$formattedSequence}";

        }
        else
            $physicianCode = "X-{$year}-{$formattedSequence}";

        // Combine the year, month, and sequential number to create the patient code
       // $physicianCode = "{$yearMonth}-{$formattedSequence}";
    
        return $physicianCode;
    }

    public function registerUser(Request $request){
        $request -> validate([
            'lastName'=> 'required',
            'firstName'=> 'required',
            'middleName'=> 'required',
            'birthday'=> 'required|date',
            'cnumber'=> 'required',
            'address'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6',
            'department'=> 'required',
            'license' => 'required',
            'status'=> 'required',
        ]);
        $user = new User();
        $user -> lastName = $request -> lastName;
        $user -> firstName = $request -> firstName;
        $user -> middleName = $request -> middleName;
        $user -> birthday = $request -> birthday;
        $user -> cnumber = $request -> cnumber;
        $user -> address = $request -> address;
        $user -> email = $request -> email;
        $user -> password = $request -> password;
        $user -> department = $request -> input('department'); //"Physical Therapist";
        $user -> status = $request -> status;
        $user -> license = $request -> license;
        $user -> physicianCode = $this->generateStaffCode($user);

        //echo $user;
        $res = $user -> save();
        return redirect('/admin/physicians')->with('success');
    }
    /**-----------------------------------------------------------------------------------------
            GET function for Admin to retrieve all users(physicians)
            Return 'physicians.blade.php' file and list of table of users
    -----------------------------------------------------------------------------------------**/
    public function physicians(){
        $data = User::all();
        return view('admin.physicians', compact('data'));
    }

    public function deleteStaff($id){
        User::where('id', $id)->delete();
        $data = User::all();
        return view('admin.physicians', compact('data'));
    }
}
    

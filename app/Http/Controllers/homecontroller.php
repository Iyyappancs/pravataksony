<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;

class homecontroller extends Controller
{

    public function admin_login_check(Request $request){
		$request->validate([
            'user_email' => 'required|email',
            'user_pass' => 'required'
           
        ]);
		$user_email = $request['user_email'];
        //$user_pass = base64_encode($request['user_pass']);
	    $user_pass = $request['user_pass'];
 
		


		
		$admin_login = DB::select("select * from users where email = '$user_email' and password = '$user_pass'");
		if(!$admin_login) {
	        $mg = "login error";
       	 	Session::put('admin_err', $mg);
                return redirect(url('login'));
      	}else
        {
			$admin_info = $admin_login[0];
       		$admin_login_success = "success";			
			session::put('admin_info', $admin_info);
			$usermail=$admin_info->email;
				$userid=$admin_info->id;
				$login_date = date('Y-m-d h:s:i');
			if($admin_info->name == 'superadmin'){

				session::put('sup_admin_login_success', $admin_login_success);

				return redirect(url('dashboard'));
			}
            else{
				return redirect(url('login'));
            }
        }
        }
    public function coursesave(Request $request)
    {
        $date = date('Y-m-d H:i:s');

        $file = $request->file;
        $filename =time() . '.' . $file->getClientOriginalExtension();
        $file->move('home/images/photos', $filename);

        $aadharfile = $request->aadharfile;
        $aadharfilefilename =time() . '.' . $aadharfile->getClientOriginalExtension();
        $aadharfile->move('home/images/aadhar', $aadharfilefilename);

        $tenthcertificatefile = $request->tenthcertificate;
        $tenthcertificatefilename =time() . '.' . $tenthcertificatefile->getClientOriginalExtension();
        $tenthcertificatefile->move('home/images/10thcerficate', $tenthcertificatefilename);

        $twelethcertificatefile = $request->twelethcertificate;
        $twelethcertificatefilename =time() . '.' . $twelethcertificatefile->getClientOriginalExtension();
        $twelethcertificatefile->move('home/images/12thcerficate', $twelethcertificatefilename);
      
        $data = array(
            
            'name' => $request->name,
            'fathername' => $request->fname,
            'dob' => $request->dateofbirth,
            'gender' => $request->gender,
            'email' => $request->emailaddress,
            'contactno' => $request->mobilenumber,
            'communication_address' => $request->communication,
            'pincode' => $request->pincode,
           
            'aadharnumber' => $request->aadhar,
           
            'nationality' => $request->nationality,
            'parent_annual_income' =>  $request->income,
            'course' => $request->course,
            'stream' => $request->stream,
            'year_of_passing' => $request->radios,
            
            'college_name' => $request->collegename,
            'university' => $request->university,
            'college_address' => $request->collegeaddress,
           
            'college_pincode' => $request->collegepincode,
            'cgpa_obtained_till_now'=>$request->cgpa,
            'college_contact_person' => $request->collegecontactnumber,

            'college_email_id' => $request->collegeemailaddress,
            'arrears_pending' => $request->Arrears,
            'tenth_board' => $request->tenthboard,
           
            'tenth_cgpa' => $request->tenthcgpa,
            'tenth_certificate'=>$tenthcertificatefilename,
            'school_studied_in_tenth _std' => $request->schoolstudiedtenth,

            'tweleth_board' => $request->twelethboard,
            'tweleth_cgpa' => $request->twelethcgpa,
            'tweleth_certificate' => $twelethcertificatefilename,
           
            'school_studied_in_tweleth_std' => $request->schoolstudiedtwelth,
            'choice_priority'=>$request->choicepriority,
            'created_date' => $date,

            'status' => 1,
            'photo'=>$filename,
            'aadharfile'=>$aadharfilefilename
          
        );
        DB::table('courseregistration')->insert($data);
       return redirect('registration')->with('success',' Submitted successfully');
    }

    public function dashboardview()
    {
        $block = session::get('sup_admin_login_success');
		if (!$block) {
        	return redirect(url('login'));
		}

        $data = DB::table('courseregistration')->where('id', '>', 0)->paginate(100); 
        return view('home.dashboard',compact('data'));
    }

    public function adminview()
    {
        $block = session::get('sup_admin_login_success');
		if (!$block) {
        	return redirect(url('login'));
		}
        $data = DB::table('courseregistration')->where('id', '>', 0);
        return view('home.adminview',compact('data'));
    }

    public function adminshow(Request $request,$id)
    {
        $block = session::get('sup_admin_login_success');
		if (!$block) {
        	return redirect(url('login'));
		}
        
        // $data = DB::table('courseregistration')->where('id',$id);

        $dataarray= DB::select("SELECT * from courseregistration where id='$id' order by id asc");
       $data = $dataarray[0];
       
        
       
        return view('home.adminshow',compact('data'));
    }

}

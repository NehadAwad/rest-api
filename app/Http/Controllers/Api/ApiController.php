<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;



class ApiController extends Controller
{
    //Create API
    //http://127.0.0.1:8000/api/add-employee
    public function createEmployee(Request $request){
        //validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:employees",
            "phone_no" => "required",
            "gender" => "required",
            "age" => "required"
        ]);

        //create data
        $employee = new Employee();
        

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;


        $employee->save();

        //send response
        return response()->json([
            "status" => 1,
            "massage" => "Employee created sucessfully"
        ]);

    }

    //List API
    //http://127.0.0.1:8000/api/list-employees
    public function listEmployees(){

        $employees = Employee::all();
       
        return response()->json([
            "status" => 1,
            "message" => "Listing Employee",
            "data" => $employees
        ], 200);

    }

    //Single Detail API
    //
    public function getSingleEmployee($id){

        if(Employee::where("id", $id)->exists()){
            $employee_details = Employee::where("id", $id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Employee Found",
                "data" => $employee_details
            ]);
        }
        else{
            return response()->json([
                "status" => 0,
                "message" => "Employee Not Found",
                
            ], 404);
        }

    }

    
    //Update API
    //http://127.0.0.1:8000/api/update-employee/1
    public function updateEmployee(Request $request, $id){

        if(Employee::where("id", $id)->exists()){
            $employee = Employee::find($id);

            $employee->name = !empty($request->name) ? $request->name : $employee->name;
            $employee->email = !empty($request->email) ? $request->email : $employee->email;
            $employee->phone_no = !empty($request->phone_no) ? $request->phone_no : $employee->phone_no;
            $employee->gender = !empty($request->gender) ? $request->gender : $employee->gender;
            $employee->age = !empty($request->age) ? $request->age : $employee->age;

            $employee->save();

            return response()->json([
                "status" => 1,
                "message" => "Employee Updated Successfully",
            ]);

        }
        else{
            return response()->json([
                "status" => 0,
                "message" => "Employee Not Found",
                
            ], 404);
        }

    }

    
    //Delete API
    //http://127.0.0.1:8000/api/delete-employee/4
    public function deleteEmployee($id){

        if(Employee::where("id", $id)->exists()){
            $employee = Employee::find($id);

            $employee->delete();

            

            return response()->json([
                "status" => 1,
                "message" => "Employee Deleted Successfully",
            ]);

        }
        else{
            return response()->json([
                "status" => 0,
                "message" => "Employee Not Found",
                
            ], 404);
        }

    }
}

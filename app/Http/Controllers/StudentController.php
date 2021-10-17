<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $Student = Student::count();
		  if($Student){
			 $Student = Student::latest()->paginate(5);
		  return response()->json([
		  'data' => $Student,
		  ],200);
		  }
		  return response()->json([
		  'message' => 'There is no students',
		  ],400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         
			 
			
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator= Validator::make($request->all(), [
        'Name' => 'required|max:255|min:3',
        'ID_Number' => 'required|max:255|unique:students',
        'Mobile' => 'required|min:3|max:255',
        'Birth_Date' => 'required|min:3|max:255',
        'Address' => 'required|min:3|max:255',
        ]);
        if ($validator->fails()){
        return response(['errors'=>$validator->errors()->all()], 422);
         }
       $Student = Student::create($request->all());
		 return response()->json([
		  'data' => $Student,
		 ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
		if (Student::where('id', $id)->exists()) {
        $student = Student::find($id);
      $validator= Validator::make($request->all(), [
        'ID_Number' => 'min:3|max:255|unique:students',
   
        ]);
        if ($validator->fails()){
        return response(['errors'=>$validator->errors()->all()], 422);
         }
        $student->Name = is_null($request->Name) ? $student->Name : $request->Name;
        $student->Birth_Date = is_null($request->Birth_Date) ? $student->Birth_Date : $request->Birth_Date;
		$student->ID_Number = is_null($request->ID_Number) ? $student->ID_Number : $request->ID_Number;
		$student->Mobile = is_null($request->Mobile) ? $student->Mobile : $request->Mobile;
		$student->Address = is_null($request->Address) ? $student->Address : $request->Address;
        $student->save();
        return response()->json([
          "message" => "records updated successfully",
          "data" => $student,
        ], 200);
      } else {
        return response()->json([
          "message" => "Student not found"
        ], 404);
      }
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {
         if(Student::where('id', $id)->exists()) {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Student not found"
        ], 404);
      }
    }
}

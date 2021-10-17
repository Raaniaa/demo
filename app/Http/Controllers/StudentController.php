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
        'first_name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'last_name' => 'required|min:3',
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
        'email' => 'email|max:255|unique:users',
   
        ]);
        if ($validator->fails()){
        return response(['errors'=>$validator->errors()->all()], 422);
         }
        $student->first_name = is_null($request->first_name) ? $student->first_name : $request->first_name;
        $student->last_name = is_null($request->last_name) ? $student->last_name : $request->last_name;
		$student->email = is_null($request->email) ? $student->email : $request->email;
        $student->save();
        return response()->json([
          "message" => "records updated successfully"
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

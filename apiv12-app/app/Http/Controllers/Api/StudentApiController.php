<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::get();
        return response()->json([
            'status' => 'success',
            'data' => $students
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:students,email',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors(),
            ], 400);
        }

        $data = $request->all();
        $student = Student::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Student Created Successfully',
            'student' => $student
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 'success',
                'data' => $student
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'No user Found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:students,email,except ' . $id,
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors(),
            ], 400);
        }

        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status' => 'fail',
                'message' => 'No record found'
            ], 404);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->save();

        return response()->json([
            'status' => 'success',
            'message' => 'student Updated Successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Student Not Found'
            ], 404);
        }

        $student->delete();
        return response()->json([
            'success' => 'success',
            'message' => 'User Deleted Successfully'
        ], 201);
    }
}

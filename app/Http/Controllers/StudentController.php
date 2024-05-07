<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Policies\StudentPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Student $student): JsonResponse
    {

        $this->authorize('show', [Student::class, $student]);

        $student = $student->load('activities');

        return response()->json([
            'message' => 'Student details',
            'data' => $student
        ]);
    }
}

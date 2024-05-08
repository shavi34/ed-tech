<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{

    /**
     * Display the specified resource.
     * #
     */
    public function show(Student $student): JsonResponse
    {
        $this->authorize('show', $student);

        $student = $student->load('activities', 'course');

        return response()->json([
            'message' => 'Student details',
            'data' => new StudentResource($student)
        ]);
    }
}

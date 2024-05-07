<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('list', Course::class);

        $classes = Auth::user()->classes()->with('students.activities')->paginate();

        return response()->json([
            'message' => 'Classes List',
            'data' => CourseResource::collection($classes)
        ]);
    }

    public function show(Course $class)
    {
        return response()->json([
            'message' => 'Class details',
            'data' => $class->load('students.activities')
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {

        $this->authorize('list', Course::class);

        $classes = Auth::user()->classes()->with('students')
            ->paginate($request->get('page_size', 10));

        return CourseResource::collection($classes);
    }

    public function show(Course $class): JsonResponse
    {
        $this->authorize('show', $class);

        return response()->json([
            'message' => 'Class details',
            'data' => new CourseResource($class),
        ]);
    }

    public function students(Course $class, Request $request): AnonymousResourceCollection
    {
        $this->authorize('show', $class);

        return StudentResource::collection($class->students()
            ->paginate($request->get('page_size', 10)));
    }
}

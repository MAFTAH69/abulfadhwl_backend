<?php

namespace App\Http\Controllers;

use App\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

use function Psy\bin;

class SlideController extends Controller
{
    // Get all slides
    public function getAllSlides()
    {
        $slides = Slide::all();
        if (REQ::is('api/*'))
            return response()->json([
                'slides' => $slides
            ], 200);
        return view('all_slides')->with('slides', $slides);
    }

    // Get a single slide
    public function getSingleSlide($slideId)
    {
        $slide = Slide::find($slideId);
        if (!$slide) {
            return response()->json([
                'error' => "Slide not found"
            ], 404);
        }
        return response()->json([
            'slide' => $slide
        ], 200);
    }

    // Post slide
    public function postSlide(Request $request)
    {
        $this->path = null;

        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'number' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        if ($request->hasFile('file')) {
            $this->file_path = $request->file('file')->store('slides');
        } else return response()->json([
            'message' => 'Add a slide file'
        ], 404);

        $slide = new Slide();
        $slide->number = $request->input('number');
        $slide->file = $this->file_path;

        $slide->save();
        if (REQ::is('api/*'))

            return response()->json([
                'slide' => $slide
            ], 201);
        return back()->with('message', 'Slide added successfully');
    }

    // Delete slide
    public function deleteSlide($slideId)
    {
        $slide = Slide::find($slideId);
        if (!$slide) {
            return response()->json([
                'error' => 'Slide does not exist'
            ], 204);
        }

        $slide->delete();
        if (REQ::is('api/*'))
            return response()->json([
                'slide' => 'Slide deleted successfully'
            ], 200);
        return back()->with('message', 'Slide deleted successfully');
    }

    public function viewSlideFile($slideId)
    {
        $slide = Slide::find($slideId);
        if (!$slide) {
            return response()->json([
                'error' => 'Slide not exists'
            ], 404);
        }
        $pathToFile = storage_path('/app/' . $slide->file);
        return response()->download($pathToFile);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FestivalDetail;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function holidayView(){
        return view('holiday.holidayslist');
    }
    

    public function holidayCreate(Request $post)
    {
        $post->validate([
            'user_id' => 'required',
            'festival_name' => 'required',
            'festival_date' => 'required'
        ]);

        $up['user_id'] = @$post->user_id;
        $up['festival_name'] = @$post->festival_name;
        $up['festival_date'] = @$post->festival_date;
        $up['desc'] = @$post->description ?? 'N/A';
        
        // Add duration if it exists in the request
        if ($post->has('duration') && $post->duration) {
            $up['duration'] = @$post->duration;
        }

        if($post->id){
            $syllabus = FestivalDetail::where('id', $post->id)->update($up);
        }else{
            $syllabus = FestivalDetail::create($up);
        }
      

        if ($syllabus) {
            return response()->json(['status' => 'success', 'message' => 'Syllabus Details added successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Syllabus Details not added'], 400);
        }
    }

    public function syllabusDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:holiday_list,id'
        ]);

        try {
            $syllabus = FestivalDetail::find($request->id);
            if ($syllabus) {
                $syllabus->delete();
                return response()->json(['status' => 'success', 'message' => 'Syllabus deleted successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Syllabus not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete syllabus'], 500);
        }
    }
 }

<?php

namespace App\Http\Controllers;

use App\Models\ChoirPractice;
use Illuminate\Http\Request;
use App\Traits\ChurchScopeTrait;
use Carbon\Carbon;

class ChoirPracticeController extends Controller
{
    use ChurchScopeTrait;

    public function getPractices()
    {
        $churchId = $this->getCurrentChurchId();
        
        $practices = ChoirPractice::where('church_id', $churchId)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function($practice) {
                return [
                    'id' => $practice->id,
                    'date' => $practice->date,
                    'start_time' => $practice->start_time,
                    'end_time' => $practice->end_time,
                    'location' => $practice->location,
                    'notes' => $practice->notes,
                    'is_mandatory' => $practice->is_mandatory,
                ];
            });
        
        return response()->json([
            'success' => true,
            'practices' => $practices
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $churchId = $this->getCurrentChurchId();

        // Check if practice already exists for this date and time
        $exists = ChoirPractice::where('church_id', $churchId)
            ->where('date', $request->date)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'A practice already exists at this date and time.'
            ], 422);
        }

        $practice = ChoirPractice::create([
            'church_id' => $churchId,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_mandatory' => $request->is_mandatory ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Choir practice scheduled successfully!',
            'practice' => $practice
        ]);
    }

    public function destroy($id)
    {
        $churchId = $this->getCurrentChurchId();
        
        $practice = ChoirPractice::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        $practice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Practice removed successfully!'
        ]);
    }
}
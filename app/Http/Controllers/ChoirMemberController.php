<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChoirMemberController extends Controller
{
    public function index()
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $choir_members = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->latest()
            ->paginate(12);
        
        $totalChoirMembers = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->count();
        
        $activeCount = $totalChoirMembers;
        $practiceCount = 4;
        $attendanceRate = 85;
        
        return view('choir-members.index', compact('choir_members', 'totalChoirMembers', 'activeCount', 'practiceCount', 'attendanceRate'));
    }

    public function create()
    {
        $choirRoles = ['Singer', 'Guitarist', 'Pianist', 'Drummer', 'Bassist'];
        $voiceParts = ['Soprano', 'Alto', 'Tenor', 'Bass'];
        return view('choir-members.create', compact('choirRoles', 'voiceParts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'voice_part' => 'nullable|string|max:50',
            'choir_role' => 'nullable|string|max:50',
        ]);

        $churchId = session('current_church_id', auth()->user()->church_id);

        $member = Member::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'voice_part' => $request->voice_part,
            'choir_role' => $request->choir_role,
            'church_id' => $churchId,
            'is_choir' => true,
        ]);

        $choirRole = Role::where('name', $request->choir_role ?? 'Singer')->first();
        if ($choirRole) {
            $member->roles()->attach($choirRole->id);
        }

        return redirect()->route('choir-members.index')
            ->with('success', 'Choir member added successfully!');
    }

    public function edit($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $choir_member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->where('is_choir', true)
            ->firstOrFail();
            
        $choirRoles = ['Singer', 'Guitarist', 'Pianist', 'Drummer', 'Bassist'];
        $voiceParts = ['Soprano', 'Alto', 'Tenor', 'Bass'];
            
        return view('choir-members.edit', compact('choir_member', 'choirRoles', 'voiceParts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'voice_part' => 'nullable|string|max:50',
            'choir_role' => 'nullable|string|max:50',
        ]);

        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $choir_member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->where('is_choir', true)
            ->firstOrFail();
            
        $choir_member->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'voice_part' => $request->voice_part,
            'choir_role' => $request->choir_role,
        ]);

        return redirect()->route('choir-members.index')
            ->with('success', 'Choir member updated successfully!');
    }

    public function destroy($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $choir_member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
            
        $choir_member->delete();
        
        return redirect()->route('choir-members.index')
            ->with('success', 'Choir member deleted successfully!');
    }
}
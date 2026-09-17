<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChoirMemberController extends Controller
{
    /**
     * List all choir members for the current church.
     */
    public function index()
    {
        $churchId = session('current_church_id', auth()->user()->church_id);

        $choir_members = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->where(function ($q) {
                $q->where('is_deceased', false)->orWhereNull('is_deceased');
            })
            ->latest()
            ->paginate(12);

        $totalChoirMembers = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->where(function ($q) {
                $q->where('is_deceased', false)->orWhereNull('is_deceased');
            })
            ->count();

        $activeCount = $totalChoirMembers;
        $practiceCount = 4;
        $attendanceRate = 85;

        return view('choir-members.index', compact(
            'choir_members',
            'totalChoirMembers',
            'activeCount',
            'practiceCount',
            'attendanceRate'
        ));
    }

    /**
     * Show the "Add Choir Member" form.
     * Passes available members so the picker works.
     */
    public function create()
    {
        $churchId = session('current_church_id', auth()->user()->church_id);

        $choirRoles = ['Singer', 'Guitarist', 'Pianist', 'Drummer', 'Bassist'];
        $voiceParts = ['Soprano', 'Alto', 'Tenor', 'Bass'];

        // Members eligible to be added to the choir.
        // Includes everyone (even already-in-choir ones — the view will
        // mark those as "already in choir" and disable them).
        $availableMembers = Member::where('church_id', $churchId)
            ->where(function ($q) {
                $q->where('is_deceased', false)->orWhereNull('is_deceased');
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name', 'email', 'phone', 'is_choir']);

        return view('choir-members.create', compact(
            'choirRoles',
            'voiceParts',
            'availableMembers'
        ));
    }

    /**
     * Store a choir member.
     *
     * Two supported modes:
     *   - "existing": picks an existing member via `member_id` and toggles
     *                 is_choir + voice_part on that member.
     *   - "new":      creates a brand new Member record and marks it as choir.
     */
    public function store(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);

        // ─── Mode: pick an existing member ───
        if ($request->filled('member_id')) {
            $request->validate([
                'member_id'  => 'required|integer|exists:members,id',
                'voice_part' => 'required|string|max:50',
            ]);

            $member = Member::where('id', $request->member_id)
                ->where('church_id', $churchId)
                ->firstOrFail();

            // Guard: cannot add a deceased member to the choir
            if (!empty($member->is_deceased)) {
                return back()
                    ->withInput()
                    ->with('error', 'Cannot add a deceased member to the choir.');
            }

            $member->update([
                'is_choir'   => true,
                'voice_part' => $request->voice_part,
                'choir_role' => $member->choir_role ?? 'Singer',
            ]);

            return redirect()
                ->route('choir-members.index')
                ->with('success', $member->first_name . ' ' . $member->last_name . ' has been added to the choir!');
        }

        // ─── Mode: create a brand new member ───
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birthday'   => 'nullable|date',
            'address'    => 'nullable|string',
            'phone'      => 'nullable|string|max:50',
            'voice_part' => 'required|string|max:50',
            'choir_role' => 'nullable|string|max:50',
        ]);

        $member = Member::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'address'    => $request->address,
            'phone'      => $request->phone,
            'voice_part' => $request->voice_part,
            'choir_role' => $request->choir_role ?? 'Singer',
            'church_id'  => $churchId,
            'is_choir'   => true,
        ]);

        $choirRole = Role::where('name', $request->choir_role ?? 'Singer')->first();
        if ($choirRole) {
            $member->roles()->syncWithoutDetaching([$choirRole->id]);
        }

        return redirect()
            ->route('choir-members.index')
            ->with('success', 'Choir member added successfully!');
    }

    /**
     * Show the edit form for a choir member.
     */
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

    /**
     * Update a choir member.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birthday'   => 'nullable|date',
            'address'    => 'nullable|string',
            'phone'      => 'nullable|string|max:50',
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
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'address'    => $request->address,
            'phone'      => $request->phone,
            'voice_part' => $request->voice_part,
            'choir_role' => $request->choir_role,
        ]);

        // Sync the choir role
        if ($request->filled('choir_role')) {
            $choirRole = Role::where('name', $request->choir_role)->first();
            if ($choirRole) {
                $choir_member->roles()->syncWithoutDetaching([$choirRole->id]);
            }
        }

        return redirect()
            ->route('choir-members.index')
            ->with('success', 'Choir member updated successfully!');
    }

    /**
     * Remove a member from the choir.
     *
     * IMPORTANT: This only flips `is_choir` back to false — it does NOT
     * delete the member. They still exist in Member Management.
     * If you truly want to delete, use the destroyPermanent method.
     */
    public function destroy($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);

        $choir_member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();

        // Just remove them from the choir, keep them as a regular member
        $choir_member->update([
            'is_choir'   => false,
            'voice_part' => null,
            'choir_role' => null,
        ]);

        return redirect()
            ->route('choir-members.index')
            ->with('success', $choir_member->first_name . ' has been removed from the choir.');
    }

    /**
     * (Optional) Permanently delete a member.
     * Only use if you actually want to nuke the member record too.
     */
    public function destroyPermanent($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);

        $choir_member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();

        $choir_member->delete();

        return redirect()
            ->route('choir-members.index')
            ->with('success', 'Choir member deleted permanently.');
    }
}
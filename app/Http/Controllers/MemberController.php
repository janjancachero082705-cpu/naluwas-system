<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use App\Models\ChoirGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Get active members (not deceased)
        $query = Member::where('church_id', $churchId)->where('is_deceased', false);
        
        // Filter by role if specified
        if ($request->role && $request->role != 'all') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }
        
        // Filter by choir member
        if ($request->has('choir_filter') && $request->choir_filter != 'all') {
            $query->where('is_choir', $request->choir_filter == 'yes');
        }
        
        $members = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get deceased members
        $deceasedMembers = Member::where('church_id', $churchId)
            ->where('is_deceased', true)
            ->orderBy('date_deceased', 'desc')
            ->paginate(10);
        
        $currentFilter = $request->role ?? 'all';
        $choirFilter = $request->choir_filter ?? 'all';
        $allRoles = Role::all();
        
        $totalMembers = Member::where('church_id', $churchId)->where('is_deceased', false)->count();
        $choirCount = Member::where('church_id', $churchId)->where('is_choir', true)->where('is_deceased', false)->count();
        $birthdaysThisMonth = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->whereMonth('birthday', now()->month)
            ->count();
        $deceasedCount = Member::where('church_id', $churchId)->where('is_deceased', true)->count();
        $activeMinistries = Role::count();
        
        return view('members.index', compact('members', 'deceasedMembers', 'currentFilter', 'choirFilter', 'allRoles', 
            'totalMembers', 'choirCount', 'birthdaysThisMonth', 'activeMinistries', 'deceasedCount'));
    }

    public function create()
    {
        $roles = Role::all();
        
        // If no roles exist, create default ones
        if ($roles->isEmpty()) {
            $this->createDefaultRoles();
            $roles = Role::all();
        }
        
        $choirGroups = ChoirGroup::where('church_id', session('current_church_id', auth()->user()->church_id))
            ->where('is_active', true)
            ->orderBy('rotation_order')
            ->get();
        
        return view('members.create', compact('roles', 'choirGroups'));
    }

    private function createDefaultRoles()
    {
        $defaultRoles = [
            ['name' => 'Training Pastor', 'slug' => 'training_pastor', 'icon' => 'fa-church', 'color' => 'danger'],
            ['name' => 'Palagkanta', 'slug' => 'palagkanta', 'icon' => 'fa-microphone-alt', 'color' => 'primary'],
            ['name' => 'Instruments', 'slug' => 'instruments', 'icon' => 'fa-guitar', 'color' => 'info'],
            ['name' => 'Youth Leader', 'slug' => 'youth_leader', 'icon' => 'fa-users', 'color' => 'warning'],
            ['name' => 'AGAK Mentor', 'slug' => 'agak_mentor', 'icon' => 'fa-chalkboard-teacher', 'color' => 'secondary'],
            ['name' => 'Palagbulig (Lalaki)', 'slug' => 'palagbulig_lalaki', 'icon' => 'fa-male', 'color' => 'success'],
            ['name' => 'Palagbulig (Babae)', 'slug' => 'palagbulig_babae', 'icon' => 'fa-female', 'color' => 'success'],
            ['name' => 'Gahawid sa Offering', 'slug' => 'offering', 'icon' => 'fa-hand-holding-usd', 'color' => 'dark'],
            ['name' => 'Gahawid sa Computer', 'slug' => 'computer', 'icon' => 'fa-laptop', 'color' => 'info'],
            ['name' => 'Palagdasig', 'slug' => 'palagdasig', 'icon' => 'fa-heart', 'color' => 'danger'],
        ];
        
        foreach ($defaultRoles as $role) {
            Role::create($role);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'choir_group_id' => 'nullable|exists:choir_groups,id',
            'choir_role' => 'nullable|string|in:Singer,Guitarist,Bassist,Drummer',
        ]);

        $churchId = session('current_church_id', auth()->user()->church_id);

        // Get selected role names to check if choir member
        $selectedRoleNames = [];
        if (isset($validated['roles']) && !empty($validated['roles'])) {
            $selectedRoleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();
        }
        
        // Check if member should be choir member
        // A member is considered choir if they have ANY role (all members are choir by default)
        // or if they have a choir group assigned or choir role specified
        $isChoirMember = !empty($selectedRoleNames) || 
                         $request->has('is_choir') ||
                         (isset($validated['choir_role']) && $validated['choir_role']) ||
                         (isset($validated['choir_group_id']) && $validated['choir_group_id']);

        // Determine choir role if member is choir
        $choirRole = null;
        if ($isChoirMember) {
            if (isset($validated['choir_role']) && $validated['choir_role']) {
                $choirRole = $validated['choir_role'];
            } else {
                $choirRole = 'Singer'; // Default role
            }
        }

        $member = Member::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'birthday' => $validated['birthday'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'church_id' => $churchId,
            'is_choir' => $isChoirMember,
            'choir_role' => $choirRole,
            'choir_group_id' => $validated['choir_group_id'] ?? null,
            'is_deceased' => false,
            'date_deceased' => null,
        ]);

        // Attach roles if they exist
        if (isset($validated['roles']) && !empty($validated['roles'])) {
            $member->roles()->attach($validated['roles']);
        }

        if ($isChoirMember) {
            return redirect()->route('members.index')
                ->with('success', 'Member added successfully! 🎵 Added to Choir Ministry as ' . ($choirRole ?? 'Singer') . '.');
        }

        return redirect()->route('members.index')
            ->with('success', 'Member added successfully!');
    }

    public function edit($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();

        $roles = Role::all();
        $memberRoles = $member->roles->pluck('id')->toArray();
        
        $choirGroups = ChoirGroup::where('church_id', $churchId)
            ->where('is_active', true)
            ->orderBy('rotation_order')
            ->get();

        return view('members.edit', compact('member', 'roles', 'memberRoles', 'choirGroups'));
    }

    public function update(Request $request, $id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'choir_group_id' => 'nullable|exists:choir_groups,id',
            'choir_role' => 'nullable|string|in:Singer,Guitarist,Bassist,Drummer',
        ]);

        // Get selected role names
        $selectedRoleNames = [];
        if (isset($validated['roles']) && !empty($validated['roles'])) {
            $selectedRoleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();
        }
        
        // Check if member should be choir member
        $isChoirMember = !empty($selectedRoleNames) || 
                         $request->has('is_choir') ||
                         (isset($validated['choir_role']) && $validated['choir_role']) ||
                         (isset($validated['choir_group_id']) && $validated['choir_group_id']);

        // Determine choir role if member is choir
        $choirRole = $member->choir_role; // Keep existing if not changed
        if ($isChoirMember) {
            if (isset($validated['choir_role']) && $validated['choir_role']) {
                $choirRole = $validated['choir_role'];
            } elseif (!$choirRole) {
                $choirRole = 'Singer'; // Default role
            }
        } else {
            $choirRole = null;
        }

        $member->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'birthday' => $validated['birthday'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'is_choir' => $isChoirMember,
            'choir_role' => $choirRole,
            'choir_group_id' => $validated['choir_group_id'] ?? null,
        ]);

        // Sync roles if they exist
        if (isset($validated['roles'])) {
            $member->roles()->sync($validated['roles']);
        } else {
            $member->roles()->detach();
        }

        if ($isChoirMember) {
            return redirect()->route('members.index')
                ->with('success', 'Member updated successfully! 🎵 Updated in Choir Ministry as ' . ($choirRole ?? 'Singer') . '.');
        }

        return redirect()->route('members.index')
            ->with('success', 'Member updated successfully!');
    }

    public function destroy($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        // Detach roles first
        $member->roles()->detach();
        
        // Delete choir schedules if any
        $member->choirSchedules()->delete();
        
        $member->delete();
        
        // Check if request expects JSON (for AJAX calls)
        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Member deleted successfully!']);
        }
        
        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully!');
    }
    
    public function show($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->with('roles')
            ->firstOrFail();
            
        return view('members.show', compact('member'));
    }
    
    // ==============================================
    // DECEASED MEMBER METHODS
    // ==============================================
    
    /**
     * Mark a member as deceased
     */
    public function markAsDeceased(Request $request, $id)
    {
        try {
            $churchId = session('current_church_id', auth()->user()->church_id);
            
            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->firstOrFail();
            
            $request->validate([
                'date_deceased' => 'required|date|before_or_equal:today',
            ]);
            
            $member->update([
                'is_deceased' => true,
                'date_deceased' => $request->date_deceased,
            ]);
            
            // Return JSON response for AJAX call
            return response()->json([
                'success' => true,
                'message' => "{$member->first_name} {$member->last_name} has been marked as deceased."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Restore a member from deceased to active
     */
    public function restoreFromDeceased($id)
    {
        try {
            $churchId = session('current_church_id', auth()->user()->church_id);
            
            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->firstOrFail();
            
            $member->update([
                'is_deceased' => false,
                'date_deceased' => null,
            ]);
            
            // Return JSON response for AJAX call
            return response()->json([
                'success' => true,
                'message' => "{$member->first_name} {$member->last_name} has been restored to active members."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    // Assign member to choir group
    public function assignToGroup(Request $request, $id)
    {
        $request->validate([
            'choir_group_id' => 'required|exists:choir_groups,id',
            'choir_role' => 'required|string|in:Singer,Guitarist,Bassist,Drummer',
        ]);
        
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        $member->update([
            'choir_group_id' => $request->choir_group_id,
            'choir_role' => $request->choir_role,
            'is_choir' => true,
        ]);
        
        return redirect()->route('members.show', $id)
            ->with('success', 'Member assigned to choir group successfully!');
    }
    
    // Remove member from choir group
    public function removeFromGroup($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        $member->update([
            'choir_group_id' => null,
            'choir_role' => null,
            'is_choir' => false,
        ]);
        
        return redirect()->route('members.show', $id)
            ->with('success', 'Member removed from choir group.');
    }
}
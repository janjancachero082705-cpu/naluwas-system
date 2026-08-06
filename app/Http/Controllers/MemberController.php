<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use App\Models\ChoirGroup;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $query = Member::where('church_id', $churchId)->where('is_deceased', false);
        
        if ($request->role && $request->role != 'all') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }
        
        if ($request->has('choir_filter') && $request->choir_filter != 'all') {
            $query->where('is_choir', $request->choir_filter == 'yes');
        }
        
        $members = $query->orderBy('created_at', 'desc')->paginate(10);
        
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

    /**
     * STORE - FIXED VERSION
     */
    public function store(Request $request)
    {
        try {
            // =============================================
            // DEBUG: SHOW ALL FORM DATA
            // =============================================
            \Log::info('=== FORM DATA ===');
            \Log::info(json_encode($request->all()));
            
            // =============================================
            // VALIDATE
            // =============================================
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birthday' => 'nullable|date',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'gender' => 'nullable|string|in:male,female',
                'roles' => 'nullable|array',
                'roles.*' => 'exists:roles,id',
                'choir_group_id' => 'nullable|exists:choir_groups,id',
                'choir_role' => 'nullable|string|in:Singer,Guitarist,Bassist,Drummer',
            ]);

            // =============================================
            // LOG THE GENDER
            // =============================================
            \Log::info('GENDER FROM FORM: ' . ($validated['gender'] ?? 'NOT SET'));

            $churchId = session('current_church_id', auth()->user()->church_id);

            // Check if choir member
            $isChoirMember = $request->has('is_choir') ||
                             (isset($validated['choir_role']) && $validated['choir_role']) ||
                             (isset($validated['choir_group_id']) && $validated['choir_group_id']);

            $choirRole = $validated['choir_role'] ?? null;

            // =============================================
            // CREATE MEMBER USING direct assignment
            // =============================================
            $member = new Member();
            $member->first_name = $validated['first_name'];
            $member->last_name = $validated['last_name'];
            $member->birthday = $validated['birthday'] ?? null;
            $member->address = $validated['address'] ?? null;
            $member->phone = $validated['phone'] ?? null;
            $member->email = $validated['email'] ?? null;
            $member->gender = $validated['gender'] ?? null; // THIS SAVES THE GENDER
            $member->church_id = $churchId;
            $member->is_choir = $isChoirMember;
            $member->choir_role = $choirRole;
            $member->choir_group_id = $validated['choir_group_id'] ?? null;
            $member->is_deceased = false;
            $member->date_deceased = null;
            $member->save();

            // =============================================
            // LOG WHAT WAS SAVED
            // =============================================
            \Log::info('SAVED MEMBER ID: ' . $member->id);
            \Log::info('SAVED GENDER: ' . ($member->gender ?? 'NULL'));

            // Attach roles
            if (isset($validated['roles']) && !empty($validated['roles'])) {
                $member->roles()->attach($validated['roles']);
            }

            $message = $isChoirMember 
                ? 'Member added successfully! 🎵 Added to Choir Ministry.'
                : 'Member added successfully!';

            return redirect()->route('members.index')
                ->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error: ' . json_encode($e->errors()));
            return redirect()->route('members.create')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Store Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('members.create')
                ->with('error', 'Error adding member: ' . $e->getMessage());
        }
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
        try {
            $churchId = session('current_church_id', auth()->user()->church_id);
            
            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->firstOrFail();

            \Log::info('UPDATE - Gender: ' . ($request->gender ?? 'null'));

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birthday' => 'nullable|date',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'gender' => 'nullable|string|in:male,female',
                'roles' => 'nullable|array',
                'roles.*' => 'exists:roles,id',
                'choir_group_id' => 'nullable|exists:choir_groups,id',
                'choir_role' => 'nullable|string|in:Singer,Guitarist,Bassist,Drummer',
            ]);

            // Update using direct assignment
            $member->first_name = $validated['first_name'];
            $member->last_name = $validated['last_name'];
            $member->birthday = $validated['birthday'] ?? null;
            $member->address = $validated['address'] ?? null;
            $member->phone = $validated['phone'] ?? null;
            $member->email = $validated['email'] ?? null;
            $member->gender = $validated['gender'] ?? null;
            $member->choir_group_id = $validated['choir_group_id'] ?? null;
            $member->choir_role = $validated['choir_role'] ?? null;
            $member->save();

            \Log::info('UPDATED - Gender: ' . ($member->gender ?? 'null'));

            if (isset($validated['roles'])) {
                $member->roles()->sync($validated['roles']);
            } else {
                $member->roles()->detach();
            }

            return redirect()->route('members.show', $id)
                ->with('success', 'Member updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Update error: ' . $e->getMessage());
            
            return redirect()->route('members.edit', $id)
                ->with('error', 'Error updating member: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        $member->roles()->detach();
        $member->choirSchedules()->delete();
        $member->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Member deleted successfully!']);
        }
        
        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully!');
    }
    
    public function show($id)
    {
        try {
            $churchId = session('current_church_id', auth()->user()->church_id);
            
            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->with('roles')
                ->firstOrFail();
            
            \Log::info('SHOW - Gender: ' . ($member->gender ?? 'null'));
            
            $attendanceCount = Attendance::where('member_id', $id)
                ->where('church_id', $churchId)
                ->count();
            
            $contributionCount = 0;
            $recentActivities = collect();
            
            $transactionModel = $this->getTransactionModel();
            
            if ($transactionModel) {
                try {
                    $contributionCount = $transactionModel::where('member_id', $id)
                        ->where('church_id', $churchId)
                        ->where('type', 'income')
                        ->count();
                    
                    $recentTransactions = $transactionModel::where('member_id', $id)
                        ->where('church_id', $churchId)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get()
                        ->map(function($item) {
                            return (object) [
                                'description' => $item->description ?? 'Contribution of ₱' . number_format($item->amount ?? 0, 2),
                                'created_at' => $item->created_at ?? now(),
                                'type' => 'contribution'
                            ];
                        });
                } catch (\Exception $e) {
                    \Log::warning('Transaction data error: ' . $e->getMessage());
                    $recentTransactions = collect();
                    $contributionCount = 0;
                }
            } else {
                $recentTransactions = collect();
            }
            
            $recentAttendance = Attendance::where('member_id', $id)
                ->where('church_id', $churchId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return (object) [
                        'description' => 'Attended service on ' . ($item->service_date ? \Carbon\Carbon::parse($item->service_date)->format('M d, Y') : $item->created_at->format('M d, Y')),
                        'created_at' => $item->created_at,
                        'type' => 'attendance'
                    ];
                });
            
            if (isset($recentTransactions) && $recentTransactions->count() > 0) {
                $recentActivities = $recentAttendance->merge($recentTransactions)
                    ->sortByDesc('created_at')
                    ->take(5);
            } else {
                $recentActivities = $recentAttendance;
            }
            
            return view('members.show', compact(
                'member', 
                'attendanceCount', 
                'contributionCount', 
                'recentActivities'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Error in MemberController@show: ' . $e->getMessage());
            
            return redirect()->route('members.index')
                ->with('error', 'Unable to load member profile. Please try again.');
        }
    }
    
    private function getTransactionModel()
    {
        if (class_exists('App\Models\MoneyTransaction')) {
            return 'App\Models\MoneyTransaction';
        }
        
        if (class_exists('App\Models\Transaction')) {
            return 'App\Models\Transaction';
        }
        
        if (class_exists('App\Models\Finance')) {
            return 'App\Models\Finance';
        }
        
        return null;
    }
    
    public function markAsDeceased(Request $request, $id)
    {
        try {
            $churchId = session('current_church_id', auth()->user()->church_id);
            
            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->firstOrFail();
            
            if ($request->has('date_deceased')) {
                $request->validate([
                    'date_deceased' => 'required|date|before_or_equal:today',
                ]);
                $dateDeceased = $request->date_deceased;
            } else {
                $dateDeceased = now()->toDateString();
            }
            
            $member->update([
                'is_deceased' => true,
                'date_deceased' => $dateDeceased,
            ]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$member->first_name} {$member->last_name} has been marked as deceased."
                ]);
            }
            
            return redirect()->route('members.show', $id)
                ->with('success', "{$member->first_name} {$member->last_name} has been marked as deceased.");
            
        } catch (\Exception $e) {
            \Log::error('Error in markAsDeceased: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('members.show', $id)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function restoreFromDeceased(Request $request, $id)
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
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$member->first_name} {$member->last_name} has been restored to active members."
                ]);
            }
            
            return redirect()->route('members.show', $id)
                ->with('success', "{$member->first_name} {$member->last_name} has been restored to active members.");
            
        } catch (\Exception $e) {
            \Log::error('Error in restoreFromDeceased: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('members.show', $id)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function assignToGroup(Request $request, $id)
    {
        try {
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
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Member assigned to choir group successfully!'
                ]);
            }
            
            return redirect()->route('members.show', $id)
                ->with('success', 'Member assigned to choir group successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Error in assignToGroup: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('members.show', $id)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function removeFromGroup(Request $request, $id)
    {
        try {
            $churchId = session('current_church_id', auth()->user()->church_id);
            
            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->firstOrFail();
            
            $member->update([
                'choir_group_id' => null,
                'choir_role' => null,
                'is_choir' => false,
            ]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Member removed from choir group.'
                ]);
            }
            
            return redirect()->route('members.show', $id)
                ->with('success', 'Member removed from choir group.');
                
        } catch (\Exception $e) {
            \Log::error('Error in removeFromGroup: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('members.show', $id)
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
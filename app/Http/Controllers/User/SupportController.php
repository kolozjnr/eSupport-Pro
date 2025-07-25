<?php

namespace App\Http\Controllers\User;

use App\Models\Support;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SupportController extends Controller
{
    public function index()
    {
        return view('user.supports.identity');
    }

    public function update(Request $request, $id)
    {
        $support = Support::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'support_id' => 'required| integer|exists:supports,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

    }

    public function getSupports()
    {
        $supports = Support::with('user')->get();
        return view('user.settings.manage-identity', compact('supports'));
    }

   public function getIdentity($support_id)
    {
        $identities = Identity::where('support_id', $support_id)->get();
        return response()->json($identities);
    }

    public function updateIdentity(Request $request)
    {
        $validated = $request->validate([
            'support_staff' => 'required|exists:supports,id',
            'identities' => 'nullable|array',
            'identities.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $support = Support::findOrFail($validated['support_staff']);
            $supportId = $support->id;
            $userId = $support->user_id;

            $existingCount = Identity::where('support_id', $supportId)->count();
            $newCount = count(array_filter($validated['identities'] ?? []));
            
            if ($existingCount + $newCount > 3) {
                return back()->withErrors(['identities' => 'Maximum of 3 identities allowed per support staff']);
            }

            foreach ($validated['identities'] as $identityName) {
                if (!empty($identityName)) {
                    Identity::create([
                        'user_id' => $userId, // Using the support's user_id
                        'support_id' => $supportId,
                        'name' => $identityName
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Identities updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update identities: ' . $e->getMessage()]);
        }
    }

        
}

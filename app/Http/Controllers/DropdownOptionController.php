<?php

namespace App\Http\Controllers;

use App\Models\DropdownOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DropdownOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-Assessment', ['only' => ['storeQuick']]);
        $this->middleware('permission:edit-Assessment', ['only' => ['update']]);
        $this->middleware('permission:delete-Assessment', ['only' => ['destroy']]);
    }

    public function storeQuick(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:50|in:investigation_type,exercise_name,exercise_category,special_test,clinical_impression,complaint,precaution,advice',
            'name' => 'required|string|max:255',
        ]);

        $option = DropdownOption::withDeleted()
            ->where('type', $request->type)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($request->name))])
            ->first();

        if ($option) {
            return response()->json(['id' => $option->id, 'name' => $option->name, 'already_exists' => true]);
        }

        $option = DropdownOption::create([
            'type' => $request->type,
            'name' => trim($request->name),
            'created_by' => Auth::id(),
        ]);

        return response()->json(['id' => $option->id, 'name' => $option->name, 'already_exists' => false]);
    }

    public function update(Request $request, DropdownOption $dropdownOption)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $duplicate = DropdownOption::where('id', '!=', $dropdownOption->id)
            ->where('type', $dropdownOption->type)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($request->name))])
            ->first();

        if ($duplicate) {
            return response()->json(['error' => 'An option with this name already exists'], 422);
        }

        $dropdownOption->update(['name' => trim($request->name)]);

        return response()->json(['id' => $dropdownOption->id, 'name' => $dropdownOption->name]);
    }

    public function destroy(DropdownOption $dropdownOption)
    {
        $dropdownOption->deleteRecord();

        return response()->json(['success' => true]);
    }
}
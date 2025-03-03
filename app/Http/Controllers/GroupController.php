<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        Group::create($request->all());

        return redirect()->route('group.index')
            ->with('success', 'Group was created successfully.');
    }

    public function destroy(Request $request)
    {
        Group::destroy($request->id);
        return redirect()->route('groups.index')
            ->with('success', 'Group was deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\WorkArea;
use Illuminate\View\View;

class WorkAreaController extends Controller
{
  public function index()
  {
      $workAreas = WorkArea::all();

      return view('work_areas.index', compact('workAreas'));
  }

  public function store(Request $request)
  {
      $request->validate([
          'name' => 'required|string|max:255|unique:work_areas',
      ]);

      WorkArea::create([
          'name' => $request->name,
      ]);

      return redirect()->route('work_area.index');
  }

  public function destroy(WorkArea $workArea)
  {
      $workArea->delete();

      return redirect()->route('work_area.index');
  }
}

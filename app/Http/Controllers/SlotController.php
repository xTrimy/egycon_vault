<?php

namespace App\Http\Controllers;

use App\Models\Belonging;
use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
  public function index()
  {
    $slots = Slot::paginate(15);
    $slot_counts = [];
    foreach ($slots as $slot) {
      $count = count(Belonging::where('slot_id', $slot->id)->get());
      $slot_counts[$slot->name] = $count;
    }
    return view('slots', ['slots' => $slots, 'counts' => $slot_counts]);
  }

  public function add()
  {
    return view('add-slot');
  }


  public function store(Request $request)
  {
    $request->validate([
      'name' => "required|min:1|max:2|unique:slots,name",
      'max' => 'required|numeric',
    ]);
    $slot = new Slot();
    $slot->name = $request->name;
    $slot->max = $request->max;
    $slot->save();
    return redirect()->back()->with('success', "Slot has been added!");
  }

  public function edit_slot($id)
  {
    $slot = Slot::find($id);
    return view('add-slot', ['slots' => $slot]);
  }

  public function update_slot(Request $request, $slots)
  {

    $slot = Slot::find($slots);
    $slot->name = $request->name;

    $all_slots = Slot::all();
    $slot_counts = [];
    foreach ($all_slots as $slota) {
      $count = count(Belonging::where('slot_id', $slota->id)->get());
      $slot_counts[$slota->name] = $count;
    }

    if ($slot_counts[$slot->name] > $request->max) {
      return redirect()->back()->with(["error" => "Slot cannot be edited the occupied belongings inside exceed the maximum belongings."]);
    } else {
      $slot->max = $request->max;
      $slot->save();
      return redirect()->back()->with(["success" => "Slot has been Changed!"]);
    }
  }

  public function delete_slot($id)
  {
    $slot = Slot::findOrFail($id);

    $slots = Slot::all();
    $slot_counts = [];
    foreach ($slots as $slot) {
      $count = count(Belonging::where('slot_id', $id)->get());
      $slot_counts[$slot->name] = $count;
    }
    if ($slot_counts[$slot->name] > 0) {
      return redirect()->back()->with(["error" => "Slot cannot be deleted because it's occupied."]);
    } else {
      $slot->delete();
      return redirect()->back()->with(["success" => "Slot has been deleted successfully!"]);
    }
  }
}

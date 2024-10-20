<?php

namespace App\Http\Controllers;

use App\Helpers\FilesHelper;
use App\Helpers\MailHelpers;
use App\Models\Belonging;
use App\Models\BelongingSize;
use App\Models\BelongingType;
use App\Models\VisitorType;
use App\Models\Slot;
use App\Models\BelongingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Postmark\PostmarkClient;
use stdClass;

class BelongingController extends Controller
{
  public function add()
  {
    $types = BelongingType::all();
    $sizes = BelongingSize::all();
    $visitor = VisitorType::all();
    $slots = Slot::all();
    $slot_counts = [];
    foreach ($slots as $slot) {
      $count = count(Belonging::where('slot_id', $slot->id)->get());
      $slot_counts[$slot->name] = $count;
    }
    return view('add-to-vault', ['slots' => $slots, 'types' => $types, 'sizes' => $sizes, 'visitor' => $visitor, 'slot_counts' => $slot_counts]);
  }


  public function view()
  {
    $belongings = Belonging::with('size')->with('type')->with('slot')->orderBy('id', 'DESC')->get();
    return view('belongings', ['belongings' => $belongings]);
  }


  public function store(Request $request)
  {
    $request->validate([
      'name' => "required|max:64|min:6",
      'phone' => "required|max:15|min:11",
      'email' => "email|required",
      "type" => "required|exists:belonging_types,id",
      "size" => "required|exists:belonging_sizes,id",
      'color' => "required",
      "color_name" => "required",
      "notes" => "nullable",
      "slot_id" => "required|exists:slots,id",
      "visitor" => "required|exists:visitor_types,id",

    ]);
    $belonging = new Belonging();
    $belonging->name = $request->name;
    $belonging->email = $request->email;
    $belonging->phone = $request->phone;
    $belonging->color = $request->color;
    $belonging->status = "1";
    $belonging->belonging_type_id = $request->type;
    $belonging->belonging_size_id = $request->size;
    $belonging->visitor_type_id = $request->visitor;
    $belonging->color_name = $request->color_name;
    if ($request->has('notes'))
      $belonging->notes = $request->notes;
    $belonging->slot_id = $request->slot_id;

    $slot = Slot::where('id', $request->slot_id)->first();
    $slots_count = count(Belonging::where('slot_id', $slot->id)->get());
    $code = $slots_count + 1;

    $belonging->code = $slot->name . "-" . $code;

    $visitor_type = VisitorType::where('id', $request->visitor)->first();

    $belonging_type = BelongingType::where('id', $request->type)->first();

    $belonging_size = BelongingSize::where('id', $request->size)->first();

    $belonging->added_by_id = auth()->id();

    $belonging->save();
    //add action to history
    BelongingHistory::create([
      'user_id' => auth()->id(),
      'item_id' => $belonging->id,
      'action_type' => 'Item Added',
      'action_date' => now(),
    ]);
    $data = [];
    $data['name'] = explode(' ', $belonging->name)[0];
    $data['email'] = $belonging->email;
    $data['phone'] = $belonging->phone;
    $data['status'] = $belonging->status;
    $data['visitor'] = $visitor_type->name;
    $data['type'] = $belonging_type->name;
    $data['weight'] = $belonging_size->name;
    $data['code'] = $belonging->code;
    $data['slot'] = $slot->name;
    $data['color'] = $belonging->color_name;
    MailHelpers::send_email($data, $belonging->email, MailHelpers::getRegistrationEmailTemplate());

    return redirect()->back()->with('success', 'Belonging has been added to the Vault! | Belonging Code: ' . $belonging->code);
  }
  public function belonging($id)
  {
    $belonging = Belonging::where('id', $id)
      ->with('slot')
      ->with('size')
      ->with('type')
      ->first();
    return view('belonging', ['belonging' => $belonging]);
  }

  public function edit($id)
  {
    $types = BelongingType::all();
    $sizes = BelongingSize::all();
    $visitor = VisitorType::all();
    $slots = Slot::all();
    $slot_counts = [];
    foreach ($slots as $slot) {
      $count = count(Belonging::where('slot_id', $slot->id)->get());
      $slot_counts[$slot->name] = $count;
    }

    $belonging = Belonging::where('id', $id)
      ->with('slot')
      ->with('size')
      ->with('type')
      ->first();
    return view('add-to-vault', ['slots' => $slots, 'types' => $types, 'sizes' => $sizes, 'visitor' => $visitor, 'slot_counts' => $slot_counts, 'belonging' => $belonging]);
  }

  public function update(Request $request, $belonging)
  {

    $request->validate([
      'name' => "required|max:64|min:6",
      'phone' => "required|max:15|min:11",
      'email' => "email|required",
      "type" => "required|exists:belonging_types,id",
      "size" => "required|exists:belonging_sizes,id",
      'color' => "required",
      "color_name" => "required",
      "notes" => "nullable",
      "visitor" => "required|exists:visitor_types,id",
    ]);
    $belonging = Belonging::find($belonging);

    // Store the old values before updating
    $oldValues = [
      'name' => $belonging->name,
      'email' => $belonging->email,
      'phone' => $belonging->phone,
      'color' => $belonging->color,
      'status' => $belonging->status,
      'belonging_type_id' => $belonging->belonging_type_id,
      'belonging_size_id' => $belonging->belonging_size_id,
      'visitor_type_id' => $belonging->visitor_type_id,
      'color_name' => $belonging->color_name,
      'notes' => $belonging->notes,
    ];


    //update
    $belonging->name = $request->name;
    $belonging->email = $request->email;
    $belonging->phone = $request->phone;
    $belonging->color = $request->color;
    $belonging->status = "1";
    $belonging->belonging_type_id = $request->type;
    $belonging->belonging_size_id = $request->size;
    $belonging->visitor_type_id = $request->visitor;
    $belonging->color_name = $request->color_name;


    if ($request->has('notes'))
      $belonging->notes = $request->notes;

    $belonging->save();

    //generating description by comparing values
    $description = "";
    foreach ($oldValues as $key => $oldValue) {
      $newValue = $belonging->$key;
      if ($oldValue != $newValue) {
        $description .= "$key changed from $oldValue to $newValue, \n";
      }
    }
    $description = rtrim($description, ', ');

    //add action to history
    BelongingHistory::create([
      'user_id' => auth()->id(),
      'item_id' => $belonging->id,
      'action_type' => 'Item Updated',
      'description' => $description,
      'action_date' => now(),
    ]);
    return redirect()->back()->with('success', 'Belonging has been changed!');
  }

  public function status($id)
  {
    $data = Belonging::find($id);
    $oldStatus = $data->status;
    if ($data->status == 1) {
      $data->status = 0;
    } else if ($data->status == 0) {
      $data->status = 1;
    }

    $data->save();
    $oldStatusText = $oldStatus == 1 ? 'inside' : 'outside';
    $newStatusText = $data->status == 1 ? 'inside' : 'outside';
    $description = "Status changed from $oldStatusText to $newStatusText";

    //add action to history
    BelongingHistory::create([
      'user_id' => auth()->id(),
      'item_id' => $data->id,
      'action_type' => 'Status Changed',
      'description' => $description,
      'action_date' => now(),
    ]);
    return redirect()->back()->with('success', "Belonging Status changed!");
  }

  public function delete($id)
  {
    $belonging = Belonging::findOrFail($id);

    $historyEntries = BelongingHistory::where('item_id', $belonging->id)->get();

    foreach ($historyEntries as $historyEntry) {
      $historyEntry->delete();
    }

    $belonging->delete();


    return redirect()->back()->with(["success" => "Belonging has been deleted successfully!"]);
  }

  public function belonging_image($id, Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
    ]);
    $belonging = Belonging::find($id);
    $belonging->image = FilesHelper::compressAndSave($request->image, 'images/belongings', 75);
    $belonging->save();

    return redirect()->back()->with('success', 'Image has been uploaded successfully!');
  }
}

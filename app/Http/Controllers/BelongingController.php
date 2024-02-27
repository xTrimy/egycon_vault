<?php

namespace App\Http\Controllers;

use App\Models\Belonging;
use App\Models\BelongingSize;
use App\Models\BelongingType;
use App\Models\VisitorType;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Postmark\PostmarkClient;
use stdClass;

class BelongingController extends Controller
{
    public function add(){
        $types = BelongingType::all();
        $sizes = BelongingSize::all();
        $visitor = VisitorType::all();
        $slots = Slot::all();
        $slot_counts = [];
        foreach($slots as $slot){
            $count = count(Belonging::where('slot_id',$slot->id)->get());
            $slot_counts[$slot->name] = $count;
        }
        return view('add-to-vault',['slots'=>$slots,'types'=>$types,'sizes'=>$sizes,'visitor'=>$visitor, 'slot_counts'=> $slot_counts]);
    }


    public function view()
    {
        $belongings = Belonging::with('size')->with('type')->with('slot')->orderBy('id','DESC')->get();
        return view('belongings', ['belongings' => $belongings]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=> "required|max:64|min:6",
            'phone'=>"required|max:15|min:11",
            'email'=>"email|required",
            "type"=>"required|exists:belonging_types,id",
            "size"=>"required|exists:belonging_sizes,id",
            'color'=>"required",
            "color_name"=>"required",
            "notes"=>"nullable",
            "slot_id" => "required|exists:slots,id",
            "visitor"=>"required|exists:visitor_types,id",

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
        if($request->has('notes'))
            $belonging->notes = $request->notes;
        $belonging->slot_id = $request->slot_id;

        $slot = Slot::where('id',$request->slot_id)->first();
        $slots_count = count(Belonging::where('slot_id',$slot->id)->get());
        $code = $slots_count + 1;

        $belonging->code = $slot->name ."-" . $code;

        $visitor_type = VisitorType::where('id',$request->visitor)->first();

        $belonging_type = BelongingType::where('id',$request->type)->first();

        $belonging_size = BelongingSize::where('id',$request->size)->first();

        $belonging->added_by_id = auth()->id();

        $belonging->save();
        $client = new PostmarkClient(env("POSTMARK_SECRET"));
        $sendResult = $client->sendEmailWithTemplate(
                        "info@gamerslegacy.net",
                        request('email'),
                        25435508,
                        [
                            "name" => $belonging->name,
                            "code" => $belonging->code,
                            "visitor" => $visitor_type->name,
                            "phone" => $belonging->phone,
                            "color" => $belonging->color_name,
                            "slot" => $slot->name,
                            "type" => $belonging_type->name,
                            "weight" => $belonging_size->name,



                        ]
                    );

        return redirect()->back()->with('success','Belonging has been added to the Vault! | Belonging Code: '.$belonging->code);
    }
    public function belonging($id)
    {
        $belonging = Belonging::where('id',$id)
        ->with('slot')
        ->with('size')
        ->with('type')
        ->first();
        return view('belonging', ['belonging' => $belonging]);
    }

    public function edit($id){
        $types = BelongingType::all();
        $sizes = BelongingSize::all();
        $visitor = VisitorType::all();
        $slots = Slot::all();
        $slot_counts = [];
        foreach($slots as $slot){
            $count = count(Belonging::where('slot_id',$slot->id)->get());
            $slot_counts[$slot->name] = $count;
        }

        $belonging = Belonging::where('id',$id)
        ->with('slot')
        ->with('size')
        ->with('type')
        ->first();
        return view('add-to-vault',['slots'=>$slots,'types'=>$types,'sizes'=>$sizes,'visitor'=>$visitor, 'slot_counts'=> $slot_counts, 'belonging' => $belonging]);
    }

    public function update(Request $request,$belonging){

        $request->validate([
            'name'=> "required|max:64|min:6",
            'phone'=>"required|max:15|min:11",
            'email'=>"email|required",
            "type"=>"required|exists:belonging_types,id",
            "size"=>"required|exists:belonging_sizes,id",
            'color'=>"required",
            "color_name"=>"required",
            "notes"=>"nullable",
            "visitor"=>"required|exists:visitor_types,id",
        ]);
        $belonging = Belonging::find($belonging);
        $belonging->name = $request->name;
        $belonging->email = $request->email;
        $belonging->phone = $request->phone;
        $belonging->color = $request->color;
        $belonging->status = "1";
        $belonging->belonging_type_id = $request->type;
        $belonging->belonging_size_id = $request->size;
        $belonging->visitor_type_id = $request->visitor;
        $belonging->color_name = $request->color_name;


        if($request->has('notes'))
            $belonging->notes = $request->notes;

        $belonging->save();

        return redirect()->back()->with('success','Belonging has been changed!');
    }

    public function status($id){
        $data = Belonging::find($id);
        if($data->status == 1){
            $data->status = 0;
        }
        else if($data->status == 0){
            $data->status = 1;
        }

        $data->save();
        return redirect()->back()->with('success',"Belonging Status changed!");
    }

    public function delete($id){
        $belonging = Belonging::findOrFail($id);
        $belonging->delete();

        return redirect()->back()->with(["success" => "Belonging has been deleted successfully!"]);
    }

}


<?php

namespace App\Http\Controllers;

use App\Models\Belonging;
use App\Models\BelongingSize;
use App\Models\BelongingType;
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
        $slots = Slot::all();
        $slot_counts = [];
        foreach($slots as $slot){
            $count = count(Belonging::where('slot_id',$slot->id)->get());
            $slot_counts[$slot->name] = $count;
        }
        return view('add-to-vault',['slots'=>$slots,'types'=>$types,'sizes'=>$sizes, 'slot_counts'=> $slot_counts]);
    }

    public function view()
    {
        $belongings = Belonging::with('size')->with('type')->paginate(15);
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
        ]);
        $belonging = new Belonging();
        $belonging->name = $request->name;
        $belonging->email = $request->email;
        $belonging->phone = $request->phone;
        $belonging->color = $request->color;
        $belonging->status = "1";
        $belonging->belonging_type_id = $request->type;
        $belonging->belonging_size_id = $request->size;
        $belonging->color_name = $request->color_name;


        if($request->has('notes'))
            $belonging->notes = $request->notes;
        $belonging->slot_id = $request->slot_id;

        $slot = Slot::where('id',$request->slot_id)->first();
        $slots_count = count(Belonging::where('slot_id',$slot->id)->get());
        $code = $slots_count + 1;

        $belonging->code = $slot->name ."-" . $code;
        
        $belonging->save();

        $client = new PostmarkClient(env("POSTMARK_SECRET"));
        $sendResult = $client->sendEmailWithTemplate(
                        "info@gamerslegacy.net",
                        request('email'),
                        25356257,
                        [
                            "name" => request('name'),
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

}


<?php

namespace App\Http\Controllers;

use App\Events\TicketcreateEvent;
use App\Models\Log;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        $id = $request->user()->id;
        $tickets = Ticket::where('user_id', $id)->OrderBy('id', 'desc')->paginate(5);
        return response()->json(['response' => 'success', 'tickets' => $tickets]);
    }

    public function store(Request $request)
    {
        $form = $request->validate([
            'title' => ['required', 'min:3', 'max:50'],
            'description' => ['required', 'min:3', 'max:255']
        ]);

        if ($form) {
            //  Random Ticket
            $string     = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789';
            $shuffle    = str_shuffle($string);
            $ticket       = '#' . substr($shuffle, 0, 12);
            $form['ticket'] = $ticket;

            $form['user_id'] = $request->user()->id;

            $ticketCreate = Ticket::create($form);
            if ($ticketCreate) {
                $logCreate = Log::create(['title' => 'created','user_id'=>$request->user()->id,'token' => $ticketCreate['ticket']]);
                event(new TicketcreateEvent($ticketCreate['ticket']));
                if ($logCreate) return response()->json(['response' => 'success']);
                else return response()->json(['response' => 'error']);
            }
        }
    }


    public function edit(Request $request){

        $ticket = Ticket::find($request->id);
        if($ticket['status'] == 0 || $ticket['status'] == 1){
            $form = $request->validate([
                'title' => ['required', 'min:3', 'max:50'],
                'description' => ['required', 'min:3', 'max:255']
            ]);

            if($ticket && $form){
                $ticket->title = $form['title'];
                $ticket->description = $form['description'];
                $ticket->status = 0;
                $ticket->save();

                $logCreate = Log::create(['title' => 'updated','user_id'=>$request->user()->id,'token' => $ticket['ticket']]);
                if ($logCreate) return response()->json(['response' => 'success']);
                else return response()->json(['response' => 'error']);

                return response()->json(['response' => 'success']);
            }
        }
        else return response()->json(['response' => 'error']);
    }

    public function show($id)
    {
        $tickets = Ticket::find($id);
        return response()->json(['response' => 'success', 'tickets' => $tickets]);
    }

    public function destory(Request $request)
    {
        $token = Ticket::find($request->id);
        $delete = $token->delete();
        if ($delete) {
            $logCreate = Log::create(['title' => 'deleted','user_id'=>$request->user()->id,'token' => $token['ticket']]);
            if ($logCreate) return response()->json(['response' => 'success']);
            else return response()->json(['response' => 'error']);
        }
        else return response()->json(['response' => 'Id not found.']);
    }
}

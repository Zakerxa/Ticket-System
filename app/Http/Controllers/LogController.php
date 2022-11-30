<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $log = Log::where('user_id',$request->user()->id)->OrderBy('id', 'desc')->get();
        if($log) return response()->json(['response' => 'success','log' => $log]);
        else return response()->json(['response' => 'error','log' => $log]);
    }

    public function destory($id)
    {
        $delete = DB::table('logs')->where('user_id',$id)->delete();
        if ($delete) return response()->json(['response' => 'success','log' => $delete]);
        else return response()->json(['response' => 'error','log' => $delete]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function upload(Request $request, Ticket $ticket)
    {
        $validator  = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,png|max:3000'
        ]);

        if (!$validator->fails()) {
            $path = $request->file('file')->store('public/images/tickets/' . $ticket->id);
            $file = File::create([
                'name'          => explode('/', $path)[4],
                'uploader_id'   => $request->user()->id,
                'ticket_id'     => $ticket->id
            ]);
            return response()->json(asset('images/tickets/' . $ticket->id . '/' . $file->name), 200);
        }
    }
}

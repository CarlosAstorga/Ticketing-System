<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function upload(Request $request, Ticket $ticket)
    {
        $validator  = Validator::make($request->all(), [
            'file' => 'image|mimes:jpeg,png|max:3000'
        ]);

        if (!$validator->fails()) {
            $path = $request->file('file')->store('public/images/tickets/' . $ticket->id);
            $file = File::create([
                'name'          => explode('/', $path)[4],
                'uploader_id'   => $request->user()->id,
                'ticket_id'     => $ticket->id
            ]);
            return response()->json($file, 200);
        } else {
            return response()->json($validator->messages(), 400);
        }
    }

    public function destroy(File $file)
    {
        $file->delete();
        return response()->json(
            Storage::delete('public/images/tickets/' . $file->ticket_id . '/' . $file->name),
            200
        );
    }

    public function download(File $file)
    {
        return Storage::download('public/images/tickets/' . $file->ticket_id . '/' . $file->name);
    }

    public function updateAvatar(Request $request, User $user)
    {
        $validator  = Validator::make($request->all(), [
            'file' => 'image|mimes:jpeg,png|max:3000'
        ]);

        if (!$validator->fails()) {
            $path = $request->file('file')->store('public/images/avatar/' . $user->id);
            $user->profile_picture = explode('/', $path)[4];
            if ($user->save()) return redirect('/user/profile');
        } else {
            return redirect('/user/profile')->withErrors($validator, 'avatar');
        }
    }
}

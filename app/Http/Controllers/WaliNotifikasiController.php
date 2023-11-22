<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaliNotifikasiController extends Controller
{
    public function update(Request $request, String $id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->first()?->markAsRead();
        flash()->addSuccess('Data sudah diubah.');
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Settings;

class SettingController extends Controller
{

    public function create()
    {
        $lists = [
            'vendor.pagination.bootstrap-5' => 'vendor.pagination.bootstrap-5',
            'vendor.pagination.bootstrap-4' => 'vendor.pagination.bootstrap-4',
            'vendor.pagination.custom' => 'vendor.pagination.custom',
            'vendor.pagination.simple-bootstrap-4' => 'vendor.pagination.simple-bootstrap-4',
            'vendor.pagination.simple-default' => 'vendor.pagination.simple-default',
            'vendor.pagination.simple-tailwind' => 'vendor.pagination.simple-tailwind'
        ];

        $data = [
            'title'         => 'Pengaturan Aplikasi',
            'route'         => 'setting.store',
            'method'        => 'POST',
            'button'        => 'UPDATE',
            'lists'         => $lists
        ];
        return view('operator.setting_form', $data);
    }

    public function store(Request $request)
    {
        $dataSetting = $request->except('_token');
        settings()->set($dataSetting);
        return back()->with('success', 'Data berhasil di simpan.');
    }
}

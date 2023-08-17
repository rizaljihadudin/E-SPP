<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    private $viewIndex      = 'profile_index';
    private $viewCreate     = 'profile_form';
    private $routePrefix    = 'wali.profile';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model'     =>  User::where('id', Auth::user()->id)->firstOrFail(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . '.store',
            'button'    => 'UPDATE',
            'title'     => 'Update Profile'
        ];
        return view('wali.' . $this->viewCreate, $data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $requestData = $request->validate([
                'name'      => 'required',
                'email'     => 'required|unique:users,email,' . $id,
                'no_hp'     => 'required|unique:users, no_hp,' . $id,
                'no_hp'     => 'numeric|min:11',
                'password'  => 'nullable'
            ]);
            $model = User::findOrFail($id);
            if($requestData['password']){
                $requestData['password'] = bcrypt($requestData['password']);
            }else{
                unset($requestData['password']);
            }
            $model->fill($requestData);
            $model->save();
            flash()->addSuccess('Data berhasil di update!');
        } catch (\Throwable $th) {
            flash()->addError($th->getMessage());
        }
        
        return back();
    }
}

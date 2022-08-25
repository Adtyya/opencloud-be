<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeResource;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employe::with('company')->orderBy("created_at", "DESC");
        return EmployeResource::collection($data->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "firstname" => "required|min:1",
            "lastname" => "required|min:1",
            "email" => "nullable|email",
            "phone" => "nullable|string|min:8|max:13",
            "company_id" => "required"
        ]);
        $data = Employe::create($validated);
        return response()->json([
            "success" => true,
            "message" => "New employe added"
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function show(Employe $employe)
    {
        $employe->load('company');
        return new EmployeResource($employe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function edit(Employe $employe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {
        $request->validate([
            "firstname" => "required|min:1",
            "lastname" => "required|min:1",
            "email" => "nullable|email",
            "phone" => "nullable|string|min:8|max:13"
        ]);
        $employe->fill([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "phone" => $request->phone
        ]);
        $employe->save();
        return response()->json([
            "msg" => "Data updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employe $employe)
    {
        $employe->delete();
        return response()->json([
            "msg" => "Deleted"
        ]);
    }
}

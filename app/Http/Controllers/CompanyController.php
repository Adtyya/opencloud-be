<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::with('employe')->orderBy("created_at", "DESC");
        return CompanyResource::collection($data->paginate(10))->response();
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
        $data = $request->validate([
            "name" => "required|min:2",
            "logo" => "nullable|file|max:3333|mimes:jpg,jpeg,png,gif",
            "website" => "nullable|url"
        ]);
        
        if($request->file("logo")){
            $logo = $request->file("logo")->getClientOriginalName();
            $request->file("logo")->storeAs("public/images", $logo);
            $store = Company::create([
                "name" => $request->name,
                "website" => $request->website,
                "logo" => $logo
            ]);
            return response()->json([
                "success" => true,
                "message" => "Data added"
            ]);
        }
        $store = Company::create([
            "name" => $request->name,
            "website" => $request->website,
            "logo" => $request->logo
        ]);
        return response()->json([
            "success" => true,
            "message" => "Data added"
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            "name" => "required|min:2",
            "logo" => "nullable|file|max:3333|mimes:jpg,jpeg,png,gif",
            "website" => "nullable|url"
        ]);
        if($request->file("logo")){
            $logo = $request->file("logo")->getClientOriginalName();
            $path = $request->file("logo")->storeAs("public/images", $logo);
            $oldName = $company->logo;
            Storage::disk('public')->delete('/images/'.$oldName);
            $company->fill([
                "name" => $request->name,
                "logo" => $logo,
                "website" => $request->website
            ]);
            $company->save();
            return response()->json([
                "message" => "edited and old picture deleted"
            ]);
        }
        $company->fill([
            "name" => $request->name,
            "logo" => $company->logo,
            "website" => $request->website
        ]);
        $company->save();
        return response()->json([
            "message" => "edited"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        Storage::disk("public")->delete('/images/'.$company->logo);
        return response()->json([
            "msg" => "success"
        ]);
    }
}

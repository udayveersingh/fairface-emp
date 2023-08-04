<?php

namespace App\Http\Controllers;

use App\Models\Annoucement;
use Illuminate\Http\Request;

class AnnoucementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Annoucement';
        $announcements = Annoucement::latest()->get();
        return view('backend.announcement',compact('title','announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Annoucement::create($request->all());
        return back()->with('success',"Announcement has been added");    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annoucement  $annoucement
     * @return \Illuminate\Http\Response
     */
    public function show(Annoucement $annoucement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Annoucement  $annoucement
     * @return \Illuminate\Http\Response
     */
    public function edit(Annoucement $annoucement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annoucement  $annoucement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Annoucement $annoucement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annoucement  $annoucement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annoucement $annoucement)
    {
        //
    }
}

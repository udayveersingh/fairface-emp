<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyDocument;
use Illuminate\Http\Request;

class CompanyDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'company-document';
        $data['company_documents'] = CompanyDocument::latest()->get();
        return view('backend.company-document.create', $data);
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
        $request->validate([
            'document_name' => 'required',
        ]);

        $imageName = Null;
        if ($request->hasFile('attachment')) {
            $imageName = time() . '.' . $request->attachment->extension();
            $request->attachment->move(public_path('storage/company/document/'.$request->input('document_name').'/'), $imageName);
        }

        $company_document = new CompanyDocument();
        $company_document->name = $request->input('document_name');
        $company_document->attachment = $imageName;
        $company_document->save();
        return back()->with('success', 'Company document has been created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'document_name' => 'required',
        ]);
        $company_document = CompanyDocument::find($request->id);  

        $imageName = Null;
        if ($request->hasFile('attachment')) {
            $imageName = time() . '.' . $request->attachment->extension();
            $request->attachment->move(public_path('storage/company/document/'.$request->input('document_name').'/'), $imageName);
        }

        $company_document->name = $request->input('document_name');
        $company_document->attachment = $imageName;
        $company_document->save();
        return back()->with('success', 'Company document has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $company_document = CompanyDocument::find($request->id);
        $company_document->delete();
        return back()->with('success',"Company Document has been deleted successfully!!");
    }
}

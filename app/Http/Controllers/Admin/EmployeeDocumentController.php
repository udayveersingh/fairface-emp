<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;

class EmployeeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = "Employee document";
        $employee_documents = EmployeeDocument::get();
        return view('backend.employee-document', compact('title', 'employee_documents', 'empId'));
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
        $this->validate($request, [
            'name' => 'required',
            'attachment' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $file = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->extension();
            $file->move(public_path('storage/documents/employee/' . $request->emp_id), $file_name);
        }
        EmployeeDocument::create([
            'employee_id' => $request->emp_id,
            'name'        => $request->name,
            'attachment' => $file_name,
        ]);

        $notification = notify('Employee document has been added');
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validate($request, [
            'name' => 'required',
            'attachment' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $file = null;
        $file_name = "";
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->extension();
            $file->move(public_path('storage/documents/employee/' . $request->emp_id), $file_name);
        }

        $Employee_document = EmployeeDocument::find($request->id);
        $Employee_document->update([
            'employee_id' => $request->emp_id,
            'name'        =>  $request->name,
            'attachment' => $file_name,
        ]);
        $notification = notify('Employee documents has been updated');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_document = EmployeeDocument::find($request->id);
        $employee_document->delete();
        return back()->with('success', "Employee document has been deleted.");
    }
}

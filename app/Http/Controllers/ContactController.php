<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Excel;
use Flash;
use Session;
use App\imports\ContactImport;
use Yajra\Datatables\Datatables;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    public function datatable()
    {   
        $contact_details = Contact::get();

        return Datatables::of($contact_details)
            ->addIndexColumn()
            ->make(true);
    }
    
    /**
     * create
     *
     * @return void
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx, csv',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error','Please provide correct file');        
        }else{
            Excel::import(new ContactImport, $request->file);
            return redirect()->back()->with('success', 'File Imported Successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:120|',
            'last_name' => 'required|max:120|',
            'phone_no' => 'required|min:11|numeric'
        ]);
        if (!$validator->fails()) {
            if(Contact::create($request->all())){
                
                return back()->with('success','Contact created successfully!');
            }else{
                return back()->with('error','Failed to create contact!'); 
            }
        }else{
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        return view('contact.edit', compact('contact'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'phone_no' => 'required|min:11|numeric'
        ]);

        if (!$validator->fails()) {
            
            $contact = Contact::findOrFail($id);

            $contact->fill(
                array(
                    'first_name' => $request->first_name, 
                    'last_name' => $request->last_name,
                    'phone_no' => $request->phone_no
                )
            );

            if($contact->save()){
                return back()->with('success','Contact updated successfully!');  
            }
            else{
                return back()->with('error','Failed to update contact!'); 
            }
        } 
        else {
            return redirect()->back()->with('error', 'Contact failed to update.')
                        ->withErrors($validator)
                        ->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        if( $contact->delete() ) {

            return 'success';
        } else {
            return 'error';
        }
    }
}

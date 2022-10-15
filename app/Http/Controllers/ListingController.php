<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // show all listing
    public function index(){
            return view('listings/index', ['listings'=> Listing::latest()->filter(request(['tag', 'search']))->paginate(4)]);       
    }
    // show one list
    public function show(Listing $listing) { 
            return view('listings/show',['list'=> $listing]);
    }
    // create jobb
    public function create() { 
        return view('listings/create');
   }
   // store data
   public function store(Request $request){
        $formField = $request->validate([
                'title'=> 'required',
                'email'=> ['required','email'],
                'company'=> 'required',
                'location'=> 'required',
                'website'=> 'required',
                'tags'=> 'required',
                'description'=> 'required',
                
        ]);
        if($request->hasFile('logo')){
                $formField['logo']= $request->file('logo')->store('logos', 'public');
        }
        $formField['user_id'] = auth()->id();
        Listing::create($formField);
        return redirect('/')->with('message', 'Job created Successfully!');
   }
   //Edit Data
   public function edit(Listing $listing){
        return view('listings.edit', ['listing'=>$listing]);
   }
   // Update Data
   public function update(Request $request, Listing $listing){
        // Makr sure logged in user is owner
        if($listing->user_id != auth()->id()){
                abort(403, 'Unauthorizeed Action');
        }
        $formField = $request->validate([ 
                'title'=> 'required',
                'email'=> ['required','email'],
                'company'=> 'required',
                'location'=> 'required',
                'website'=> 'required',
                'tags'=> 'required',
                'description'=> 'required',
                
        ]);
        if($request->hasFile('logo')){
                $formField['logo']= $request->file('logo')->store('logos', 'public');
        }
        $listing->update($formField);
        return back()->with('message', 'Job Updated Successfully!');
   }
   //Delete data 
   public function destroy(Listing $listing){
        // Makr sure logged in user is owner
        if($listing->user_id != auth()->id()){
                abort(403, 'Unauthorizeed Action');
        }
         $listing->delete();
         return redirect('/')->with('message', 'Job deleted Successfully!');
   }
   // Manage Listing function
   public function manage(){
        $user = auth()->user();
        $listings = Listing::where('user_id', 2)->get();
        return view('listings.manage', ['listings'=> $listings]);
   }
}
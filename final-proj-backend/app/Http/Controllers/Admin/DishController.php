<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    
    public function index()
    {
        $user_id = Auth::id();

        $companies = Company::where('user_id', $user_id)->get();
                       

        $company_dishes = [];

        foreach ($companies as $company) {
            $dishes = Dish::where('company_id', $company->id)->orderby('name','asc')->get();

            $company_dishes[$company->name] = $dishes;

        }

        return view('admin.dishes.index', compact('company_dishes'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dish $dish)
    {
        $user_id = Auth::id();

        if($dish->company->user_id !== $user_id)
        {
            abort(403, 'Accesso non autorizzato');
        }
        
        return view('admin.dishes.show', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        //
    }
}

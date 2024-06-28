<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $companies = Company::all();

        return view("admin.companies.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::orderBy("name","asc")->get();

        return view("admin.companies.create", compact("types"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {

        $form_data = $request->validated();// per la validazione

        $form_data['slug'] = Company::getUniqueSlug($form_data['name']);

        if($request->hasFile('image')) {
            $image_path = Storage::disk('public')->put('image', $request->image);
            $form_data['image'] = $image_path;
        }
        
        $new_company = Company::create($form_data);

        if($request->has('types'))
        {
           $new_company->types()->attach($form_data['types']);
        }


        // $new_company->save();


        return to_route("admin.companies.show", $new_company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load(['user', 'user.companies', 'types', 'types.companies']);
        return view('admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $company->load(['types']);
        $types = Type::orderBy("name","asc")->get();

        return view("admin.companies.edit", compact("company", 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $form_data = $request->validated();// per la validazione

        $company->name = $form_data["name"];
        $company->slug = Str::slug($company->name);
        $company->image = $form_data["image"];
        $company->city = $form_data["city"];
        $company->address = $form_data["address"];
        $company->vat_number = $form_data["vat_number"];
        $company->description = $form_data["description"];
        $company->phone_number = $form_data["phone_number"];
        $company->email = $form_data["email"];

        $company->save();

        return to_route("admin.companies.show", $company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return to_route("admin.companies.index");
    }
}

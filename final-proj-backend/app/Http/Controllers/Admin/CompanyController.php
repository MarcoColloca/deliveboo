<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $new_company = Company::create($form_data);

        $new_company->name = $form_data["name"];
        $new_company->slug = Str::slug($new_company->name);
        $new_company->image = $form_data["image"];
        $new_company->city = $form_data["city"];
        $new_company->address = $form_data["address"];
        $new_company->vat_number = $form_data["vat_number"];
        $new_company->description = $form_data["description"];
        $new_company->phone_number = $form_data["phone_number"];
        $new_company->email = $form_data["email"];

        $new_company->type_id = $form_data['type_id'];

        $new_company->save();


        return to_route("admin.companies,show", $new_company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $types = Type::orderBy("name","asc")->get();

        return view("admin.companies.edit", compact("company"));
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

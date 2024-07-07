<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera l'utente attualmente autenticato
        $user = auth()->user();
    
        // Recupera le compagnie associate all'utente
        $companies = Company::where('user_id', $user->id)->get();
    
        // Recupera i piatti associati a queste compagnie
        $dishes = Dish::whereIn('company_id', $companies->pluck('id'))->get();
    
        // Recupera gli ordini che contengono i piatti di queste compagnie
        $orders = Order::whereHas('dishes', function($query) use ($dishes) {
            $query->whereIn('dishes.id', $dishes->pluck('id'));
        })->with('dishes.company')->get();
    
        // Raggruppa gli ordini per nome della compagnia
        $companyOrders = $orders->groupBy(function ($order) {
            return $order->dishes->first()->company->name;
        });
    
        // Passa i dati alla vista usando compact
        return view('admin.orders.index', compact('companies', 'companyOrders'));
    }
    
    



    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return 'Show';
    }


    // Metodo per mostrare gli ordini relativi ad una singola azienda
    public function showOne($company_id, Request $request)
    {
        $user_id = Auth::id();
    
        // Recupera la compagnia specificata
        $company = Company::find($company_id);
    
        if (!$company) {
            abort(404, 'Compagnia non trovata');
        }
    
        if ($company->user_id !== $user_id) {
            abort(403, 'Accesso alla pagina non autorizzato');
        }
    
        // Recupera gli ordini associati ai piatti di questa compagnia
        $orders = Order::whereHas('dishes', function($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->with('dishes')->get();
    
        return view('admin.orders.showOne', compact('company', 'orders'));
    }
    













    /* CRUD INUTILIZZATE */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

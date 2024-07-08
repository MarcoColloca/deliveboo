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
        // Recupero l'utente autenticato
        $user = auth()->user();
        
        // Recupero tutte le compagnie associate all'utente autenticato
        $companies = Company::where('user_id', $user->id)->get();
    
        // Recupero gli ID delle compagnie
        $companyIds = $companies->pluck('id');
        
        // Recupero gli ID dei piatti appartenenti alle compagnie dell'utente
        $dishIds = Dish::whereIn('company_id', $companyIds)->pluck('id');
    
        // Recupero gli ordini che hanno piatti appartenenti alle compagnie dell'utente
        $orders = Order::whereHas('dishes', function ($query) use ($dishIds) {
            $query->whereIn('dishes.id', $dishIds);
        })->with([
            // Aggiungo le le informazioni delle compagnie dei piatti
            'dishes' => function ($query) {
                $query->with('company');
            }
        ])->get();
    
        // Filtro gli ordini per includere solo quelli che contengono piatti delle compagnie dell'utente
        $filteredOrders = $orders->filter(function ($order) use ($companyIds) {
            foreach ($order->dishes as $dish) {
                // Se un piatto non appartiene alle compagnie dell'utente, escludo l'ordine
                if (!$companyIds->contains($dish->company_id)) {
                    return false;
                }
            }
            return true;
        });
    
        // Raggruppo gli ordini per nome della compagnia
        $companyOrders = $filteredOrders->groupBy(function ($order) {
            // Uso il nome della compagnia del primo piatto nell'ordine.
            return $order->dishes->first()->company->name;
        });
    
        // Ritorno le compagnie e gli ordini alla vista
        return view('admin.orders.index', compact('companies', 'companyOrders'));
    }
    
    



    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {   
        // se l'ordine appartiene ad una compagnia, diversa dalla compagnia dell'utente loggato faccio un abort. 
        // l'id dello user sta nella compagnia, io sono in order, devo quindi:
        // se l'ordine è legato a dei piatti che appartengono alla compagnia che non appartiene all'utente loggato facio un abort

        // Recupera l'ID dell'utente autenticato
        $user_id = Auth::id();

        // Recupera gli ID delle compagnie appartenenti all'utente
        $company_ids = Company::where('user_id', $user_id)->pluck('id');

        // Controlla se l'ordine contiene piatti che appartengono a compagnie che non sono dell'utente autenticato
        $belongsToUser = $order->dishes->every(function ($dish) use ($company_ids) {
            return $company_ids->contains($dish->company_id);
        });

        // Se l'ordine contiene piatti di compagnie non appartenenti all'utente, esegui un abort
        if (!$belongsToUser) {
            abort(403, 'Accesso negato. Non puoi visualizzare questo ordine.');
        }

        return view('admin.orders.show', compact('order'));
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
        $orders = Order::whereHas('dishes', function ($query) use ($company_id) {
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

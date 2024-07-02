<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request) {
        $per_page = $request->perPage ?? 10;

        $results = Type::orderBy("created_at","desc")->paginate($per_page);

        return response()->json([
            'success' => true,
            'results'=> $results,

        ]);
       
    }



    
    public function select(Type $type)
    {        

        $type->load('companies', 'companies.types');



        $results = $type;

        
        return response()->json([
            'success' => true,
            'results' => $results
        ]);
       
    }
}

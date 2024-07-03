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



    public function select(Request $request)
    {
        $typeSlugs = $request->input('typeSlugs');
        if (!is_array($typeSlugs)) {
            return response()->json([
                'success' => false,
                'message' => 'typeSlugs should be an array'
            ], 400);
        }
    
        $types = Type::whereIn('slug', $typeSlugs)->with('companies', 'companies.types')->get();
    
        $companies = collect();
        foreach ($types as $type) {
            $companies = $companies->merge($type->companies);
        }
        $companies = $companies->unique('id');
    
        return response()->json([
            'success' => true,
            'results' => ['companies' => $companies]
        ]);
    }
    
}

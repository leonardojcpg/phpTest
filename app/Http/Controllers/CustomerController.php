<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cpf' => 'required|unique:customers',
            'name' => 'required',
            'birth_date' => 'required|date',
            'sex' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);

        Customer::create($data);

        return response()->json(['message' => 'Customer created successfully']);
    }

    public function index()
    {
        $customers = Customer::all();

        return response()->json($customers);
    }

    public function search(Request $request)
    {
        $query = Customer::query();

        if ($request->has('cpf')) {
            $query->where('cpf', $request->input('cpf'));
        }

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('birth_date')) {
            $query->where('birth_date', $request->input('birth_date'));
        }

        if ($request->has('sex')) {
            $query->where('sex', $request->input('sex'));
        }

        if ($request->has('state')) {
            $query->where('state', $request->input('state'));
        }

        if ($request->has('city')) {
            $query->where('city', $request->input('city'));
        }

        $results = $query->get();

        return view('customers.search_results', compact('results'));
    }
}
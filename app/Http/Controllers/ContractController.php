<?php

namespace App\Http\Controllers;

use App\Models\Contract;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::active()->ordered()->get();
        return view('pages.contracts.index', compact('contracts'));
    }
}

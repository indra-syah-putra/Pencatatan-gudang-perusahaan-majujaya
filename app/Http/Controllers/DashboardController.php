<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persediaan;

class DashboardController extends Controller
{
    public function index()
    {
        $inventories = Persediaan::with('barang')->paginate(10);
        return view('dashboard', compact('inventories'));
    }
}
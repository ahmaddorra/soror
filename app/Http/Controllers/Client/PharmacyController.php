<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $limit = (int)$request->input('length');
            $start = (int)$request->input('start');
            $order = $request->input('columns.' . $request->input('order.0.column') . '.data');
            $dir = $request->input('order.0.dir');
            $s = $request->input('search.value');


            $query = Pharmacy::query()->orderBy($order, $dir)->skip($start)->take($limit);
            if ($s != "") {
                $query = $query->where('name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%");
            }
            return response()->datatable($request->input('draw'), $query->count(), Pharmacy::query()->count(), $query->get());
        }

        return view("client.index");
    }

}

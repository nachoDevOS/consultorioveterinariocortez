<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Supplier;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected $storageController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->storageController = new StorageController();
    }

    public function index()
    {
        $this->custom_authorize('browse_incomes');
        return view('administrations.incomes.browse');
    }

    public function list(){
        $this->custom_authorize('browse_incomes');

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;
        $typeIncome = request('typeIncome') ?? null;

        $data = Income::with(['register', 'supplier', 'incomeDetails'=>function($q){
                            $q->where('deleted_at', null);
                        }, 'incomeTransactions'=>function($q){
                            $q->where('deleted_at', null);
                        }])
                        ->withSum(['incomeTransactions as amortization' => function($query) {
                            $query->where('deleted_at', null);
                        }], 'amount')
                       
                        ->where(function($query) use ($search){
                            $query->OrwhereHas('supplier', function($query) use($search){
                                $query->whereRaw($search ? "name like '%$search%'" : 1);
                            })
                            ->OrWhereRaw($search ? "id = '$search'" : 1)
                            ->OrWhereRaw($search ? "observation like '%$search%'" : 1);
                        })
                        ->where('deleted_at', NULL)
                        // ->whereRaw($typeIncome? "typeIncome = '$typeIncome'" : 1)
                        // ->orderBy('status', 'DESC')
                        ->orderBy('id', 'DESC')

                        ->paginate($paginate);
        return view('administrations.incomes.list', compact('data'));
    }

    public function create()
    {
        $this->custom_authorize('browse_incomes');
        $suppliers = Supplier::where('deleted_at', null)->get();
        return view('administrations.incomes.edit-add', compact('suppliers'));
    }


}

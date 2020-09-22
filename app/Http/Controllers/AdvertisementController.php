<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Country;
use App\Currency;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Option;
use App\TransState;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class AdvertisementController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $advertisements = Auth::user()->advertisements()
//            ->with('payment_countries','receiver_countries', 'payment_currencies', 'receiver_currencies')
            ->get()
            ->sortByDesc('updated_at');
        return view('advertisement.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $currency = Currency::select(
            DB::raw("CONCAT(name, '_', slug) AS name"),'id')
            ->where('id', '!=', '2') //create_old
            ->pluck('name', 'id');
        $country = Country::select(
            DB::raw("CONCAT(name, '_', slug) AS name"),'id')
            ->where('id', '!=', '2') //create_old
            ->pluck('name', 'id');

        return view('advertisement.create', compact('currency', 'country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdvertisementRequest $request
     * @return Response
     */
    public function store(StoreAdvertisementRequest $request)
    {
        $advertisement = Auth::user()->advertisements()->create($request->all());
        Session::flash('status', 'آگهی شما ایجاد شد.');
        return redirect(route('advertisement.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Advertisement $advertisement
     * @return Response
     */
    public function show(Advertisement $advertisement)
    {
        $transStates = DB::table('trans_states')->select('id', 'name', 'desc')->orderBy('id')->get();
        $rates = Currency::all()->where('id', '=', $advertisement->p_currency_id)->first();
        $wage = Option::all()->where('key', '=', 'wage')->first();
        return view('advertisement.show', compact('advertisement', 'transStates', 'rates', 'wage'));
    }

    /**
     * Show the form for editing the specified resource.
     * Gate is a policy which authorize the user can update the ad or not.
     *
     * @param Advertisement $advertisement
     * @return Response
     */
    public function edit(Advertisement $advertisement)
    {
        Gate::authorize('update', $advertisement);

        $currency = Currency::select(
            DB::raw("CONCAT(name, '_', slug) AS name"),'id')
            ->where('id', '!=', '2') //create_old
            ->pluck('name', 'id');
        $country = Country::select(
            DB::raw("CONCAT(name, '_', slug) AS name"),'id')
            ->where('id', '!=', '2') //create_old
            ->pluck('name', 'id');

        return view('advertisement.edit', compact('currency', 'country', 'advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreAdvertisementRequest $request
     * @param Advertisement $advertisement
     * @return Response
     */
    public function update(StoreAdvertisementRequest $request, Advertisement $advertisement)
    {
        Gate::authorize('update', $advertisement);
        $advertisement->update($request->toArray());

        Session::flash('status', 'آگهی شما ویرایش شد.');
        return redirect(route('advertisement.index'));
    }

    /**
     * Remove the specified resource from storage.
     * Gate is a policy which authorize the user can delete the ad or not.
     *
     * @param Advertisement $advertisement
     * @return Response
     */
    public function destroy(Advertisement $advertisement)
    {
        Gate::authorize('delete', $advertisement);
        $advertisement->destroy($advertisement->id);
        Session::flash('status', 'آگهی شما حذف شد.');
        return redirect(route('advertisement.index'));
    }

    /**
     * Process advertisement datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function advertisement_data()
    {
//        $advertisements = Advertisement::with('p_country:id,name', 'p_currency:id,name', 'r_country:id,name', 'r_currency:id,name', 'user:id,name');
        $advertisements = DB::table('advertisements')
            ->Join('users', 'user_id', '=', 'users.id')
            ->Join('countries as c', 'p_country_id', '=', 'c.id')
            ->Join('currencies as c1', 'p_currency_id', '=', 'c1.id')
            ->Join('countries', 'r_country_id', '=', 'countries.id')
            ->Join('currencies', 'r_currency_id', '=', 'currencies.id')
            ->select('advertisements.id', 'advertisements.amount_from', 'advertisements.amount_to', 'users.name as name',
                'c.name as p_country', 'c1.name as p_currency', 'countries.name as r_country', 'currencies.name as r_currency');

        return Datatables::of($advertisements)
            ->addColumn('action', function ($advertisements) {
                return '<a href="'.route('advertisement.show', $advertisements->id).'" class="btn btn-xs btn-primary">خرید</a>';
            })
            ->make(true);
    }
}

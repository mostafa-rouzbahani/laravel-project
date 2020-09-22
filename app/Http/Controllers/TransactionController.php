<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Http\Requests\StoreTransactionRequest;
use App\Notifications\TransactionUpdate;
use App\Option;
use App\Transaction;
use App\TransLevel;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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
        $transStates = DB::table('trans_states')->select('name', 'desc')->orderBy('id')->get();
        $transAccepts = DB::table('trans_accepts')->select('name', 'desc')->orderBy('id')->get();

        return view('transactions.index', compact('transStates', 'transAccepts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransactionRequest $request
     * @return Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $transaction = Auth::user()->b_transactions()->create($request->except('wage') + [
            'transaction_id'    => Str::upper(Str::random(10)),
            'transAccept_id'    => 1,
            'wage'              => str_replace(",", "", $request->wage),
            's_user_id'         => Advertisement::findorfail($request->advertisement_id)->user->id,
            's_currency_id'     => Advertisement::findorfail($request->advertisement_id)->p_currency_id,
            's_country_id'      => Advertisement::findorfail($request->advertisement_id)->p_country_id,
            'b_user_id'         => Auth::id(),
            'b_currency_id'     => Advertisement::findorfail($request->advertisement_id)->r_currency_id,
            'b_country_id'      => Advertisement::findorfail($request->advertisement_id)->r_country_id
            ]);
        $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', 'create' ));
        $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', 'create'));
        Session::flash('status', 'درخواست شما ارسال شد.');
        return redirect(route('transactions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function edit(Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        $transLevels = TransLevel::all();
        $currentLevel = $transaction->transLevel_id;
        Auth::user()->unreadNotifications()->where('data->transaction_id', $transaction->id)->update(['read_at' => now()]);
        $options = Option::all()
            ->whereIn('key', ['accountName', 'bankName', 'accountNumber', 'SHABA']);
        return view('transactions.edit', compact('transaction', 'transLevels', 'currentLevel', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        if( $transaction->transAccept_id === 1 && $transaction->s_user_id == Auth::id() && $request->transAccept_id == 'reject' ){
            $transaction->update([
                'transAccept_id'    => 2,
                'transAccept_date'  => Carbon::now()
                ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', 'reject' ));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', 'reject'));
            Session::flash('status', 'درخواست معامله توسط شما رد شد.');
            return redirect(route('transactions.index'));
        }

        elseif( $transaction->transAccept_id === 1 && $transaction->s_user_id == Auth::id() && $request->transAccept_id == 'accept' ){
            $transaction->update([
                    'transAccept_id'    => 3,
                    'transAccept_date'  => Carbon::now(),
                    'transState_id'     => 1,
                    'transLevel_id'     => 1
                ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', 'accept'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', 'accept'));
            Session::flash('status', 'درخواست معامله توسط شما پذیرفته شد.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 2 ){
            Session::flash('status', 'این معامله قبلا رد شده است.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 3 && $transaction->b_user_id == Auth::id() && $transaction->transLevel_id === 1 ){
            $transaction->update([
                'transLevel_id'     => 2
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', '1'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '1'));
            User::all()->where('is_admin', '=', '1')->first()->notify(new TransactionUpdate($transaction,  'admin', '1'));
            Session::flash('status', 'پرداخت پول توسط شما در حال بررسی است.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 3 &&  Auth::user()->isAdmin() && $transaction->transLevel_id === 2 ){
            $transaction->update([
                'admin_money_flag'  => 1,
                'admin_money_date'  => Carbon::now(),
                'transLevel_id'     => 3
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', '2'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '2'));
            Session::flash('status', 'دریافت پول توسط سایت تایید شد.');
            return redirect(route('admin.transactions'));
        }

        elseif( $transaction->transAccept_id === 3 &&  $transaction->b_user_id == Auth::id() && $transaction->transLevel_id === 3 ){
            $transaction->update($request->all() + [
                'transLevel_id'     => 4
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', '3'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '3'));
            Session::flash('status', 'اطلاعات بانکی شما دریافت شد.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 3 &&  $transaction->s_user_id == Auth::id() && $transaction->transLevel_id === 4 ){
            $transaction->update([
                    'transLevel_id'     => 5
                ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', '4'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '4'));
            Session::flash('status', 'تاییدیه پرداخت توسط شما ارسال شد.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 3 &&  $transaction->b_user_id == Auth::id() && $transaction->transLevel_id === 5 ){
            $transaction->update([
                'b_money_flag'  => 1,
                'b_money_date'  => Carbon::now(),
                'transLevel_id'     => 6
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', '5'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '5'));
            Session::flash('status', 'تاییدیه دریافت توسط شما ارسال شد.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 3 &&  $transaction->s_user_id == Auth::id() && $transaction->transLevel_id === 6 ){
            $transaction->update($request->all() + [
                    'transLevel_id'     => 7
                ]);
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '6'));
            User::all()->where('is_admin', '=', '1')->first()->notify(new TransactionUpdate($transaction,  'admin', '6'));
            Session::flash('status', 'اطلاعات بانکی شما دریافت شد.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        elseif( $transaction->transAccept_id === 3 &&  Auth::user()->isAdmin() && $transaction->transLevel_id === 7 ){
            $transaction->update([
                'transLevel_id'     => 8
            ]);
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '7'));
            Session::flash('status', 'ارسال پول توسط سایت تایید شد.');
            return redirect(route('admin.transactions'));
        }

        elseif( $transaction->transAccept_id === 3 &&  $transaction->s_user_id == Auth::id() && $transaction->transLevel_id === 8 ){
            $transaction->update([
                's_money_flag'  => 1,
                's_money_date'  => Carbon::now(),
                'transLevel_id' => 9,
                'transState_id' => 2
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', '8'));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', '8'));
            Session::flash('status', 'تاییدیه دریافت توسط شما ارسال شد.');
            return redirect(route('transactions.edit', $transaction->id));
        }

        else{
            Session::flash('status', 'دستور شما نامعتبر است.');
            return redirect(route('transactions.index'));
        }
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        Gate::authorize('cancel', $transaction);

        if( $transaction->transAccept_id === 3 && $transaction->transLevel_id < 7 && $transaction->cancel_flag === 0 && $request->transCancel == 'true'){
            $transaction->update([
                'cancel_flag'    => 1,
                'cancel_flag_date'  => Carbon::now()
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', 'cancel' ));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', 'cancel'));
            User::all()->where('is_admin', '=', '1')->first()->notify(new TransactionUpdate($transaction,  'admin', 'cancel'));
            Session::flash('status', 'درخواست لغو معامله ارسال شد.');
            return redirect(route('transactions.index'));
        }

        if( $transaction->transAccept_id === 3 && $transaction->transLevel_id < 7 && $transaction->cancel_flag === 1 && $request->transCancel == 'true' &&  Auth::user()->isAdmin()){
            $transaction->update([
                'transState_id'    => 4
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', 'cancel' ));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', 'cancel'));
            Session::flash('status', 'درخواست لغو پذیرفته شد.');
            return redirect(route('admin.transactions'));
        }

        if( $transaction->transAccept_id === 3 && $transaction->transLevel_id < 7 && $transaction->cancel_flag === 1 && $request->transCancel == 'false' &&  Auth::user()->isAdmin()){
            $transaction->update([
                'cancel_flag'    => 2
            ]);
            $transaction->b_user->notify(new TransactionUpdate($transaction,  'buy', 'cancel' ));
            $transaction->s_user->notify(new TransactionUpdate($transaction,  'sell', 'cancel'));
            Session::flash('status', 'درخواست لغو رد شد.');
            return redirect(route('admin.transactions'));
        }

        else{
            Session::flash('status', 'دستور شما نامعتبر است.');
            return redirect(route('transactions.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    /**
     * Process transactions datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function b_datatable_data()
    {
        $b_transactions = DB::table('transactions')
            ->where([
                ['b_user_id', '=', Auth::id()],
                ['transAccept_id', '!=', 2]
            ])
            ->whereRaw('(transState_id is null or transState_id = ?)', [1])
//            ->whereNull('transState_id')
//            ->orwhere('transState_id', '=', 1)
            ->leftJoin('users', 's_user_id', '=', 'users.id')
            ->leftJoin('countries', 's_country_id', '=', 'countries.id')
            ->leftJoin('currencies', 's_currency_id', '=', 'currencies.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_levels', 'transLevel_id', '=', 'trans_levels.id')
            ->select(DB::raw('transactions.id, users.name as name, FORMAT(transactions.s_amount, 2) as s_amount, countries.name as country, currencies.name as currency, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date,transactions.transaction_id, trans_accepts.name as accept, trans_levels.name as level'));

        return Datatables::of($b_transactions)
            ->addColumn('action', function ($b_transactions) {
                return '<a href="'. route('transactions.edit', $b_transactions->id) .'" class="btn btn-xs btn-primary">جزییات</a>';
            })
            ->make(true);
    }

    /**
     * Process transactions datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function s_datatable_data()
    {
        $s_transactions = DB::table('transactions')
            ->where([
                ['s_user_id', '=', Auth::id()],
                ['transAccept_id', '!=', 2]
            ])
            ->whereRaw('(transState_id is null or transState_id = ?)', [1])
            ->leftJoin('users', 'b_user_id', '=', 'users.id')
            ->leftJoin('countries', 's_country_id', '=', 'countries.id')
            ->leftJoin('currencies', 's_currency_id', '=', 'currencies.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_levels', 'transLevel_id', '=', 'trans_levels.id')
            ->select(DB::raw('transactions.id, users.name as name, FORMAT(transactions.b_amount, 2) as b_amount,countries.name as country, currencies.name as currency, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date, transactions.transaction_id, trans_accepts.name as accept, trans_levels.name as level'));

        return Datatables::of($s_transactions)
            ->addColumn('action', function ($s_transactions) {
                return '<a href="'. route('transactions.edit', $s_transactions->id) .'" class="btn btn-xs btn-primary">جزییات</a>';
            })
            ->make(true);
    }

    /**
     * Process transactions datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function f_datatable_data()
    {
        $b_transactions = DB::table('transactions')
            ->where([
                ['b_user_id', '=', Auth::id()],
                ['transAccept_id', '!=', 1]
            ])
            ->whereRaw('(transState_id is null or transState_id != ?)', [1])
            ->leftJoin('users', 's_user_id', '=', 'users.id')
            ->leftJoin('currencies', 's_currency_id', '=', 'currencies.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_states', 'transState_id', '=', 'trans_states.id')
            ->select(DB::raw('transactions.id, transactions.transaction_id, "خرید" as buyOrSell, currencies.name as currency, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date, trans_accepts.name as accept, trans_states.name as state'));

        $s_transactions = DB::table('transactions')
            ->where([
                ['s_user_id', '=', Auth::id()],
                ['transAccept_id', '!=', 1]
            ])
            ->whereRaw('(transState_id is null or transState_id != ?)', [1])
            ->leftJoin('users', 'b_user_id', '=', 'users.id')
            ->leftJoin('currencies', 's_currency_id', '=', 'currencies.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_states', 'transState_id', '=', 'trans_states.id')
            ->select(DB::raw('transactions.id, transactions.transaction_id, "فروش" as buyOrSell , currencies.name as currency, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date, trans_accepts.name as accept, trans_states.name as state'))
            ->union($b_transactions);

        $f_transactions = DB::table(DB::raw("({$s_transactions->toSql()}) as t"))
            ->select(['id', 'transaction_id', 'buyOrSell', 'currency', 'date', 'accept', 'state'])
            ->setBindings([Auth::id(), 1, 1, Auth::id(), 1, 1]);

        return Datatables::of($f_transactions)
            ->addColumn('action', function ($f_transactions) {
                return '<a href="'. route('transactions.edit', $f_transactions->id) .'" class="btn btn-xs btn-primary">جزییات</a>';
            })
            ->make(true);
    }
}

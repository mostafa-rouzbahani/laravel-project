<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Notifications\TicketNotification;
use App\Option;
use App\Ticket;
use App\TicketMessage;
use App\Transaction;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the admin abilities.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Display transaction of site.
     *
     * @return Application|Factory|View
     */
    public function transactions()
    {
        Auth::user()->unreadNotifications()->orwherein('data->flag', ['rcv', 'pay', 'cancel'])->update(['read_at' => now()]);
        return view('admin.transactions');
    }

    /**
     * Display a transaction details.
     *
     * @param Transaction $transaction
     * @return Application|Factory|View
     */
    public function transactionShow(Transaction $transaction)
    {

        return view('admin.transactionShow', compact('transaction'));
    }

    /**
     * Process admin datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function verify_data()
    {
        $transactions = DB::table('transactions')
            ->whereRaw('((transState_id = 1 and transLevel_id = 2) or (transState_id = 1 and transLevel_id = 7) or (transState_id != 4 and cancel_flag = 1))')
            ->leftJoin('users as buyer', 'b_user_id', '=', 'buyer.id')
            ->leftJoin('users as seller', 's_user_id', '=', 'seller.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_states', 'transState_id', '=', 'trans_states.id')
            ->leftJoin('trans_levels', 'transLevel_id', '=', 'trans_levels.id')
            ->select(DB::raw('transactions.id, transactions.transaction_id,FORMAT(transactions.b_amount,2) as b_amount, buyer.name as buyer,
                                   seller.name as seller, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date,
                                   trans_accepts.name as accept,trans_states.name as state,trans_levels.name as level,transactions.transLevel_id,
                                   transactions.cancel_flag'
            ));

        return Datatables::of($transactions)
            ->addColumn('action', function ($transactions) {
                if($transactions->cancel_flag === 1)
                    return '<form method="POST" action="'.route('transactions.cancel', $transactions->id).'">'.csrf_field().method_field('PATCH').'<input type="hidden" name="transCancel" value="true"><button type="submit" class="btn btn-xs btn-warning">تایید لغو</button></form>
                            <form method="POST" action="'.route('transactions.cancel', $transactions->id).'">'.csrf_field().method_field('PATCH').'<input type="hidden" name="transCancel" value="false"><button type="submit" style= "margin-top: 10%" class="btn btn-xs btn-danger">رد لغو</button></form>';
                elseif($transactions->transLevel_id === 2)
                    return '<form method="POST" action="'.route('transactions.update', $transactions->id).'">'.csrf_field().method_field('PATCH').'<button type="submit" class="btn btn-xs btn-success">دریافت پول</button></form>';
                elseif($transactions->transLevel_id === 7)
                    return '<form method="POST" action="'.route('transactions.update', $transactions->id).'">'.csrf_field().method_field('PATCH').'<button type="submit" class="btn btn-xs btn-info">پرداخت پول</button></form>';
            })
            ->editColumn('transaction_id', function($transactions) {
                return '<a href="'. route('admin.transactionShow', $transactions->id) .'" class="simple-text">'. $transactions->transaction_id .'</a>';
            })
            ->rawColumns(['transaction_id', 'action'])
            ->make(true);
    }

    /**
     * Process transactions datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function active_data()
    {
        $transactions = DB::table('transactions')
            ->whereRaw('(transState_id = 1 or transAccept_id = 1)')
            ->leftJoin('users as buyer', 'b_user_id', '=', 'buyer.id')
            ->leftJoin('users as seller', 's_user_id', '=', 'seller.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_states', 'transState_id', '=', 'trans_states.id')
            ->leftJoin('trans_levels', 'transLevel_id', '=', 'trans_levels.id')
            ->select(DB::raw('transactions.id, transactions.transaction_id,FORMAT(transactions.b_amount,2) as b_amount, buyer.name as buyer,
                                   seller.name as seller, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date,
                                   trans_accepts.name as accept,trans_states.name as state,trans_levels.name as level,transactions.transLevel_id,
                                   transactions.cancel_flag'
            ));

        return Datatables::of($transactions)
            ->editColumn('transaction_id', function($transactions) {
                return '<a href="'. route('admin.transactionShow', $transactions->id) .'" class="simple-text">'. $transactions->transaction_id .'</a>';
            })
            ->rawColumns(['transaction_id', 'action'])
            ->make(true);
    }

    /**
     * Process transactions datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function finish_data()
    {
        $transactions = DB::table('transactions')
            ->whereRaw('(transState_id != 1 or transAccept_id = 2)')
            ->leftJoin('users as buyer', 'b_user_id', '=', 'buyer.id')
            ->leftJoin('users as seller', 's_user_id', '=', 'seller.id')
            ->leftJoin('trans_accepts', 'transAccept_id', '=', 'trans_accepts.id')
            ->leftJoin('trans_states', 'transState_id', '=', 'trans_states.id')
            ->leftJoin('trans_levels', 'transLevel_id', '=', 'trans_levels.id')
            ->select(DB::raw('transactions.id, transactions.transaction_id,FORMAT(transactions.b_amount,2) as b_amount, buyer.name as buyer,
                                   seller.name as seller, DATE_FORMAT(transactions.created_at, "%Y-%m-%d") as date,
                                   trans_accepts.name as accept,trans_states.name as state,trans_levels.name as level,transactions.transLevel_id,
                                   transactions.cancel_flag'
            ));

        return Datatables::of($transactions)
            ->editColumn('transaction_id', function($transactions) {
                return '<a href="'. route('admin.transactionShow', $transactions->id) .'" class="simple-text">'. $transactions->transaction_id .'</a>';
            })
            ->rawColumns(['transaction_id', 'action'])
            ->make(true);
    }

    /**
     * Display rates page.
     *
     * @return Application|Factory|View
     */
    public function rates()
    {
        $currencies = Currency::all();
        return view('admin.rates', compact('currencies'));
    }

    /**
     * Process the request for irr_rate of the currency table.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function rateChange(Request $request)
    {
        $request->validate([
            'irr_rate' => 'required|numeric',
        ]);
        $currencies = Currency::all();
        foreach ($currencies as $currency){
            $currency->update([
                'irr_rate'      =>   $request->irr_rate,
                'irr_rate_date' =>   Carbon::now(),
                'exchange'      =>   $request->irr_rate * (1/$currency->usd_rate),
                'exchange_date' =>   Carbon::now(),
            ]);
        }

        return redirect(route('admin.rates'));
    }

    /**
     * Display tickets page.
     *
     * @return Application|Factory|View
     */
    public function tickets()
    {
        return view('admin.tickets');
    }

    /**
     * Process advertisement datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function active_tickets_data()
    {
        $tickets = DB::table('tickets')
            ->where('status', '=', 1)
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->select(DB::raw('tickets.id, users.name as name, tickets.ticket_id, tickets.title, DATE_FORMAT(tickets.created_at, "%Y-%m-%d") as created_at'))
            ->orderByDesc('tickets.created_at')
            ->orderByDesc('tickets.updated_at');
        return Datatables::of($tickets)
            ->addColumn('action', function ($tickets) {
                return '<a href="'.route('admin.ticketShow',$tickets->id).'" class="btn btn-xs btn-primary">مشاهده</a>
                        <form method="POST" action="'.route('admin.ticketClose', $tickets->id).'">'.csrf_field().method_field('PATCH').'<input type="hidden" name="ticketClose" value="true"><button type="submit" style= "margin-top: 10%" class="btn btn-xs btn-danger">بستن</button></form>';
            })
            ->make(true);
    }

    /**
     * Process advertisement datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function finish_tickets_data()
    {
        $tickets = DB::table('tickets')
            ->where('status', '!=', 1)
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->select(DB::raw('tickets.id, users.name as name, tickets.ticket_id, tickets.title, DATE_FORMAT(tickets.created_at, "%Y-%m-%d") as created_at'))
            ->orderByDesc('tickets.created_at')
            ->orderByDesc('tickets.updated_at');


        return Datatables::of($tickets)
            ->addColumn('action', function ($tickets) {
                return '<a href="'.route('admin.ticketShow',$tickets->id).'" class="btn btn-xs btn-primary">مشاهده</a>';
            })
            ->make(true);
    }

    /**
     * Display a ticket details.
     *
     * @param Ticket $ticket
     * @return Application|Factory|View
     */
    public function ticketShow(Ticket $ticket)
    {
        $messages = TicketMessage::all()
            ->where('ticket_id', '=', $ticket->id)
            ->sortByDesc('created_at');
        return view('admin.ticketShow', compact('ticket', 'messages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return Application|RedirectResponse|Redirector
     */
    public function ticketUpdate(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string'
        ]);
        $ticket->messages()->create($request->only(['message']) + [
            'admin' => 1
            ]);
        $ticket->user->notify(new TicketNotification($ticket, 'false'));
        Session::flash('status', 'پیام شما ارسال شد.');
        return redirect(route('admin.ticketShow', $ticket->id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return Application|RedirectResponse|Redirector
     */
    public function ticketClose(Request $request, Ticket $ticket)
    {
        if ($request->ticketClose == true){
            $ticket->update(  [
                    'status' => 2
                ]);
            Session::flash('status', 'تیکت بسته شد.');
            return redirect(route('admin.tickets'));
        }
        Session::flash('status', 'دستور برای تیکت نامعتبر است.');
        return redirect(route('admin.tickets'));
    }

    /**
     * Display options page.
     *
     * @return Application|Factory|View
     */
    public function options()
    {
        $options = Option::all();
        return view('admin.options', compact('options'));
    }

    /**
     * Process the update request for options.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function optionChange(Request $request)
    {
        $request->validate([
            'value' => 'required|string',
        ]);
        $option = Option::where('key', '=', $request->key)->first();
        $option->update(array_filter($request->all()));

        return redirect(route('admin.options'));
    }

}

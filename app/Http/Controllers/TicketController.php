<?php

namespace App\Http\Controllers;

use App\Notifications\TicketNotification;
use App\Ticket;
use App\TicketMessage;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
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
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('ticket.index');
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
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
        ]);
        $ticket = Auth::user()->tickets()->create($request->except(['message']) + [
                'ticket_id'    => Str::upper(Str::random(10)),
            ]);
        $ticket->messages()->create($request->only(['message']));
        $users = User::where('is_admin', '=', 1)->get();
        foreach ($users as $user){
            $user->notify(new TicketNotification($ticket,  'true' ));
        }
        Session::flash('status', 'تیکت شما ایجاد شد.');
        return redirect(route('tickets.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return Application|Factory|View
     */
    public function show(Ticket $ticket)
    {
        Gate::authorize('view', $ticket);
        $messages = TicketMessage::all()
            ->where('ticket_id', '=', $ticket->id)
            ->sortByDesc('created_at');
        return view('ticket.show', compact('ticket', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, Ticket $ticket)
    {
        Gate::authorize('update', $ticket);
        $request->validate([
            'message' => 'required|string'
        ]);
        $ticket->messages()->create($request->only(['message']));
        $users = User::where('is_admin', '=', 1)->get();
        foreach ($users as $user){
            $user->notify(new TicketNotification($ticket,  'true' ));
        }
        Session::flash('status', 'پیام شما ارسال شد.');
        return redirect(route('tickets.show', $ticket->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    /**
     * Process advertisement datatable ajax request.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function ticket_data()
    {
        $tickets = DB::table('tickets')
        ->where('user_id', '=', Auth::id())
        ->select(DB::raw('id, ticket_id, title, IF(status = 1 ,\'در حال بررسی\',\'پایان یافته\') as status, DATE_FORMAT(created_at, "%Y-%m-%d") as created_at'))
        ->orderByDesc('status')
        ->orderByDesc('created_at');

        return Datatables::of($tickets)
            ->addColumn('action', function ($tickets) {
                return '<a href="'.route('tickets.show',$tickets->id).'" class="btn btn-xs btn-primary">مشاهده</a>';
            })
            ->make(true);
    }
}

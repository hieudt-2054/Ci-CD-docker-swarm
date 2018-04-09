<?php

namespace App\Http\Controllers\smstake\senderID;

use App\Http\Controllers\Controller;
use App\Model\senderID\SenderId;
use App\SMS\Requests\SenderID\SenderIDRequest;
use App\SMS\Responsables\SenderID\SenderIDDeleteResponse;
use App\SMS\Responsables\SenderID\SenderIDIndexResponse;
use App\SMS\Services\SenderID\SenderIDService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SenderIDController extends Controller
{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;
    /**
     * @var SenderIDService
     */
    private $senderIDService;

    /**
     * SenderIDController constructor.
     * @param Breadcrumbs     $breadcrumbs
     * @param SenderIDService $senderIDService
     */
    public function __construct(Breadcrumbs $breadcrumbs, SenderIDService $senderIDService)
    {
        $this->breadcrumbs     = $breadcrumbs;
        $this->senderIDService = $senderIDService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = $this->breadcrumbs::render('senderID.index');
        $statuses = [
            '' => 'select',
            1 => 'Waiting for approval',
            2=> 'Assigned',
            3=> 'Approved',
            4=> 'Rejected'
        ];
        $filterArray = [
            '' => 'select',
            '1' => 'senderId',
            '2' => 'createdAt'
        ];

        return view('smstake.sender-id.index', compact('statuses', 'filterArray', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SenderIDRequest $senderIDRequest
     * @return SenderIDIndexResponse|\Illuminate\Http\Response
     */
    public function store(SenderIDRequest $senderIDRequest)
    {
        return new SenderIDIndexResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'senderName' => 'required|alpha|min:6',
            ]
        );
        $senderId              = SenderId::find($id);
        $senderId->sender_name = $request->senderName;
        $senderId->status      = $request->status;
        $senderId->save();

        return redirect()->route('senderID.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return SenderIDDeleteResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return new SenderIDDeleteResponse($id);
    }


    public function findSenderIdByStatus(Request $request)
    {
        if (request()->has('status')) {
            $senderid = SenderId::where('status', request('status'))->paginate(2)
                                ->append('status', request('status'))->toArray();

            return response()->json($senderid);
        } else {
            $senderid = SenderId::paginate(2)->toArray();

            return response()->json($senderid);
        }


        $status = $request->status;
        if ($status == "") {
            $senderid = SenderId::all()->get()->toArray();

            return response()->json($senderid);
        } else {

            $senderid = SenderId::select('id', 'sender_name', 'status', 'created_at')->where('status', $status)->get()->toArray();

            return response()->json($senderid);

        }
        //$senderid = DB::table('sender_ids')->where('status' ,'=', $status )->get();
        //$html = view('smstake/sender-id/senderid_data', compact('senderid'))->render();

        //return  $html;
    }

    /**
     *returns the dataList for the dataTable
     * @param Request $request
     * @return
     */
    public function getDataForDataTable(Request $request)
    {
        $listSenderID = $this->senderIDService->getListForDataTable($request);

        return Datatables::of($listSenderID)
            ->addIndexColumn()
            ->addColumn('status', function ($query) {
                return view('smstake.sender-id.partials.status', ['status' => $query->status]);
            })
            ->addColumn('action', function ($query) {
                return view(
                    'smstake.partials.datatable.action',
                    [
                        'updateFormId' => '',
                        'updateRoute'  => '',
                        'deleteFormId' => 'senderIDDelete',
                        'deleteRoute'  => route('senderID.destroy', $query->id),
                        'columnId'     => $query->id,
                        'option'       => 'delete',
                    ]
                );
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}

<?php

namespace App\Http\Controllers\smstake\quickSMS;

use App\Model\sms\Sms;
use App\SMS\Requests\SMS\QuickSMSRequest;
use App\SMS\Responsables\SMS\SMSStoreResponse;
use App\SMS\Services\Group\GroupService;
use App\SMS\Services\SenderID\SenderIDService;
use App\SMS\Services\SMS\SMSService;
use DateTime;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QuickSMSController extends Controller
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
     * @var GroupService
     */
    private $groupService;
    /**
     * @var SMSService
     */
    private $SMSService;

    /**
     * QuickSMSController constructor.
     * @param Breadcrumbs     $breadcrumbs
     * @param SenderIDService $senderIDService
     * @param GroupService    $groupService
     * @param SMSService      $SMSService
     */
    public function __construct(
        Breadcrumbs $breadcrumbs,
        SenderIDService $senderIDService,
        GroupService $groupService,
        SMSService $SMSService
    ) {
        $this->breadcrumbs     = $breadcrumbs;
        $this->senderIDService = $senderIDService;
        $this->groupService    = $groupService;
        $this->SMSService = $SMSService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = $this->breadcrumbs::render('quickSms.index');
        $senderIds   = $this->senderIDService
            ->senderCreatedByLoggedUser()
            ->where('status', 3)
            ->pluck('sender_name', 'id');
        $groups      = $this->groupService
            ->groupCreatedByLoggedUser()
            ->withCount('contacts')
//            ->having('contacts_count', '>', 0)
            ->get();
        $groupsNew   = [];


        foreach ($groups as $group) {
            $groupsNew[$group->id] = $group->group_name . "[" . $group->contacts_count . "]";
        }
        $groups = collect($groupsNew);

        return view('smstake.quick-sms.index', compact('breadcrumbs', 'senderIds', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuickSMSRequest $quickSMSRequest
     * @return SMSStoreResponse|\SMSStoreResponse
     * @internal param Request $request
     */
    public function store(QuickSMSRequest $quickSMSRequest)
    {
        return new SMSStoreResponse();
    }

    public function list()
    {
        $breadcrumbs = $this->breadcrumbs::render('quickSms.list');

        return view('smstake.quick-sms.list', compact('breadcrumbs'));
    }

    public function getListForDataTable(Request $request)
    {
        $listSMS = $this->SMSService->getListForDataTable($request);

        return DataTables::of($listSMS)
                         ->addIndexColumn()
                         ->editColumn('text_message', function (Sms $sms) {
                             $text_message = '<span>'.str_limit(strip_tags($sms->text_message), 40).'</span>';
                             return $text_message.(strlen(strip_tags($sms->text_message)) > 40 ? '<a href="javascript:;"
                                     class="popovers" data-container="body" role="button" data-html="true"
                                     data-content="'. strip_tags($sms->text_message).'" data-trigger="focus"> </a>' : '');
                         })
                         ->editColumn('status', function (Sms $sms){
                             $scheduledTime = strtotime($sms->date_scheduled);
                             $currentTime = strtotime(now());
                             $difference = $scheduledTime - $currentTime;
                             $status = '<a class="btn btn-danger btn-rounded btn-sm" href="#">
                                            <i class="fa fa-hand-stop-o" aria-hidden="true">&nbsp;&nbsp;</i>STOP</a>';
                             if ($difference <= 0)
                                 $status = "COMPLETED";

                             return $status;
                         })
                         ->rawColumns(['text_message','status'])
                         ->make(true);
    }
}

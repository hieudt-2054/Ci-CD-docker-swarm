<?php

namespace App\Http\Controllers\smstake\group;

use App\Http\Controllers\Controller;
use App\Model\group\Group;
use App\SMS\Constants\DBTable;
use App\SMS\Requests\Groups\GroupRequest;
use App\SMS\Responsables\Group\GroupDeleteResponse;
use App\SMS\Responsables\Group\GroupIndexResponse;
use App\SMS\Responsables\Group\GroupUpdateResponse;
use App\SMS\Services\Group\GroupService;
use Carbon\Carbon;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GroupController extends Controller
{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;
    /**
     * @var GroupService
     */
    private $groupService;

    /**
     * GroupController constructor.
     * @param Breadcrumbs  $breadcrumbs
     * @param GroupService $groupService
     */
    public function __construct(Breadcrumbs $breadcrumbs, GroupService $groupService)
    {
        $this->breadcrumbs  = $breadcrumbs;
        $this->groupService = $groupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = $this->breadcrumbs::render('group.index');

        $groups = Group::all();

        return view('smstake.group.index', compact('groups', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('smstake.group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupRequest $groupRequest
     * @return GroupIndexResponse
     * @internal param Request $request
     */
    public function store(GroupRequest $groupRequest)
    {
        return new GroupIndexResponse();
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
        $group = Group::find($id);

        return view('smstake.group.edit', compact('group'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $groupRequest
     * @param  int         $id
     * @return GroupUpdateResponse
     * @internal param Request $request
     */
    public function update(GroupRequest $groupRequest, $id)
    {
        return new GroupUpdateResponse($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return GroupDeleteResponse
     */
    public function destroy($id)
    {
        return new GroupDeleteResponse($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDataForDataTable(Request $request)
    {
        $listGroup = $this->groupService->getListForDataTable($request);

        return Datatables::of($listGroup)
                         ->addIndexColumn()
                         ->addColumn(
                             'action',
                             function ($query) {
                                 return view(
                                     'smstake.partials.datatable.action',
                                     [
                                         'updateFormId' => 'updateGroupForm',
                                         'updateRoute'  => route('group.edit', $query->id),
                                         'deleteFormId' => 'deleteGroupForm',
                                         'deleteRoute'  => route('group.destroy', $query->id),
                                         'columnId'     => $query->id,
                                         'option'       => 'both',
                                     ]
                                 );
                             }
                         )
                         ->editColumn(
                             'created_at',
                             function ($query) {
                                 return Carbon::parse($query->created_at)->format('d/m/Y');
                             }
                         )
                         ->rawColumns(['action'])
                         ->make(true);
    }

    /**
     * Populates a new add form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddForm()
    {
        return view('smstake.group.create');
    }
}

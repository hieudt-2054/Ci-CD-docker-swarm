<?php

namespace App\Http\Controllers\smstake\contact;

use App\Http\Controllers\Controller;
use App\Model\contacts\Contact;
use App\Model\group\Group;
use App\SMS\Requests\Contacts\ContactRequest;
use App\SMS\Responsables\Contact\ContactDeleteResponse;
use App\SMS\Responsables\Contact\ContactEditResponse;
use App\SMS\Responsables\Contact\ContactIndexResponse;
use App\SMS\Responsables\Contact\ContactMultiDeleteResponse;
use App\SMS\Services\Contact\ContactService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;
    /**
     * @var ContactService
     */
    private $contactService;

    /**
     * ContactController constructor.
     * @param Breadcrumbs    $breadcrumbs
     * @param ContactService $contactService
     */
    public function __construct(Breadcrumbs $breadcrumbs, ContactService $contactService)
    {
        $this->breadcrumbs    = $breadcrumbs;
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = $this->breadcrumbs::render('contact.index');
        $groups      = Group::where('user_id', auth()->user()->id)->pluck('group_name', 'id');
        $contacts    = Contact::with('group')->get();

        return view('smstake.contact.index', compact('groups', 'contacts', 'breadcrumbs'));
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
     * @param ContactRequest $request
     * @return ContactIndexResponse|\Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        return new ContactIndexResponse();
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
     * @return ContactEditResponse
     */
    public function edit($id)
    {
        $groups   = Group::where('user_id', auth()->user()->id)->pluck('group_name', 'id');
        $contacts = Contact::with('group')->get();
        $contact  = Contact::find($id);

        return view('smstake.contact.edit', compact('contact', 'groups', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $contactRequest
     * @param  int           $id
     * @return ContactEditResponse
     */
    public function update(ContactRequest $contactRequest, $id)
    {
        return new ContactEditResponse($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return ContactDeleteResponse
     */
    public function destroy($id)
    {
        return new ContactDeleteResponse($id);
    }

    /**
     *returns the dataList for the dataTable
     * @param Request $request
     * @return
     */
    public function getDataForDataTable(Request $request)
    {
        $listContacts = $this->contactService->getListForDataTable($request);

        return Datatables::of($listContacts)
                         ->addIndexColumn()
                         ->addColumn(
                             'action',
                             function ($query) {
                                 return view(
                                     'smstake.partials.datatable.action',
                                     [
                                         'updateFormId' => 'updateContactForm',
                                         'updateRoute'  => route('contact.edit', $query->id),
                                         'deleteFormId' => 'deleteContactForm',
                                         'deleteRoute'  => route('contact.destroy', $query->id),
                                         'columnId'     => $query->id,
                                         'option'       => 'both',
                                     ]
                                 );
                             }
                         )
                         ->addColumn(
                             'checkbox',
                             function ($target) {
                                 return view(
                                     'smstake.partials.datatable.checkbox',
                                     [
                                         'rowId'   => $target->id,
                                         'groupId' => $target->group_id,
                                     ]
                                 );
                             }
                         )
                         ->rawColumns(['action', 'checkbox'])
                         ->make(true);
    }

    public function getAddForm()
    {
        $groups   = Group::where('user_id', auth()->user()->id)->pluck('group_name', 'id');
        $contacts = Contact::with('group')->get();

        return view('smstake.contact.create', compact('groups', 'contacts'));
    }

    public function getEditForm()
    {
        $groups   = Group::pluck('group_name', 'id');
        $contacts = Contact::with('group')->get();

        return view('smstake.contact.edit', compact('groups', 'contacts'));
    }

    /**
     * @param Request $request
     * @return ContactMultiDeleteResponse
     */
    public function multiDelete(Request $request)
    {
        return new ContactMultiDeleteResponse($request->input('delete'));
    }

    public function listContactOfGroup($groupId)
    {
        $contactList = Group::find($groupId)
                            ->contacts()
                            ->select('mobile_number')
                            ->get();
        //selectRaw('group_concat(mobile_number) as number')

        return $contactList;
    }
}

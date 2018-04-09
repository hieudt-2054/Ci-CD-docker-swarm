<?php

namespace App\Http\Controllers\smstake\draft;

use App\Http\Controllers\Controller;
use App\Model\draft\Draft;
use App\SMS\Constants\Common;
use App\SMS\Library\Translator;
use App\SMS\Requests\Drafts\DraftRequest;
use App\SMS\Responsables\Draft\DraftCreateResponse;
use App\SMS\Responsables\Draft\DraftDestroyResponse;
use App\SMS\Responsables\Draft\DraftUpdateResponse;
use App\SMS\Services\Draft\DraftService;
use Carbon\Carbon;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\TranslateClient;
use Yajra\DataTables\DataTables;

class DraftController extends Controller
{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;
    /**
     * @var DraftService
     */
    private $draftService;
    /**
     * @var Translator
     */
    private $translator;

    /**
     * DraftController constructor.
     * @param Breadcrumbs  $breadcrumbs
     * @param DraftService $draftService
     * @param Translator   $translator
     */
    public function __construct(Breadcrumbs $breadcrumbs, DraftService $draftService, Translator $translator)
    {
        $this->breadcrumbs  = $breadcrumbs;
        $this->draftService = $draftService;
        $this->translator = $translator;
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs::render('draft.index');

        return view('smstake.draft.index', compact('breadcrumbs'));
    }

    /**
     * Stores the draft to the database
     *
     * @param DraftRequest $draftRequest
     * @return DraftCreateResponse
     */
    public function store(DraftRequest $draftRequest)
    {
        return new DraftCreateResponse();
    }


    /**
     * This method generates the respective drafts' edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $draft = Draft::find($id);
        $languages = Common::LANGUAGES;
        return view('smstake.draft.edit', compact('draft', 'languages'));
    }

    /**
     * Updates the request draft
     * @param DraftRequest $draftRequest
     * @param              $id
     * @return DraftUpdateResponse
     */
    public function update(DraftRequest $draftRequest, $id)
    {
        return new DraftUpdateResponse($id);
    }

    public function destroy($id)
    {
        return new DraftDestroyResponse($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDataForDataTable(Request $request)
    {
        $listGroup = $this->draftService->getListForDataTable($request);

        return Datatables::of($listGroup)
                         ->addIndexColumn()
                         ->addColumn(
                             'action',
                             function ($query) {
                                 return view(
                                     'smstake.partials.datatable.action',
                                     [
                                         'updateFormId' => 'updateDraftForm',
                                         'updateRoute'  => route('draft.edit', $query->id),
                                         'deleteFormId' => 'deleteDraftForm',
                                         'deleteRoute'  => route('draft.destroy', $query->id),
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
                         ->editColumn('draft_message', function (Draft $draft) {
                            $draft_message = '<span>'.str_limit(strip_tags($draft->draft_message), 40).'</span>';
                            return $draft_message.(strlen(strip_tags($draft->draft_message)) > 40 ? '<a href="javascript:;"
                                     class="popovers" data-container="body" role="button" data-html="true"
                                     data-content="'. strip_tags($draft->draft_message).'" data-trigger="focus"> </a>' : '');
                         })
                         ->rawColumns(['action','draft_message'])
                         ->make(true);
    }

    /**
     * Populates a new add form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddForm()
    {
        $languages = Common::LANGUAGES;
        return view('smstake.draft.create', compact('languages'));
    }

    /**
     * translates the given sentence into the provided language
     * @return string
     */
    public function translate()
    {
        $content = \request('content') . \request('lastHit');
        return $this->translator->translate(\request('language'), $content);
    }

    /**
     * converts the contents back to english
     * @return string
     */
    public function toggle(){
        $content = strip_tags(\request('content'));
        $currentLang = $this->translator->getTheSource('hi', $content);
        $source = ($currentLang == 'en') ? 'en' : \request('language');
        $target = ($currentLang == 'en') ? \request('language') : 'en';
        return $this->translator->convert($source, $target, $content);
    }

    public function getListOfDrafts()
    {
        return $this->draftService->getListForDataTable();
    }
}

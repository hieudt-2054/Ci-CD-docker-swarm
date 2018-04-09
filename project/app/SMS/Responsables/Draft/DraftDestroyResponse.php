<?php

namespace App\SMS\Responsables\Draft;

use App\Model\draft\Draft;
use Illuminate\Contracts\Support\Responsable;

class DraftDestroyResponse implements Responsable
{
    /**
     * @var
     */
    private $draftId;

    /**
     * DraftDestroyResponse constructor.
     * @param $draftId
     */
    public function __construct($draftId)
    {
        $this->draftId = $draftId;
    }


    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $response = [
            'status'  => 0,
            'message' => 'not initialised',
        ];

        try {
            Draft::destroy($this->draftId);
            $response = [
                'status'  => 200,
                'message' => 'Draft is successfully deleted',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'Failed to delete the draft',
            ];
        }

        return response()->json($response);
    }
}
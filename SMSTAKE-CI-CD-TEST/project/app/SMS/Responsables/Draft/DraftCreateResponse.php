<?php

namespace App\SMS\Responsables\Draft;

use Illuminate\Contracts\Support\Responsable;

class DraftCreateResponse implements Responsable
{

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
            $createdDraft = auth()->user()->drafts()->create($request->all());

            $response = [
                'status'  => 200,
                'message' => 'successfully stored the draft',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to store the draft',
            ];
        }

        return response()->json($response);
    }
}
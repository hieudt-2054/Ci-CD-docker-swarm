<?php

namespace App\SMS\Responsables\Group;

use Illuminate\Contracts\Support\Responsable;

class GroupIndexResponse implements Responsable
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
            $createdGroup = auth()->user()->groups()->create($request->all());

            $response = [
                'status'  => 200,
                'message' => 'successfully stored the group',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to store the group',
            ];
        }

        return response()->json($response);
    }
}
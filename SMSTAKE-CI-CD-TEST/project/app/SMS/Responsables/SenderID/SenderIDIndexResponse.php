<?php

namespace App\SMS\Responsables\SenderID;

use App\Model\senderID\SenderId;
use Illuminate\Contracts\Support\Responsable;

class SenderIDIndexResponse implements Responsable
{
    /**
     * SenderIDIndexResponse constructor.
     */
    public function __construct()
    {
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
            auth()->user()->senderIds()->create($request->all());
            $response = [
                'status'  => 200,
                'message' => 'successfully stored the senderID',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to store the senderID',
            ];
        }

        return response()->json($response);
    }
}

<?php

namespace App\SMS\Responsables\Contact;

use App\Model\contacts\Contact;
use Illuminate\Contracts\Support\Responsable;

class ContactIndexResponse implements Responsable
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
            $contact = auth()->user()->contacts()->create($request->all());
            $response = [
                'status'  => 200,
                'message' => 'successfully stored the contact',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to store the contact',
                'error'=> $exception->getMessage()
            ];
        }

        return response()->json($response);
    }
}
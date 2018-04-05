<?php

namespace App\SMS\Responsables\SMS;

use Exception;
use Illuminate\Contracts\Support\Responsable;

class SMSStoreResponse implements Responsable
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        $response = [
            'status'  => 0,
            'message' => 'not initialised',
        ];
        try {
            auth()->user()->sms()->create($request->all());
            $response = [
                'status'  => 200,
                'message' => 'successfully stored the SMS',
            ];
        } catch (Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to store the SMS',
                'error' => $exception->getMessage()
            ];
        }

        return response()->json($response);
    }

    private function formatData($rawData)
    {
        return [
            'sender_id' => $rawData->sender_id,
            'language' => $rawData->language,
            'text_message' => $rawData->text_message,
            'date_scheduled' => $rawData->date_scheduled
        ];
    }
}
<?php

namespace App\SMS\Responsables\Contact;


use App\Model\contacts\Contact;
use Illuminate\Contracts\Support\Responsable;

class ContactEditResponse implements Responsable
{
    /**
     * @var
     */
    private $id;

    /**
     * ContactEditResponse constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
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
            $data = $this->formatData($request);
            Contact::where('id', $this->id)->update($data);
            $response    = [
                'status'  => 200,
                'message' => 'Contact updated successfully',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'Contact could not be updated',
            ];
        }

        return response()->json($response);
    }

    private function formatData($request)
    {
        return [
            'group_id' => $request->group_id,
            'mobile_number' => $request->mobile_number,
            'contact_name' => $request->contact_name,
            'email' => $request->email
        ];
    }
}
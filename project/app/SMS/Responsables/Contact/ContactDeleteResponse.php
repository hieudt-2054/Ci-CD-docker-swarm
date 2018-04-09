<?php
/**
 * Created by PhpStorm.
 * User: yathu
 * Date: 2/1/18
 * Time: 7:34 AM
 */

namespace App\SMS\Responsables\Contact;


use App\Model\contacts\Contact;
use Illuminate\Contracts\Support\Responsable;

class ContactDeleteResponse implements Responsable
{
    /**
     * @var
     */
    private $contactId;

    /**
     * ContactDeleteResponse constructor.
     * @param $contactId
     */
    public function __construct($contactId)
    {
        $this->contactId = $contactId;
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
            Contact::destroy($this->contactId);
            $response = [
                'status'  => 200,
                'message' => 'Contact is successfully deleted',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'Failed to delete the contact',
            ];
        }

        return response()->json($response);
    }
}
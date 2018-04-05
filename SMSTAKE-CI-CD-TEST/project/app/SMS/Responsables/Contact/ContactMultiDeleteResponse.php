<?php
/**
 * Created by PhpStorm.
 * User: yathu
 * Date: 2/1/18
 * Time: 9:04 PM
 */

namespace App\SMS\Responsables\Contact;


use App\Model\contacts\Contact;
use Illuminate\Contracts\Support\Responsable;

class ContactMultiDeleteResponse implements Responsable
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
            $idList = $request->input('delete');
            $numberOfDeletedRecord = Contact::whereIn('id', $idList)->delete();
            $totalNumberOfRecords  = count($idList);
            if ($totalNumberOfRecords == $numberOfDeletedRecord) {
                $response = [
                    'status'  => 200,
                    'message' => 'successfully deleted '.$numberOfDeletedRecord.' contacts',
                ];
            }
            else{
                $response = [
                    'status'  => 200,
                    'message' => 'failed to delete '.$numberOfDeletedRecord.' contacts',
                ];
            }
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to delete the contacts',
                'error'     => $exception->getMessage()
            ];
        }

        return response()->json($response);
    }
}
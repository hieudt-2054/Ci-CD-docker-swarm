<?php
/**
 * Created by PhpStorm.
 * User: yathu
 * Date: 2/7/18
 * Time: 7:43 AM
 */

namespace App\SMS\Responsables\Draft;


use App\Model\draft\Draft;
use Illuminate\Contracts\Support\Responsable;

class DraftUpdateResponse implements Responsable
{
    /**
     * @var
     */
    private $id;

    /**
     * DraftUpdateResponse constructor.
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
            Draft::find($this->id)->update($data);
            $response    = [
                'status'  => 200,
                'message' => 'Draft updated successfully',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'Draft could not be updated',
            ];
        }

        return response()->json($response);
    }

    private function formatData($request)
    {
        return [
            'draft_message' => $request->draft_message,
        ];
    }
}
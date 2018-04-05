<?php

namespace App\SMS\Responsables\Group;


use App\Model\group\Group;
use Illuminate\Contracts\Support\Responsable;

class GroupUpdateResponse implements Responsable
{
    /**
     * @var
     */
    private $id;

    /**
     * GroupUpdateResponse constructor.
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
            Group::where('id', $this->id)->update($data);
            $response    = [
                'status'  => 200,
                'message' => 'Group updated successfully',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'Group could not be updated',
            ];
        }

        return response()->json($response);


    }

    private function formatData($request)
    {
        return [
            'group_name' => $request->group_name,
        ];
    }
}
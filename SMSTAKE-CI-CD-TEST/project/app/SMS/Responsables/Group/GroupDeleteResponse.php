<?php
/**
 * Created by PhpStorm.
 * User: yathu
 * Date: 2/1/18
 * Time: 6:52 AM
 */

namespace App\SMS\Responsables\Group;


use App\Model\group\Group;
use Illuminate\Contracts\Support\Responsable;

class GroupDeleteResponse implements Responsable
{
    /**
     * @var
     */
    private $groupId;

    /**
     * GroupDeleteResponse constructor.
     * @param $groupId
     */
    public function __construct($groupId)
    {
        $this->groupId = $groupId;
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
            Group::destroy($this->groupId);
            $response = [
                'status'  => 200,
                'message' => 'Group is successfully deleted',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'Failed to delete the group',
            ];
        }

        return response()->json($response);
    }
}
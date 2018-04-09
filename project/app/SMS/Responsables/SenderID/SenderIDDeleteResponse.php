<?php
namespace App\SMS\Responsables\SenderID;


use App\Model\senderID\SenderId;
use Illuminate\Contracts\Support\Responsable;

class SenderIDDeleteResponse implements Responsable
{
    /**
     * @var int
     */
    private $senderID;

    /**
     * SenderIDDeleteResponse constructor.
     * @param int $senderID
     */
    public function __construct(int $senderID)
    {
        $this->senderID = $senderID;
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
            SenderId::destroy($this->senderID);
            $response = [
                'status'  => 200,
                'message' => 'senderID is successfully deleted',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status'  => 500,
                'message' => 'failed to delete the senderID',
            ];
        }

        return response()->json($response);
    }
}
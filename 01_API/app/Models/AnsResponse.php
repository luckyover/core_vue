<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use ResponseCode;

/**
 * @OA\Schema(schema="AnsResponse", description="Data of API will return to client")
 */
class AnsResponse extends JsonResource
{
    public function __construct()
    {
    }

    /**
     * @OA\Property(
     *      description="HTTP response return for client",
     *      example="200"
     * )
     */
    public int $code = ResponseCode::OK;

    /**
     * @OA\Property(
     *      description="Message when error",
     *      example=""
     * )
     */
    public string $message = '';

    /**
     * @OA\Property(
     *      description="Error code when have error, this use to show message in client",
     *      example=""
     * )
     */
    public string $messageNo = '';

    public ?AnsException $dataError = null;

    public ?array $invalidData = null;

    public function toArray(Request $request): array
    {
        if ($this->message == '') {
            $fieldName = '';
            $message = '';
            if ($this->dataError && !isset($this->dataError['line'])) {
                foreach ($this->dataError as $key => $value) {
                    $fieldName = $key;
                    $this->messageNo = $value[0];
                    break;
                }
            }
            if ($this->code != ResponseCode::OK) {
                if (array_key_exists($this->messageNo, SystemMessage::MSG)) {
                    $message = SystemMessage::MSG[$this->messageNo];
                } else {
                    $message = 'エラーが発生しました。もう一度お願いします。';
                }
            }
            $this->message = str_replace('{0}', $fieldName, $message);
        }
        $result = [
            'code' => $this->code,
            'messageNo' => $this->messageNo,
            'message' => $this->message,
        ];
        if (isset($this->data)) {
            $result['data'] = $this->data;
        } else {
            try {
                $result['data'] = $this->data;
            } catch (\Exception $e) {
            }
        }
        if (isset($this->dataError)) {
            $result['dataError'] = $this->dataError;
        }
        if (isset($this->invalidData)) {
            $result['invalidData'] = $this->invalidData;
        }

        return $result;
    }
}

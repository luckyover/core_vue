<?php

namespace App\api\Common\Resources\App;

use AnsResponse;
use App\api\Common\Models\App\AppState;

/**
 * @OA\Schema(schema="AppStateResource")
 */
class AppStateResource extends AnsResponse
{
    public function __construct(AppState $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/AppState")
     */
    public AppState $data;
}

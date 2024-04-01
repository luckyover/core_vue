<?php

namespace App\Models;

use AnsResponse;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(schema="SuggestSearchResource")
 */
class SuggestSearchResource extends AnsResponse
{
    public function __construct(array $data)
    {
        $this->data = collect();
        foreach ($data as $key => $val) {
            $this->data->push(new AnsSuggestSearch($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsSuggestSearch")
     * )
     */
    public Collection $data;
}

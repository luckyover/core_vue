<?php

namespace API\Master\Models\M004;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M004CompanyCombobox",
 *      description="Data detail of company"
 * )
 */
class CompanyCombobox extends AnsModel
{
    /**
     * @OA\Property(example="0")
     */
    public ?int $company_cd = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $company_nm;
}

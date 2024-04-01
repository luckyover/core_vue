<?php

namespace App\Repositories\Implements;

use App\Repositories\IItemRepository;
use App\Utility\Constants;
use App\Utility\ItemClassDiv;
use DbService;

class ItemRepository implements IItemRepository
{
    public function __construct()
    {
    }

    public function find($input): array
    {
        $result = DbService::execSQL('SPC_M101_INQ1', [
            'item_cd' => $input->item_cd,
            'color_cd' => $input->color_cd,
        ]);

        return $result[0][0] ?? [];
    }

    public function refer($input): array
    {
        $result = DbService::execSQL('SPC_M101_INQ4', [
            'item_cd' => $input->inq_item_cd,
            'color_cd' => $input->inq_color_cd,
            'item_class_div' => $input->inq_item_class_div,
        ]);

        return $result[0][0] ?? [];
    }

    public function search($condition)
    {
        $result = DbService::execSQL('SPC_M101_INQ2', [
            'inq_item_cd' => $condition->inq_item_cd,
            'inq_item_nm' => $condition->inq_item_nm,
            'inq_color_cd' => $condition->inq_color_cd,
            'inq_color_nm' => $condition->inq_color_nm,
            'inq_item_class_div' => $condition->inq_item_class_div,
            'inq_process_div' => $condition->inq_process_div,
            'inq_category_div' => $condition->inq_category_div,
            'inq_supplier_cd' => $condition->inq_supplier_cd,
            'remove_process' => ($condition->remove_process ?? false) === true ? 1 : 0,
            'page_size' => $condition->page_size,
            'page' => $condition->page,
            'sort_column' => $condition->sort_column,
            'sort_type' => $condition->sort_type,
        ]);

        return $result;
    }

    public function suggestSearch($input)
    {
        $result = DbService::execSQL('SPC_M101_INQ3', [
            'search' => $input['search'] ?? '',
            'item_class_div' => $input['inq_item_class_div'] ?? 0,
            'rows' => Constants::MAX_ROW_SUGGEST,
        ]);

        return $result[0] ?? [];
    }

    public function save($input): array
    {
        $result = DbService::execSQL('SPC_M101_ACT1', [
            'item_cd' => $input->item_cd,
            'color_cd' => $input->color_cd,
            'item_nm' => $input->item_nm,
            'item_kn_nm' => $input->item_kn_nm,
            'item_ab_nm' => $input->item_ab_nm,
            'color_nm' => $input->color_nm,
            'color_kn_nm' => $input->color_kn_nm,
            'color_ab_nm' => $input->color_ab_nm,
            'item_class_div' => $input->item_class_div,
            'process_div' => $input->process_div,
            'category_div' => $input->category_div,
            'material_div' => $input->material_div,
            'supplier_cd' => $input->supplier_cd,
            'supplier_item_cd' => $input->supplier_item_cd,
            'tax_div' => $input->tax_div,
            'remarks' => $input->remarks,
            'sizes' => $input->item_class_div !== ItemClassDiv::PROCESS ? json_encode($input->sizes) : '',
        ]);
        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }

    public function delete($input): array
    {
        $result = DbService::execSQL('SPC_M101_ACT2', [
            'item_cd' => $input->item_cd,
            'color_cd' => $input->color_cd,
        ]);

        DbService::hasDatabaseError($result);

        return $result[0][0] ?? [];
    }
}

<?php

namespace App\Repositories\Implements;

use App\Repositories\ILibraryRepository;
use DbService;

class LibraryRepository implements ILibraryRepository
{
    public function find(string $name_div, bool $add_empty = false): array
    {
        $result = DbService::execSQL('SPC_M401_INQ1', [
            'name_div' => $name_div,
            'add_empty' => $add_empty ? '0' : '1',
        ]);

        return $result[0] ?? [];
    }

    public function getLibs(array $name_div, bool $add_empty = false): array
    {
        $result = DbService::execSQL('SPC_M401_INQ2', [
            'name_div' => implode(',', $name_div),
        ]);

        $libs = [];
        foreach ($result[0] ?? [] as $idx => $item) {
            if (!isset($libs[$item['name_div']])) {
                $libs[$item['name_div']] = [];
            }
            $libs[$item['name_div']][] = $item;
        }

        foreach ($name_div as $key => $div) {
            if (!isset($libs[$div])) {
                $libs[$div] = [];
            }
            if ($add_empty && (count($libs[$div]) === 0 || array_search('0', array_column($libs[$div], 'name_cd')) === false || array_search(0, array_column($libs[$div], 'name_cd')) === false)) {
                $libs[$div] = array_merge([[
                    'name_div' => $div,
                    'name_cd' => 0,
                    'name' => '',
                    'kn_name' => '',
                    'ab_name' => '',
                    'default_flg' => 0,
                    'sort' => 0,
                ]],
                    $libs[$div]);
            }
        }

        return $libs;
    }
}

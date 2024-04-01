<?php

namespace App\Repositories\Implements;

use App\Repositories\IUserRepository;
use App\Utility\Constants;
use DbService;

class UserRepository implements IUserRepository
{
    public function checkUserSwaggerLogin($account)
    {
        $result = DbService::execSQL('', [], [
            'fake_data' => $account->username === config('l5-swagger.user.username') &&
                $account->password === config('l5-swagger.user.password') ? [
                    [
                        [],
                        [
                            'user_cd' => $account->username,
                        ],
                    ],
                ] : [
                    [
                        [
                            'error_typ' => 1,
                            'message_cd' => '入力されたパスワードは正しくありません',
                        ],
                        [],
                    ],
                ],
        ]);
        DbService::hasDatabaseError($result);

        return $result;
    }

    public function checkUserLogin($account)
    {
        $result = DbService::execSQL('SPC_Login_ACT1', [
            'user_cd' => $account->username,
            'password' => $account->password,
        ]);

        DbService::hasDatabaseError($result);

        return $result;
    }

    public function find($user_cd)
    {
        $result = DbService::execSQL('SPC_M002_INQ1', [
            'user_cd' => $user_cd,
        ]);

        return $result[0][0] ?? [];
    }

    public function search($condition)
    {
        $result = DbService::execSQL('SPC_M002_INQ4', [
            'inq_user_cd' => $condition->inq_user_cd,
            'inq_user_nm' => $condition->inq_user_nm,
            'inq_user_kn_nm' => $condition->inq_user_kn_nm,
            'inq_user_ab_nm' => $condition->inq_user_ab_nm,
            'inq_tel' => $condition->inq_tel,
            'inq_fax' => $condition->inq_fax,
            'inq_mailaddress' => $condition->inq_mailaddress,
            'inq_belong_department_div' => $condition->inq_belong_department_div,
            'page_size' => $condition->page_size,
            'page' => $condition->page,
            'sort_column' => $condition->sort_column,
            'sort_type' => $condition->sort_type,
        ]);

        return $result;
    }

    public function suggestSearch($search)
    {
        $result = DbService::execSQL('SPC_M002_INQ3', [
            'search' => $search,
            'rows' => Constants::MAX_ROW_SUGGEST,
        ]);

        return $result[0] ?? [];
    }

    public function save($user)
    {
        $result = DbService::execSQL('SPC_M002_ACT1', [
            'user_cd' => $user->user_cd,
            'password' => $user->password,
            'user_nm' => $user->user_nm,
            'user_kn_nm' => $user->user_kn_nm,
            'user_ab_nm' => $user->user_ab_nm,
            'tel' => $user->tel,
            'fax' => $user->fax,
            'mailaddress' => $user->mailaddress,
            'belong_department_div' => $user->belong_department_div,
            'authority_div' => $user->authority_div,
        ]);
        DbService::hasDatabaseError($result);

        return $result[0][0] ?? [];
    }

    public function delete($user_cd)
    {
        $result = DbService::execSQL('SPC_M002_ACT2', [
            'user_cd' => $user_cd,
        ]);
        DbService::hasDatabaseError($result);

        return $result[0][0] ?? [];
    }
}

<?php
/**
 * M002Controller
 * Processing for screen M002 ユーザーマスタ
 *
 * 処理概要/process overview  : M002Controller
 * 作成日/create date         : 2024/02/17
 * 作成者/creater             : QuyPN - quypn@ans-asia.com
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @copyright Copyright (c) ANS-ASIA
 *
 * @version 1.0.0
 */

namespace App\api\System\Controllers;

use AnsResponse;
use App\api\System\Actions\M002\DeleteUserAction;
use App\api\System\Actions\M002\GetInitDataAction;
use App\api\System\Actions\M002\GetUserDetailAction;
use App\api\System\Actions\M002\SaveUserAction;
use App\api\System\Actions\M002\SearchUserAction;
use App\api\System\Actions\M002\SuggestSearchAction;
use App\api\System\Requests\M002\SaveUserRequest;
use App\api\System\Requests\M002\SearchUserRequest;
use App\api\System\Resources\M002\InitDataResource;
use App\api\System\Resources\M002\ListOfUsersResource;
use App\api\System\Resources\M002\UserDetailResource;
use App\Http\Controllers\Controller;
use App\Models\SuggestSearchResource;
use Illuminate\Http\Request;

class M002Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get data 所属部門区分 and 権限区分
     * Created: 2024/02/17
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param CheckAccountAction $action
     * @return GetInitDataAction Data 所属部門区分 and 権限区分
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Search users
     * Created: 2024/02/26
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return ListOfUsersResource list of user follow search condition
     */
    public function index(SearchUserRequest $request, SearchUserAction $action): ListOfUsersResource
    {
        return new ListOfUsersResource($action->handle($request->makeCondition()));
    }

    /**
     * Get data for input suggest search user
     * Created: 2024/02/26
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return SuggestSearchResource Data for input suggest search
     */
    public function suggestSearch(Request $request, SuggestSearchAction $action): SuggestSearchResource
    {
        return new SuggestSearchResource($action->handle($request->all()['search'] ?? ''));
    }

    /**
     * Get detail of user
     * Created: 2024/02/17
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param ?string $id
     * @return GetInitDataAction Detail of user
     */
    public function show(?string $id, GetUserDetailAction $action): UserDetailResource
    {
        return new UserDetailResource($action->handle($id));
    }

    /**
     * Save information of user
     * Created: 2024/02/17
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return AnsResponse Result after saved
     */
    public function store(SaveUserRequest $request, SaveUserAction $action): AnsResponse
    {
        $action->handle($request->makeUser());

        return new AnsResponse;
    }

    /**
     * Delete a user
     * Created: 2024/02/17
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param ?string $id
     * @return AnsResponse Result after saved
     */
    public function destroy(?string $id, DeleteUserAction $action): AnsResponse
    {
        $action->handle($id);

        return new AnsResponse;
    }
}

<?php
/**
 * M301Controller
 * Processing for screen M301 商品マスタ
 *
 * 処理概要/process overview  : M301Controller
 * 作成日/create date         : 2024/02/22
 * 作成者/creater             : ThuanNV - thuannv@ans-asia.com
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @copyright Copyright (c) ANS-ASIA
 *
 * @version 1.0.0
 */

namespace App\api\Master\Controllers;

use AnsResponse;
use App\api\Master\Actions\M301\DeleteProcessPriceAction;
use App\api\Master\Actions\M301\GetInitDataAction;
use App\api\Master\Actions\M301\SaveProcessPriceAction;
use App\api\Master\Actions\M301\SearchConditionDetailAction;
use App\api\Master\Requests\M301\DeleteProcessPriceRequest;
use App\api\Master\Requests\M301\SaveProcessPriceRequest;
use App\api\Master\Requests\M301\SearchConditionRequest;
use App\api\Master\Resources\M301\InitDataResource;
use App\api\Master\Resources\M301\ProcessPriceResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class M301Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get data for combobox on screen M301
     * Created: 2024/02/22
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @param CheckAccountAction $action
     * @return InitDataResource Data for M301
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Search condition on screen M301
     * Created: 2024/02/22
     *
     * @return ProcessPriceResource Data for screen M301
     *
     *@author ThuanNV <thuannv@ans-asia.com>
     */
    public function index(SearchConditionRequest $request, SearchConditionDetailAction $action): ProcessPriceResource
    {
        $params = $request->makeKeyRefer();

        return new ProcessPriceResource($action->handle($params));
    }

    /**
     * Save list data process price
     * Created: 2024/02/19
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @return AnsResponse Result after saved
     */
    public function store(SaveProcessPriceRequest $request, SaveProcessPriceAction $action)
    {
        $data = $request->makeData();

        $action->handle($data);

        return new AnsResponse;
    }

    /**
     * Delete list data of process price
     * Created: 2024/02/19
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @param ?string $id
     * @return AnsResponse Result after saved
     */
    public function destroy(?string $id, DeleteProcessPriceRequest $request, DeleteProcessPriceAction $action)
    {
        $data = $request->makeData();
        $action->handle($data);

        return new AnsResponse;
    }
}

<?php
/**
 * M302Controller
 * Processing for screen M302 商品マスタ
 *
 * 処理概要/process overview  : M302Controller
 * 作成日/create date         : 2024/02/22
 * 作成者/creater             : DungNT - quypn@ans-asia.com
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
use App\api\Master\Actions\M302\DeleteProcessCostAction;
use App\api\Master\Actions\M302\GetInitDataAction;
use App\api\Master\Actions\M302\SaveProcessCostAction;
use App\api\Master\Actions\M302\SearchProcessCostAction;
use App\api\Master\Requests\M302\DeleteProcessCostRequest;
use App\api\Master\Requests\M302\SaveProcessCostRequest;
use App\api\Master\Requests\M302\SearchProcessCostRequest;
use App\api\Master\Resources\M302\InitDataResource;
use App\api\Master\Resources\M302\ProcessCostResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class M302Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get data for combobox on screen M302
     * Created: 2024/02/22
     *
     * @author DungNT <quypn@ans-asia.com>
     *
     * @return InitDataResource Data for combobox
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Get data product for screen M302
     * Created: 2024/02/22
     *
     * @author DungNT <quypn@ans-asia.com>
     *
     * @return ProcessCostResource Data for screen M302
     */
    public function index(SearchProcessCostRequest $request, SearchProcessCostAction $action): ProcessCostResource
    {
        return new ProcessCostResource($action->handle($request->makeCondition()));
    }

    /**
     * Save data for product in screen M302
     * Created: 2024/02/22
     *
     * @author DungNT <quypn@ans-asia.com>
     *
     * @return AnsResponse Data after save data
     */
    public function store(SaveProcessCostRequest $request, SaveProcessCostAction $action): AnsResponse
    {
        $action->handle($request->makeData());

        return new AnsResponse;
    }

    /**
     * Delete a product
     * Created: 2024/02/22
     *
     * @author DungNT <quypn@ans-asia.com>
     *
     * @param DeleteProcessCostRequest $action
     * @param ?string $id
     * @return AnsResponse Data after delete data
     */
    public function destroy(?string $id, DeleteProcessCostRequest $request, DeleteProcessCostAction $action): AnsResponse
    {
        $action->handle($request->makeData());

        return new AnsResponse;
    }
}

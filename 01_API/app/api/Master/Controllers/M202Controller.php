<?php
/**
 * M202Controller
 * Processing for screen M202 商品原価マスタ
 *
 * 処理概要/process overview  : M202Controller
 * 作成日/create date         : 2024/02/22
 * 作成者/creater             : hainn - hainn@ans-asia.com
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
use App\api\Master\Actions\M202\DeleteProductCostAction;
use App\api\Master\Actions\M202\SaveProductCostAction;
use App\api\Master\Actions\M202\SearchProductCostAction;
use App\api\Master\Requests\M202\DeleteProductCostRequest;
use App\api\Master\Requests\M202\SaveProductCostRequest;
use App\api\Master\Requests\M202\SearchProductCostRequest;
use App\api\Master\Resources\M202\ProductCostResource;
use App\Http\Controllers\Controller;

class M202Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Search product cost
     * Created: 2024/02/24
     *
     * @author Hainn <Hainn@ans-asia.com>
     *
     * @return ProductCostResource of product cost
     */
    public function index(SearchProductCostRequest $request, SearchProductCostAction $action): ProductCostResource
    {
        return new ProductCostResource($action->handle($request->makeCondition()));
    }

    /**
     * Save data for product cost
     * Created: 2024/02/22
     *
     * @author Hainn <Hainn@ans-asia.com>
     *
     * @return AnsResponse Data after save data
     */
    public function store(SaveProductCostRequest $request, SaveProductCostAction $action): AnsResponse
    {
        $action->handle($request->makeCondition());

        return new AnsResponse;
    }

    /**
     * Delete list data of product cost
     * Created: 2024/02/22
     *
     * @author HaiNN <Hainn@ans-asia.com>
     *
     * @param ?string $id
     * @return AnsResponse Result after deleted
     */
    public function destroy(?string $id, DeleteProductCostRequest $request, DeleteProductCostAction $action)
    {
        $action->handle($request->makeCondition());

        return new AnsResponse;
    }
}

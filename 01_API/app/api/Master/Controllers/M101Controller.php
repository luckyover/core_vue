<?php
/**
 * M101Controller
 * Processing for screen M101 商品マスタ
 *
 * 処理概要/process overview  : M101Controller
 * 作成日/create date         : 2024/02/22
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

namespace App\api\Master\Controllers;

use AnsResponse;
use App\api\Master\Actions\M101\DeleteItemAction;
use App\api\Master\Actions\M101\GetInitDataAction;
use App\api\Master\Actions\M101\GetItemDetailAction;
use App\api\Master\Actions\M101\ReferNameItemAction;
use App\api\Master\Actions\M101\SaveItemAction;
use App\api\Master\Actions\M101\SearchItemAction;
use App\api\Master\Actions\M101\SuggestSearchAction;
use App\api\Master\Requests\M101\DeleteItemRequest;
use App\api\Master\Requests\M101\GetItemDetailRequest;
use App\api\Master\Requests\M101\SaveItemRequest;
use App\api\Master\Requests\M101\SearchItemRequest;
use App\api\Master\Resources\M101\InitDataResource;
use App\api\Master\Resources\M101\ItemDetailResource;
use App\api\Master\Resources\M101\ListOfItemResource;
use App\api\Master\Resources\M101\ReferNameItemResource;
use App\Http\Controllers\Controller;
use App\Models\SuggestSearchResource;
use Illuminate\Http\Request;

class M101Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get data for combobox on screen M101
     * Created: 2024/02/22
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param CheckAccountAction $action
     * @return InitDataResource Data for combobox
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Search items
     * Created: 2024/02/26
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return SearchItemAction Detail of user
     */
    public function index(SearchItemRequest $request, SearchItemAction $action): ListOfItemResource
    {
        return new ListOfItemResource($action->handle($request->makeCondition()));
    }

    /**
     * Get data for input suggest search supplier
     * Created: 2024/02/25
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return SuggestSearchResource Data for input suggest search
     */
    public function suggestSearch(Request $request, SuggestSearchAction $action): SuggestSearchResource
    {
        return new SuggestSearchResource($action->handle($request->all()));
    }

    /**
     * Refer name of product
     * Created: 2024/02/26
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param ?string $id
     * @return ItemDetailResource Data detail of product
     */
    public function refer(?string $id, SearchItemRequest $request, ReferNameItemAction $action): ReferNameItemResource
    {
        $params = $request->makeCondition();
        $params->inq_item_cd = $id;

        return new ReferNameItemResource($action->handle($params));
    }

    /**
     * Get data product for screen M101
     * Created: 2024/02/22
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param ?string $id
     * @return ItemDetailResource Data for screen M101
     */
    public function show(?string $id, GetItemDetailRequest $request, GetItemDetailAction $action): ItemDetailResource
    {
        $params = $request->makeKeyRefer();
        $params->item_cd = $id;

        return new ItemDetailResource($action->handle($params));
    }

    /**
     * Save data for product in screen M101
     * Created: 2024/02/22
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return AnsResponse Data after save data
     */
    public function store(SaveItemRequest $request, SaveItemAction $action): AnsResponse
    {
        $action->handle($request->makeItem());

        return new AnsResponse;
    }

    /**
     * Delete a product
     * Created: 2024/02/22
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param ?string $id
     * @return AnsResponse Data after delete data
     */
    public function destroy(?string $id, DeleteItemRequest $request, DeleteItemAction $action): AnsResponse
    {
        $params = $request->makeKeyRefer();
        $params->item_cd = $id;
        $action->handle($params);

        return new AnsResponse;
    }
}

<?php
/**
 * M005Controller
 * Processing for screen M005 納品先マスタ
 *
 * 処理概要/process overview  : M005Controller
 * 作成日/create date         : 2024/02/19
 * 作成者/creater             : QuanLH - quanlh@ans-asia.com
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
use App\api\Master\Actions\M005\DeleteDeliveryAction;
use App\api\Master\Actions\M005\GetDeliveryDetailAction;
use App\api\Master\Actions\M005\SaveDeliveryAction;
use App\api\Master\Actions\M005\SearchDeliveryAction;
use App\api\Master\Actions\M005\SuggestSearchAction;
use App\api\Master\Requests\M005\SaveDeliveryRequest;
use App\api\Master\Requests\M005\SearchDeliveryRequest;
use App\api\Master\Resources\M005\DeliveryDetailResource;
use App\api\Master\Resources\M005\DeliveryStoreResource;
use App\api\Master\Resources\M005\ListOfDeliveryResource;
use App\Http\Controllers\Controller;
use App\Models\SuggestSearchResource;
use Illuminate\Http\Request;

class M005Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Search delivery
     * Created: 2024/02/27
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return SearchDeliveryAction List data of customer and paging
     */
    public function index(SearchDeliveryRequest $request, SearchDeliveryAction $action): ListOfDeliveryResource
    {
        return new ListOfDeliveryResource($action->handle($request->makeCondition()));
    }

    /**
     * Get data for input suggest search delivery
     * Created: 2024/02/27
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
     * Get detail of delivery
     * Created: 2024/02/19
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @param ?int $id
     * @return GetInitDataAction Detail of delivery
     */
    public function show(?int $id, GetDeliveryDetailAction $action): DeliveryDetailResource
    {
        return new DeliveryDetailResource($action->handle($id));
    }

    /**
     * Save information of Delivery
     * Created: 2024/02/19
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @return AnsResponse Result after saved
     */
    public function store(SaveDeliveryRequest $request, SaveDeliveryAction $action): DeliveryStoreResource
    {
        return new DeliveryStoreResource($action->handle($request->makeDelivery())['delivery_cd'] ?? '');
    }

    /**
     * Delete a Delivery
     * Created: 2024/02/19
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @param ?int $id
     * @return AnsResponse Result after saved
     */
    public function destroy(?int $id, DeleteDeliveryAction $action): AnsResponse
    {
        $action->handle($id);

        return new AnsResponse;
    }
}

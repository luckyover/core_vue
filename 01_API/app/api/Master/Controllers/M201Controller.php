<?php
/**
 * M201Controller
 * Processing for screen M201 商品売価マスタ
 *
 * 処理概要/process overview  : M201Controller
 * 作成日/create date         : 2024/02/22
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
use App\api\Master\Actions\M201\DeleteSizesPriceAction;
use App\api\Master\Actions\M201\GetInitDataAction;
use App\api\Master\Actions\M201\SaveSizesPriceAction;
use App\api\Master\Actions\M201\SearchConditionDetailAction;
use App\api\Master\Requests\M201\DeleteSizesPriceRequest;
use App\api\Master\Requests\M201\SaveSizesPriceRequest;
use App\api\Master\Requests\M201\SearchConditionRequest;
use App\api\Master\Resources\M201\InitDataResource;
use App\api\Master\Resources\M201\SizesPriceResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class M201Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get data for combobox on screen M201
     * Created: 2024/02/22
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @param CheckAccountAction $action
     * @return InitDataResource Data for combobox
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Get data size price product for screen M201
     * Created: 2024/02/22
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @return SizesPriceResource Data for screen M201
     */
    public function index(SearchConditionRequest $request, SearchConditionDetailAction $action): SizesPriceResource
    {
        $params = $request->makeKeyRefer();

        return new SizesPriceResource($action->handle($params));
    }

    /**
     * Save data for size price  product in screen M201
     * Created: 2024/02/22
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @return AnsResponse Data after save data
     */
    public function store(SaveSizesPriceRequest $request, SaveSizesPriceAction $action)
    {
        $data = $request->makeData();

        $action->handle($data);

        return new AnsResponse;
    }

    /**
     * Delete a size price product
     * Created: 2024/02/22
     *
     * @author QuanLH <quanlh@ans-asia.com>
     *
     * @param ?string $id
     * @return AnsResponse Data after delete data
     */
    public function destroy(?string $id, DeleteSizesPriceRequest $request, DeleteSizesPriceAction $action)
    {
        $data = $request->makeData();
        $action->handle($data);

        return new AnsResponse;
    }
}

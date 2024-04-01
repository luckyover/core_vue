<?php
/**
 * M004Controller
 * Processing for screen M004 得意先マスタ
 *
 * 処理概要/process overview  : M004Controller
 * 作成日/create date         : 2024/02/19
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
use App\api\Master\Actions\M004\DeleteCustomerAction;
use App\api\Master\Actions\M004\GetCustomerDetailAction;
use App\api\Master\Actions\M004\GetInitDataAction;
use App\api\Master\Actions\M004\SaveCustomerAction;
use App\api\Master\Actions\M004\SearchCustomerAction;
use App\api\Master\Actions\M004\SuggestSearchAction;
use App\api\Master\Requests\M004\SaveCustomerRequest;
use App\api\Master\Requests\M004\SearchCustomerRequest;
use App\api\Master\Resources\M004\CustomerDetailResource;
use App\api\Master\Resources\M004\CustomerStoreResource;
use App\api\Master\Resources\M004\InitDataResource;
use App\api\Master\Resources\M004\ListOfCustomersResource;
use App\Http\Controllers\Controller;
use App\Models\SuggestSearchResource;
use Illuminate\Http\Request;

class M004Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get data 分類区分1 , 分類区分2 and 分類区分3
     * Created: 2024/02/19
     *
     * @author Hainn <Hainn@ans-asia.com>
     *
     * @param CheckAccountAction $action
     * @return GetInitDataAction Data 分類区分1 , 分類区分2 and 分類区分3
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Search customers
     * Created: 2024/02/27
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return SearchCustomerAction List data of customer and paging
     */
    public function index(SearchCustomerRequest $request, SearchCustomerAction $action): ListOfCustomersResource
    {
        return new ListOfCustomersResource($action->handle($request->makeCondition()));
    }

    /**
     * Get data for input suggest search customer
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
     * Get detail of customer
     * Created: 2024/02/19
     *
     * @author Hainn <Hainn@ans-asia.com>
     *
     * @param ?int $id
     * @return GetInitDataAction Detail of customer
     */
    public function show(?int $id, GetCustomerDetailAction $action): CustomerDetailResource
    {
        return new CustomerDetailResource($action->handle($id));
    }

    /**
     * Save information of customer
     * Created: 2024/02/19
     *
     * @author Hainn <Hainn@ans-asia.com>
     *
     * @return AnsResponse Result after saved
     */
    public function store(SaveCustomerRequest $request, SaveCustomerAction $action): CustomerStoreResource
    {
        return new CustomerStoreResource($action->handle($request->makeCustomer())['customer_cd'] ?? '');
    }

    /**
     * Delete a customer
     * Created: 2024/02/19
     *
     * @author Hainn <Hainn@ans-asia.com>
     *
     * @param ?int $id
     * @return AnsResponse Result after saved
     */
    public function destroy(?int $id, DeleteCustomerAction $action): AnsResponse
    {
        $action->handle($id);

        return new AnsResponse;
    }
}

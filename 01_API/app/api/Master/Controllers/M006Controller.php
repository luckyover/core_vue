<?php

namespace App\api\Master\Controllers;

use AnsResponse;
use App\api\Master\Actions\M006\DeleteSupplierAction;
use App\api\Master\Actions\M006\GetInitDataAction;
use App\api\Master\Actions\M006\GetSupplierDetailAction;
use App\api\Master\Actions\M006\SaveSupplierAction;
use App\api\Master\Actions\M006\SearchSupplierAction;
use App\api\Master\Actions\M006\SuggestSearchAction;
use App\api\Master\Requests\M006\SaveSupplierRequest;
use App\api\Master\Requests\M006\SearchSupplierRequest;
use App\api\Master\Resources\M006\InitDataResource;
use App\api\Master\Resources\M006\ListOfSupplierResource;
use App\api\Master\Resources\M006\SupplierAct1Resource;
use App\api\Master\Resources\M006\SupplierDetailResource;
use App\Http\Controllers\Controller;
use App\Models\SuggestSearchResource;
use Illuminate\Http\Request;

class M006Controller extends Controller
{
    public function __construct()
    {
    }

    /**
     * Get detail of supplier
     * Created: 2024/02/19
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @param ?string $id
     * @return GetInitDataAction Detail of supplier
     */
    public function getInitData(Request $request, GetInitDataAction $action): InitDataResource
    {
        return new InitDataResource($action->handle());
    }

    /**
     * Search suppliers
     * Created: 2024/02/24
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return GetInitDataAction Detail of user
     */
    public function index(SearchSupplierRequest $request, SearchSupplierAction $action): ListOfSupplierResource
    {
        return new ListOfSupplierResource($action->handle($request->makeCondition()));
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
     * Get detail of supplier
     * Created: 2024/02/17
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @param ?string $id
     * @return GetInitDataAction Detail of user
     */
    public function show(?string $id, Request $request, GetSupplierDetailAction $action): SupplierDetailResource
    {
        return new SupplierDetailResource($action->handle($id, $request->all()));
    }

    /**
     * Save information of supplier
     * Created: 2024/02/19
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @return AnsResponse Result after saved
     */
    public function store(SaveSupplierRequest $request, SaveSupplierAction $action): SupplierAct1Resource
    {
        $data = $action->handle($request->makeSupplier());

        return new SupplierAct1Resource($data['supplier_cd'] ?? 0);
    }

    /**
     * Delete a supplier
     * Created: 2024/02/19
     *
     * @author ThuanNV <thuannv@ans-asia.com>
     *
     * @param ?string $id
     * @return AnsResponse Result after saved
     */
    public function destroy(?int $id, DeleteSupplierAction $action): AnsResponse
    {
        $action->handle($id);

        return new AnsResponse;
    }
}

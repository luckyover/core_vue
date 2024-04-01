<?php

namespace App\api\Master\Swagger;

class M202Swagger
{
    /**
     *  Get detail of product cost
     *  @OA\Get(
     *      path="/api/master/m202",
     *      tags={"M202"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="item_id",
     *          description="商品コード",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string", example="OE1116")
     *      ),
     *      @OA\Parameter(
     *          name="color_cd",
     *          description="色コード",
     *          in="query",
     *          @OA\Schema(type="string", example="01")
     *      ),
     *       @OA\Parameter(
     *          name="size_cd",
     *          description="サイズコード",
     *          in="query",
     *          @OA\Schema(type="string", example="01")
     *      ),
     *       @OA\Parameter(
     *          name="supplier_cd",
     *          description="仕入先コード",
     *          in="query",
     *          @OA\Schema(type="string", example="01")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data detail of product cost",
     *          @OA\JsonContent(ref="#/components/schemas/M202ProductCostResource")
     *      ),
     *      @OA\Response(response=400, description="Bad request, response when have invalid data from client or invalid API key or request id",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/AnsResponse",
     *              @OA\Examples(example="Invalid data", ref="#/components/examples/invalid_data"),
     *              @OA\Examples(example="Bad request", ref="#/components/examples/bad_request")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Not authentication", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not authentication", ref="#/components/examples/not_auth"))),
     *      @OA\Response(response=403, description="Not access", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not access", ref="#/components/examples/not_access"))),
     *      @OA\Response(response=406, description="Not acceptable, response when have error from store or check logic in action",
     *          @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not acceptable", ref="#/components/examples/not_acceptable"))
     *      ),
     *      @OA\Response(response=500, description="Exception", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Exception", ref="#/components/examples/exception")))
     *  )
     */
    public function search()
    {
    }

    /**
     *  Save data for product
     *  @OA\Post(
     *      path="/api/master/m202",
     *      tags={"M202"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\RequestBody(
     *          description="Data detail of product cost",
     *          @OA\JsonContent(ref="#/components/schemas/M202ProductCostDetail")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Result after saved",
     *          @OA\JsonContent(ref="#/components/schemas/AnsResponse")
     *      ),
     *      @OA\Response(response=400, description="Bad request, response when have invalid data from client or invalid API key or request id",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/AnsResponse",
     *              @OA\Examples(example="Invalid data", ref="#/components/examples/invalid_data"),
     *              @OA\Examples(example="Bad request", ref="#/components/examples/bad_request")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Not authentication", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not authentication", ref="#/components/examples/not_auth"))),
     *      @OA\Response(response=403, description="Not access", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not access", ref="#/components/examples/not_access"))),
     *      @OA\Response(response=406, description="Not acceptable, response when have error from store or check logic in action",
     *          @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not acceptable", ref="#/components/examples/not_acceptable"))
     *      ),
     *      @OA\Response(response=500, description="Exception", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Exception", ref="#/components/examples/exception")))
     *  )
     */
    public function store()
    {
    }

    /**
     *  Delete a product
     *  @OA\Delete(
     *      path="/api/master/m202/{id}",
     *      tags={"M202"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="id",
     *          description="商品コード",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string", example="OE1116")
     *      ),
     *      @OA\RequestBody(
     *          description="Data detail of product cost",
     *          @OA\JsonContent(ref="#/components/schemas/M202ProductCostDetail")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Result after deleted",
     *          @OA\JsonContent(ref="#/components/schemas/AnsResponse")
     *      ),
     *      @OA\Response(response=400, description="Bad request, response when have invalid data from client or invalid API key or request id",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/AnsResponse",
     *              @OA\Examples(example="Invalid data", ref="#/components/examples/invalid_data"),
     *              @OA\Examples(example="Bad request", ref="#/components/examples/bad_request")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Not authentication", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not authentication", ref="#/components/examples/not_auth"))),
     *      @OA\Response(response=403, description="Not access", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not access", ref="#/components/examples/not_access"))),
     *      @OA\Response(response=406, description="Not acceptable, response when have error from store or check logic in action",
     *          @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Not acceptable", ref="#/components/examples/not_acceptable"))
     *      ),
     *      @OA\Response(response=500, description="Exception", @OA\JsonContent(ref="#/components/schemas/AnsResponse", @OA\Examples(example="Exception", ref="#/components/examples/exception")))
     *  )
     */
    public function destroy()
    {
    }
}

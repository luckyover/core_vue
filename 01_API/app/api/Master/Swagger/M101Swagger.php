<?php

namespace App\api\Master\Swagger;

class M101Swagger
{
    /**
     *  Get data for combobox on screen M101
     *  @OA\Get(
     *      path="/api/master/m101/data/init",
     *      tags={"M101"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Response(
     *          response=200,
     *          description="Data for combobox on screen M101",
     *          @OA\JsonContent(ref="#/components/schemas/M101InitDataResource")
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
    public function getInitData()
    {
    }

    /**
     *  Search list data of items
     *  @OA\Get(
     *      path="/api/master/m101",
     *      tags={"M101"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="inq_item_cd",
     *          description="商品コード",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_item_nm",
     *          description="商品名",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_color_cd",
     *          description="色コード",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_color_nm",
     *          description="色名",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_item_class_div",
     *          description="商品分類",
     *          in="query",
     *          @OA\Schema(type="integer", example="0")
     *      ),
     *      @OA\Parameter(
     *          name="inq_process_div",
     *          description="加工種別",
     *          in="query",
     *          @OA\Schema(type="integer", example="0")
     *      ),
     *      @OA\Parameter(
     *          name="inq_category_div",
     *          description="カテゴリー",
     *          in="query",
     *          @OA\Schema(type="integer", example="0")
     *      ),
     *      @OA\Parameter(
     *          name="inq__supplier_cd",
     *          description="仕入先",
     *          in="query",
     *          @OA\Schema(type="integer", example="0")
     *      ),
     *      @OA\Parameter(
     *          name="page_size",
     *          description="Number of record in one page",
     *          in="query",
     *          @OA\Schema(type="integer", example="50")
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Page want to get data",
     *          in="query",
     *          @OA\Schema(type="integer", example="1")
     *      ),
     *      @OA\Parameter(
     *          name="sort_column",
     *          description="column to sort data",
     *          in="query",
     *          @OA\Schema(type="string", example="item_cd", enum={"item_cd", "color_cd", "item_nm", "color_nm", "item_class_div_nm", "process_div_nm", "category_div_nm", "supplier_item_cd", "supplier_cd", "supplier_nm"})
     *      ),
     *      @OA\Parameter(
     *          name="sort_type",
     *          description="Sort type",
     *          in="query",
     *          @OA\Schema(type="string", enum={"ASC", "DESC"}, example="ASC")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data have list of suppliers and data for paging",
     *          @OA\JsonContent(ref="#/components/schemas/M101ListOfItemResource")
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
    public function index()
    {
    }

    /**
     *  Get detail of product
     *  @OA\Get(
     *      path="/api/master/m101/data/refer/{id}",
     *      tags={"M101"},
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
     *      @OA\Parameter(
     *          name="inq_item_class_div",
     *          description="商品分類",
     *          in="query",
     *          @OA\Schema(type="integer", example="0")
     *      ),
     *      @OA\Parameter(
     *          name="inq_color_cd",
     *          description="色コード",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data detail of product",
     *          @OA\JsonContent(ref="#/components/schemas/M101ReferNameItemResource")
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
    public function refer()
    {
    }

    /**
     *  Get list data product for suggest search
     *  @OA\Get(
     *      path="/api/master/m101/data/suggest",
     *      tags={"M101"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="search",
     *          description="商品",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data product for suggest search",
     *          @OA\JsonContent(ref="#/components/schemas/SuggestSearchResource")
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
    public function suggestSearch()
    {
    }

    /**
     *  Get detail of product
     *  @OA\Get(
     *      path="/api/master/m101/{id}",
     *      tags={"M101"},
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
     *      @OA\Parameter(
     *          name="color_cd",
     *          description="色コード",
     *          in="query",
     *          @OA\Schema(type="string", example="01")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data detail of product",
     *          @OA\JsonContent(ref="#/components/schemas/M101Data")
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
    public function show()
    {
    }

    /**
     *  Save data for product
     *  @OA\Post(
     *      path="/api/master/m101",
     *      tags={"M101"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\RequestBody(
     *          description="Data detail of product",
     *          @OA\JsonContent(ref="#/components/schemas/M101ItemDetail")
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
     *      path="/api/master/m101/{id}",
     *      tags={"M101"},
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
     *      @OA\Parameter(
     *          name="color_cd",
     *          description="色コード",
     *          in="query",
     *          @OA\Schema(type="string", example="01")
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

<?php

namespace App\api\Master\Swagger;

class M005Swagger
{
    /**
     *  Search data of delivery
     *  @OA\Get(
     *      path="/api/master/m005",
     *      tags={"M005"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="inq_delivery_cd",
     *          description="納品先コード",
     *          in="query",
     *          @OA\Schema(type="integer", example="0")
     *      ),
     *      @OA\Parameter(
     *          name="inq_delivery_nm",
     *          description="納品先名",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_delivery_kn_nm",
     *          description="納品先名カナ",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_delivery_ab_nm",
     *          description="納品先名略称",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_delivery_tel",
     *          description="TEL",
     *          in="query",
     *          @OA\Schema(type="string", example="")
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
     *          @OA\Schema(type="string", example="delivery_cd", enum={"delivery_cd", "delivery_nm", "delivery_kn_nm", "delivery_ab_nm", "delivery_zip", "delivery_address1", "delivery_address2", "delivery_address3", "delivery_tel", "delivery_mail_address", "delivery_department_nm", "delivery_manager_nm"})
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
     *          @OA\JsonContent(ref="#/components/schemas/M005ListOfDeliveryResource")
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
     *  Get list data delivery for suggest search
     *  @OA\Get(
     *      path="/api/master/m005/data/suggest",
     *      tags={"M005"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="search",
     *          description="納品先",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data supplier for suggest search",
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
     *  Get detail of delivery
     *  @OA\Get(
     *      path="/api/master/m005/{id}",
     *      tags={"M005"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="id",
     *          description="納品先コード",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="int", example="1")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data detail of delivery",
     *          @OA\JsonContent(ref="#/components/schemas/M005DeliveryDetailResource")
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
     *  Save data of delivery
     *  @OA\Post(
     *      path="/api/master/m005",
     *      tags={"M005"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\RequestBody(
     *          description="Data detail of delivery",
     *          @OA\JsonContent(ref="#/components/schemas/M005DeliveryDetail")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Result after saved",
     *          @OA\JsonContent(ref="#/components/schemas/M005DeliveryStoreResource")
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
     *  Delete a delivery
     *  @OA\Delete(
     *      path="/api/master/m005/{id}",
     *      tags={"M005"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="id",
     *          description="納品先コード",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="int", example="1")
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

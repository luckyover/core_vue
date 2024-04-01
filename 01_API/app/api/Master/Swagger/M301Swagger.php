<?php

namespace API\Master\Swagger;

class M301Swagger
{
    /**
     *  Get data for combobox on screen M301
     *  @OA\Get(
     *      path="/api/master/m301/data/init",
     *      tags={"M301"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Response(
     *          response=200,
     *          description="Data for combobox on screen M301",
     *          @OA\JsonContent(ref="#/components/schemas/M301InitDataResource")
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
     *  Get list m_process_price
     *  @OA\Get(
     *      path="/api/master/m301",
     *      tags={"M301"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="item_cd",
     *          in="query",
     *          example="",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="item_nm",
     *          in="query",
     *          example="",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="category_div",
     *          in="query",
     *          required=true,
     *          example="0",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="material_div",
     *          in="query",
     *          required=true,
     *          example="0",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="processing_place_div",
     *          in="query",
     *          required=true,
     *          example="0",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Result after saved",
     *          @OA\JsonContent(ref="#/components/schemas/M301ProcessPriceResource")
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
     *  Save Update And Delete list data m_process_price
     *  @OA\Post(
     *      path="/api/master/m301",
     *      tags={"M301"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\RequestBody(
     *          description="Data detail of supplier",
     *          @OA\JsonContent(ref="#/components/schemas/M301PostProcessPrice")
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
     *  Delete list data m_process_price
     *  @OA\Delete (
     *      path="/api/master/m301",
     *      tags={"M301"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\RequestBody(
     *          description="Data detail of supplier",
     *          @OA\JsonContent(ref="#/components/schemas/M301DeleteProcessPrice")
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
    public function destroy()
    {
    }
}

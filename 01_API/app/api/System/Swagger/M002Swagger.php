<?php

namespace App\api\System\Swagger;

class M002Swagger
{
    /**
     *  Get data 所属部門区分 and 権限区分
     *  @OA\Get(
     *      path="/api/system/m002/data/init",
     *      tags={"M002"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Response(
     *          response=200,
     *          description="Data for init screen M002",
     *          @OA\JsonContent(ref="#/components/schemas/M002InitDataResource")
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
     *  Search data of users
     *  @OA\Get(
     *      path="/api/system/m002",
     *      tags={"M002"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="inq_user_cd",
     *          description="ユーザーコード",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_user_nm",
     *          description="ユーザー名",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_user_kn_nm",
     *          description="ユーザー名カナ",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_user_ab_nm",
     *          description="ユーザー名略称",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_tel",
     *          description="TEL",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_fax",
     *          description="FAX",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_mailaddress",
     *          description="メールアドレス",
     *          in="query",
     *          @OA\Schema(type="string", example="")
     *      ),
     *      @OA\Parameter(
     *          name="inq_belong_department_div",
     *          description="所属部門区分",
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
     *          @OA\Schema(type="string", example="user_cd", enum={"user_cd", "user_nm", "user_kn_nm", "user_ab_nm", "tel", "fax", "mailaddress", "belong_department_div_nm"})
     *      ),
     *      @OA\Parameter(
     *          name="sort_type",
     *          description="Sort type",
     *          in="query",
     *          @OA\Schema(type="string", enum={"ASC", "DESC"}, example="ASC")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data have list of users and data for paging",
     *          @OA\JsonContent(ref="#/components/schemas/M002ListOfUsersResource")
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
     *  Get list data user for suggest search
     *  @OA\Get(
     *      path="/api/master/m002/data/suggest",
     *      tags={"M002"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="search",
     *          description="ユーザー",
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
     *  Get detail of user
     *  @OA\Get(
     *      path="/api/system/m002/{id}",
     *      tags={"M002"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="id",
     *          description="ユーザーコード",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string", example="809")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data detail of user",
     *          @OA\JsonContent(ref="#/components/schemas/M002UserDetailResource")
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
     *  Save data of user
     *  @OA\Post(
     *      path="/api/system/m002",
     *      tags={"M002"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\RequestBody(
     *          description="Data detail of user",
     *          @OA\JsonContent(ref="#/components/schemas/M002UserDetail")
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
     *  Delete a user
     *  @OA\Delete(
     *      path="/api/system/m002/{id}",
     *      tags={"M002"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Parameter(
     *          name="id",
     *          description="ユーザーコード",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string", example="809")
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

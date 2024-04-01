<?php

namespace App\api\Common\Swagger;

class AppSwagger
{
    /**
     *  @OA\Get(
     *      path="/api/app/app-state",
     *      tags={"App"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/api_key"),
     *      @OA\Parameter(ref="#/components/parameters/request_id"),
     *      @OA\Parameter(ref="#/components/parameters/screen_id"),
     *      @OA\Response(
     *          response=200,
     *          description="Current state of one application session",
     *          @OA\JsonContent(ref="#/components/schemas/AppStateResource")
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
    public function getAppState()
    {
    }
}

<?php

namespace App\api\Common\Controllers;

use App\api\Common\Actions\App\DownloadFileAction;
use App\api\Common\Actions\App\GetAppStateAction;
use App\api\Common\Requests\App\DownloadFileRequest;
use App\api\Common\Resources\App\AppStateResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AppController extends Controller
{
    public function getAppState(
        Request $request, GetAppStateAction $actions
    ): AppStateResource {
        return new AppStateResource($actions->handle());
    }

    public function downloadFile(
        DownloadFileRequest $request, DownloadFileAction $actions
    ): Response|RedirectResponse|BinaryFileResponse {
        return $actions->handle($request->makeInput());
    }
}

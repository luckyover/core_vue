<?php

namespace App\api\Common\Actions\App;

use App\api\Common\Models\App\FileDownloadInformation;
use FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use JWTAuth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadFileAction
{
    public function handle(FileDownloadInformation $input): Response|RedirectResponse|BinaryFileResponse
    {
        try {
            $logined = true;
            if (($input->token ?? '') === '') {
                $logined = false;
            } else {
                try {
                    $payload = JWTAuth::setToken($input->token)->getPayload();
                } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException $e) {
                    $logined = false;
                } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e) {
                    $logined = false;
                } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
                    $logined = false;
                }
            }
            if (!$logined) {
                return redirect('/login');
            }

            return FileService::downloadLocalFile(storage_path() . $input->url, $input->filename, $input->action);
        } catch (\Exception $e) {
            return redirect('/500?e=' . $e->getMessage());
        }
    }
}

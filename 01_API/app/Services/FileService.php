<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileService
{
    public function __construct()
    {
    }

    public static function downloadLocalFile($fullPath, $filename = null, $action = 'D'): Response|RedirectResponse|BinaryFileResponse
    {
        if (!file_exists($fullPath)) {
            return redirect('/404');
        }
        $pathinfo = pathinfo($fullPath);
        $extension = $pathinfo['extension'] ?? 'csv';
        $filename = $filename ?? ($pathinfo['filename'] . '.' . $extension);
        $headers = [];
        $contentTypes = 'application/octet-stream';
        if ($extension == 'pdf') {
            $contentTypes = 'application/pdf';
        } elseif ($extension == 'csv') {
            $contentTypes = 'text/csv';
        } elseif ($extension == 'doc') {
            $contentTypes = 'application/msword';
        } elseif ($extension == 'docx') {
            $contentTypes = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } elseif ($extension == 'xls') {
            $contentTypes = 'application/vnd.ms-excel';
        } elseif ($extension == 'xlsx') {
            $contentTypes = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } elseif ($extension == 'txt') {
            $contentTypes = 'text/plain';
        }
        $headers['Content-Type'] = $contentTypes;
        if (($action ?? 'D') !== 'R') {
            $headers['Content-Description'] = 'File Transfer';

            return response()->download($fullPath, $filename, $headers);
        } else {
            return response()->file($fullPath, $headers);
        }
    }
}

<?php

namespace App\api\Common\Models\App;

use AnsModel;

class FileDownloadInformation extends AnsModel
{
    public string $token;

    public string $url;

    public string $filename;

    public string $action;
}

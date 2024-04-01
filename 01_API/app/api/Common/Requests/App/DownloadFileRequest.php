<?php

namespace App\api\Common\Requests\App;

use AnsRequest;
use App\api\Common\Models\App\FileDownloadInformation;

class DownloadFileRequest extends AnsRequest
{
    public function makeInput(): FileDownloadInformation
    {
        return new FileDownloadInformation($this->all());
    }
}

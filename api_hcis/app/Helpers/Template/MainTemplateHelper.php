<?php

namespace App\Helpers\Template;



require_once 'RemoveKeyword.php';
require_once 'InputTemplate.php';
require_once 'GetDataInput.php';
require_once 'GetDataAuto.php';

class MainTemplateHelper
{
    use RemoveKeyword;
    use InputTemplate;
    use DisplayInput;
    use GetDataInit;
    use GetDataInput;
    use GetDataLogin;
    use GetDataAuto;

    public $html;

    public function encodeHtml($html)
    {
        $encoding = base64_encode($html);
        return $encoding;
    }

    public function get()
    {
        return $this->html;
    }
}

<?php

namespace App\Libraries\Widget;

class Toolbar
{

    public static function toolbarTable(array $param)
    {
        return view('Widget/Toolbar', $param);
    }
    public static function toolbarTemplate(array $param)
    {
        return view('Widget/ToolbarTemplate', $param);
    }
}

<?php

namespace App\Libraries;

class Widget
{
    public function flashMessage()
    {
        return view('widgets/flash_message');
    }

    public function pagination($params)
    {
        return view('widgets/pagination', $params);
    }
}
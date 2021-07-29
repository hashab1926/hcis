<?php

namespace App\Helpers\Template;

trait RemoveKeyword
{

    private $allowRemoveInput = [
        'Text',
        'DateRange',
        'List',
        'Table'
    ];

    private function concatAllowRemove()
    {
        $allowRemove = $this->allowRemoveInput;
        $length = count($allowRemove) - 1;
        $tampung = '';
        $x = 0;
        foreach ($allowRemove as $list) :
            if ($x == $length)
                $tampung .= '\\$' . $list . '->';
            else
                $tampung .= '\\$' . $list . '->|';
            $x++;

        endforeach;

        return $tampung;
    }

    public function removeKeyword()
    {
        $this->removeKeywordInput()
            ->removeKeywordAuto()
            ->removeKeywordLogin()
            ->removeKeywordLink();

        return $this;
    }

    private function removeKeywordInput()
    {
        $display = $this->html;
        $concatAllowRemove = $this->concatAllowRemove();
        $pattern = "/({$concatAllowRemove})\{[a-zA-z0-9\s]*\}/";
        $display = preg_replace($pattern, '', $display);
        $this->html = $display;

        return $this;
    }

    private function removeKeywordAuto()
    {
        $display = $this->html;
        $pattern = "/\\$\{\{[a-zA-z0-9\s]*\}\}/";
        $display = preg_replace($pattern, '', $display);
        $this->html = $display;
        return $this;
    }

    private function removeKeywordLogin()
    {
        $display = $this->html;
        $pattern = "/\\\$Login->\{\{[a-zA-z0-9\s]*\}\}/";
        $display = preg_replace($pattern, '', $display);
        $this->html = $display;

        return $this;
    }

    private function removeKeywordLink()
    {
        $display = $this->html;
        // echo $display;
        $pattern = "/\\\$Link->[a-zA-Z]*->\{\{[a-zA-Z0-9\s]*\}\}/";
        $display = preg_replace($pattern, '', $display);
        $this->html = $display;

        return $this;
    }
}

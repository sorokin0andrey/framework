<?php

namespace test\app\Views;

/**
 * View
 */
class View
{
    public $layout = 'layout';
    public $vars = [];

    public function render($template, $title = '', $data = '')
    {
        if(is_array($data)) extract($data);
        if(is_array($this->vars)) extract($this->vars);

        if(file_exists(__DIR__ . '/' . $template . '.php')) {
            $template = __DIR__ . '/' . $template . '.php';
        } else {
            dd('Template <b>"'.$template.'"</b> does not exists');
        }

        if(file_exists(__DIR__.'/'.$this->layout.'.php')) {
            require $this->layout.'.php';
        } else {
            dd('Layout <b>"'.$this->layout.'"</b> does not exists');
        }
    }

    public function setVars($data)
    {
        $this->vars = $data;
    }
}
<?php
class View {

    private $vars;

    public function __get($var) {
        if (isset($this->vars [$var])) {
            return $this->vars[$var];
        }
    }

    public function assign($var, $value) {
        $this->vars [$var] = $value;
    }

    public function show($template) {
        ob_start();
        include_once  __DIR__."/views/". $template;
        return ob_get_flush();
    }

}

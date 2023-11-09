<?php
namespace Base;

class View {

    public function render($path, $data = null)
    {
        include $path;        
    }
}
?>
<?php namespace NetworkPie\Bloke;


class View
{
    private $_view_path;
    private $_layout;
    private $_blocks;

    public $view;
    public $view_data;

    public function __construct($view_path)
    {
        $this->_view_path = $view_path;
        $this->_blocks = [];
    }

    public function render($view, $view_data = [])
    {
        extract($view_data);
        unset($view_data);

        ob_start();
        include $this->_view_path . '/' . $view . '.phtml';
        $content = ob_get_clean();

        if (isset($this->_layout)) {
            $layout = new View($this->_view_path);
            $content = $layout->render($this->_layout,
                array_merge(
                    ['content' => $content],
                    $this->_blocks
                )
            );
        }

        return $content;
    }

    private function layout($layout, $view_data = [])
    {
        $this->_layout = $layout;
        $this->_layoutData = $view_data;
    }

    private function block($name)
    {
        $this->_blocks[$name] = '';

        ob_start();
    }

    private function endBlock()
    {
        // move to end element of array
        end($this->_blocks);

        // grab key of that last element and fill it with rendered data
        $this->_blocks[key($this->_blocks)] = ob_get_clean();
    }
}

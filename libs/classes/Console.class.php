<?php

class Console
{

    private $options = array();
    private $params = array();

    function __construct()
    {
        $this->params['BOLD'] = 1;
        $this->params['UNDERLINE'] = 4;
        $this->params['BLACK'] = 30;
        $this->params['RED'] =  31;
        $this->params['GREEN'] = 32;
        $this->params['YELLOW'] = 33;
        $this->params['BLUE'] = 34;
        $this->params['MAGENTA'] = 35;
        $this->params['CYAN'] = 36;
        $this->params['WHITE'] = 37;
    }

    function bold()
    {
        array_push($this->options, $this->params['BOLD']);
        return $this;
    }

    function underline()
    {
        array_push($this->options, $this->params['UNDERLINE']);
        return $this;
    }

    function highlight($color = 'WHITE')
    {
        $color = strtoupper($color);

        if (isset($this->params[$color]))
        {
            array_push($this->options, 10+$this->params[$color]);
        }

        return $this;
    }

    function color($color = 'WHITE')
    {
        $color = strtoupper($color);

        if (isset($this->params[$color]))
        {
            array_push($this->options, $this->params[$color]);
        }

        return $this;
    }

    function write_string($string)
    {
        $string = "\033[".join(";",$this->options)."m".$string."\033[0m";
        unset($this->options);
        $this->options = array();
        return $string;
    }
    
    function writeln($string)
    {
        echo "\033[".join(";",$this->options)."m".$string."\033[0m";
        unset($this->options);
        $this->options = array();
    }
}

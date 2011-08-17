<?php

class ConsoleDoc
{

    public function __construct($filename = null)
    {
        $this->console = new Console();

        if ($filename != null)
        {
            $this->file = file($filename);
        }
    }

    function load_file_($filename)
    {
       $this->file = file($filename);
       $this->file = join("", $this->file);
       return $this;
    }

    function parse()
    {
       while(preg_match("/\*\*(.*)\*\*/", $this->file, $results))
       {
            $this->file = str_replace($results[0], 
                $this->console->bold()->write_string($results[1]), $this->file);
       }

       while(preg_match("/__(.*)__/", $this->file, $results))
       {
            $this->file = str_replace($results[0], 
                $this->console->bold()->write_string($results[1]), $this->file);
       }
       
       while(preg_match("/\*(.*)\*/", $this->file, $results))
       {
            $this->file = str_replace($results[0], 
                $this->console->underline()->write_string($results[1]), $this->file);
       }
       
       while(preg_match("/_(.*)_/", $this->file, $results))
       {
            $this->file = str_replace($results[0], 
                $this->console->underline()->write_string($results[1]), $this->file);
       }

       while(preg_match("/`([^`])*/", $this->file, $results))
       {
            $this->file = str_replace($results[0], $this->syntax_hightlight($results[0]), $this->file);
       }
       
       while(preg_match("/\*/", $this->file, $results))
       {
            $this->file = str_replace($results[0], '•', $this->file);
       }

       return $this;
    }

    function syntax_hightlight($code)
    {
       
        foreach ($this->php_keywords as $regex => $color) 
        {
            $code = preg_replace("/\b$regex\b/", 
                $this->console->bold()->color($color)->write_string($regex), $code);
        }    
        
        if (preg_match_all('/\$([a-zA-Z_0-9]+)/', $code, $results))
        {
            $results = $results[0];
            rsort($results); // replace the larger subset words
            foreach ($results as $match)
            {
                $code = preg_replace("/\\$match\b/", 
                    $this->console->bold()->color("blue")->write_string($match), $code);
            }
        }
        
        if (preg_match_all("/([^\"])*/", $code, $results))
        {
            foreach ($results[0] as $match)
            {
                echo $this->console->bold()->color("red")->write_string($match)."=";
                #$match = '\"'.$match.'\"';
                #$code = preg_replace("/".$match."/", 
                #   , $code);
            }
        }
        $code = str_replace("`", "", $code);
        return $code;
     }

    function render()
    {
        $this->console->writeln($this->file);
    }

    private $file = null; 
    private $console;


    private $php_keywords = array(
        'abstract' => 'green', 
        'and' => 'yellow',
        'array' => 'green',
        'as' => 'yellow',
        'break' => 'yellow',
        'case' => 'yellow',
        'catch' => 'yellow',
        'class' => 'green',
        'clone' => 'purple',
        'const' => 'yellow',
        'continue' => 'yellow',
        'declare' => 'yellow',
        'default' => 'yellow',
        'do' => 'yellow',
        'die' => 'yellow',
        'echo' => 'purple',
        'else' => 'yellow',
        'elseif' => 'yellow',
        'empty' => 'yellow',
        'enddeclare' => 'yellow',
        'endfor' => 'yellow',
        'endforeach' => 'yellow',
        'endif' => 'yellow',
        'endswitch' => 'yellow',
        'endwhile' => 'yellow',
        'eval' => 'yellow',
        'exit' => 'yellow',
        'extends' => 'green',
        'final' => 'green',
        'for' => 'yellow',
        'foreach' => 'yellow',
        'function' => 'magenta',
        'global' => 'green',
        'goto' => 'white',
        'if' => 'yellow',
        'implements' => 'green',
        'include' => 'magenta',
        'include_once' => 'magenta',
        'interface' => 'green',
        'isset' => 'yellow',
        'instanceof' => 'yellow',
        'list' => 'green',
        'namespace' => 'white',
        'new' => 'magenta',
        'or' => 'yellow',
        'parent' => 'green',
        'print' => 'purple',
        'private' => 'green',
        'protected' => 'green',
        'public' => 'magenta',
        'require' => 'magenta',
        'require_once' => 'magenta',
        'return' => 'yellow',
        'self' => 'green',
        'static' => 'green',
        'switch' => 'yellow',
        'throw' => 'yellow',
        'try' => 'yellow',
        'unset' => 'yellow',
        'use' => 'white',
        'var' => 'yellow',
        'while' => 'yellow',
        'xor' => 'yellow'
    );
}


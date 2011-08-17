<?php

class Git 
{
    protected $repos = null;

    public function __construct($repo = null)
    {
    }

    public function select_repo($repo)
    {
         if (isset($this->repos[$repo]))
         {
            $this->selected_repo = $repo;
         }
         else
         {
            throw new Exception("$repo does not exist");
         }
         return $this;
    }

    public function fetch($fetch_repo, $branch)
    {
        return $this->execute_git_command("git fetch $fetch_repo $branch");
    }

    public function add_repo($repos)
    {
        if (!is_array($repos)) $repos = array($repos);

        foreach($repos as $repo)
        {
            $this->repos[$repo] = array();
        }
        
        return $this;
    }

    public function clone_repo($repo_url, $options = null)
    {
        if ($this->selected_repo == null)
        {
            throw new Exception("no repo selected");
        }

        echo "\033[31;1mgit clone $repo_url $this->selected_repo\033[0m\n";

        passthru("git clone $repo_url $this->selected_repo", $return);
        if ($return > 0)
        {
            throw new Exception("failed to clone repo");
        }

        return $this;
    }

    public function pull($remote, $revision, $options = null)
    {
        $options_string = join(" ", $options);
        return $this->execute_git_command("git pull $options_string $remote $revision");
    }

    public function push($remote, $branch, $options = null)
    {
        $options_string = join(" ", $options);
        return $this->execute_git_command("git push $options_string $remote $branch");
    }

    public function branch($branch)
    {
        return $this->execute_git_command("git branch $branch");
    }

    public function remote_add($name, $repo)
    {
        return $this->execute_git_command("git remote add $name $repo");
    }

    public function checkout_branch($branch)
    {
        return $this->execute_git_command("git checkout $branch");
    }

    private function execute_git_command($command)
    {
        if ($this->selected_repo == null)
        {
            throw new Exception("no repo selected");
        }

        $repo = $this->selected_repo;
        $current_dir = getcwd();

        if (!file_exists($current_dir."/".$repo)) 
        {
            throw new Exception("repo: $repo does not exist");
        }

        chdir($current_dir."/".$repo);
        echo "\033[32;1m$command\033[0m\n";
        exec($command , $results,$return);
        chdir($current_dir);
        if ($return > 0)
        {
            throw new Exception("Failed to execute $command");
        }
        return $this;
    }
}



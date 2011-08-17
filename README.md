#AutoGit is a set of tools designed to help automate git tasks (merging, submodules, etc)

#Notes

When specifying a file name it will first look in the specified; if not found then the json directory; finally if found in neither it will try and append .json

All 3 commands will produce the same result

ex: bin/auto-merge -f json/file1 json/file2
ex: bin/auto-merge -f file1.json file2.json
ex: bin/auto-merge -f file1 file2

##Merging Branches

### bin/auto-merge

Paramters:
    -f : --file     specifies the json to read
    -n : --no-push  will clone and merge but no push will be made

This will clone both branches merge then and push them back up to the repo

ex: bin/auto-merge -f file1 file2 file3 file4


##Example json file

{
    "project-name":{
        "repo_name":"self",
        "repo_url":"git@github.com:hardeep/AutoGit.git",
        "repo_branch":"development",
        "remote_name":"self-master",
        "remote_url":"git@github.com:hardeep/AutoGit.git",
        "remote_branch":"master"
    }
}

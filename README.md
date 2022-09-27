# SPARTA CLI TOOLS

## Usage:

###List of commands:
```
./console.php list
```
### SSH

```
./console.php ssh [options] [--] <project> [<environment>]

Arguments:
  project          Project ID
  environment      Environment code [default: "production"]

Options:
  -c, --executeCommand=EXECUTECOMMAND  Command to execute 
  
Example:
  ./console.php ssh 6fck2obu3244c --executeCommand=ls
```

### MYSQL

```
sql [options] [--] <project> [<environment> [<relationship>]]

Arguments:
  project               Project ID
  environment           Environment code [default: "production"]
  relationship          Relationship [default: "database"]

Options:
  -sql, --sql=SQL       Command to execute
  
Example:
./console.php sql 6fck2obu3244c --sql="select count(*), status from cron_schedule group by status"
count(*)	status
4	error
259	missed
520	pending
2093	success
```
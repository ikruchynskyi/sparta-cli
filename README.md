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
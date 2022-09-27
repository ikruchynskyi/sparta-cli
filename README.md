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

### SQL

```
./console.php sql [options] [--] <project> [<environment> [<relationship>]]

Arguments:
  project               Project ID
  environment           Environment code [default: "production"]
  relationship          Relationship [default: "database"]

Options:
  -query, --query=QUERY  DB query to execute
  
Example:
./console.php sql 6fck2obu3244c --sql="select count(*), status from cron_schedule group by status"
count(*)	status
4	error
259	missed
520	pending
2093	success
```

### Elasticsearch | Opensearch
We can utilize ./console.php ssh command to make requests to search engine
```
Example:
./console.php ssh 6fck2obu3244c --executeCommand='curl -X GET 127.0.0.1:9200/_cat/indices?v'
health status index                     uuid                   pri rep docs.count docs.deleted store.size pri.store.size
green  open   magento2_stg_product_1_v2 MnyC8JZGSGywn3yQgBVg5Q   3   2          0            0      2.2kb           783b
green  open   magento2_product_34_v7    xxX8jZNeStaiPlUN_wUn5g   3   2       4666         1405    414.2mb        142.5mb
green  open   magento2_product_52_v6    XreeN2ujQUyl64yfcJmbbw   3   2       2005          306    784.9mb        242.3mb
green  open   magento2_product_37_v7    JYIbkiY6RciCec3YTnO1Wg   3   2       4666         1372    420.6mb        143.5mb
green  open   magento2_product_40_v7    YCiR0C2LTty7XLadzg2ugA   3   2       4666          697      400mb        121.6mb
green  open   magento2_product_55_v6    br47e9-QTBGmu7K-kawKIA   3   2       2005          445    748.9mb        250.4mb
```
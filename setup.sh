
[ "$#" -ne 2 ] && echo "Naudojimas: ./setup.sh [DB_VARDAS] [DB_SLAPTAZODIS]" && exit 1;
SOURCE_DIR="/var/www/html/pazinciu_portalas" 
DBNAME="it_proj"

if [ ! -d $SOURCE_DIR ]; then
    mkdir -p $SOURCE_DIR
fi

cp ./source/* $SOURCE_DIR
chmod o+x $SOURCE_DIR #if not set, need permissions to access
systemctl restart apache2

EXP="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$DBNAME'"
res=$(mysql -u stud -pstud -e "$EXP")

if [ -n "$res" ]; then 
    mysql -u $1 -p$2 -e "CREATE DATABASE IF NOT EXISTS $DBNAME"
    mysql -u $1 -p$2 $DBNAME < db.sql
fi

[ "$#" -ne 2 ] && echo "Naudojimas: ./setup.sh [DB_VARDAS] [DB_SLAPTAZODIS]" && exit 1;
SOURCE_DIR="/var/www/html/pazinciu_portalas" 
DBNAME="it_proj"

mkdir $SOURCE_DIR
cp ./source/* $SOURCE_DIR
chmod o+x $SOURCE_DIR #if not set, need permissions to access

mysql -u $1 -p$2 -e "CREATE DATABASE IF NOT EXISTS $DBNAME"
mysql -u $1 -p$2 $DBNAME < db.sql

systemctl restart apache2
if [ $# -eq 0 ]; then
    echo "No arguments provided"
    exit 1
fi

cp ../"$1"/modules/Vtiger/views/Detail.php  backup/1.php
cp ../"$1"/layouts/vlayout/modules/Vtiger/DetailViewHeader.tpl backup/2.php
cp -f done/Detail.php ../"$1"/modules/Vtiger/views/
cp -f done/DetailViewHeader.tpl ../"$1"/layouts/vlayout/modules/Vtiger/

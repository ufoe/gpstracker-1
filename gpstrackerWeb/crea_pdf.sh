export LANG=it_IT.UTF-8

export folderhere=$(dirname $0)
export folder="$folderhere/stampe/"

echo "sh /opt/jasperReportsStart/run_linux.sh --class org.gjt.mm.mysql.Driver -t $1  --database jdbc:mysql://$4/$7 --user $5 --pass $6 --output $2  --param COD=$3 --param folder=$folder" >> /tmp/crea_pdf.geco.txt

sh /opt/jasperReportsStart/run_linux.sh --class org.gjt.mm.mysql.Driver -t $1  --database jdbc:mysql://$4/$7 --user $5 --pass $6 --output $2  --param COD=$3 --param folder=$folder


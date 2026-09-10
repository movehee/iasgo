
for testfile in `ls ../upload/xml/*.xml`
do
  filename=${testfile%.*}  
  echo "Converting $testfile"
  java -jar html2image.jar $testfile ../upload/thumbnails/
done

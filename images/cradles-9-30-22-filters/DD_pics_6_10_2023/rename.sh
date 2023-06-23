#!/bin/bash
for file in *
do
  if [ -f "$file" ];then
    newfile="${file%.jpg} Fan Pull.jpg"
    mv "$file" "$newfile"
#    echo "${file%.jpg} Fan Pull.jpg"
#    echo "${file/jpeg/jpg}"
  fi
done

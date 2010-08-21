#!/bin/sh
rm pipe
mkfifo pipe
ftp -n < pipe &
exec 3>pipe
echo "open host" >&3
echo "user X Y" >&3
echo "cd www" >&3
for i in $*; do
    echo "put $i" >&3
done
echo "dir" >&3
echo "quit" >&3
exec 3>&-


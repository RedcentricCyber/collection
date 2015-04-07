#!/bin/bash

# this isn't part of the challenge but just useful for creating
# messages in the redis backend.

if [ $# -lt 1 ]; then
    echo "$(basename $0) to from subject text"
    exit
fi

msg_to=$1
msg_from=$2
msg_subject=$3
msg_text=$4
date=${5:-$(date +%s)}

next_msg_id=$(echo "GET next.msg.id" | redis-cli)
echo "SET msg:$next_msg_id \"$msg_from|$date|$msg_subject|$msg_text\"" | redis-cli
echo "LPUSH uid:$msg_to:msgs $next_msg_id" | redis-cli
echo "INCR next.msg.id" | redis-cli



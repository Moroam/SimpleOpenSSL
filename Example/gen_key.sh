#!/bin/bash
# centos 7
#openssl req -newkey rsa:2048 -nodes -keyout your_key.key -out your_key.csr  -days 365
# centos 8
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout your_key.key -out your_key.csr

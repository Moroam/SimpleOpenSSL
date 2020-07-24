#!/bin/bash
openssl req -newkey rsa:2048 -nodes -keyout your_key.key -out your_key.csr  -days 365

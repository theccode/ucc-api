# UCC API DOCUMENTATION
## TABLE OF CONTENTS
###### INTRODUCTION 
###### GETTING STARTED WITH THE UCC API
###### HTTP CLIENTS
###### 1. HTTPie 
###### 2. Postman 
###### 3. Curl
## OVERVIEW 
## WELCOME
## WHAT COULD GO WRONG
## Wrong regno or password 
## Absence of a bearer or access token
## USEFUL ENDPOINTS

# INTRODUCTION
UCC API integration makes it seamlessly easier for developers to build data driven applications.

# GETTING STARTED WITH THE UCC API
This document aims at explaining how to successfully call the UCC API and get the necessary data
objects.

# HTTP CLIENTS
1. HTTPie
HTTPie – API testing client that is making APIs simple and intuitive for those building tools.
https://httpie.io
2. Postman
Postman is an API platform for building and using APIs. Postman simplifies each step of the
API lifecycle and streamlines collaboration so you can create better APIs—faster.
https://www.postman.com/
3. Curl
cURL is a computer software project providing a library and command-line tool for
transferring data using various network protocols
https://curl.se/

# OVERVIEW
For the purpose of demonstration and seeing how this API works, let’s kick start by using the
HTTPie client. There are other alternatives to HTTPie like postman and curl as stated above.

# WELCOME
Let’s begin by testing our setup. Open a terminal and type the following command:
http http://api.ucc.edu.test/academic/test.php

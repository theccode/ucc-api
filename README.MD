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

![Welcome](https://user-images.githubusercontent.com/7442471/187428206-31d74e91-5d09-49ae-aba2-c0b758d67367.png)

The response will be a welcome message “Welcome to the UCC API”.

Okay, now let’s get Josephine Akonobea Bekoe’s student profile details by first making a post
request to the following endpoint:
http post http://api.ucc.edu.test/academic/login.php
regno=”PS/CSC/17/00**” password=”password”

![request](https://user-images.githubusercontent.com/7442471/187428648-2bba12ef-ddb8-4549-9f3b-771d237b7500.png)

### Response:
1.	Access Token – used for accessing the student’s details
2.	New Token – used for generating new access token when the access token expires.
An access token can be used to retrieve student’s data by making a request that include the access token in the authorization header of the http request like so:
http http://api.ucc.edu.test/academic/student "Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJzaGEyNTYifQ.eyJzdWIiOiJQU1wvQ1NDXC8xN1wvMDA2NiIsImV4cGlyZXNfaW4iOjE2NTU1OTA1MjF9.XmfHfloV9xJ6kfZVnze0BouS4mYJeX3NGHV1Ygbj8sw"

For the purpose of our demonstration, the access token is set to expire in 20s. When an access token expires, a student’s detail cannot be obtained by the expired token and therefore a new one should be generated using the value of the new_token property in the response body of our request. 

![token_expired](https://user-images.githubusercontent.com/7442471/187429865-f76fe393-d14e-464e-8b53-36193935f240.png)
 

A new access token can be requested through the following endpoint using the new_token value:
http http://api.ucc.edu.test/academic/renew.php token=eyJ0eXAiOiJKV1QiLCJhbGciOiJzaGEyNTYifQ.eyJzdWIiOiJQU1wvQ1NDXC8xN1wvMDA2NiIsImV4cGlyZXNfaW4iOjE2NTYwMjM3OTV9.RaAXe5LWcXeBUJsmdMWJnQvtQf3nzRGdI8zNpFXf9Os
![new_access_token](https://user-images.githubusercontent.com/7442471/187430026-57e9e270-b0b6-447b-b772-4bf53ce628ef.png)


The new access token can be used to request a resource in the following way:

http http://api.ucc.edu.test/academic/student "Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJzaGEyNTYifQ.eyJzdWIiOiJQU1wvQ1NDXC8xN1wvMDA2NiIsImV4cGlyZXNfaW4iOjE2NTU1OTE5Mjh9.GL6SbQRhfdvWPlIicC6pcbNCF0Z5_p7uO2SrP7KqS0s"

Using the new access token to retrieve a student record will yield the following response:

http http://api.ucc.edu.test/academic/student "Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJzaGEyNTYifQ.eyJzdWIiOiJQU1wvQ1NDXC8xN1wvMDA2NiIsImV4cGlyZXNfaW4iOjE2NTU1OTE5Mjh9.GL6SbQRhfdvWPlIicC6pcbNCF0Z5_p7uO2SrP7KqS0s"

HTTP/1.1 200 OK
Connection: Keep-Alive
Content-Type: application/json; charset:UTF-8
Date: Sat, 18 Jun 2022 22:38:38 GMT
Keep-Alive: timeout=5, max=100
Server: Apache/2.4.46 (Unix) mod_fastcgi/mod_fastcgi-SNAP-0910052141 OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13
Transfer-Encoding: chunked
X-Powered-By: PHP/8.0.8

{
    "admission_no": "201736606",
    "alt_email": "akonobeajosiefyn@gmail.com",
    "applicant_id": 201736606,
    "bank_account": null,
    "bank_branchid": null,
    "biometric_enrolment": 0,
    "biometric_enrolment_date": null,
    "card_print": 0,
    "cellphone": "0245158569",
    "centreid": 1,
    "cert_no": null,
    "cgpa": null,
    "cgpa_raw": null,
    "completed": 1,
    "created_at": null,
    "disabilityid": 0,
    "doa": "JUL2017",
    "dob": "2000-09-09",
    "doc": "SEP2021",
    "email": "",
    "entry_modeid": null,
    "entrylevel": "100",
    "fname": "JOSEPHINE",
    "gps_address": "",
    "graduate": 0,
    "hall": "OGUAA HALL",
    "hallid": "OGUAA",
    "homeadd": "AMASAMAN",
    "homephone": "0245158569",
    "hometown": "PRAMKESSE",
    "idcardstatus": 0,
    "inst_email": "jbekoe@stu.ucc.edu.gh",
    "level": "400",
    "lname": "BEKOE",
    "loan_take_times": null,
    "major": "COMPUTER SCIENCE",
    "majorid": "01967",
    "marital_status": "Single",
    "mname": "AKONOBEA",
    "nationality": "GHANAIAN",
    "nationalityid": 0,
    "non_res_add": "",
    "paytype": "NR",
    "pob_region": null,
    "pob_town": "KOFORIDUA",
    "post_box": "C/ONAA ADJELEY S.A. SEKYI, DEPT. OF SOC. & ANTHRO.",
    "post_town": "UCC, CAPE COAST",
    "previous_name": null,
    "progid": "BSCCSC",
    "program": "BSC. ( COMP. SCIENCE)",
    "ref_no": "RF16/201736606",
    "regno": "PS/CSC/17/0066",
    "resident_status": "",
    "room_no": "E63",
    "schoolid": 0,
    "sex": "F",
    "ssnit": null,
    "status": 1,
    "studid": 132851,
    "studyleave": 0,
    "taking_ssnit": null,
    "teachers_regno": null,
    "title": "Ms.",
    "updated_at": null,
    "verification_date": null,
    "verified": 1,
    "withdrawn": null,
    "workplace_id": ""
}

## WHAT COULD GO WRONG

### Wrong regno or password 

http post http://api.ucc.edu.test/academic/login.php regno="PS/CSC/17/0066" password="am"
HTTP/1.1 401 Unauthorized
Connection: Keep-Alive
Content-Type: application/json; charset:UTF-8
Date: Sat, 18 Jun 2022 22:52:26 GMT
Keep-Alive: timeout=5, max=100
Server: Apache/2.4.46 (Unix) mod_fastcgi/mod_fastcgi-SNAP-0910052141 OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13
Transfer-Encoding: chunked
X-Powered-By: PHP/8.0.8

{
    "message": "Invalid credentials!"
}

Absence of a bearer or access token

http http://api.ucc.edu.test/academic/student "Authorization:Bearer "
HTTP/1.1 400 Bad Request
Connection: close
Content-Type: application/json; charset:UTF-8
Date: Sat, 18 Jun 2022 22:55:26 GMT
Server: Apache/2.4.46 (Unix) mod_fastcgi/mod_fastcgi-SNAP-0910052141 OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13
Transfer-Encoding: chunked
X-Powered-By: PHP/8.0.8

{
    "message": "Incomplete authorization header [e.g. Authorization:Bearer...]"
}

# USEFUL ENDPOINTS
-----------------------------------
|ENDPOINT | RESPONSE | DESCRIPTION|
|---------|----------|------------| 
| http://api.ucc.edu.test/academic/login | Access token, renew token | Can be used to retrieve a resource from the database |
| http://api.ucc.edu.test/academic/renew |New Access token and renew token| Can be used to generate new access and renew tokens when the access token expires |
| http://api.ucc.edu.test/academic/student |resource e.g. student profile |Used to obtain student’s profile details|
| http://api.ucc.edu.test/academic/logout | Deletes access token | Removes the user’s access token and deny’s access to a resource from the server |
| http://api.ucc.edu.test/academic/cron |Deletes expired tokens |Removes all expired tokens  and logs users out|

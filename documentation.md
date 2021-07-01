FORMAT: 1A

# BeMo Student API

# Auth Modules

## Register user [POST /api/auth/register]
Register a new user with a `username` and `password`.

+ Request (application/json)
    + Body

            {
                "name": "John Doe",
                "email": "john@doe.com",
                "password": "secret"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "message": "Message (if any)",
                "data": {
                    "token": "TOKEN"
                }
            }

## Login [POST /api/auth/login]
Login system using `email` and `password`.

+ Request (application/json)
    + Body

            {
                "email": "john@doe.com",
                "password": "secret"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "message": "Message (if any)",
                "data": {
                    "token": "TOKEN"
                }
            }

+ Response 401 (application/json)
    + Body

            {
                "status": "success",
                "message": "Credentials not match",
                "data": null
            }

## Logout [POST /api/auth/logout]


+ Request (application/json)
    + Headers

            Authorization: Bearer [TOKEN]

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "message": "Token Revoked",
                "data": null
            }
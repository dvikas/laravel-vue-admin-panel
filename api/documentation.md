FORMAT: 1A

# Reno Api

# Customer Tasks

## Add customer's sub-task [POST /]


+ Request (application/json)
    + Body

            {
                "customer_id": "1f9b81c0-2837-11e8-89ad-c3d72b04bf87",
                "parent_task": "Drawing Room",
                "parent_task_id": "d1b2f0c0-15f2-11e8-b15a-d7ab2ac3a6c7",
                "child_task": "Child Drawing Room 2",
                "child_task_id": "d7157fa0-15f2-11e8-a15f-5372bed2ba95",
                "quantity": "12",
                "unit": "12",
                "rate": "12",
                "total": "12",
                "certificate_id": "null"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": 10,
                "username": "foo"
            }

+ Response 422 (application/json)
    + Body

            {
                "error": {
                    "username": [
                        "Username is already taken."
                    ]
                }
            }
# Usage
## Jobs endpoint
### Rest API Success Responses
1. POST https://api.example.com/api/jobs

REQUEST
```json
Content-Type: application/json
{
    "scrap_info": [
        {
            "url": "https://test-url-1.com/",
            "selector": ".selector-1"
        },
        {
            "url": "https://test-url-2.com/",
            "selector": ".selector-2"
        }
    ]
}
```
RESPONSE
```json
Status: 200 OK
{
    "message": "Create job successful!",
    "data": {
        "id": "1111"
    }
}
```
2. GET https://api.example.com/api/jobs/{id}

RESPONSE
```json
Content-Type: application/json
Status: 200 OK
{
    "message": "OK",
    "data": {
        "id": "1111",
        "scrap_info": [
            {
                "url": "https://test-url-1.com/",
                "selector": ".selector-1"
            },
        ],
        "scraped_data": {
            "https://test-url-1.com/": "Scraped content"
        },
        "status": "Completed"
    }
}
```
3. DELETE https://api.example.com/api/jobs/{id}

RESPONSE
```json
Content-Type: application/json
Status: 200 OK
{
    "message": "Delete job successful",
    "data": ""
}
```
### Rest API Error Responses

1. GET - HTTP Response Code: **404**

```json
Content-Type: application/json
Status: 404 Not Found
{
    "message": "Job not found!",
    "errors": ""
}
```
2. DELETE - HTTP Response Code: **404**

```json
Content-Type: application/json
Status: 404 Not Found
{
    "message": "Job not found!",
    "errors": ""
}
```
3. POST -  HTTP Response Code: **422**

```json
Content-Type: application/json
Status: 422 Unprocessable Content
{
    "message": "The scrap_info.0.url field is required. (and 1 more error)",
    "errors": {
        "scrap_info.0.url": [
            "The scrap_info.0.url field is required."
        ],
        "scrap_info.0.selector": [
            "The scrap_info.0.selector field is required."
        ]
    }
}
```

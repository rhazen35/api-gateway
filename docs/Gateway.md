# The Gateway

This service functions as a Gateway for all external API requests.
Only a single route is provided for publishing the requests to the message broker.

#### Route: http://some_host/api/message/publish

## JSON
The request body has the following structure:

```
{
    "channel": "some_channel_name",
    "payload": {
        "property": "string",
        "property2" boolean
        "property3": {
            "property4": integer
        }
    }
}
```

## Response
The response consist of two parts.

* The status code. (202 Accepted)
* The response body. (messageId)

The messageId can be used to keep track of the message on the client side.
This is very useful for when an event should be pinpointed to a particular message. 

![Response Body Example Image](/docs/image/response-body-example.png)
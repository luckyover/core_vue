<?php

namespace App\Models;

class ResponseCode
{
    // Standard response for successful HTTP requests.
    // The actual response will depend on the request method used.
    // In a GET request, the response will contain an entity corresponding to the requested resource.
    // In a POST request, the response will contain an entity describing or containing the result of the action.
    const OK = 200;

    // The server successfully processed the request and is not returning any content
    const NO_CONTENT = 204;

    // The server cannot or will not process the request due to an apparent client error
    // (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing)
    const BAD_REQUEST = 400;

    // Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided.
    const UNAUTHORIZED = 401;

    // The request contained valid data and was understood by the server, but the server is refusing action.
    // This may be due to the user not having the necessary permissions for a resource or needing an account of some sort,
    // or attempting a prohibited action (e.g. creating a duplicate record where only one is allowed)
    const FORBIDDEN = 403;

    // The requested resource could not be found but may be available in the future. Subsequent requests by the client are permissible.
    const NOT_FOUND = 404;

    // A request method is not supported for the requested resource;
    // for example, a GET request on a form that requires data to be presented via POST, or a PUT request on a read-only resource
    const METHOD_NOT_ALLOW = 405;

    // This response is sent when the web server, after performing server-driven content negotiation,
    // doesn't find any content that conforms to the criteria given by the user agent.
    const NOT_ACCEPTABLE = 406;

    // The server timed out waiting for the request. According to HTTP specifications:
    // "The client did not produce a request within the time that the server was prepared to wait
    const REQUEST_TIME_OUT = 408;

    // The file want get could not be found but may be available in the future. Subsequent requests by the client are permissible.
    const FILE_NOT_FOUND = 499;

    // A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
    const SERVICE_ERROR = 500;

    // The server was acting as a gateway or proxy and received an invalid response from the upstream server.
    const BAD_GATEWAY = 502;

    // The server cannot handle the request (because it is overloaded or down for maintenance). Generally, this is a temporary state
    const SERVICE_UNAVAILABLE = 503;
}

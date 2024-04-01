### [IdentityService](/01_API/app/Services/IdentityService.php)
The `IdentityService` class provides methods related to user identity, such as retrieving IP address, accessing cookies, obtaining current user information, checking permissions, and generating authentication tokens.

<table>
<thead>
<tr>
<th>Method</th>
<th>Parameters</th>
<th>Returns</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>getIPAddress</td>
<td></td>
<td>

`string`: The IP address of the request.</td>
<td>Get IP address of the request.</td>
</tr>
<tr>
<td>getCookie</td>
<td>

- `string $key`: The key of the cookie to retrieve.
- `string $default`: The default value to return if the cookie does not exist. Default is an empty string `''`.</td>
<td>

`string`: Value of the cookie associated with the given key, or the default value if the cookie does not exist.</td>
<td>Get the value of a cookie by key.</td>
</tr>
<tr>
<td>getCurrentUserId</td>
<td></td>
<td>

`string`: The ID of the user currently logged in.</td>
<td>Get the ID of the currently logged-in user.</td>
</tr>
<tr>
<td>getCurrentUser</td>
<td></td>
<td>

`array`: Information about the currently logged-in user.</td>
<td>Get information about the currently logged-in user.</td>
</tr>
<tr>
<td>havePermission</td>
<td>

- `string $user_id`: The ID of the user to check permissions for.
- `string $route_name`: The name of the route the user wants to access.</td>
<td>

`bool`: `true` if the user has permission to access the specified route, otherwise returns `false`.</td>
<td>Check if a user has permission to access a route.</td>
</tr>
<tr>
<td>canAccess</td>
<td>

- `string $route_name`: The name of the route the user wants to access.</td>
<td>

`bool`: `true` if the user can access the specified function, otherwise returns `false`.</td>
<td>Check if a user can access a function.</td>
</tr>
<tr>
<td>getToken</td>
<td>

- `string $username`: The username for which to generate the token.
- `string $result`: Additional data to include in the token.</td>
<td>

`string`: An authentication token for the specified user..</td>
<td>Generate an authentication token for a user.</td>
</tr>
</tbody>
</table>

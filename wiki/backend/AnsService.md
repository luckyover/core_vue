### [AnsService](/01_API/app/Services/AnsService.php)
The `AnsService` class provides various utility methods for string manipulation and UUID generation.

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
<td>isEmpty</td>
<td>

- `string|int|null $str`: The string to check for emptiness.
- `bool $isCheckZero` (optional): A boolean flag indicating whether to consider zero as empty. Default is `false`.</td>
<td>

`bool`: `true` if the string is empty or null, otherwise returns `false`.</td>
<td>Checks whether a given value is empty.</td>
</tr>
<tr>
<td>randomString</td>
<td>

- `int $n`: The length of the random string to generate. Default is `100`.</td>
<td>

`string`: A random string of the specified length.</td>
<td>Generate a random string of specified length.</td>
</tr>
<tr>
<td>genUuid</td>
<td></td>
<td>

`string`: A UUID string.</td>
<td>Generate a UUID (Universally Unique Identifier).</td>
</tr>
</tbody>
</table>
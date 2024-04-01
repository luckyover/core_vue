### [ansSecurity](/02_WEB/src/utils/ansSecurity.ts)
The `ansSecurity` module provides functions for encoding and decoding parameters, parsing JWT tokens, and generating passwords with specific rules.
``` ts
import { ansSecurity } from '@/utils'

// Example usage
const encodedParams = ansSecurity.encodeParams({ key: 'value' });
console.log(encodedParams); // Output: eyJrZXkiOiJ2YWx1ZSJ90

const decodedParams = ansSecurity.decodeParams(encodedParams);
console.log(decodedParams); // Output: { key: 'value' }

const jwtPayload = ansSecurity.parseJwt('your.jwt.token');
console.log(jwtPayload);

const generatedPassword = ansSecurity.generatePassword(16, [
  { chars: 'abcdefghijklmnopqrstuvwxyz', min: 4 },
  { chars: '0123456789', min: 4 },
  { chars: '!@#$%^&*()', min: 4 },
]);
console.log(generatedPassword); // Output: 0zto4n^1@z!(3ik$
```

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
<td>encodeParams</td>
<td>

- `params: IAnsDynamic | null` (optional): An object containing parameters to encode.

</td>
<td>The encoded base64 string.</td>
<td>Encodes parameters into a base64 string.</td>
</tr>
<tr>
<td>decodeParams</td>
<td>

- `params: string | null` (optional): The base64 string to decode.

</td>
<td>An object containing decoded parameters.</td>
<td>Decodes a base64 string into parameters.</td>
</tr>
<tr>
<td>parseJwt</td>
<td>

- `token: string | null` (optional): The JWT token to parse.

</td>
<td>An object representing the payload of the JWT token.</td>
<td>Parses a JWT token and extracts the payload.</td>
</tr>
<tr>
<td>generatePassword</td>
<td>

- `length: number` (optional): The length of the generated password. Default is `12`.
- `rules: Array<{ chars: string; min: number }>` (optional): An array of objects specifying character sets and minimum occurrences.

</td>
<td>A randomly generated password string.</td>
<td>Generates a random password based on specified rules.</td>
</tr>
</tbody>
</table>
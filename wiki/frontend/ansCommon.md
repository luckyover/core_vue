### [ansCommon](/02_WEB/src/utils/ansCommon.ts)
The `ansCommon` module provides a set of utility functions commonly used across the application. These functions include checking for emptiness, detecting mobile devices, extracting user information from a token, and shuffling strings.
``` ts
import { ansCommon } from '@/utils'

// Example usage
const emptyCheckResult = ansCommon.isEmpty('');
console.log(emptyCheckResult); // Output: true

const mobileCheckResult = ansCommon.isMobile();
console.log(mobileCheckResult); // Output: true if the environment is a mobile device, otherwise false

const user = ansCommon.getUserFromToken();
console.log(user); // Output: User profile extracted from the token

const shuffledString = ansCommon.shuffleString('hello');
console.log(shuffledString); // Output: ehlol or similar shuffled string
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
<td>isEmpty</td>
<td>

- `str: string | number | undefined | null | object`: A string, number, undefined, null, or object to check for emptiness.
- `isCheckZero: boolean` (optional): A boolean flag indicating whether to consider zero as empty. Default is `false`.

</td>
<td>

`true` if the value is empty, otherwise `false`.

</td>
<td>Checks whether a given value is empty.</td>
</tr>
<tr>
<td>isMobile</td>
<td></td>
<td>

`true` if the environment is a mobile device, otherwise `false`.

</td>
<td>Detects if the current environment is a mobile device.</td>
</tr>
<tr>
<td>getUserFromToken</td>
<td></td>
<td>An object representing the user profile extracted from the token.</td>
<td>Retrieves user profile information from a stored token.</td>
</tr>
<tr>
<td>isMobile</td>
<td></td>
<td>

`true` if the environment is a mobile device, otherwise `false`.

</td>
<td>Detects if the current environment is a mobile device.</td>
</tr>
<tr>
<td>shuffleString</td>
<td>

- `str: string`: The input string to be shuffled.
- `maxLength: number` (optional): The maximum length of the shuffled string. Default is `0` (no maximum length).

</td>
<td>The shuffled string.</td>
<td>Shuffles the characters of a string.</td>
</tr>
</tbody>
</table>
### [ansNumber](/02_WEB/src/utils/ansNumber.ts)
The `ansNumber` module provides utility functions for handling numeric values. These functions include converting strings to numbers, formatting numbers into strings with various options such as decimals, negatives, and money formats.

``` ts
import { ansNumber } from '@/utils'

// Example usage
const numberResult = ansNumber.toNumber('123');
console.log(numberResult); // Output: 123

const formattedNumber = ansNumber.toNumberString(123456.789, {
  isDecimal: true,
  decimal: 2,
  isNegative: true,
  isMoney: true,
});
console.log(formattedNumber); // Output: -123,456.78
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
<td>toNumber</td>
<td>

- `str: string | undefined | null`: A string or undefined/null to convert to a number.
- `isDefaultIsMax: boolean` (optional): A boolean flag indicating whether to return the maximum possible number (4294967295) when the input is empty. Default is `false`.

</td>
<td>A number converted from the input string.</td>
<td>Converts a string to a number.</td>
</tr>
<tr>
<td>toNumberString</td>
<td>

- `str: string | number`: A string or number to convert to a formatted number string.
- `options` (optional): An object containing formatting options.
    - `isDecimal: boolean` (optional): A boolean flag indicating whether to include decimal points. Default is `true`.
    - `decimal: number`: The number of decimal places to include.
    - `isNegative: boolean` (optional): A boolean flag indicating whether to allow negative numbers. Default is `false`.
    - `isMoney: boolean`: A boolean flag indicating whether to format the number as currency.
    - `maxLength: number` (optional): The maximum length of the formatted string.

</td>
<td>A formatted number string based on the input and options.</td>
<td>Converts a string or number to a formatted number string.</td>
</tr>
</tbody>
</table>


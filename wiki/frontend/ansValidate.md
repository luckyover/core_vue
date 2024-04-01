### [ansValidate](/02_WEB/src/utils/ansValidate.ts)
The `ansValidate` module provides functions for validating input data, checking for errors, and managing error messages in applications.

``` ts
import { ansValidate } from '@/utils'

// Example usage
const inputErrors = ansValidate.getInputError('username');
console.log(inputErrors); // Output: {errors: ["このフィールドは必須です。"], error: 'このフィールドは必須です。', isError: true}

ansValidate.removeInputError('username')

const isValidEmail = ansValidate.isEmail('test@example.com');
console.log(isValidEmail) // Output: true

const isValidPhone = ansValidate.isPhone('123-456-7890');
console.log(isValidPhone) // Output: true

const isValidZipCode = ansValidate.isZipCode('123-4567')
console.log(isValidZipCode) // Output: true

const isKatakana = ansValidate.isKatakana('カタカナ')
console.log(isKatakana) // Output: true

const data = { email: 'test@example.com', phone: '123-456-7890' }
const validationRules = { email: 'required|email', phone: 'required|phone' }
const isValidData = ansValidate.isValidData(data, validationRules)
console.log(isValidData) // Output: true

ansValidate.removeAllErrors()

ansValidate.focusFirstError()

ansValidate.removeError('username')
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
<td>getInputError</td>
<td>

- `name: string` (optional): The name of the input field.

</td>
<td>An object containing input errors.</td>
<td>Retrieves input errors based on the input name.</td>
</tr>
<tr>
<td>removeInputError</td>
<td>

- `name: string` (optional): The name of the input field.

</td>
<td></td>
<td>Removes input errors associated with the input name.</td>
</tr>
<tr>
<td>isEmail</td>
<td>

- `str: string` (optional): The string to validate.

</td>
<td>

`true` if the string is a valid email format, otherwise `false`.

</td>
<td>Checks if the input string is a valid email format.</td>
</tr>
<tr>
<td>isPhone</td>
<td>

- `str: string` (optional): The string to validate.

</td>
<td>

`true` if the string is a valid phone number format, otherwise `false`.

</td>
<td>Checks if the input string is a valid phone number format.</td>
</tr>
<tr>
<td>isZipCode</td>
<td>

- `str: string` (optional): The string to validate.

</td>
<td>

`true` if the string is a valid ZIP code format, otherwise `false`.

</td>
<td>Checks if the input string is a valid ZIP code format.</td>
</tr>
<tr>
<td>isKatakana</td>
<td>

- `str: string` (optional): The string to validate.

</td>
<td>

`true` if the string contains only Katakana characters, otherwise `false`.

</td>
<td>Checks if the input string contains only Katakana characters.</td>
</tr>
<tr>
<td>isValidData</td>
<td>

- `data: IAnsDynamic`: The data object to validate.
- `rules: IAnsValidateRule`: Rules specifying validation criteria.

</td>
<td>

`true` if the data is valid, otherwise `false`.

</td>
<td>Validates input data based on specified rules.</td>
</tr>
<tr>
<td>removeAllErrors</td>
<td></td>
<td></td>
<td>Removes all errors on screen.</td>
</tr>
<tr>
<td>removeError</td>
<td>

- `item: string`: The item identifier to remove error from.

</td>
<td></td>
<td>Removes an error associated with the specified item.</td>
</tr>
<tr>
<td>focusFirstError</td>
<td></td>
<td></td>
<td>Sets focus to the first error element in the document.</td>
</tr>
</tbody>
</table>

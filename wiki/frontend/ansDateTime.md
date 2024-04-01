### [ansDateTime](/02_WEB/src/utils/ansDateTime.ts)
The `ansDateTime` module provides functions for handling date and time-related operations. These functions enable conversion of date and time strings, arithmetic operations on time, and comparison between dates and times.

``` ts
import { ansDateTime } from '@/utils'

// Example usage
const dateString = ansDateTime.toDateString('20231231');
console.log(dateString); // Output: '2023/12/31'

const timeString = ansDateTime.toTimeString('1430');
console.log(timeString); // Output: '14:30'

const comparison = ansDateTime.compareTime('09:00', '12:00');
console.log(comparison); // Output: -1
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
<td>toDateString</td>
<td>

- `str: string | undefined | null`: The input string representing a date.

</td>
<td>The formatted date string.</td>
<td>Converts a string to a formatted date string (YYYY/MM/DD).</td>
</tr>
<tr>
<td>toMonthString</td>
<td>

- `str: string | undefined | null`: The input string representing a date.

</td>
<td>The formatted month string.</td>
<td>Converts a string to a formatted month string (YYYY/MM).</td>
</tr>
<tr>
<td>toTimeString</td>
<td>

- `str: string | undefined | null`: The input string representing a time.
- `isOnly24h: boolean` (optional): A boolean indicating whether to enforce 24-hour format. Default is `false`.

</td>
<td>The formatted time string.</td>
<td>Converts a string to a formatted time string.</td>
</tr>
<tr>
<td>plusTime</td>
<td>

- `time1: string | null`: The first time value.
- `time2: string | null`: The second time value.

</td>
<td>The sum of the two time values.</td>
<td>Adds two time values together.</td>
</tr>
<tr>
<td>minusTime</td>
<td>

- `time1: string | null`: The first time value.
- `time2: string | null`: The second time value.

</td>
<td>The difference between the two time values.</td>
<td>Subtracts one time value from another.</td>
</tr>
<tr>
<td>compareTime</td>
<td>

- `time1: string | null`: The first time value.
- `time2: string | null`: The second time value.

</td>
<td>

`1` if `time1` is greater, `0` if they are equal, `-1` if `time2` is greater.

</td>
<td>Compares two time values.</td>
</tr>
<tr>
<td>compareDate</td>
<td>

- `date1: string | null`: The first date value.
- `date2: string | null`: The second date value.

</td>
<td>

`1` if `date1` is greater, `0` if they are equal, `-1` if `date2` is greater.

</td>
<td>Compares two date values.</td>
</tr>
<tr>
<td>compareMonth</td>
<td>

- `month1: string | null`: The first month value.
- `month2: string | null`: The second month value.

</td>
<td>

`1` if `month1` is greater, `0` if they are equal, `-1` if `month2` is greater.

</td>
<td>Compares two month values.</td>
</tr>
<tr>
<td>getDayOfWeek</td>
<td>

- `day: number` (optional): The numeric representation of the day (0-6, where 0 is Sunday).

</td>
<td>

`1` if `month1` is greater, `0` if they are equal, `-1` if `month2` is greater.

</td>
<td>The abbreviated name of the day of the week (e.g., "日" for Sunday).</td>
</tr>
<tr>
<td>getAbsoluteMonths</td>
<td>

- `momentDate: moment.Moment | string | null` (optional): The date to calculate months from.

</td>
<td>The total number of months.</td>
<td>Calculates the total number of months from a given date.</td>
</tr>
<tr>
<td>monthDiff</td>
<td>

- `start: moment.Moment | string | null`: The starting date.
- `end: moment.Moment | string | null`: The ending date.

</td>
<td>Calculates the difference in months between two dates.</td>
<td>The difference in months.</td>
</tr>
</tbody>
</table>

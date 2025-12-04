<?php
//create a handle so I can read "input.txt" line by line
$handle = fopen('input.txt', 'r');
$totaljoltage = 0;
$lineNum = 0;
$skippedLines = 0;
$sumPerLine = [];
while (($line = fgets($handle)) !== false) {
    $lineNum++;
    $line = trim($line);
    //find the position in line[] with the highest digit, unless it's the last digit then it should be the first instanse of the second highest digit   
    $lineArray = str_split($line);
    $highestDigit = max($lineArray);
    $remainingDigits = array_diff($lineArray, [$highestDigit]);
    $secondHighestDigit = !empty($remainingDigits) ? max($remainingDigits) : $highestDigit;
    $position = strpos($line, $highestDigit);
    if ($position == strlen($line) - 1) {
        $position = strpos($line, $secondHighestDigit);
    }
    
    //now try to find the highest digit AFTER position (in the substring after $position)
    if ($position < strlen($line) - 1) {
        $substringAfter = substr($line, $position + 1);
        $substringAfterArray = str_split($substringAfter);
        $highestDigitAfter = max($substringAfterArray);
        $positionAfter = strpos($substringAfter, $highestDigitAfter);
        //totaljoltage += two-digit number formed by concatenating digit at $position and digit at ($position + 1 + $positionAfter)
        $digit1 = $line[$position];
        $digit2 = $line[$position + 1 + $positionAfter];
        $lineTotal = (int)($digit1 . $digit2); // Concatenate digits to form two-digit number
        $totaljoltage += $lineTotal;
        $sumPerLine[] = $lineTotal;
    } else {
        $skippedLines++;
    }
}
fclose($handle);
$output = "Total joltage: " . $totaljoltage . "\n";
$output .= "Total lines: " . $lineNum . "\n";
$output .= "Skipped lines: " . $skippedLines . "\n";
$output .= "Processed lines: " . ($lineNum - $skippedLines) . "\n";
if (count($sumPerLine) > 0) {
    $output .= "Average per processed line: " . ($totaljoltage / count($sumPerLine)) . "\n";
    $output .= "Min per line: " . min($sumPerLine) . "\n";
    $output .= "Max per line: " . max($sumPerLine) . "\n";
    $output .= "First 10 line totals: " . implode(", ", array_slice($sumPerLine, 0, 10)) . "\n";
}
echo $output;
file_put_contents('output.txt', $output);
?>
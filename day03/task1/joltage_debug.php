<?php
//create a handle so I can read "input.txt" line by line
$handle = fopen('input.txt', 'r');
$totaljoltage = 0;
$lineNum = 0;
$skippedLines = 0;
while (($line = fgets($handle)) !== false) {
    $lineNum++;
    $line = trim($line);
    
    //find the position in line[] with the highest digit, unless it's the last digit then it should be the first instanse of the second highest digit   
    $lineArray = str_split($line);
    $highestDigit = max($lineArray);
    $secondHighestDigit = max(array_diff($lineArray, [$highestDigit]));
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
        $digit1 = (int)$line[$position];
        $digit2 = (int)$line[$position + 1 + $positionAfter];
        $lineTotal = $digit1 + $digit2;
        $totaljoltage += $lineTotal;
        
        if ($lineNum <= 5) {
            echo "Line $lineNum: position=$position, digit1=$digit1, positionAfter=$positionAfter, digit2=$digit2, lineTotal=$lineTotal\n";
        }
    } else {
        $skippedLines++;
        if ($lineNum <= 5) {
            echo "Line $lineNum: SKIPPED (position=$position, strlen=" . strlen($line) . ")\n";
        }
    }
}
fclose($handle);
echo "\nTotal joltage: $totaljoltage\n";
echo "Skipped lines: $skippedLines\n";
echo "Processed lines: " . ($lineNum - $skippedLines) . "\n";
echo "Average per processed line: " . ($totaljoltage / ($lineNum - $skippedLines)) . "\n";
?>

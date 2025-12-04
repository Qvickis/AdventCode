<?php
// Part Two: Select exactly 12 digits from each line to form the largest possible 12-digit number
//create a handle so I can read "input.txt" line by line
$handle = fopen('input.txt', 'r');
$totaljoltage = 0;
$lineNum = 0;
$sumPerLine = [];

/**
 * Find the largest number by selecting exactly k digits from a string while maintaining order
 * Uses a greedy stack-based algorithm: remove smaller digits when we encounter larger ones
 */
function findLargestNumber($digits, $k) {
    $n = strlen($digits);
    if ($k >= $n) {
        return $digits; // Return all digits if k >= length
    }
    
    $toRemove = $n - $k; // How many digits we need to remove
    $stack = [];
    
    for ($i = 0; $i < $n; $i++) {
        $currentDigit = $digits[$i];
        
        // While we can still remove digits and current digit is larger than the last kept digit,
        // remove the smaller digit to maximize the result
        // Also ensure we don't remove too many (we need at least k digits total)
        while ($toRemove > 0 && !empty($stack) && $stack[count($stack) - 1] < $currentDigit) {
            array_pop($stack);
            $toRemove--;
        }
        
        $stack[] = $currentDigit;
    }
    
    // If we still need to remove more digits (happens when digits are in descending order),
    // remove from the end (smallest digits)
    while (count($stack) > $k) {
        array_pop($stack);
    }
    
    return implode('', $stack);
}

while (($line = fgets($handle)) !== false) {
    $lineNum++;
    $line = trim($line);
    
    if (empty($line)) {
        continue;
    }
    
    // Find the largest 12-digit number by selecting exactly 12 digits
    $selectedDigits = findLargestNumber($line, 12);
    $lineTotal = (int)$selectedDigits;
    $totaljoltage += $lineTotal;
    $sumPerLine[] = $lineTotal;
    
    // Debug output for first few lines
    if ($lineNum <= 5) {
        echo "Line $lineNum: Original length=" . strlen($line) . ", Selected: $selectedDigits, Value: $lineTotal\n";
    }
}

fclose($handle);

$output = "--- Part Two ---\n\n";
$output .= "Total output joltage: " . number_format($totaljoltage) . "\n";
$output .= "Total lines processed: " . $lineNum . "\n";
if (count($sumPerLine) > 0) {
    $output .= "Average per line: " . number_format($totaljoltage / count($sumPerLine), 2) . "\n";
    $output .= "Min per line: " . min($sumPerLine) . "\n";
    $output .= "Max per line: " . max($sumPerLine) . "\n";
}

echo $output;
file_put_contents('output2.txt', $output);
?>

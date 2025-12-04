<?php
function findLargestNumber($digits, $k) {
    $n = strlen($digits);
    if ($k >= $n) {
        return $digits;
    }
    
    $toRemove = $n - $k;
    $stack = [];
    
    for ($i = 0; $i < $n; $i++) {
        $currentDigit = $digits[$i];
        
        while ($toRemove > 0 && !empty($stack) && $stack[count($stack) - 1] < $currentDigit) {
            array_pop($stack);
            $toRemove--;
        }
        
        $stack[] = $currentDigit;
    }
    
    // Remove remaining digits from the end if needed
    while (count($stack) > $k) {
        array_pop($stack);
    }
    
    return implode('', $stack);
}

// Test cases from the problem
$tests = [
    ['987654321111111', 12, '987654321111'],
    ['811111111111119', 12, '811111111119'],
    ['234234234234278', 12, '434234234278'],
    ['818181911112111', 12, '888911112111']
];

echo "Testing algorithm:\n\n";
foreach ($tests as $idx => $test) {
    $result = findLargestNumber($test[0], $test[1]);
    $match = ($result === $test[2]) ? '✓ PASS' : '✗ FAIL';
    echo "Test " . ($idx + 1) . ": $match\n";
    echo "  Input:    {$test[0]}\n";
    echo "  Expected: {$test[2]}\n";
    echo "  Got:      $result\n\n";
}

<?php
// create a function that reads the input.txt file and stores it in an array 
function readInput() {
    // this handle can be used to read the file line by line 
    $handle = fopen('input.txt', 'r');
    return $handle;
}

function number_of_zero_location($handle) {
    $current_position = 50;
    $zero_location = 0;
    
    // Read file line by line
    while (($line = fgets($handle)) !== false) {
        $line = trim($line); // Remove whitespace and newline
        
        if (empty($line)) {
            continue; // Skip empty lines
        }
        
        // Check if line starts with 'L' or 'R'
        if (substr($line, 0, 1) === 'L') {
            // Extract number after 'L'
            $number = (int)substr($line, 1);
            $current_position = $current_position - $number;
        } elseif (substr($line, 0, 1) === 'R') {
            // Extract number after 'R'
            $number = (int)substr($line, 1);
            $current_position = $current_position + $number;
        }
        
        // Handle wrapping: keep position in range 0-99 using modulo arithmetic
        // This handles both positive overflow (>99) and negative underflow (<0)
        $current_position = (($current_position % 100) + 100) % 100;
        
        // Check if we're at position 0
        if ($current_position == 0) {
            $zero_location += 1;
        }
    }
    
    return $zero_location;
}

// Execute the function and print the result
$handle = readInput();
$result = number_of_zero_location($handle);
fclose($handle);
echo "Number of times zero location was reached: " . $result . "\n";

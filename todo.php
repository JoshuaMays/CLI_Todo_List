<?php

 // Create array to hold list of todo items
 $items = array();

// List array items formatted for CLI
function list_items($list)
{
    // Create empty starter string
    $listString = '';
    
    // Loop through an array $list to pull out $key and $items from the array.
    foreach ($list as $key => $items) {
    	// Increment $key so list number starts at 1 rather than 0.
    	$key++;
    	// Concatenate each list item to $listString
    	$listString .= "[{$key}] {$items}" . PHP_EOL;
    }
    return $listString;
}

// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
function get_input($upper = FALSE) 
{
    // // Return filtered STDIN input
    // if ($upper) {
    // 	$userInput = strtoupper(trim(fgets(STDIN)));
    // 	return $userInput;
    // }
    // else {
    // 	$userInput = trim(fgets(STDIN));
    // 	return $userInput;
    // }

	// Ternary Version
	$userInput = $upper ? $userInput = strtoupper(trim(fgets(STDIN))) : $userInput = trim(fgets(STDIN));
	return $userInput;
}

// The loop!
do {
    // Echo the list produced by the function
    echo list_items($items);

    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = get_input();


    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = get_input();
        // Remove from array
        unset($items[--$key]);
        $items = array_values($items);
    }
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);

?>
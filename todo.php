<?php

// Create array to hold list of todo items
$items = array();

// The Loop!
do {
	// Iterate through list items
	foreach ($items as $key => $item) {
		// Increment $key so array starts at 1, not 0.
		$key++;
		// Display each item and a newline
		echo "[{$key}] {$item}\n";
	}

	// Show the menu options 
	echo '(N)ew item, (R)emove item, (Q)uit : ';

	// Get the input from user
	// Use trim() to remove whitespace and newlines
	// Use strtoupper() to accept lower case input
	$input = strtoupper(trim(fgets(STDIN)));

	// Check for actionable input
	if ($input == 'N') {
		// Ask for entry
		echo 'Enter item: ';
		// Add entry to list array 
		$items[] = trim(fgets(STDIN));
	} elseif ($input == 'R') {
		// Remove which item?
		echo 'Enter item number to remove: ';
		// Get array key
		$key = trim(fgets(STDIN));
		// Remove from array. Subtract 1 from key so
		// the correct key=>value is removed.
		unset($items[$key - 1]);
		$items = array_values($items);
	}
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);

?>
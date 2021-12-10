<pre>The Challenge

Your company needs you to implement a Binary Search Tree (BST), using the language of your choice. Your solution will be utilized by several different teams throughout your organization. Initially, this BST only needs to support integers. 

Requirements

 The BST must be built from an array of integers
 DONE- Implement a method that returns the deepest nodes in the BST along with their depth
 DONE- Implement any supporting methods needed for the solution to be useable by different teams throughout the organization

Example:
	Input: 12,11,90,82,7,9
	Output: deepest, 9; depth, 3

What we are looking for
 - Correctness - will your solution produce the desired results
 - Conciseness - does your solution balance clarity and brevity
 - Maintainability - does your code stand up to changing needs
 - Anti-patterns - does your solution avoid anti-patterns
<hr>
<?php

// require function library
require_once "bst.function.php";

// Create an array to be inserted into the binary search tree
// Larger array for test purposes
//$insertArray = array(50,40,60,55,81,99,102,3,56,34,54);
$insertArray = array(12,11,90,82,7,9);

// Customized Array Options
// If overrideIntegers is set, parses them into $insertArray
if(isset($_GET['overrideIntegers'])){
	$explodedInput = explode(',', $_GET['overrideIntegers']);
	$sanitizedInput = array();
	foreach($explodedInput as $v){
		// check if the single value casts entirely to integers.  if yes, this is valid, otherwise ignored.
		if(ctype_digit($v)){
        	$sanitizedInput[] = intval($v);
    	}
	}
	if(count($sanitizedInput) > 0){
		echo "Override was declared.  <a href=bst-depth.php>Click here to clear the input.</a>\r\n";
		$insertArray = $sanitizedInput;
	}
	elseif(count($sanitizedInput) === 0){
		echo "Override text was submitted, but ignored, as it contained no pure integer values.\r\n";
	}
	
}

// Create the Binary Search Tree empty base
$tree = new BinaryTree();

// Insert all elements of the array
foreach($insertArray as $v){
	//$tree->insertIterative($v);
	$tree->insertValue($v);
}

// Output required format
echo "<b>Demonstration of Tree: Output per requirement spec</b> \r\n\r\n";
echo "Input: " . implode($insertArray, ",") . "\r\n";
echo "Output: " . $tree->getDeepestChildrenTechSpec();
echo "<hr>";

// Enable customization fo the array
echo "<b>Demonstration of Tree: Custom Array</b> \r\n\r\n";
echo "A custom comma separated set of integers can be applied.  Error handling is implemented.";
?>
<form method="GET">
<input type="text" name="overrideIntegers">
<input type="submit">
</form>

<?php
// Further demonstration of tree: PlantUML
echo "Demonstration of Tree: PlantUML \r\n\r\n";
$uml = $tree->getUML();
$url = $tree->getUMLURL();
echo "<a target=\"_blank\" href=\"$url\">Click here to view a mapping of this tree.  This may fail if the input array becomes too large.</a>\r\n\r\n";
echo "The raw plant UML: \r\n\r\n";
echo $uml;
echo "<hr>";

// Demonstration of search value
echo "Demonstration of Searching \r\n\r\n";
echo "This provides a method by which individual values can be searched.\r\n";
echo "Below represents a loop calling findValue method over each element of the integer insert array.\r\n\r\n";
foreach(array_merge($insertArray, array(99999, -99999, 100001, -100001)) as $value){
	$searchResult = $tree->findValue($value);
	$ancestryString = implode($searchResult['ancestry'], ",");
	if($searchResult['exists'] === FALSE){
		echo "  $value does NOT exist, but if it did it would have ";
	}
	else{
		echo "  $value DOES exist, and it has ";
	}
	echo "depth [{$searchResult['depth']}], ancestors [$ancestryString]\r\n";
}

echo "\r\n\r\nNote that some values that hopefully were not in the integer insert array are searched, showing misses.\r\n\r\n";
echo "<hr>";

// Debug dump of the tree
echo "Debug dump of the tree for review (var_dump(\$tree)) \r\n\r\n";
var_dump($tree);

?>
</pre>
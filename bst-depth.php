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
$insertArray = array(12,11,90,82,7,9);

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

// Further demonstration of tree: PlantUML
echo "Demonstration of Tree: PlantUML \r\n\r\n";
$uml = $tree->getUML();
$url = $tree->getUMLURL();
echo "<a target=\"_blank\" href=\"$url\">Click here to view a mapping of this tree.  This may fail if the input array becomes too large.</a>\r\n\r\n";
echo "The raw plant UML: \r\n\r\n";
echo $uml;
echo "<hr>";

// Debug dump of the tree
echo "Debug dump of the tree for review (var_dump(\$tree)) \r\n\r\n";
var_dump($tree);

?>
</pre>

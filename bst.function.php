<?php

// Preface
// I was torn between creating either one single class to encapsulate both the definition of a tree
// and a node in the tree together, but chose to separate the tree from the nodes.  This is 
// primarily predicated on the idea that I may eventually want to add metadata properties to the
// tree object that are separate from properties that any individual nodes may have.
/************************************************************************************************/

// Class BinaryTree represents the parent BinaryTree object, functioning essentially as a 
// controller.  Using this class will allow you to access methods and properties associated with 
// the BinaryTreeNode rootNode object.

class BinaryTree{
	// Initialize variables
	public function __construct(){
		$this->rootNode = NULL;
	}

	// Insert a new value into the tree
	public function insertValue($value){
		// Check value is an integer
		if(!is_int($value)){
			return;
		}

		// If there is no root node, create one.  Otherwise, call the BinaryTreeNode recursive
		// insertion method.
		if($this->rootNode === NULL){
			$this->rootNode = new BinaryTreeNode($value);
		}
		else{
			$this->rootNode->insertValue($value);
		}		
	}

	// Returns an array detailing the deepest nodes in the BST along with their depth in an array.
	// return array(
	//		'maxDepth' => $maxDepth // integer representing the maximum depth of the tree.
	//		'nodes' => $nodes // array of values [index]['value' => int value, 'count' => int count]
	public function getDeepestChildren(){
		// check empty case
		if($this->rootNode === NULL){
			return 0;
		}
		
		// Leverage binary tree node methods to produce the data.
		return $this->rootNode->getDeepestChildren();
	}

	// Returns a string of deepest nodes in a format that exactly mirrors the requirements doc
	// Sample: "deepest, 9; depth, 3"
	public function getDeepestChildrenTechSpec(){
		$raw = $this->getDeepestChildren();
		$returnString = "deepest, " . implode($raw['nodes']) . "; depth, " . $raw['maxDepth'];
		return $returnString;
	}

	// Returns a well-formed UML string that can visualize the Binary Search Tree
	public function getUML(){
		// Check empty case
		if($this->rootNode === NULL){
			return "";
		}
		
		// Leverage node functions to produce data
		return $this->rootNode->getUML();
	}

	// Returns a plantuml.com-formatted URL for direct html embedding
	public function getUMLURL(){
		if($this->rootNode === NULL){
			return "";
		}

		// Leverage node functions to produce data
		$uml = $this->rootNode->getUML();

		// plantuml.com  spec at https://plantuml.com/text-encoding#32ec0710e82adf79 calls for hex
		// encoding and prefixing the encoded hex with ~h
		$urlEncodedUml = bin2hex($uml);
		$url = "https://www.plantuml.com/plantuml/uml/~h" . $urlEncodedUml;
		return $url;
	}

} //end class BinaryTree

// Class BinaryTreeNode represents a simple node within a binary tree.  
//  - int value is the value of the node
//  - int count is the frequency of the value occurring.
//  - BinaryTreeNode left and BinaryTreeNode right represent children of this node.

class BinaryTreeNode{
	// Initialize variables
	public function __construct(int $value = NULL){
		$this->value = $value;
		$this->count = 1;
		$this->left = NULL;
		$this->right = NULL;
	}

	function insertValue(int $value){
		// validate input is valid
		if(!is_int($value)){
			// echo "$value is not an integer.";
			return;
		}

		// If the inserting value is less than this node value, it's a "left"
		if($value < $this->value){
			// If the child is null, then instantiate a new node.  otherwise recurse to child node
			if($this->left === NULL){
				$this->left = new BinaryTreeNode($value);
			}
			else{
				$this->left->insertValue($value);
			}
		}
		// If the inserting value is greater than this node value, it's a "right"
		elseif($value > $this->value){
			// If the child is null, then instantiate a new node.  otherwise recurse to child node
			if($this->right === NULL){
				$this->right = new BinaryTreeNode($value);	
			}
			else{
				$this->right->insertValue($value);
			}
		}
		// - While elseif is not explicitly required and just an else would technically suffice,
		// it is the only remaining case and is called out for ease of readability.  This could 
		// be removed for minor optimization.
		elseif($value === $this->value){
			$this->count++;
		}
	}

	// Return an associative array in which all nodes are mapped to their depth.  Passes an array
	// $nodes to itself to preserve values across iterations.
	// $nodes['depth']['incrementing index']['value' => integer value, 'count' => frequency]
	function getAllChildrenByDepth($depth = 0, &$nodes = array()){
		$nodes[$depth][] = array('value' => $this->value, 'count' => $this->count);
		$depth++;
		// If left node exists, traverse the tree
		if($this->left != NULL){
		 	$this->left->getAllChildrenByDepth($depth, $nodes);
		}
		// if right node exists, traverse its tree
		if($this->right != NULL){
			$this->right->getAllChildrenByDepth($depth, $nodes);
		}
		return $nodes;
	}

	// Leverages data parsed by getAllChidlrenByDepth to find the deepest children in the tree
	function getDeepestChildren(){
		// Receive formatted array from getAllChildrenByDepth
		$nodesByDepth = $this->getAllChildrenByDepth();
		
		// Since depth is mapped to the first key, we can infer maximum depth equals maximum key.
		$maxDepth = max(array_keys($nodesByDepth));
		
		// Pass each member of the maximum depth array into the return nodes array
		$nodes = array();
		foreach($nodesByDepth[$maxDepth] as $node){
			$nodes[] = $node['value'];
		}
		return array('maxDepth' => $maxDepth, 'nodes' => $nodes);
	}

	// Value-add function to generate a UML-formatted string to visually represent the BST. This
	// creates a string of format [parent value] ~~ [child value]:[L|R] which is compliance with
	// UML formatting to draw relationships.  Since this operates left to right first, this will
	// always feed PlantUML what it needs to create an effective visual representation.
	function getUML(&$umlString = ""){
		if($this->left != NULL){
		 	$umlString.= strval($this->value) . " ~~ " . $this->left->value . ":L\r\n";
		 	$this->left->getUML($umlString);
		}
		if($this->right != NULL){
		 	$umlString.= strval($this->value) . " ~~ " . $this->right->value . ":R\r\n";
		 	$this->right->getUML($umlString);
		}
		return $umlString;
	}
} //end class BinaryTreeNode

?>

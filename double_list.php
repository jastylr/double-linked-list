<?php

// Code to create a doubly-linked list where Nodes can be inserted
// and removed from any location. I tried to comment this file as best
// as I could to explain what is going on so read over them.
 
// Each item in the list is an object of Node which
// contains the data for that node and also a pointer
// to the next and previous Nodes 
class Node {
    
    public $data;
    public $next;
    public $previous;
 
    // Set the data value during contruction
    function __construct($data) {
        $this->data = $data;
    }
 
    // Return the data value of the selected Node
    public function getNode() {
        return $this->data;
    }
}
 
// DoubleLinkedList - class to handle creating and manipulating a
// doubly-linked list 
class DoubleLinkedList {
    
    private $firstNode;
    private $lastNode;
    private $nodeCount;
 
    // Initialize the first and last nodes to NULL during construction
    // and set the total Node count to 0
    function __construct() {
        $this->firstNode = NULL;
        $this->lastNode = NULL;
        $this->nodeCount = 0;
    }
 
    // isEmpty method - checks wheter the list is empty
    public function isEmpty() {
        return ($this->nodeCount <= 0);
    }

    // insertHead method - Inserts a new Node at the beginning (or head) of the list
    public function insertHead($data) {
        // Create a new Node and pass it a data value
        $newNode = new Node($data);
 
        // If the list is currently empty, meaning no Nodes
        if($this->isEmpty()) {
            // Set lastNode which would be NULL to the new Node
            $this->lastNode = $newNode;
        } else {
            // Otherwise we already have a firstNode becaue the list
            // is not empty. So set the current firstNode's previous
            // pointer to point to our new Node which in essence says
            // the the original firstNode now comes after our new Node
            $this->firstNode->previous = $newNode;
        }
 
        // Set the new Node's next pointer to the firstNode. This may
        // either be NULL if there aren't any other nodes or it will
        // point to the previous firstNode if there was one. We do this
        // before overwriting firstNode with our new Node
        $newNode->next = $this->firstNode;
        
        // Now set firstNode to be our new Node and increase the node count
        $this->firstNode = $newNode;
        $this->nodeCount++;
    }
 
    // insertTail - Inserts a new Node at the end (or tail) of the list
    public function insertTail($data) {
        // Create a new Node and pass it a value
        $newNode = new Node($data);
 
        // If the list is currently empty
        if($this->isEmpty()) {
            // Set firstNode which would be NULL, to be our new Node
            $this->firstNode = $newNode;
        } else {
            // The list isn't empty so set the current lastNode's next
            // value to be our new Node
            $this->lastNode->next = $newNode;
        }

        // Set the new Node's previous value to the current lastNode
        // before making our new Node the last node in the list
        $newNode->previous = $this->lastNode;
        // Set lastNode to our newly added node and update the node count
        $this->lastNode = $newNode;
        $this->nodeCount++;
    }
 
    // insertAfter - Inserts a Node after the node specified by $key in the list
    public function insertAfter($key, $data) {
        // Get a pointer to the first Node in the list
        // to start iteration from
        $current = $this->firstNode;
 
        // Iterate over the Nodes until we find the one
        // whose data value matches the specified key
        while($current->data != $key) {
            // Get the next Node
            $current = $current->next;
            // If we don't find a match then return false
            if($current == NULL)
                return false;
        }

        // A match was found so create a new node with the
        // passed in data value
        $newNode = new Node($data);
 
        // If the matched node is the last node in the list
        if($current == $this->lastNode) {
            // Set our new node's next to NULL since the new
            // node will now be the last node
            $newNode->next = NULL;
            // Make the new node the last node
            $this->lastNode = $newNode;
        } else {
            // Otherwise the matched node is not the last node.
            // Set the new node's next value equal to the current
            // node's next value
            $newNode->next = $current->next;
            // Set the previous node of the node after the current
            // node to be our new node
            $current->next->previous = $newNode;
        }
 
        // Set the new Node's previous pointer to the current node
        $newNode->previous = $current;
        // Set the current Node's next pointer to the newly created node
        // and increment the node count
        $current->next = $newNode;
        $this->nodeCount++;
 
        return true;
    }

    // Insert a new Node before the specified Node
    public function insertBefore($key, $data) {
        // Set $current to be the first node to
        // start iterating from
        $current = $this->firstNode;
 
        // While the current node's data is NOT equal
        // to the key we are searching for
        while($current->data != $key) {
            // Set $current = to the next Node
            $current = $current->next;
            
            // if $current is NULL then return
            // because we didn't find a match
            if($current == NULL)
                return false;
        }
 
        // Create a new node
        $newNode = new Node($data);
 
        // If the current node is the first node
        if($current == $this->firstNode) {
            // set the new node's previous to NULL
            $newNode->previous = NULL;
            // Make the first node equal to our new node
            $this->firstNode = $newNode;
        } else {
            // Set the new node's previous = to the current
            // node's previous
            $newNode->previous = $current->previous;
            // Set the current node's, previous node's next
            // equal to our new node
            $current->previous->next = $newNode;
        }
 
        // Set our new node's next node equal to the current node
        $newNode->next = $current;
        // Set the current node's previous node equal to our new node
        // and update the node count
        $current->previous = $newNode;
        $this->nodeCount++;
 
        return true;
    }
 
    // Delete the first node in the list
    public function deleteFirstNode() {
        // Store a temporary pointer to the first node object
        $temp = $this->firstNode;

        // If the first node has no next, meaning there
        // there are no other nodes
        if($this->firstNode->next == NULL) {
            // Set the lastNode equal to NULL
            $this->lastNode = NULL;
        } else {
            // Otherwise set the node after the first node's
            // previous point to be NULL
            $this->firstNode->next->previous = NULL;
        }
 
        // Set firstNode equal to the the node after the first node
        // and decrement the node count
        $this->firstNode = $this->firstNode->next;
        $this->nodeCount--;
        return $temp;
    }
 
    // Delete the last node in the list
    public function deleteLastNode() {
        // Store a temporary pointer to the last node in the list
        $temp = $this->lastNode;
 
        // If the first node's next object is NULL meaning
        // that there are no other nodes
        if($this->firstNode->next == NULL) {
            // Set firstNode equal to NULL
            $this->firstNode = NULL;
        } else {
            // Otherwise remove the pointer to the lastNode
            // by getting it's previous node and setting
            // that node's next pointer to NULL
            $this->lastNode->previous->next = NULL;
        }
 
        // Set lastNode to be the node previous to the last node
        // since we have now removed the original last node
        $this->lastNode = $this->lastNode->previous;
        $this->nodeCount--;
        return $temp;
    }
 
    // Delete a specific Node at the specified location
    public function deleteNode($key) {
        // Get a pointer to the first node and save
        // it as $current
        $current = $this->firstNode;
 
        // Loop over the list searching for a matching
        // Node specified by $key
        while($current->data != $key) {
            $current = $current->next;
            if($current == NULL)
                return null;
        }
 
        // If we have a match and that match is the first node
        if($current == $this->firstNode) {
            // Set firstNode to be equal to the node after the
            // current node
            $this->firstNode = $current->next;
        } else {
            // Otherwise set the next pointer of the node that
            // comes before the matching node to be equal to
            // the the node after the matching node
            $current->previous->next = $current->next;
        }
 
        // If the matching node is the last node in the list
        if($current == $this->lastNode) {
            // Make lastNode equal to the node before the matching node
            $this->lastNode = $current->previous;
        } else {
            // Make the previous pointer of the node after the matching node
            // equal to the node before the matching node
            $current->next->previous = $current->previous;
        }
 
        // Decrement the node count
        $this->nodeCount--;
        return $current;
    }

    // Return the first Node in the list
    public function getFirstNode()
    {
        return $this->firstNode;
    }

    // Return the last Node in the list
    public function getLastNode()
    {
        return $this->lastNode;
    }
 
    // Iterate over the list and display each
    // value from the beginning of the list to the end
    public function displayForward() {
 
        $current = $this->firstNode;
 
        // Starting from the first node, print out
        // the current node's value and then get the
        // next node until no more nodes are left
        while($current != NULL) {
            echo $current->getNode() . " ";
            $current = $current->next;
        }
    }
 
    // Iterate over the list and and display each
    // value starting from the end of the list
    public function displayBackward() {
 
        $current = $this->lastNode;
 
        // Starting from the last node, print out 
        // each current node's value and then get the
        // previous node until no more nodes are left
        while($current != NULL) {
            echo $current->getNode() . " ";
            $current = $current->previous;
        }
    }
 
    // Return the total number of nodes in the list
    public function totalNodes() {
        return $this->nodeCount;
    }
 
}

$totalNodes = 100;
$theList = new DoubleLinkedList();

for($i=1; $i <= $totalNodes; $i++) {
    $theList->insertTail($i);
}

echo '<h3>Linked List Example with 100 Nodes</h3>';

echo '<h4>Print the list from beginning to end</h4>';
$theList->displayForward();
echo '<br>';

echo '<p>Calling insertBefore(14, 360) - inserts the value 360 before the node at position 14</p>';
$theList->insertBefore(14, 360);

echo '<p>Calling insertAfter(80, 260) - inserts the value 260 after the node at postion 80</p>';
$theList->insertAfter(80, 260);

echo '<p>Calling deleteFirstNode() - deletes the first node in the list</p>';
$theList->deleteFirstNode();

echo '<p>Calling deleteLastNode() - deletes the last node in the last </p>'; 
$theList->deleteLastNode();

echo '<p>Calling deleteNode(50) - deletes the node at postion 50</p>';
$theList->deleteNode(50);

echo '<p>Calling insertTail(666) - inserts value of 666 at end of list</p>';
$theList->insertTail(666);

// Redisplay the list with with the changes made above
echo '<h3>Redisplaying the list after making the above changes</h3>';
$theList->displayForward();
echo '<br><br>';

echo '<h4>Now print the list from the end to the beginning</h4>';
$theList->displayBackward();
 
?>
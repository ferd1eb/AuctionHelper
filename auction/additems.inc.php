<h2>About to enter an item.</h2>
<?php
if (isset($_SESSION['login'])) {
    echo "<h2>About to add an item</h2>\n";
    $itemid = $_POST['itemid'];
    if ((trim($itemid) == '') OR (!is_numeric($itemid)))
    {
        echo "<h2>Sorry, you must enter a valid item ID number</h2>\n";
    } else {
        // $name = $_POST['name'];    
        // $description = $_POST['description'];
        // $resaleprice = $_POST['resaleprice'];
        // $winbidder = $_POST['winbidder'];
        // $winprice = $_POST['winprice'];
        echo "<h2>$itemid</h2>" 
        // echo "<h2>$description</h2>" 
        // echo "<h2>$resaleprice</h2>" 
        // echo "<h2>$winbidder</h2>" 
        // echo "<h2>$winprice</h2>"

    }
}
?>
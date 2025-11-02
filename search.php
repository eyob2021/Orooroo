<?php
// Path to the CSV file
$csvFile = 'data.csv';

// Read the CSV file into an array
$rows = array_map('str_getcsv', file($csvFile));

// Search for the value from the form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchValue = strtolower($_POST['search']);
    $foundValues = array();

    foreach ($rows as $row) {
        // Convert the first column data to lowercase for case-insensitive search
        $rowData = strtolower($row[0]);

        // Check if the search term is at the start of Column A
        if (strpos($rowData, $searchValue) === 0) {
            $foundValues[] = $row; // Store the entire row (columns A, B, and C)
        }
    }

    // Count the total number of matching results
    $totalResults = count($foundValues);

    // Display the total count of results
    echo "<style>
            h3 {
                font-size: 1.5em;
                color: #333;
            }
            div {
                border: 1px solid #ccc;
                margin: 10px 0;
                padding: 10px;
                background-color: #f9f9f9;
            }
            h1 {
                color: red;
                font-size: 1.2em;
            }
            p {
                margin-top: 5px;
            }
          </style>";

    echo "<h3>Total Results Found: $totalResults</h3>";

    // Display all matching results with line breaks between columns A, B, and C
    if (!empty($foundValues)) {
        echo "<h3>Results:</h3>";
        foreach ($foundValues as $foundRow) {
            echo '<div>';
            echo '<span style="color: red;"><h1>' . $foundRow[0] . '</h1></span>' . $foundRow[1] . '<p>' . $foundRow[2] . '</p><br>';
            echo '</div>';
        }
    } else {
        echo "<p>No matching results found.</p>";
    }
}
?>
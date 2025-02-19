<?php
// Define the PHP function
function test()
{
    $token = '2340|CxxJUqAQUOpY1XPngf9562H2NYroYbaNayWyNK7v';
    $ch = curl_init('https://digisaka.info/api/v1/user/fields');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    // Return the JSON response
    return json_decode($response, true);
}

// Check if the request is an AJAX request
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    echo json_encode(test());
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Function Execution</title>
</head>
<body>
    <h1>Execute PHP Function</h1>
    <button id="testButton">Test API</button>
    <pre id="output"></pre>

    <script>
        document.getElementById('testButton').addEventListener('click', function() {
            fetch('', {  // Empty string refers to the current PHP file
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Indicate AJAX request
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('output').textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                document.getElementById('output').textContent = 'Fetch error: ' + error.message;
            });
        });
    </script>
</body>
</html>

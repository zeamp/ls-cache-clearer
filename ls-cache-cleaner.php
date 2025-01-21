<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cache'])) {
    
    // Set your lscache cache directory to its path -ze (v1.0)
    $cacheDir = '/home/tabpgs/lscache';

    function deleteContents($path) {
        if (is_dir($path)) {
            $items = scandir($path);
            foreach ($items as $item) {
                if ($item !== '.' && $item !== '..') {
                    $itemPath = $path . DIRECTORY_SEPARATOR . $item;
                    if (is_dir($itemPath)) {
                        deleteContents($itemPath);
                        rmdir($itemPath);
                    } else {
                        unlink($itemPath);
                    }
                }
            }
        } else {
            throw new Exception("Directory not accessible: $path");
        }
    }

    try {
        if (is_readable($cacheDir) && is_writable($cacheDir)) {
            deleteContents($cacheDir);
            $message = "Cache cleared successfully on " . date('Y-m-d H:i:s');
        } else {
            $message = "Cache directory exists but is not readable or writable.";
        }
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear LS Cache Manually</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            text-align: center;
        }
       .alert {
        color: green;
        font-weight: bold;
    }
    </style>
</head>
<body>
    <h1>LS Cache Clearer</h1>
   
    
    <form method="POST">
        <button type="submit" name="clear_cache">Clear LS Cache</button>
    </form>

    <?php if (isset($message)): ?>
        <p class="alert"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <br><br><br><a href="https://www.zpvy.com" target="_blank">by Richard Ward</a>
</body>
</html>

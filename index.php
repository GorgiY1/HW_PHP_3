
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление товарами</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        
    }
    h1, h2 {
        text-align: center;
        
    }
    form {
        margin-bottom: 20px;
    }
    label {
        display: inline-block;
        width: 150px;
    }
    input, select, button {
        padding: 5px;
        margin-bottom: 10px;
    }
    button {
        background-color: blue;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
    button:hover {
        background-color: lightblue;
    }
    ul {
        list-style-type: none;
    }
    li {
        margin: 5px 0;
    }

    .login1 {
        display: none;
    }
    
</style>
</head>
<body>
    <h1>Управление товарами</h1>
    <form method="post">
        <label for="sort">Выберите сортировку:</label>
        <select name="sort" id="sort">
            <option value="quick">Быстрая сортировка</option>
            <option value="bubble">Сортировка пузырьком</option>
        </select>
        <button type="submit" name="action" value="sort">Сортировать</button>
    </form>
    <form method="post">
        <label for="search">Введите значение для поиска:</label>
        <input type="text" name="search" id="search">
        <label for="search_type">Тип поиска:</label>
        <select name="search_type" id="search_type">
            <option value="binary">Бинарный поиск</option>
            <option value="linear">Линейный поиск</option>
        </select>
        <button type="submit" name="action" value="search">Искать</button>
    </form>
    <form method="post">
        <button type="submit" name="action" value="reverse">Перевернуть список</button>
        <button type="submit" name="action" value="uppercase">Изменить регистр на верхний</button>
        
    </form>
    <form method="post">
        <label for="username">Логин:</label>
        <input type="text" name="username" id="username">
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password">
        <button type="submit" name="action" value="login">Войти</button>
    </form>
        <form id="after_login" method="post" >
            <label for="manufacturer">Производитель:</label>
            <input type="text" name="manufacturer" id="manufacturer">
            <label for="product">Товар:</label>
            <input type="text" name="product" id="product">
            <button type="submit" name="action" value="add_product">Добавить товар</button>
            <button type="submit" name="action" value="remove_product">Удалить товар</button>
        </form>
    

    <?php 
$products = [
    "Samsung" => ["Galaxy S21", "Galaxy Note 20", "Galaxy Tab S7"],
    "Apple" => ["iPhone 12", "iPhone 12 Pro", "MacBook Pro", "iPad Pro"],
    "Sony" => ["Xperia 5", "PlayStation 5", "Bravia OLED TV"],
    "LG" => ["OLED TV", "Refrigerator", "Washing Machine"],
    "Huawei" => ["P30", "Mate 40", "MediaPad M5"],
    "Xiaomi" => ["Mi 11", "Redmi Note 10", "Mi TV"],
    "OnePlus" => ["OnePlus 9", "OnePlus Nord", "OnePlus Watch"],
    "HP" => ["Spectre x360", "Envy Laptop", "Pavilion Desktop"],
    "Dell" => ["XPS 13", "Inspiron 15", "Alienware m15"],
    "Microsoft" => ["Surface Pro", "Xbox Series X", "Surface Laptop"]
];
?>

    <?php
    // Отображение списка товаров
    function displayProducts($products) {
        echo "<h2>Список товаров</h2>";
    echo "<ul>";
    foreach ($products as $manufacturer => $items) {
        echo "<li><strong>$manufacturer</strong>: " . implode(", ", $items) . "</li>";
    }
    echo "</ul>";
    }

    displayProducts($products);
    ?>



    <?php
    // Быстрая сортировка
    function quicksort($array) {
        if (count($array) < 2) {
            return $array;
        }
        $left = $right = [];
        reset($array);
        $pivot_key = key($array);
        $pivot = array_shift($array);
        foreach ($array as $k => $v) {
            if ($v < $pivot) {
                $left[$k] = $v;
            } else {
                $right[$k] = $v;
            }
        }
        return array_merge(quicksort($left), [$pivot_key => $pivot], quicksort($right));
    }

    // Сортировка пузырьком
    function bubbleSort($array) {
        $size = count($array);
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    $temp = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j] = $temp;
                }
            }
        }
        return $array;
    }

    // Бинарный поиск
    function binarySearch($array, $x) {
        sort($array);
        $low = 0;
        $high = count($array) - 1;
        while ($low <= $high) {
            $mid = ($low + $high) / 2;
            if ($array[$mid] < $x) {
                $low = $mid + 1;
            } elseif ($array[$mid] > $x) {
                $high = $mid - 1;
            } else {
                return $mid;
            }
        }
        return -1; // Не найдено
    }

    // Линейный поиск
    function linearSearch($array, $x) {
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $x) {
                return $i;
            }
        }
        return -1; // Не найдено
    }
    ?>
    <?php
// Перевернуть массив
function reverseArray($array) {
    return array_reverse($array);
}

// Изменение регистра символов
function changeCase($array, $case = MB_CASE_UPPER) {
    return array_map(function($item) use ($case) {
        return mb_convert_case($item, $case);
    }, $array);
}

// Фильтрация по цене
function filterByPrice($array, $minPrice = 0, $maxPrice = PHP_INT_MAX) {
    return array_filter($array, function($price) use ($minPrice, $maxPrice) {
        return $price >= $minPrice && $price <= $maxPrice;
    });
}
?>

<?php
session_start();

// Пример проверки логина и пароля
function authenticate($username, $password) {
    $validUsername = "admin";
    $validPassword = "admin";
    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['authenticated'] = true;
        return true;
    }
    return false;
}

// Добавление товара
function addProduct(&$products, $manufacturer, $product) {
    if (isset($products[$manufacturer])) {
        array_push($products[$manufacturer], $product);
    } else {
        $products[$manufacturer] = [$product];
    }
}

// Списание товара
function removeProduct(&$products, $manufacturer, $product) {
    if (isset($products[$manufacturer])) {
        $index = array_search($product, $products[$manufacturer]);
        if ($index !== false) {
            unset($products[$manufacturer][$index]);
            $products[$manufacturer] = array_values($products[$manufacturer]);
        }
    }
}

// Проверка аутентификации
function isAuthenticated() {
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
}
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
    
        switch ($action) {
            case 'sort':
                $sortType = $_POST['sort'] ?? '';
                foreach ($products as $manufacturer => &$items) {
                    if ($sortType === 'quick') {
                        $items = quicksort($items);
                    } elseif ($sortType === 'bubble') {
                        $items = bubbleSort($items);
                    }
                }
                displayProducts($products);
                break;
    
            case 'search':
                $searchValue = $_POST['search'] ?? '';
                $searchType = $_POST['search_type'] ?? '';
                foreach ($products as $manufacturer => $items) {
                    $index = -1;
                    if ($searchType === 'binary') {
                        $index = binarySearch($items, $searchValue);
                    } elseif ($searchType === 'linear') {
                        $index = linearSearch($items, $searchValue);
                    }
                    if ($index !== -1) {
                        echo "Товар найден: $items[$index] у производителя $manufacturer";
                    }
                }
                displayProducts($products);
                break;
    
            case 'reverse':
                foreach ($products as &$items) {
                    $items = reverseArray($items);
                }
                displayProducts($products);
                break;
    
            case 'uppercase':
                foreach ($products as &$items) {
                    $items = changeCase($items);
                }
                displayProducts($products);
                break;
    
            case 'filter_expensive':
                foreach ($products as &$items) {
                    $items = filterByPrice($items, 100); // Показать товары дороже 100
                }
                displayProducts($products);
                break;
    
            case 'login':
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';
                if (authenticate($username, $password)) {
                    echo "Успешный вход";
                    $style = 'display: block;';
                } else {
                    echo "Неверный логин или пароль";
                }
                
                break;
    
            case 'add_product':
                if (isAuthenticated()) {
                    $manufacturer = $_POST['manufacturer'] ?? '';
                    $product = $_POST['product'] ?? '';
                    addProduct($products, $manufacturer, $product);
                }
                displayProducts($products);
                break;
    
            case 'remove_product':
                if (isAuthenticated()) {
                    $manufacturer = $_POST['manufacturer'] ?? '';
                    $product = $_POST['product'] ?? '';
                    removeProduct($products, $manufacturer, $product);
                }
                displayProducts($products);
                break;
        }
        
    }
?>
</body>
</html>
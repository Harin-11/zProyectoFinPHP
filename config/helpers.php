<?php
function getBaseUrl() {
    $protocol = ($_SERVER['HTTPS'] ?? '') === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $dir = strpos($script, '/public/index.php') !== false || strpos($script, '\\public\\index.php') !== false 
        ? dirname(dirname($script)) 
        : dirname($script);
    $baseUrl = rtrim($protocol . '://' . $host . $dir, '/') . '/public/';
    return $baseUrl;
}

function url($controller, $action, $params = []) {
    $url = getBaseUrl() . 'index.php?controller=' . $controller . '&action=' . $action;
    foreach ($params as $key => $value) {
        $url .= '&' . $key . '=' . urlencode($value);
    }
    return $url;
}
?>


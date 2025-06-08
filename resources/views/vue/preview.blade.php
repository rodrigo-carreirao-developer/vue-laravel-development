<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Preview</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div id="app">
        <user-preview-component></user-preview-component>
    </div>
</body>
</html>
{{-- create a view about with tailwindcss --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>About</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <h1 class="text-4xl text-center mt-10">About</h1>
        <p class="text-center mt-5">This is the about page</p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Site Laravel')</title>
<link rel="stylesheet" href="{{ asset('assets/font/fontawesome-free-7.1.0-web/css/all.css') }}">
<link rel="icon" href="{{ asset('assets/upload/dash_img/logo-1.png') }}" type="image/png">
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('assets/js/app.js') }}"> -->
<script src="{{ asset('assets/js/app.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome 6 Free -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-bxCxD5Yl+6DhtQ3TF/DJwxVtWZ+vS7Dw+q6KQnZnPZkbkhZpVf+hzw2i9CqI6S8cP7VnI3g0S2zbyK9hSz6S/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=person" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=dangerous" />
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-o1cRfiNIX+qY8XzTjMqCF6eH4K0G5J4EtEJqO/NFcvxF6p4g/0Bq4VdJLyKZ3J4Gp2z5yAxy1XIb2XY6Fl1mQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body class="font-sans">


            @yield('content')



</body>

<script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</html>

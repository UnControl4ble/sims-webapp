<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="wrapper">
        <x-sidebar-component />

        <section id="content-wrapper">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            {{ $slot }}
        </section>
    </div>

    <script>
        const $button = document.querySelector('.fa-bars');
        const $wrapper = document.querySelector('#wrapper');
        const $logo = document.querySelector('.navbar-header h2');

        $logo.style.display = 'flex';
        $button.style.display = 'block';

        $button.addEventListener('click', (e) => {
            e.preventDefault();
            $wrapper.classList.toggle('toggled');

            if ($wrapper.classList.contains('toggled')) {
                $logo.style.display = 'none';
            } else {
                $logo.style.display = 'flex';
            }

            if (window.innerWidth < 992) {
                $button.style.display = 'block';
            }
        });

        function checkScreenSize() {
            if (window.innerWidth < 992) {
                $logo.style.display = 'none';
                $button.style.display = 'block';
            } else {
                $logo.style.display = 'flex';
                $button.style.display = 'block';
            }
        }

        checkScreenSize();

        window.addEventListener('resize', checkScreenSize);
    </script>
    @stack('script')
</body>

</html>

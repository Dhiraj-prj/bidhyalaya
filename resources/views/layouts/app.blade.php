<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/fevicon.ico') }}" type="image/x-icon">



    <title>@yield('title')</title>
    <meta name="meta_description" content="@yield('meta_description')">
    <meta name="meta_keyword" content="@yield('meta_keyword')">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <style>
        /* Initial lazy background setup */
        .lazy-bg {
            background-image: none;
        }

        /* Background image for About Section */
        .bg-light { background-color: #f8f9fa; }
        .bg-white { background-color: #ffffff; }
        .bg-dark { background-color: #343a40; }
        .text-dark { color: #343a40; }
        .text-muted { color: #6c757d; }

        /* Button Styles */
        .custom-btn {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #0056b3;
            opacity: 0.8;
        }

        /* Card Styles */
        .card {
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .card-body { padding: 20px; }
        .card-shadow { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .hover-shadow:hover { box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2); }

        /* Heading Styles */
        h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
        }

        /* Underline for headings */
        .underline {
            width: 60px;
            height: 3px;
            background-color: #007bff;
            margin: 0 auto;
        }

        /* Spacing */
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-0 { margin-bottom: 0; }
        .text-center { text-align: center; }
        .lead { font-size: 1.25rem; color: #6c757d; }
        .font-weight-bold { font-weight: 700; }
        .p-5 { padding: 3rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .rounded-lg { border-radius: 12px; }


        /* Custom Button Styles */
        .custom-btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #0056b3;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Post Heading */
        .post-heading {
            font-size: 26px;
            color: #000;
        }

        /* Underline Customization */
        .underline {
            height: 3px;
            width: 60px;
            background-color: #e71212 !important;
            margin-bottom: 10px;
        }
    </style>

</head>
<body>
    <div id="app">
        @include('layouts.inc.frontend-navbar')

        <main class="py-4">
            @yield('content')
        </main>

        @yield('footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" ></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/scripts.js') }}" defer></script>
    @yield('scripts')
</body>
</html>

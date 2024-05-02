<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="/img/logoiddrives.png" type="image/icon type">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://fastly.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://fastly.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <!-- SweetAlert2 -->
        <script src="https://fastly.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- jQuery Library (required for DataTables) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        {{-- Data table css and js --}}
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>


        <!-- Buttons extension CSS and JS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

        <!-- JSZip (for Excel export) -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

        <!-- PDFMake (for PDF export) -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

        <!-- Buttons extension - HTML5 export buttons -->
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
            integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <!-- Scripts -->
        <script src="https://fastly.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <script src="https://fastly.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        {{-- Owl carousel --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'sans-serif'],
                        },
                    }
                }
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col justify-between" style="background-color: var(--bg-color);">
            @if (Auth::user()->role == 'new')
                @include('layouts.navigation')
            @else
                @include('layouts.mainNav')
            @endif
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main style="background-color: var(--bg-color);" class="flex-auto">
                {{ $slot }}
            </main>
            <footer class="flex mt-5 justify-around w-full bg-white p-2 flex-wrap">
                <div class="flex gap-2 align-items-center justify-center flex-wrap mb-2">
                    <div><img src="/img/logoiddrives.png" alt="" width="50"></div>
                    <div class="flex items-center text-sm"><p style="height: fit-content">บริษัท ไอดีไดรฟ์ จำกัด <br> 200/222 หมู่2 ถนนชัยพฤกษ์ ตำบลในเมือง อำเภอเมืองขอนแก่น จังหวัดขอนแก่น <br> Tel : 043-228 899 www.iddrives.co.th Email : idofficer@iddrives.co.th</p></div>
                </div>
                <div class="text-center flex items-center">
                    <p>© 2023 KST ID System</p>
                </div>
            </footer>
        </div>

        <!-- Owl Carousel JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
    </body>
</html>

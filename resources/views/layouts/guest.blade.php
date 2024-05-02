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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased" >
        <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gray-100" style="background-image: url('{{ asset('img/bg.jpg') }}'); background-size: cover; background-position: center">
            <div class="flex-auto">

            </div>
            <div class="flex-auto">
                <div class="py-2 md:py-4">
                    <a href="/">
                        <img src="/img/logo.png" alt="" >
                    </a>
                </div>

                <div class="w-full sm:max-w-md my-6 px-6 py-4  overflow-hidden rounded-xl" style="backdrop-filter: blur(4px); box-shadow: 0px 0px 10px 0px white; border-radius: 20px; background-color:rgba(255, 255, 255, .2);">
                    {{ $slot }}
                </div>
            </div>
            <div class="owl-carousel owl-theme w-1/2">
                <div class="item">
                    <a href="https://www.iddriver.com/" target="_BLANK">
                        <div >
                            <img src="/img/carouselphoto/2.jpg" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.trainingzenter.com/" target="_BLANK">
                        <div >
                            <img src="/img/carouselphoto/tz.jpg" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://iddrives.co.th/web/" target="_BLANK">
                        <div>
                            <img src="/img/carouselphoto/id.jpg" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.idklever.com/" target="_BLANK">
                        <div>
                            <img src="/img/carouselphoto/10.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://dronettc.com/" target="_BLANK">
                        <div>
                            <img src="/img/carouselphoto/drone.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://sureintime.com/" target="_BLANK">
                        <div>
                            <img src="/img/carouselphoto/logoins.png" style="max-height: 150px; object-fit:contain;" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <footer class="flex flex-wrap w-100 justify-around w-full pb-2" >
                <div class="flex flex-wrap justify-center text-center  gap-2 align-items-center">
                    <div><img src="/img/logoiddrives.png" alt="" width="50"></div>
                    <div class="flex items-center text-white text-sm"><p style="height: fit-content">บริษัท ไอดีไดรฟ์ จำกัด 200/222 หมู่2 ถนนชัยพฤกษ์ อำเภอเมืองขอนแก่น จังหวัดขอนแก่น <br> Tel : 043-228 899 www.iddrives.co.th Email : idofficer@iddrives.co.th</p></div>
                </div>
                <div class="text-center flex items-center text-white">
                    <p>Powered by © 2023 KST ID System</p>
                </div>
            </footer>
        </div>
        <script src="{{ asset('assets/owl.carousel.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.owl-carousel').owlCarousel({
                    // Customize carousel options here
                    loop: true, // Whether to loop the carousel
                    nav: false, // Navigation buttons (prev/next)
                    dots: true, // Pagination dots
                    autoplay:true,
                    margin: 10,
                    autoplayTimeout:3000,
                    autoplayHoverPause:true,
                    autoplaySpeed: 1000,
                    responsive: {
                        0: { // Breakpoint for screens smaller than or equal to 0px
                            items: 1, // Show only 1 item
                        },
                        600: { // Breakpoint for screens between 600px and 959px
                            items: 2, // Show 2 items
                        },
                        960: { // Breakpoint for screens 960px and above
                            items: 3, // Show 3 items
                        }
                    }
                });
            });
        </script>
    </body>
</html>

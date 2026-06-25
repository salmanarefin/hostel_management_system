<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Younic Home - Opening Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between h-16">
                <div>
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-700">
                        Younic Home
                    </a>
                </div>

                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Register
                        </a>
                    @endauth
                </nav>
            </div>

        </div>
    </header>

    <!-- Hero / Offer Slider -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-700 via-indigo-700 to-sky-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                <div>
                    <p class="uppercase tracking-widest text-blue-100 text-sm font-semibold mb-3">
                        Smart Hostel Management
                    </p>

                    <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                        Find Your Perfect Seat at
                        <span class="text-yellow-300">Younic Home</span>
                    </h1>

                    <p class="text-lg text-blue-100 mb-6 leading-relaxed">
                        Explore available hostel seats, view room details, and see current offers.
                        To submit a booking request, you must login or register first.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        @auth
                            @if(auth()->user()->role === 'customer')
                                <a href="{{ route('customer.bookings.index') }}"
                                   class="bg-white text-blue-700 px-5 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                                    Go to Booking Page
                                </a>
                            @else
                                <a href="{{ route('admin.dashboard') }}"
                                   class="bg-white text-blue-700 px-5 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                                    Go to Admin Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="bg-white text-blue-700 px-5 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                                Login to Book
                            </a>

                            <a href="{{ route('register') }}"
                               class="border border-white text-white px-5 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-700 transition">
                                Create Account
                            </a>
                        @endauth
                    </div>
                </div>

                <div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-2xl border border-white/20">

                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold">
                                Offers & Discounts
                            </h2>

                            <span class="text-sm text-blue-100">
                                Auto sliding
                            </span>
                        </div>

                        <div class="relative min-h-[240px] overflow-hidden rounded-xl">
                            @foreach($offers as $index => $offer)
                                <div class="offer-slide absolute inset-0 transition-all duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-full pointer-events-none' }}"
                                     data-slide="{{ $index }}">

                                    <div class="bg-white/10 rounded-xl p-6 border border-white/10 h-full flex flex-col justify-center">
                                        <div class="inline-block bg-yellow-300 text-slate-900 text-xs font-bold px-3 py-1 rounded-full mb-4 w-fit">
                                            OFFER {{ $index + 1 }}
                                        </div>

                                        <h3 class="text-2xl font-bold mb-3">
                                            {{ $offer->title }}
                                        </h3>

                                        <p class="text-blue-100 leading-relaxed text-base">
                                            {{ \Illuminate\Support\Str::limit($offer->message, 180) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-center gap-2 mt-5">
                            @foreach($offers as $index => $offer)
                                <button type="button"
                                        class="slider-dot w-3 h-3 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/40' }}"
                                        data-index="{{ $index }}">
                                </button>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Quick Info -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                    <h3 class="font-bold text-lg text-blue-800 mb-2">
                        Available Seat Preview
                    </h3>

                    <p class="text-slate-600">
                        Browse currently available hostel seats before login.
                    </p>
                </div>

                <div class="bg-green-50 border border-green-100 rounded-xl p-6">
                    <h3 class="font-bold text-lg text-green-800 mb-2">
                        Login Required for Booking
                    </h3>

                    <p class="text-slate-600">
                        Guests can view seat cards, but booking request can only be submitted after login.
                    </p>
                </div>

                <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-6">
                    <h3 class="font-bold text-lg text-yellow-800 mb-2">
                        Special Offers
                    </h3>

                    <p class="text-slate-600">
                        Stay updated with current discounts, announcements, and booking promotions.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Seat Cards -->
    <section class="py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
                <div>
                    <p class="text-blue-600 font-semibold uppercase tracking-wide text-sm mb-2">
                        Available Seats
                    </p>

                    <h2 class="text-3xl font-bold text-slate-900">
                        Hostel Seat Cards
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Browse available seats. Booking is not allowed from this dashboard without login.
                    </p>
                </div>

                @auth
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.bookings.index') }}"
                           class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition">
                            Go to Booking Page
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}"
                           class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition">
                            Admin Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition">
                        Login to Book
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @forelse($availableSeats as $seat)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition border border-slate-100 overflow-hidden">

                        <div class="bg-gradient-to-r from-blue-600 to-sky-500 p-5 text-white">
                            <div class="flex justify-between items-start">

                                <div>
                                    <p class="text-sm text-blue-100">
                                        Seat Number
                                    </p>

                                    <h3 class="text-2xl font-bold">
                                        {{ $seat->seat_number }}
                                    </h3>
                                </div>

                                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full">
                                    Available
                                </span>

                            </div>
                        </div>

                        <div class="p-5 space-y-3">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wide">
                                    Branch
                                </p>

                                <p class="font-semibold text-slate-800">
                                    {{ $seat->room->branch->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-slate-500 uppercase tracking-wide">
                                        Room
                                    </p>

                                    <p class="font-semibold text-slate-800">
                                        {{ $seat->room->room_number ?? 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-500 uppercase tracking-wide">
                                        Daily Rent
                                    </p>

                                    <p class="font-semibold text-slate-800">
                                        {{ number_format($seat->room->rent_amount ?? 0, 2) }} BDT
                                    </p>
                                </div>
                            </div>

                            <div class="pt-2">
                                <div class="bg-slate-50 text-slate-600 text-sm px-3 py-2 rounded-lg border">
                                    Preview only. Please login to continue booking.
                                </div>
                            </div>

                            <div class="pt-2">
                                @auth
                                    @if(auth()->user()->role === 'customer')
                                        <a href="{{ route('customer.bookings.index') }}"
                                           class="block w-full text-center bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition">
                                            Go to Booking Page
                                        </a>
                                    @else
                                        <a href="{{ route('admin.dashboard') }}"
                                           class="block w-full text-center bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition">
                                            Admin Dashboard
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full text-center bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-10 text-center">

                            <h3 class="text-xl font-bold text-slate-800 mb-2">
                                No Available Seat Found
                            </h3>

                            <p class="text-slate-500">
                                Currently no seats are available. Please check again later.
                            </p>

                        </div>
                    </div>
                @endforelse

            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-slate-900 rounded-3xl p-8 lg:p-10 text-white text-center">
                <h2 class="text-3xl font-bold mb-3">
                    Ready to Book Your Hostel Seat?
                </h2>

                <p class="text-slate-300 max-w-2xl mx-auto mb-6">
                    View available seats now and continue with booking after login.
                    Our booking, payment, leave, exit, and seat change modules are fully dynamic.
                </p>

                <div class="flex justify-center gap-3 flex-wrap">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.bookings.index') }}"
                               class="bg-blue-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                Go to Booking
                            </a>
                        @else
                            <a href="{{ route('admin.dashboard') }}"
                               class="bg-blue-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                Admin Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-blue-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="border border-white text-white px-5 py-3 rounded-lg font-semibold hover:bg-white hover:text-slate-900 transition">
                            Register
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-3">

            <p class="text-slate-500 text-sm">
                © {{ date('Y') }} Younic Home. All rights reserved.
            </p>

            <div class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                        Register
                    </a>
                @endauth
            </div>

        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = document.querySelectorAll('.offer-slide');
            const dots = document.querySelectorAll('.slider-dot');

            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach(function (slide, i) {
                    if (i === index) {
                        slide.classList.remove('opacity-0', 'translate-x-full', 'pointer-events-none');
                        slide.classList.add('opacity-100', 'translate-x-0');
                    } else {
                        slide.classList.remove('opacity-100', 'translate-x-0');
                        slide.classList.add('opacity-0', 'translate-x-full', 'pointer-events-none');
                    }
                });

                dots.forEach(function (dot, i) {
                    if (i === index) {
                        dot.classList.remove('bg-white/40');
                        dot.classList.add('bg-white');
                    } else {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-white/40');
                    }
                });

                currentSlide = index;
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    const selectedIndex = Number(this.dataset.index);
                    showSlide(selectedIndex);
                });
            });

            if (slides.length > 1) {
                setInterval(function () {
                    let nextSlide = currentSlide + 1;

                    if (nextSlide >= slides.length) {
                        nextSlide = 0;
                    }

                    showSlide(nextSlide);
                }, 3000);
            }
        });
    </script>

</body>
</html>
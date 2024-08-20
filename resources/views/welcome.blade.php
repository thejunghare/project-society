<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      MySocietyERP
    </title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
    rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css"
    rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->

  </head>

  <body class="">
    {{-- header --}} {{--
    <nav class="h-16 flex justify-between items-center shadow-sm">
      <div class="w-1/2 flex items-center m-4">
        <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto" alt="Logo">
        <p class="ml-2 text-2xl italic tracking-wide font-extrabold">
          <a href="#" class="cursor-not-allowed text-mygreen-500 text-bold">
            mySocietyERP
          </a>
        </p>
      </div>
      <div class="w-1/2 flex justify-end items-center">
        <p class="px-6 text-lg tracking-wide subpixel-antialiased font-bold">
          <a href="#" class=" text-dark-500">
            Home
          </a>
        </p>
        <p class="px-6 text-lg tracking-wide subpixel-antialiased font-bold">
          <a href="#about" class=" text-dark-500">
            About Us
          </a>
        </p>
        <p class="px-6 text-lg tracking-wide subpixel-antialiased font-bold">
          <a href="#contact" class=" text-dark-500">
            Contact Us
          </a>
        </p>
      </div>
    </nav>
    --}}


    <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div class="flex flex-row">
                <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto" alt="Logo">
                <p class="ml-2 text-2xl italic tracking-wide font-extrabold">
                  <a href="#" class="cursor-not-allowed text-mygreen-500 text-bold">
                    mySocietyERP
                  </a>
                </p>
            </div>
          <button data-collapse-toggle="navbar-solid-bg" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-solid-bg" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
              </svg>
          </button>
          <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
            <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
              <li>
                <a href="" class="block py-2 px-3 md:p-0 text-white bg-mygreen-700 rounded md:bg-transparent md:text-mygreen-700 md:dark:text-mygreen-500 dark:bg-mygreen-600 md:dark:bg-transparent" aria-current="page">Home</a>
              </li>
              <li>
                <a href="#about" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-mygreen-700 dark:text-white md:mygreen-700 md:hover:text-mygreen-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About Us</a>
              </li>
              {{-- <li>
                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
              </li> --}}
              <li>
                <a href="#contact" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-mygreen-700 dark:text-white md:dark:hover:text-mygreen-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    {{-- main section --}}


    <section class="bg-mygreen-100 flex items-center justify-center h-screen align-middle">
      <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 animate-fadeInUp">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl">
          Simplifying Society Management with
          <span class="text-mygreen-500">
            mySocietyERP
          </span>
        </h1>
        <p class="mb-8 text-lg font-normal text-black lg:text-xl sm:px-16 lg:px-48">
          MySociety ERP streamlines society operations, from member registration
          to maintenance bill management and payments, making community management
          effortless and transparent.
        </p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
          @auth @if (auth()->user()->role_id == 2)
          <a href="{{ url('/accountant/dashboard') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-full bg-mygreen-700 hover:bg-mygreen-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-mygreen-900">
            Dashboard
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
          @elseif(auth()->user()->role_id == 1)
          <a href="{{ url('/admin/dashboard') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-full bg-mygreen-700 hover:bg-mygreen-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-mygreen-900">
            Dashboard
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
          @else
          <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-full bg-mygreen-700 hover:bg-mygreen-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-mygreen-900">
            Dashboard
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
          @endif @else
          <a href="{{ route('login') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-full bg-mygreen-700 hover:bg-mygreen-800 focus:ring-4 focus:ring-mygreen-300 dark:focus:ring-mygreen-900">
            Login
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
          <a href="#contact" class="inline-flex justify-center items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-gray-900 rounded-full border border-gray-500 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            <!-- Icon -->
            <svg class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"
              />
            </svg>
            <!-- Button Text -->
            Request Demo
          </a>
          @endauth
        </div>
      </div>
    </section>


    <section class="bg-gray-100 flex items-center justify-center flex-1 animate-fadeInUp"
    id="about">
      <div class="max-w-screen-xl px-4 py-16 mx-auto sm:px-6 lg:px-8">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-4xl align-middle">
          About Us
        </h1>
        <p class="text-lg text-gray-700 mb-6">
          Welcome to
          <span class="font-bold text-mygreen-500">
            mySocietyERP
          </span>
          – your comprehensive solution for society management. Our platform is
          designed to simplify and streamline the management of housing societies
          and residential communities. With
          <span class="font-bold text-mygreen-500">
            mySocietyERP
          </span>
          , societies can easily register on our website, and members can register
          under their respective societies.
        </p>
        <p class="text-lg text-gray-700 mb-6">
          We understand the complexities involved in managing a society's financials,
          particularly when it comes to maintenance bills. Our platform offers a
          robust system that allows for the efficient management and tracking of
          maintenance bills, ensuring transparency and ease of access for all society
          members. Members can view their maintenance dues, make payments, and track
          their payment history, all within a user-friendly interface.
        </p>
        <p class="text-lg text-gray-700">
          At
          <span class="font-bold text-mygreen-500">
            mySocietyERP
          </span>
          , we are committed to enhancing the living experience in residential communities
          by providing a seamless and efficient management tool. Join us and experience
          a smarter way to manage your society.
        </p>
      </div>
    </section>

    <section class="bg-mygreen-100 py-16 flex items-center justify-center animate-fadeInUp">
        <div class="pt-10 pb-10 md:pt-22 md:pb-22">
          <div class="flex relative flex-col w-full items-center justify-center">
            <h1 class="md:text-[40px]  text-[28px] xs:text-[26px] font-bold tracking-wide">
              Why choose us?
            </h1>
            <p class="text-[#7A7A7A] md:text-lg text-[12px] text-center font-medium mt-4">
              Unlock Your Society’s Potential with Our Comprehensive Management Solutions
            </p>
            <div class="lg:block">
              <div class="grid lg:grid-cols-3 xl:gap-20 gap-10 mt-16 m-4">
                <div class="xl:w-[360px] bg-white dark:bg-[#ffffff08] dark:hover:border dark:hover:border-[#FCEDEF] cursor-pointer group hover:bg-green-600 flex flex-col items-start px-6 py-8 rounded-xl">
                  <p class="xl:text-4xl text-2xl text-mygreen-400 font-bold">
                    01
                  </p>
                  <p class="text-green-600 xl:text-[24px] text-[16px] font-semibold mt-2 group-hover:text-[#FFFFFF] group-hover:dark:text-green-600">
                    Seamless Maintenance Management
                  </p>
                  <p class="group-hover:text-[#FFFFFF] xl:text-[16px] text-[12px] font-medium mt-2 tracking-wide">
                    Our platform offers a streamlined process for generating and managing
                    maintenance bills, ensuring timely reminders and hassle-free payments for
                    society members.
                  </p>
                </div>
                <div class="xl:w-[360px] bg-white dark:bg-[#ffffff08] dark:hover:border dark:hover:border-[#FCEDEF] cursor-pointer group hover:bg-green-600 flex flex-col items-start p-8 rounded-xl">
                  <p class="xl:text-4xl text-2xl text-mygreen-400 font-bold">
                    02
                  </p>
                  <p class="text-green-600 xl:text-[24px] text-[16px] font-semibold mt-2 group-hover:text-[#FFFFFF] group-hover:dark:text-green-600">
                    Transparent Financial Overview
                  </p>
                  <p class="group-hover:text-[#FFFFFF] xl:text-[16px] text-[12px] font-medium mt-2 tracking-wide">
                    Access detailed financial summaries, track payments, and view real-time
                    updates on society funds, ensuring transparency and trust among members.
                  </p>
                </div>
                <div class="xl:w-[360px] bg-white dark:bg-[#ffffff08] dark:hover:border dark:hover:border-[#FCEDEF] cursor-pointer group hover:bg-green-600 flex flex-col items-start p-8 rounded-xl ">
                  <p class="xl:text-4xl text-2xl text-mygreen-400 font-bold">
                    03
                  </p>
                  <p class="text-green-600 xl:text-[24px] text-[16px] font-semibold mt-2 group-hover:text-[#FFFFFF] group-hover:dark:text-green-600">
                    Comprehensive Member Management
                  </p>
                  <p class="group-hover:text-[#FFFFFF] xl:text-[16px] text-[12px] font-medium mt-2 tracking-wide">
                    Easily manage society members, update their information, and monitor their
                    engagement with society activities through our intuitive platform.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>


    <section class="bg-gray-100 py-16 flex items-center justify-center animate-fadeInUp"
    id="contact">
      <div class="max-w-screen-md px-4 mx-auto text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-6">
            Request a Demo/Contact Us
          </h2>
          <p class="mb-8 text-lg font-normal text-gray-500">
            Interested in seeing how our platform can help you manage your society efficiently? Request a demo, and we'll walk you through the features and benefits tailored to your needs.
          </p>

        <form action="#" method="post" class="space-y-4">
          <div>
            <label for="name" class="block text-left text-gray-700 font-medium mb-1">
              Name
            </label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-mygreen-500"
            />
          </div>
          <div>
            <label for="email" class="block text-left text-gray-700 font-medium mb-1">
              Email
            </label>
            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-mygreen-500"
            />
          </div>
          <div>
            <label for="message" class="block text-left text-gray-700 font-medium mb-1">
              Message
            </label>
            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-mygreen-500">
            </textarea>
          </div>
          <button type="submit" class="inline-flex items-center py-3 px-6 text-base font-medium text-center text-white rounded-full bg-mygreen-700 hover:bg-mygreen-800 focus:ring-4 focus:ring-mygreen-300 dark:focus:ring-mygreen-900">
            Send Message
          </button>
        </form>
      </div>
    </section>

    {{-- footer --}}
    <footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://junghare.tech/" class="hover:underline">Junghare.tech™</a>. All Rights Reserved.
        </span>
        <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
            <li>
                <a href="#about" class="hover:underline me-4 md:me-6">About</a>
            </li>
            <li>
                <a href="/privacy-policy" class="hover:underline me-4 md:me-6">Privacy Policy</a>
            </li>
            <li>
                <a href="#contact" class="hover:underline">Contact</a>
            </li>
        </ul>
        </div>
    </footer>

    <script src="{{ asset('../node_modules/flowbite/dist/flowbite.js') }}">
    </script>
    {{--
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js">
    </script>
    --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js">
    </script>
  </body>

</html>

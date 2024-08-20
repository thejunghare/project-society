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
                <a href="#" class="block py-2 px-3 md:p-0 text-white bg-mygreen-700 rounded md:bg-transparent md:text-mygreen-700 md:dark:text-mygreen-500 dark:bg-mygreen-600 md:dark:bg-transparent" aria-current="page">Home</a>
              </li>
              <li>
                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-mygreen-700 dark:text-white md:mygreen-700 md:hover:text-mygreen-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About Us</a>
              </li>
              {{-- <li>
                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
              </li> --}}
              <li>
                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-mygreen-700 dark:text-white md:dark:hover:text-mygreen-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
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
            Request a Demo
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
    <footer class="bg-gray-500 rounded-lg shadow sm:flex sm:items-center sm:justify-between p-4 sm:p-6 xl:p-8 dark:bg-gray-800 antialiased">
      <p class="mb-4 text-sm text-center text-gray-100 sm:mb-0">
        &copy; 2023-2024
        <a href="https://flowbite.com/" class="hover:underline" target="_blank">
          jughare.tech
        </a>
        . All rights reserved.
      </p>
      <div class="flex justify-center items-center space-x-1">
        <a href="#" data-tooltip-target="tooltip-facebook" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
          <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          fill="currentColor" viewBox="0 0 8 19">
            <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
            clip-rule="evenodd" />
          </svg>
          <span class="sr-only">
            Facebook
          </span>
        </a>
        <div id="tooltip-facebook" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
          Like us on Facebook
          <div class="tooltip-arrow" data-popper-arrow>
          </div>
        </div>
        <a href="#" data-tooltip-target="tooltip-twitter" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
          <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          fill="none" viewBox="0 0 20 20">
            <path fill="currentColor" d="M12.186 8.672 18.743.947h-2.927l-5.005 5.9-4.44-5.9H0l7.434 9.876-6.986 8.23h2.927l5.434-6.4 4.82 6.4H20L12.186 8.672Zm-2.267 2.671L8.544 9.515 3.2 2.42h2.2l4.312 5.719 1.375 1.828 5.731 7.613h-2.2l-4.699-6.237Z"
            />
          </svg>
          <span class="sr-only">
            Twitter
          </span>
        </a>
        <div id="tooltip-twitter" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
          Follow us on Twitter
          <div class="tooltip-arrow" data-popper-arrow>
          </div>
        </div>
        <a href="#" data-tooltip-target="tooltip-github" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
          <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
            clip-rule="evenodd" />
          </svg>
          <span class="sr-only">
            Github
          </span>
        </a>
        <div id="tooltip-github" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
          Star us on GitHub
          <div class="tooltip-arrow" data-popper-arrow>
          </div>
        </div>
        <a href="#" data-tooltip-target="tooltip-dribbble" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
          <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z"
            clip-rule="evenodd" />
          </svg>
          <span class="sr-only">
            Dribbble
          </span>
        </a>
        <div id="tooltip-dribbble" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
          Follow us on Dribbble
          <div class="tooltip-arrow" data-popper-arrow>
          </div>
        </div>
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
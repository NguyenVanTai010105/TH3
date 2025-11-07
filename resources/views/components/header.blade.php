<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#B4D2CC] m-0 p-0 box-border ">
    <header
        class=" sticky my-10 bg-white h-20 shadow-md border-4 border-[#C9E0DA] p-2 rounded-3xl z-50 w-4/5 max-w-7-xl mx-auto ">

        <div class="container flex items-center justify-between h-full w-full px-10  ">
            <div class="logo h-12 w-auto ">
                <img src="{{ asset('images/crocodile.png') }}" class=" h-full w-auto object-contain" alt="logo">
            </div>
            <div class="navbar flex text-gray-500  items-center justify-center space-x-4">
                <div class="inline-block relative group">
                    <p class="hover:text-black cursor-pointer">HomePage</p>
                    <hr
                        class="absolute left-0 bottom-0 w-0 h-[2.5px] bg-yellow-500 transition-all ease-in-all  duration-500 group-hover:w-full">
                </div>
                <div class="inline-block relative group">
                    <p class="hover:text-black cursor-pointer">Technology</p>
                    <hr
                        class="absolute left-0 bottom-0 w-0 h-[2.5px] bg-yellow-500 transition-all ease-in-all  duration-500 group-hover:w-full">
                </div>
                <div class="inline-block relative group">
                    <p class="hover:text-black cursor-pointer"> Careers</p>
                    <hr
                        class="absolute left-0 bottom-0 w-0 h-[2.50px] bg-yellow-500 transition-all ease-in-all duration-500 group-hover:w-full">
                </div>

            </div>
        </div>

    </header>

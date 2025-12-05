<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng nhập</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInLeft {
            0% {
                transform: translateX(-100vw);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        body {
            background-color: #0E4743;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <main class="w-full max-w-md">

        {{-- Toast thông báo --}}
        @if (session('status'))
            <div id="toast"
                class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 opacity-0 transform transition-all duration-300">
                {{ session('status') }}
            </div>
        @elseif($errors->any())
            <div id="toast"
                class="fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 opacity-0 transform transition-all duration-300">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section class="bg-white px-8 py-6 rounded-3xl shadow-2xl" style="animation: slideInLeft 0.6s ease-out">
            <h1 class="text-2xl font-extrabold text-gray-900 text-center mb-6">Đăng nhập</h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input name="email" value="{{ old('email') }}" required type="email"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        placeholder="you@example.com" />
                </div>

                {{-- Password --}}
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <input id="password" name="password" required type="password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        placeholder="********" />
                    <button type="button" id="toggle_visible"
                        class="absolute right-3 bottom-0 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition hover:scale-125">
                        👁️
                    </button>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full bg-white text-black font-semibold rounded-xl px-5 py-3 shadow-md hover:text-white hover:bg-blue-600 hover:scale-105 transition-all">
                        Đăng nhập
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600 mt-3">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}"
                        class="text-indigo-600 font-medium underline hover:text-indigo-700">
                        Đăng ký tại đây
                    </a>
                </p>
            </form>
        </section>
    </main>

    <script>
        // Show/hide password
        const toggle_visible = document.getElementById("toggle_visible");
        const password = document.getElementById("password");
        toggle_visible.addEventListener("click", () => {
            if (password.type === "password") {
                password.type = "text";
                toggle_visible.textContent = "🙈";
            } else {
                password.type = "password";
                toggle_visible.textContent = "👁️";
            }
        });

        // Toast animation
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-x-20', 'scale-90');
                toast.classList.add('opacity-100', 'translate-x-0', 'scale-100');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-x-0', 'scale-100');
                toast.classList.add('opacity-0', 'translate-x-20', 'scale-90');
            }, 3100);
        }
    </script>
</body>

</html>

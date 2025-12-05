<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #0E4743;
        }

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
            <h1 class="text-2xl font-extrabold text-gray-900 text-center mb-6">Tạo tài khoản</h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Fullname --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                    <input name="name" value="{{ old('name') }}" required type="text"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        placeholder="Nguyễn Văn A" />
                </div>

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
                        placeholder="Tối thiểu 8 ký tự" />
                    <button type="button" id="toggle_visible"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition hover:scale-125">
                        👁️
                    </button>
                </div>

                {{-- Confirm Password --}}
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu</label>
                    <input id="password_confirmation" name="password_confirmation" required type="password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        placeholder="Nhập lại mật khẩu" />
                    <button type="button" id="toggle_visible_confirm"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition hover:scale-125">
                        👁️
                    </button>
                </div>

                {{-- Terms --}}
                <div class="flex items-center gap-3">
                    <input id="terms" name="terms" type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                    <label for="terms" class="text-sm text-gray-600">Tôi đồng ý với <a href="#"
                            class="text-indigo-600 underline">Điều khoản</a></label>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full bg-white text-black font-semibold rounded-xl px-5 py-3 shadow-md hover:text-white hover:bg-blue-600 hover:scale-105 transition-all">
                        Đăng ký
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600 mt-3">
                    Nếu đã có tài khoản?
                    <a href="{{ route('login') }}" class="text-indigo-600 font-medium underline hover:text-indigo-700">
                        Đăng nhập tại đây
                    </a>
                </p>
            </form>
        </section>
    </main>

    <script>
        const toggle_visible = document.getElementById("toggle_visible");
        const password = document.getElementById("password");
        const toggle_visible_confirm = document.getElementById("toggle_visible_confirm");
        const password_confirmation = document.getElementById("password_confirmation");

        toggle_visible.addEventListener("click", () => {
            if (password.type === "password") {
                password.type = "text";
                toggle_visible.textContent = "🙈"
            } else {
                password.type = "password";
                toggle_visible.textContent = "👁️"
            }
        });

        toggle_visible_confirm.addEventListener("click", () => {
            if (password_confirmation.type === "password") {
                password_confirmation.type = "text";
                toggle_visible_confirm.textContent = "🙈"
            } else {
                password_confirmation.type = "password";
                toggle_visible_confirm.textContent = "👁️"
            }
        });

        // Toast animation
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.classList.remove('opacity-0');
                toast.classList.add('opacity-100');
            }, 100);
            setTimeout(() => {
                toast.classList.remove('opacity-100');
                toast.classList.add('opacity-0');
            }, 3100);
        }
    </script>
</body>

</html>

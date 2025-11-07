<style>
    /* Footer visual styles to complement Tailwind utilities */
    .footer-custom {
        background: linear-gradient(180deg, #0f4b47 0%, #083935 100%);
        color: #fff;
        border-radius: 18px 18px 0 0;
        overflow: hidden
    }

    .footer-custom .max-w-6xl {
        padding: 48px 24px
    }

    .footer-custom .logo-chip {
        width: 28px;
        height: 28px;
        background: #f5a623;
        border-radius: 6px;
        display: inline-block;
        margin-right: 8px
    }

    .footer-custom p {
        color: #cfe9e2
    }

    .footer-custom .social a {
        color: #cfe9e2;
        font-size: 18px
    }

    .footer-custom .social a:hover {
        color: #f5a623
    }

    .footer-custom .back-btn {
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 8px 12px;
        border-radius: 8px;
        background: transparent;
        color: #fff
    }

    .footer-custom .bottom-bar {
        background: #f5a623;
        color: #0f3b37;
        padding: 12px 0;
        font-weight: 600
    }

    @media (max-width:768px) {
        .footer-custom .max-w-6xl {
            padding: 24px
        }
    }
</style>

<footer class="footer-custom bg-[#0F3B37] text-white rounded-t-2xl overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 py-12 flex flex-col md:flex-row justify-between gap-10">

        <!-- Logo + mô tả -->
        <div class="md:w-1/3">
            <div class="flex items-center mb-4">
                <div class="w-6 h-6 bg-[#f5a623] rounded mr-2"></div>
                <span class="font-bold text-lg tracking-wide">UEFALONA</span>
            </div>
            <p class="text-sm text-gray-300 leading-relaxed mb-5">
                VARCELONA
            </p>

            <div class="flex space-x-4 text-xl mb-5">
                <a href="#" class="hover:text-[#f5a623]"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" class="hover:text-[#f5a623]"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" class="hover:text-[#f5a623]"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-[#f5a623]"><i class="fa-brands fa-facebook-f"></i></a>
            </div>
            <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="border px-4 py-2 text-sm flex items-center gap-2 rounded hover:bg-white hover:text-[#0F3B37] transition">
                <span>↑</span> BACK TO TOP
            </button>
        </div>

        <!-- Site map -->
        <div>
            <h3 class="font-semibold text-lg mb-4">Hãy Sống Theo Cách Của Bạn</h3>
            <ul class="space-y-2 text-gray-300 text-sm">
                <li><a href="#" class="hover:text-[#f5a623]">Homepage</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Technology</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Ataraxis Breast</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Resources & News</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Careers</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Contact Us</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Portal</a></li>
            </ul>
        </div>

        <!-- Legal -->
        <div>
            <h3 class="font-semibold text-lg mb-4">Legal</h3>
            <ul class="space-y-2 text-gray-300 text-sm">
                <li><a href="#" class="hover:text-[#f5a623]">Privacy Policy</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Terms of Services</a></li>
                <li><a href="#" class="hover:text-[#f5a623]">Lawyer's Corners</a></li>
            </ul>
        </div>

    </div>

    <div class="bg-[#f5a623] text-[#0F3B37] text-center py-3 text-sm font-medium">
        © 2024, ataraxis.ai, All Rights Reserved.
    </div>
</footer>

</body>

</html>

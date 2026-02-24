<footer class="bg-gray-900 text-gray-300 pt-16">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">

        <!-- Company Info -->
        <div>
            <a href="{{ site_url() }}">
            <img src="{{site_logo()}}" alt="Acewebx" class="h-10 mb-4">
            <p class="text-sm leading-relaxed">
                AceWebx is a software development company providing high-quality web,
                mobile app, and digital marketing solutions worldwide.
            </p>
            </a>

            <!-- Social Icons -->
            <div class="flex space-x-4 mt-4">
                <a href="#" class="hover:text-white"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="hover:text-white"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" class="hover:text-white"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
        <!-- Useful Links -->
        <div>
            <h4 class="text-white font-semibold mb-4">Useful Links</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-white">Home</a></li>
                <li><a href="#" class="hover:text-white">About Us</a></li>
                <li><a href="#" class="hover:text-white">Services</a></li>
                <li><a href="#" class="hover:text-white">Portfolio</a></li>
                <li><a href="#" class="hover:text-white">Contact Us</a></li>
            </ul>
        </div>

        <!-- Services -->
        <div>
            <h4 class="text-white font-semibold mb-4">Our Services</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-white">Web Development</a></li>
                <li><a href="#" class="hover:text-white">Mobile App Development</a></li>
                <li><a href="#" class="hover:text-white">UI/UX Design</a></li>
                <li><a href="#" class="hover:text-white">Digital Marketing</a></li>
                <li><a href="#" class="hover:text-white">Testing</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div>
            <h4 class="text-white font-semibold mb-4">Contact Info</h4>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start space-x-3">
                    <i class="fa-solid fa-location-dot mt-1 text-red-500"></i>
                    <span>
                        B-15, Industrial Area Phase 8B,<br>
                        S.A.S Nagar (Mohali), Punjab
                    </span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-phone text-red-500"></i>
                    <span>+91 9988-550-534</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-envelope text-red-500"></i>
                    <span>info@acewebx.com</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-800 mt-12"></div>

    <!-- Bottom Bar -->
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p>© {{ date('Y') }} AceWebx. All Rights Reserved.</p>
        <p class="text-gray-400 mt-2 md:mt-0">
            Designed with ❤️ by AceWebx
        </p>
    </div>
</footer>

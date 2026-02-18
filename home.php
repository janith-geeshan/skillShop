<?php include "header.php"; ?>
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Learn & Earn Skill Today</h1>
                <p class="text-blue-100 text-lg mb-6">
                    Connect with experet skill sellers and buyers in our thriving community.
                </p>

                <!-- search Bar  -->
                <div class="mb-6 bg-white rounded-lg p-3 flex gap-2">
                    <input type="text" placeholder="What skill are your looking for?"
                        class="flex-1 bg-transparent text-gray-900 outline-none text-sm" />
                    <button class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 font-medium text-sm transition-colors">Search</button>
                </div>

                <div class="flex gap-4 flex-col md:flex-row">

                    <?php if (isset($_SESSION["user_email"])): ?>

                        <?php if ($userRole == "buyer"): ?>
                            <a href="buyer-dashboard.php"
                                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover: shadow-lg inline-block transition-all">Go
                                to Dashboard</a>
                            <a href="#browse"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-bold hover:bg-white hover:bg-opacity-10 inline-block transition-all">Browse
                                Skills</a>
                        <?php endif; ?>

                        <?php if ($userRole == "seller"): ?>
                            <a href="seller-dashboard.php"
                                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover: shadow-lg inline-block transition-all">Go
                                to Dashboard</a>
                            <a href="#"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-bold hover:bg-white hover:bg-opacity-10 inline-block transition-all">Create
                                skills</a>
                        <?php endif; ?>

                    <?php else: ?>
                        <a href="index.php"
                            class="bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover: shadow-lg inline-block transition-all">Get
                            Started</a>
                        <a href="#"
                            class="border-2 border-white text-white px-6 py-3 rounded-lg font-bold hover:bg-white hover:bg-opacity-10 inline-block transition-all">Learn
                            More</a>

                    <?php endif; ?>

                </div>
            </div>

            <div class="hidden md:block">
                <div class="bg-white bg-opacity-10 rounded-xl p-8 backdrop-blur-sm">
                    <div class="space y-4">
                        <div class="flex items-center gap-3 text-blue-100">
                            <span class="text-2xl">✨</span>
                            <p class="">Expert Instructors ready to teach.</p>
                        </div>

                        <div class="flex items-center gap-3 text-blue-100">
                            <span class="text-2xl">🚀</span>
                            <p class="">Grow your skills or business.</p>
                        </div>

                        <div class="flex items-center gap-3 text-blue-100">
                            <span class="text-2xl">💰</span>
                            <p class="">Secure transactions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courasel -->
<section id="browse" class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="mb-12">
        <h2 class="text-3xl mb:text-4xl font-bold text-gray-900 mb-2">Featured Skills</h2>
        <p class="text-gray-600">
            Discover Trending Skills and top Sellers
        </p>
    </div>

    <!-- Courasel container -->
    <div class="relative group">
        <div class="overflow-hidden rounded-xl">
            <div id="carousel" class="flex transition-transform duration-500 ease-out" style="transform: translateX(0);">

                <!-- Carousel items -->
                <div class="carousel-item flex-shrink-0 w-full md:w-1/3 px-3 pb-4">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all h-full">
                        <img src="assets/images/cover1.jpg" class="w-full h-40 object-cover" />
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">UI/UX Design Mastery</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn modern design principles</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rs. 24999.00</span>
                                <span class="text-yellow-400">⭐ 4.9 (265)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item flex-shrink-0 w-full md:w-1/3 px-3 pb-4">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all h-full">
                        <img src="assets/images/cover2.jpg" class="w-full h-40 object-cover" />
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">Mobile App Development</h3>
                            <p class="text-gray-600 text-sm mb-4">Build iOS & Android apps</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rs. 85999.00</span>
                                <span class="text-yellow-400">⭐ 4.1 (325)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item flex-shrink-0 w-full md:w-1/3 px-3 pb-4">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all h-full">
                        <img src="assets/images/cover3.jpg" class="w-full h-40 object-cover" />
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">UI/UX Design Mastery</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn modern design principles</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rs. 24999.00</span>
                                <span class="text-yellow-400">⭐ 4.9 (265)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item flex-shrink-0 w-full md:w-1/3 px-3 pb-4">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all h-full">
                        <img src="assets/images/cover1.jpg" class="w-full h-40 object-cover" />
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">UI/UX Design Mastery</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn modern design principles</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rs. 24999.00</span>
                                <span class="text-yellow-400">⭐ 4.9 (265)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item flex-shrink-0 w-full md:w-1/3 px-3 pb-4">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all h-full">
                        <img src="assets/images/cover1.jpg" class="w-full h-40 object-cover" />
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">UI/UX Design Mastery</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn modern design principles</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rs. 24999.00</span>
                                <span class="text-yellow-400">⭐ 4.9 (265)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item flex-shrink-0 w-full md:w-1/3 px-3 pb-4">
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all h-full">
                        <img src="assets/images/cover1.jpg" class="w-full h-40 object-cover" />
                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2">UI/UX Design Mastery</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn modern design principles</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rs. 24999.00</span>
                                <span class="text-yellow-400">⭐ 4.9 (265)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Navigation buttons -->
        <button onclick="slideCarousel(-1);" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1 bg-blue-600 text-white p-3
         rounded-full hover:bg-blue-700 transition-all hover:scale-110 z-10 opacity-0 group-hover:opacity-100">⫷</button>
        <button onclick="slideCarousel(1);" class="absolute right-0 top-1/2 -translate-y-1/2 -translate-x-0 bg-blue-600 text-white p-3
         rounded-full hover:bg-blue-700 transition-all hover:scale-110 z-10 opacity-0 group-hover:opacity-100">⫸</button>

    </div>

    <!-- Carousel Indicators -->
    <div id="carousel-indicators" class="flex justify-center gap-2 ">
        <button onclick="goToSlide(0);" class="carousel-dot w-3 h-3 rounded-full bg-blue-600 transition-all"></button>
        <button onclick="goToSlide(1);" class="carousel-dot w-3 h-3 rounded-full bg-gray-600 transition-all"></button>
    </div>

</section>

<!-- Categories Section -->
<section id="categories" class="bg-gray-50 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-col-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-12 text-center">Explore Categories</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="#" class="group bg-white p-6 rounded-lg text-center shadow hover:shadow-lg transition-all
                        cursor-pointer hover:scale-105 hover:border-2 hover:border-blue-600">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">🎨</div>
                <p class="font-semibold text-gray-800 group-hover:text-blue-600">Design</p>
            </a>

            <a href="#" class="group bg-white p-6 rounded-lg text-center shadow hover:shadow-lg transition-all
                        cursor-pointer hover:scale-105 hover:border-2 hover:border-blue-600">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">💻</div>
                <p class="font-semibold text-gray-800 group-hover:text-blue-600">Development</p>
            </a>

            <a href="#" class="group bg-white p-6 rounded-lg text-center shadow hover:shadow-lg transition-all
                        cursor-pointer hover:scale-105 hover:border-2 hover:border-blue-600">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">📱</div>
                <p class="font-semibold text-gray-800 group-hover:text-blue-600">Mobile</p>
            </a>

            <a href="#" class="group bg-white p-6 rounded-lg text-center shadow hover:shadow-lg transition-all
                        cursor-pointer hover:scale-105 hover:border-2 hover:border-blue-600">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">📚</div>
                <p class="font-semibold text-gray-800 group-hover:text-blue-600">Education</p>
            </a>

            <a href="#" class="group bg-white p-6 rounded-lg text-center shadow hover:shadow-lg transition-all
                        cursor-pointer hover:scale-105 hover:border-2 hover:border-blue-600">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">📽️</div>
                <p class="font-semibold text-gray-800 group-hover:text-blue-600">Video</p>
            </a>

            <a href="#" class="group bg-white p-6 rounded-lg text-center shadow hover:shadow-lg transition-all
                        cursor-pointer hover:scale-105 hover:border-2 hover:border-blue-600">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">💼</div>
                <p class="font-semibold text-gray-800 group-hover:text-blue-600">Business</p>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-12 text-center">
        What our users say...
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-2xl transition-shadow hover:scale-105 duration-300">
            <div class="flex items-center mb-4">
                <img src="https://images.unsplash.com/photo-1562788869-4ed32648eb72?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8b2ZmaWNlJTIwcGVyc29ufGVufDB8fDB8fHww" class="w-12 h-12  rounded-full mr-4" />
                <div>
                    <p class="font-bold text-gray-900">Naleen Fernando</p>
                    <p class="text-sm text-yellow-400">⭐⭐⭐⭐⭐</p>
                </div>
            </div>
            <p class="text-gray-600">Skillshop helped me to learn web development and land a great job.</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-2xl transition-shadow hover:scale-105 duration-300">
            <div class="flex items-center mb-4">
                <img src="https://images.unsplash.com/photo-1589386417686-0d34b5903d23?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8b2ZmaWNlJTIwcGVyc29ufGVufDB8fDB8fHww" class="w-12 h-12  rounded-full mr-4" />
                <div>
                    <p class="font-bold text-gray-900">Isuru Sampath</p>
                    <p class="text-sm text-yellow-400">⭐⭐⭐⭐</p>
                </div>
            </div>
            <p class="text-gray-600">Skillshop was the best.</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-2xl transition-shadow hover:scale-105 duration-300">
            <div class="flex items-center mb-4">
                <img src="https://images.unsplash.com/photo-1624237326876-90ebbdf28e59?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fG9mZmljZSUyMHBlcnNvbnxlbnwwfHwwfHx8MA%3D%3D" class="w-12 h-12  rounded-full mr-4" />
                <div>
                    <p class="font-bold text-gray-900">Dave Morgan</p>
                    <p class="text-sm text-yellow-400">⭐⭐⭐⭐⭐</p>
                </div>
            </div>
            <p class="text-gray-600">This was a real turning point in my professional carrer.</p>
        </div>

    </div>
</section>

<!-- Stacks Section -->
<section class="py-16 md:py-24 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-4 md-grid-cols-4 gap-8 text-center">

            <div class="hover:scale-110 transition-transform duration-300 cursor-pointer">
                <div class="text-4xl md:text-5xl font-bold mb-2">
                    50K+
                </div>
                <p class="text-blue-100">Active Users</p>
            </div>

            <div class="hover:scale-110 transition-transform duration-300 cursor-pointer">
                <div class="text-4xl md:text-5xl font-bold mb-2">
                    10K+
                </div>
                <p class="text-blue-100">Skill Listed</p>
            </div>

            <div class="hover:scale-110 transition-transform duration-300 cursor-pointer">
                <div class="text-4xl md:text-5xl font-bold mb-2">
                    98%
                </div>
                <p class="text-blue-100">Satisfaction Rate</p>
            </div>

            <div class="hover:scale-110 transition-transform duration-300 cursor-pointer">
                <div class="text-4xl md:text-5xl font-bold mb-2">
                    100M+
                </div>
                <p class="text-blue-100">transaction Value</p>
            </div>

        </div>
    </div>
</section>

<!-- How it works -->
<section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-12 text-center">How it works</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="text-center group">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full w-16 h-16 flex items-center justify-center text-2xl text-white mx-auto
            mb-4 group-hover:scale-110 transition-transform">1</div>
            <h3 class="font-bold text-lg text-gray-900 mb-2">Create Account</h3>
            <p class="text-gray-600 text-sm">Sign up as a buyer or seller in minutes</p>
        </div>

        <div class="text-center group">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full w-16 h-16 flex items-center justify-center text-2xl text-white mx-auto
            mb-4 group-hover:scale-110 transition-transform">2</div>
            <h3 class="font-bold text-lg text-gray-900 mb-2">Browse or list</h3>
            <p class="text-gray-600 text-sm">Explore skills or create your own content.</p>
        </div>

        <div class="text-center group">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full w-16 h-16 flex items-center justify-center text-2xl text-white mx-auto
            mb-4 group-hover:scale-110 transition-transform">3</div>
            <h3 class="font-bold text-lg text-gray-900 mb-2">Connect & Learn</h3>
            <p class="text-gray-600 text-sm">Interact with instructions and comunity</p>
        </div>

        <div class="text-center group">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full w-16 h-16 flex items-center justify-center text-2xl text-white mx-auto
            mb-4 group-hover:scale-110 transition-transform">4</div>
            <h3 class="font-bold text-lg text-gray-900 mb-2">Grow & Earn</h3>
            <p class="text-gray-600 text-sm">Build skills or passive income stream.</p>
        </div>
    </div>
</section>

<!-- Call to section -->
<section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 md:p-16 text-center text-white shadow-2xl">

        <h2 class="text-3xl md: text-4xl font-bold mb-4">Ready to Start Your Joruney ?</h2>
        <p class="text-blue-100 text-lg mb-8">Joint thousands of learners and sellers earning on SkillShop today</p>

        <div class="flex flex-col md:flex-row gap-4 justify-center">

            <?php if (isset($_SESSION["user_email"])): ?>

                <?php if ($userRole == "buyer"): ?>
                    <a href="buyer-dashboard.php"
                        class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:shadow-2x1 inline-block transition-all hover:scale-105">
                        Go to Dashboard</a>
                    <a href="#browse"
                        class="border-2 border-white text-white px-8 py-3 rounded-1g font-bold hover:bg-white hover:bg-opacity-20 inline-block transition-all">
                        Explore More</a>
                <?php elseif ($userRole == "seller"): ?>
                    <a href="seller-dashboard.php"
                        class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:shadow-2x1 inline-block transition-all hover:scale-105">
                        Go to Dashboard</a>
                    <a href="#"
                        class="border-2 border-white text-white px-8 py-3 rounded-lg font-boldhover:bg-white hover:bg-opacity-20 inline-block transition-all">
                        Create New Skill</a>
                <?php endif; ?>

            <?php else: ?>

                <a href="index.php"
                    class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:shadow-2xl inline-block transition-all hover:scale-105">
                    Sign Up Now</a>
                <a href="#browse"
                    class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:bg-opacity-20 inline-block transition-all">
                    Learn More</a>

            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    var currentSlide = 0;
    var itemsPreview = window.innerWidth >= 768 ? 3 : 1;
    var totalItems   = 6;
    var maxSlides    = Math.ceil(totalItems / itemsPreview) - 1;

    function slideCarousel(direction) {
        currentSlide += direction;

        if (currentSlide > maxSlides) {
            currentSlide = 0;
        } else if (currentSlide < 0) {
            currentSlide = maxSlides;
        }

        updateCarousel();
    }

    function goToSlide(slide) {
        currentSlide = slide;
        updateCarousel();
    }

    function updateCarousel() {
        var carousel = document.getElementById("carousel");
        var slideWidth = 100 / itemsPreview;
        var offSet = currentSlide * slideWidth;
        carousel.style.transform = `translateX(${offSet}%)`;

        //Update dots
        var dotsContainer = document.getElementById("carousel-indicators");
        var dots = dotsContainer.querySelectorAll(".carousel-dot");

        dots.forEach((dot, index) => {
            if (index == currentSlide) {
                dot.classList.add("bg-blue-600");
                dot.classList.remove("bg-gray-300");
            } else {
                dot.classList.remove("bg-blue-600");
                dot.classList.add("bg-gray-300");
            }
        });
    }

    // Auto slide carousel every 5 seconds
    setInterval(() => {
        slideCarousel(1);
    }, 5000);

    //Handle responsive changes
    window.addEventListener("resize", () => {
        updateCarousel();
    });

    // Initiallize dots onload
    window.addEventListener("load", () => {
        var dotsContainer = document.getElementById("carousel-indicators");
        dotsContainer.innerHTML = "";
        for (var i = 0; i <= maxSlides; i++) {
            var dot = document.createElement("button");
            dot.onclick = () => goToSlide(i);
            dot.className = `carousel-dot w-3 h-3 rounded-full transaction-all ${i == 0 ? "bg-blue-600" : "bg-gray-300"}`;
            dotsContainer.appendChild(dot);
        }
    });
</script>

<?php include "footer.php"; ?>
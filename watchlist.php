<?php

if (!isset($_SESSION)) session_start();

require_once "db/connection.php";
require_once "process/authCheck.php";

$loggedIn = isset($_SESSION["logged_in"]) ??  false;
$userRole = isset($_SESSION["active_account_type"]) ?? "";
$userID = isset($_SESSION["user_id"]) ?? 0;

if (!$loggedIn || $userRole != "buyer" || $userID <= 0) {
    header("Location: index.php");
    exit;
}

include "header.php";
?>

<div class="min-h-screen relative overflow-hidden">
    <section class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">

            <div>

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-rose-100/80 
                text-rose-700 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.177a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    Saved Skills
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-light">My Watchlist</h1>
                <p class="text-gray-500 mt-2">3 skills saved for later.</p>

            </div>

            <a href="search-products.php" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold bg-white border-2 border-gray-200 text-gray-700 hover:border-blue-400 hover:text-blue-600 shadow-sm hover:shadow-md transition-all shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Browse More
            </a>
        </div>
        <?php if (false): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="watchlist-grid">

                <article class="group relative bg-white/80 backdrop-blur rounded-2xl border border-gray-100 shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 hover:translate-y-1" data-product-id="">

                    <a href="product-view.php" class="block">
                        <div class="relative h-44 bg-gradient-to-br from-slate-100 to-slate-50 overflow-hidden">
                            <img src="uploads/products/product_1_1772019835_8a306d04.jpg" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />

                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 backdrop-blur text-xs font-bold text-blue-700 rounded-lg shadow-sm">Advanced</span>
                        </div>

                        <div class="p-5">
                            <p class="text-xs font-semibold text-blue-600 mb-1">Sahan Perera</p>
                            <h3 class="font-bold text-gray-900 text-base leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">Web Development and Analysis</h3>
                            <div class="flex items-center justify-between mt-4">
                                <span class="flex items-center gap-1 text-sm">
                                    <span class="text-amber-400">★</span> New
                                </span>
                                <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Rs. 50,000.00</span>
                            </div>
                        </div>
                    </a>

                    <button type="button" class="wl-heart absolute top-3 right-3 z-20 w-10 h-10 flex items-center justify-center rounded-full bg-white/90 backdrop-blur shadow-md text-rose-500 hover:scale-110 active:scale-85 transition-transform" data-product-id="" title="Remove from watchlist">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>

                </article>

                <article class="group relative bg-white/80 backdrop-blur rounded-2xl border border-gray-100 shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 hover:translate-y-1" data-product-id="">

                    <a href="product-view.php" class="block">
                        <div class="relative h-44 bg-gradient-to-br from-slate-100 to-slate-50 overflow-hidden">
                            <img src="uploads/products/product_1_1772019835_8a306d04.jpg" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />

                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 backdrop-blur text-xs font-bold text-blue-700 rounded-lg shadow-sm">Advanced</span>
                        </div>

                        <div class="p-5">
                            <p class="text-xs font-semibold text-blue-600 mb-1">Sahan Perera</p>
                            <h3 class="font-bold text-gray-900 text-base leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">Web Development and Analysis</h3>
                            <div class="flex items-center justify-between mt-4">
                                <span class="flex items-center gap-1 text-sm">
                                    <span class="text-amber-400">★</span> New
                                </span>
                                <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Rs. 50,000.00</span>
                            </div>
                        </div>
                    </a>

                    <button type="button" class="wl-heart absolute top-3 right-3 z-20 w-10 h-10 flex items-center justify-center rounded-full bg-white/90 backdrop-blur shadow-md text-rose-500 hover:scale-110 active:scale-85 transition-transform" data-product-id="" title="Remove from watchlist">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>

                </article>
            </div>

        <?php else: ?>
            <div class="relative bg-white/80 backdrop-blur rounded-3xl border border-dashed border-gray-200 p-16 text-center shadow-lg max-w-xl mx-auto">
                <div class="inline-flex w-24 h-24 items-center justify-center rounded-full bg-gradient-to-br from-rose-100 to-indigo-100 text-5xl mb-6">❤️</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your watchlist is empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Save skills you're interested in with the heart icon and find them here.</p>
                <a href="search-products.php" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600
                to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl
                transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Browse Skills
                </a>

            </div>

        <?php endif; ?>

    </section>
</div>

<?php include "footer.php"; ?>
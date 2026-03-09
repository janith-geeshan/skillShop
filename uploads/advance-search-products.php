<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db/connection.php";

// check remember me token exists
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    require_once "process/authCheck.php";
}

$loggedIn = isset($_SESSION["logged_in"]) ? $_SESSION["logged_in"] : false;
$userRole = isset($_SESSION["active_account_type"]) ? $_SESSION["active_account_type"] : "";
$userId   = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

require "header.php";

// build filters array from GET parameters
$filters = [
    "q"        => isset($_GET["q"]) ? trim($_GET["q"]) : "",
    "category" => isset($_GET["cat"]) ? intval($_GET["cat"]) : "",
    "level"    => isset($_GET["level"]) ? intval($_GET["level"]) : "",
    "price_min" => isset($_GET["price_min"]) ? floatval($_GET["price_min"]) : "",
    "price_max" => isset($_GET["price_max"]) ? floatval($_GET["price_max"]) : "",
    "rating"   => isset($_GET["rating"]) ? floatval($_GET["rating"]) : "",
    "sort"     => isset($_GET["sort"]) ? $_GET["sort"] : "newest"
];

// pagination
$currentPage  = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
$itemsPerPage = 12;

// get categories for filter
$categoryResult = Database::search("SELECT `id`, `name` FROM `category` ORDER BY `name`");
$categories = [];
if ($categoryResult && $categoryResult->num_rows > 0) {
    while ($category = $categoryResult->fetch_assoc()) {
        $categories[] = $category;
    }
}

// use ProductSearcher helper which applies all filters, ratings having clause
require_once "Controlers/ProductSearcher.php";
$searcher = new ProductSearcher($userId);

// count and fetch
$totalProducts = $searcher->getCount($filters);
$totalPages    = $totalProducts ? ceil($totalProducts / $itemsPerPage) : 0;
$products       = $searcher->search($filters, $currentPage, $itemsPerPage);
?>




<div class="min-h-screen bg-gray-50">

    <!-- Search header  -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 text-center">Find your perfect skill</h1>
            <p class="text-blue-100 text-center mb-8">Discover expert-led courses across various topics</p>

            <!-- search box  -->
            <form method="GET" action="advance-search-products.php" class="max-w-2xl mx-auto flex gap-2">
                <input type="text" name="q" placeholder="Search Skills, Topics, Instrustors..."
                    value="<?php echo $filters["q"]; ?>" class="flex-1 px-5 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none 
             focus:ring-2 focus:ring-yellow-400 text-sm" autocomplete="off" />
                <button type="submit" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900
             font-bold rounded-lg transition-colors">🔍 Search</button>
            </form>
        </div>
    </section>
    <!-- Main Content Area -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col lg:flex-row gap-4">

            <!-- Sidebar: Filters -->
            <aside id="filterSidebar" class="lg:w-1/4 flex-shrink-0 space-y-6 hidden lg:block mobile-filter-modal">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">

                    <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h2 class="font-bold text-gray-600 flex items-center gap-2">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 17a4 4 0 0 0 4-4V7a4 4 0 0 0-8 0v6a4 4 0 0 0 4 4zm0 0v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2m-6 0H9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2">
                                </path>
                            </svg>
                            Refine Results
                        </h2>
                        
                        <button onclick="toggleFilters();" class="lg:hidden text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18l18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="GET" action="advance-search-products.php" class="p-5 space-y-6">
                        <input type="hidden" name="q" value="<?php echo htmlspecialchars($filters["q"]); ?>">

                        <!-- Category -->
                        <div>
                            <label class="block text-gray-900 text-sm font-bold mb-3">📁 Category</label>
                            <select name="cat" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                <option value="">All categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $filters['category'] == $cat['id'] ? "selected" : ""; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Difficulty -->
                        <div>
                            <label class="block text-gray-900 text-sm font-bold mb-3">🎓 Difficulty</label>
                            <div class="space-y-2">
                                <?php $levels = [1 => "🟢 Beginner", 2 => "🟡 Intermediate", 3 => "🔴 Advanced"]; ?>
                                <?php foreach ($levels as $val => $label): ?>
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="level" value="<?php echo $val; ?>" <?php echo $filters['level'] == $val ? "checked" : ""; ?> class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-blue-600 transition-colors"><?php echo $label; ?></span>
                                    </label>
                                <?php endforeach; ?>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="level" value="" <?php echo empty($filters["level"]) ? "checked" : ""; ?> class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                    <span class="ml-3 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">Any Level</span>
                                </label>
                            </div>
                        </div>

                        <!-- Ratings -->
                        <div>
                            <label class="block text-gray-900 text-sm font-bold mb-3">⭐ Minimum Rating</label>
                            <select name="rating" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                <option value="">Any Rating</option>
                                <option value="4" <?php echo $filters["rating"] == "4" ? "selected" : ""; ?>>4+ Stars</option>
                                <option value="3" <?php echo $filters["rating"] == "3" ? "selected" : ""; ?>>3+ Stars</option>
                                <option value="2" <?php echo $filters["rating"] == "2" ? "selected" : ""; ?>>2+ Stars</option>
                                <option value="1" <?php echo $filters["rating"] == "1" ? "selected" : ""; ?>>1+ Stars</option>
                                <option value="0" <?php echo $filters["rating"] == "0" ? "selected" : ""; ?>>New / Not Rated</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-gray-900 text-sm font-bold mb-3">💰 Price Range (Rs.)</label>
                            <div class="space-y-4 px-1">
                                <input type="range" id="priceMin" min="0" max="1000000" step="500"
                                    value="<?php echo $filters["price_min"] ?: '0'; ?>"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                                    oninput="updatePriceFormRange(event);" />
                                <input type="range" id="priceMax" min="0" max="1000000" step="500"
                                    value="<?php echo $filters["price_max"] ?: '1000000'; ?>"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                                    oninput="updatePriceFormRange(event);" />
                                <div class="flex items-center gap-2">
                                    <input type="number" name="price_min" id="priceMinInput" placeholder="Min"
                                        class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 text-xs rounded-lg focus:ring-1 focus:ring-blue-500 outline-none"
                                        oninput="updatePriceFormRange(event);" />
                                    <span class="text-gray-400">-</span>
                                    <input type="number" name="price_max" id="priceMaxInput" placeholder="Max"
                                        class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 text-xs rounded-lg focus:ring-1 focus:ring-blue-500 outline-none"
                                        oninput="updatePriceFormRange(event);" />
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="pt-4 space-y-3">
                            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition-all active:scale-[0.90]">
                                Apply Filters
                            </button>
                            <a href="advance-search-products.php?q=<?php echo htmlspecialchars($filters["q"]); ?>"
                                class="block w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center font-bold text-sm rounded-xl transition-all">
                                Reset
                            </a>
                        </div>
                    </form>



                </div>
            </aside>

            <!-- product display area -->
            <main class="flex-1">
                <!-- results bar -->
                <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleFilters();" class="lg:hidden flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm
                                                      font-semibold text-gray-700 hover:bg-gray-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 20 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-.707.293V17l-4v-6.586a1 1 0 00-.293-.707l-3.293 7.293 7.293a1 1 0 011 0l1 6.586V2">
                                </path>
                            </svg>

                        </button>
                        <p class="text-gray-600 text-sm">
                            <?php if ($totalProducts > 0): ?>
                                Showing <span class="font-bold text-gray-700"><?php echo $totalProducts; ?></span> skills
                                <?php if ($filters['q']) echo ' for <span class="text-blue-600">' . $filters['q'] . '</span>'; ?>
                            <?php else: ?>
                                No results found for your search
                            <?php endif; ?>
                        </p>


                    </div>
                    <div class="flex items-center gap-3 bg-white p-1 rounded-xl border border-gray-100 shadow-sm">
                        <span class="text-xs text-gray-400 font-medium pl-3 hidden sm:inline">Sort By</span>
                        <form method="GET" id="sortForm">
                            <select name="sort" onchange="this.form.submit();"
                                class="pl-2 pr-8 py-2 bg-transparent text-sm font-bold text-gray-700 cursor-pointer focus:outline-none">
                                <option value="newest" <?php echo $filters["sort"] == "newest" ? "selected" : ""; ?>>Recently added</option>
                                <option value="price_low" <?php echo $filters["sort"] == "price_low" ? "selected" : ""; ?>>Price: Low to High</option>
                                <option value="price_high" <?php echo $filters["sort"] == "price_high" ? "selected" : ""; ?>>Price: High to Low</option>
                                <option value="rating" <?php echo $filters["sort"] == "rating" ? "selected" : ""; ?>>Rating: High to Low</option>
                                <option value="popular" <?php echo $filters["sort"] == "popular" ? "selected" : ""; ?>>Popularity (Most Customers)</option>
                                <option value="reviews" <?php echo $filters["sort"] == "reviews" ? "selected" : ""; ?>>Most Reviewed</option>
                            </select>
                            <?php
                            // preserve all other query parameters when sorting (use original GET keys such as 'cat')
                            foreach ($_GET as $k => $v) {
                                if ($k !== 'sort' && $v !== '') {
                                    echo "<input type='hidden' name='" . htmlspecialchars($k) . "' value='" . htmlspecialchars($v) . "' />";
                                }
                            }
                            ?>
                        </form>
                    </div>

                </div>

                <?php if (count($products) > 0): ?>
                    <!-- products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php foreach ($products as $product):
                            $rating = $product["avg_rating"] > 0 ? round($product["avg_rating"], 1) : "New"; ?>
                            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden h-full">
                                <div class="relative aspect-video bg-gray-100 overflow-hidden">
                                    <?php if ($product["image_url"]): ?>
                                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-blue-50">
                                            <span class="text-4xl">📚</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-white/50 backdrop-blur shadow-sm text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                                            <?php echo htmlspecialchars($product["level"]); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center text-[10px]">👤</div>
                                        <span class="text-xs font-semibold text-blue-600"><?php echo htmlspecialchars($product["seller_name"]); ?></span>
                                    </div>
                                    <h3 class="text-gray-900 font-bold text-base leading-tight mb-3 line-clamp-2 hover:text-blue-600 transition-colors">
                                        <a href="product-view.php?id=<?php echo $product["id"]; ?>">
                                            <?php echo htmlspecialchars($product["title"]); ?>
                                        </a>
                                    </h3>
                                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-6">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-yellow-400 text-lg">⭐</span>
                                            <span class="font-bold text-gray-900"><?php echo $rating; ?></span>
                                            <span>(<?php echo $product["review_count"]; ?>)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span><?php echo $product["customer_count"]; ?> customers</span>
                                        </div>
                                    </div>
                                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-400 font-medium">Skill</span>
                                            <span class="text-xl font-semibold text-blue-500">Rs. <?php echo number_format($product["price"], 2); ?></span>
                                        </div>
                                        <a href="product-view.php?id=<?php echo $product["id"]; ?>"
                                            class="p-1 bg-blue-200 text-blue-600 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-all transform group-hover:translate-x-2">
                                            <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1):
                        // build query string from original GET parameters so names (like 'cat') are preserved
                        $filterQuery = "";
                        foreach ($_GET as $k => $v) {
                            if ($k !== 'page' && $v !== '') {
                                $filterQuery .= "&" . urlencode($k) . "=" . urlencode($v);
                            }
                        }
                    ?>
                        <div class="mt-16 flex justify-center">
                            <nav class="inline-flex items-center gap-2 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                                <?php if ($currentPage > 1): ?>
                                    <a href="?page=<?php echo $currentPage - 1; ?><?php echo $filterQuery; ?>" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-50 text-gray-500 transition-all">‹</a>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php if ($i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1)): ?>
                                        <a href="?page=<?php echo $i; ?><?php echo $filterQuery; ?>" class="w-10 h-10 flex items-center justify-center rounded-xl text-sm font-bold transition-all <?php echo $i == $currentPage ? "bg-blue-600 text-white shadow-lg shadow-blue-200" : "text-gray-600 hover:bg-gray-50"; ?>"><?php echo $i; ?></a>
                                    <?php elseif ($i == 2 && $currentPage > 3): ?>
                                        <span class="text-gray-300">...</span>
                                    <?php elseif ($i == $totalPages - 1 && $currentPage < $totalPages - 2): ?>
                                        <span class="text-gray-300">...</span>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="?page=<?php echo $currentPage + 1; ?><?php echo $filterQuery; ?>" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-50 text-gray-500 transition-all">›</a>
                                <?php endif; ?>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php else: ?>



                    <!-- Empty state -->
                    <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-gray-200 shadow-sm max-w-xl mx-auto my-20">
                        <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-8">
                            <span class="text-5xl">🛠</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No matching skills found!</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed">
                            We couldn't find anything matching your filters. Try clearing some options or searching for a different keyword.
                        </p>
                        <a href="advance-search-products.php" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-all transform active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5h.582M15.356 2A.001 0.001 0 004.582 0M8m11 1v5h-.581M0a8.003 8.003 0 0115.357 2m15.357 21l5" />
                            </svg>
                            Clear All Filters
                        </a>
                    </div>


                <?php endif; ?>

            </main>


        </div>



    </section>

    </section>


    <!-- feature section -->
    <section class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-500 mb-8 text-center">Why Choose Skillshop</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- First Card -->
                <div class="grid text-center p-6 rounded-xl hover:bg-gray-200 transition-colors">
                    <div class="bg-blue-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-300 transition-colors">
                        <!-- Bookmark Icon -->
                        <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 012-2h6a2 2 0 012 2v14l-5-3-5 3V3z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Learn at Your Pace</h3>
                    <p class="text-sm text-gray-600">Access courses anytime, anywhere on any device</p>
                </div>

                <!-- Second Card -->
                <div class="grid text-center p-6 rounded-xl hover:bg-gray-200 transition-colors">
                    <div class="bg-green-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-300 transition-colors">
                        <!-- Shield Icon -->
                        <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V6l7-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Expert Instructors</h3>
                    <p class="text-sm text-gray-600">Learn from experienced professionals in their field</p>
                </div>

                <!-- Third Card -->
                <div class="grid text-center p-6 rounded-xl hover:bg-gray-200 transition-colors">
                    <div class="bg-purple-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-300 transition-colors">
                        <!-- Dollar Icon -->
                        <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1.07a4.002 4.002 0 013 3.87c0 1.657-1.343 3-3 3H9v2h2a2 2 0 110 4H10a1 1 0 01-1-1v-1.07a4.002 4.002 0 01-3-3.87c0-1.657 1.343-3 3-3h2V6H9a2 2 0 110-4h1z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Affordable Pricing</h3>
                    <p class="text-sm text-gray-600">Quality education that fits your budget</p>
                </div>

            </div>
        </div>
    </section>


</div>

<style>
    @media (max-width: 1024px) {
        .mobile-filter-modal.active {
            display: block !important;
            position: fixed;
            inset: 0;
            z-index: 100;
            background-color: #fff;
            overflow-y: auto;
            padding-bottom: 2rem;
        }
    }
</style>


<script>
    function toggleFilters() {
        const sidebar = document.getElementById("filterSidebar");
        sidebar.classList.toggle("hidden");
        sidebar.classList.toggle("active");
        document.body.style.overflow = sidebar.classList.contains("active") ? "hidden" : "";
    }

    function updatePriceFormRange(event) {
        const min = document.getElementById("priceMin");
        const max = document.getElementById("priceMax");
        const minInput = document.getElementById("priceMinInput");
        const maxInput = document.getElementById("priceMaxInput");

        // Sync slider → input
        if (event && parseInt(min.value) > parseInt(max.value)) {
            if (event.target.id === "priceMin") {
                max.value = min.value;
            } else {
                min.value = max.value;
            }
        }

        minInput.value = min.value;
        maxInput.value = max.value;

        // Sync input → slider
        min.value = minInput.value || 0;
        max.value = maxInput.value || 1000000;

        if (parseInt(min.value) > parseInt(max.value)) {
            [min.value, max.value] = [max.value, min.value];
        }
    }

    window.addEventListener("DOMContentLoaded", () => {
        updatePriceFormRange();
    });
</script>

<?php

require "footer.php";

?>
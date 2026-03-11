<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "db/connection.php";

// Check remember me token available
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != true) {
    require_once "process/authCheck.php";
}

$loggedIn = isset($_SESSION["logged_in"]) ? $_SESSION["logged_in"] : false;
$userRole = isset($_SESSION["active_account_type"]) ? $_SESSION["active_account_type"] : "";
$userID = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

require "header.php";

//search and pagination
$searchQuery = isset($_GET["q"]) ? trim($_GET["q"]) : "";
$currentPage = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
$itemPerPage = 12;

//Build Search Query
$whereClause = "WHERE p.`status`=`active`";
$params = [];
$paramType = "";

if(!empty($searchQuery)){
   $searchTeam =" %{$searchQuery}%";
   $whereClause .= "AND(p. `title` LIKE ? OR p.`description` LIKE ?)";
   $params = [$searchTeam,$searchTeam];
   $paramType = "ss";
}



?>

<div class="min-h-screen bg-gray-50">

    <!--Search Header-->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 text-center">Find Your Perfect Skill</h1>
            <p class="text-blue-100 text-center mb-8">Discover experent-led courses acrooss various topics</p>

            <!--Search Box-->
            <form method="GET" action="search-products.php" class="max-w-2xl mx-auto flex gap-2">
                <input type="text" name="q" placeholder="Search skills.topics,instructors..."
                    value="" class="flex-1 px-5 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none
                    focus:ring-2 focus:ring-yellow-400 text-sm" autocomplete="off" />
                <button type="submit" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900
                     font-bold rounded-lg transition-colors">🔍 Search</button>
            </form>

            <!--Result Count-->
            <P class="text-blue-100 text-center text-sm mt-6">
                <span class="font-bold">6</span>
                skills found for "UI"
            </P>
        </div>
    </section>

    <!--Result Section-->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

            <!--Product card 1-->
            <div class="relative bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300
               overflow-hidden flex flex-col border border-gray-100 group">

                <a href="product-view.php?id=1" class="absolute inset-0 z-10"></a>

                <!--Image-->
                <div class="relative w-full h-48 bg-gray-100 overflow-hidden flex-shrink-0">
                    <img src="./assets/images/cover1.jpg"
                        class="w-full h-full object-cover group-hover:scale-105 transform duration-300" />
                    <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold
                      rounded-full">Beginner</span>
                </div>

                <!--Content-->
                <div class="p-4 flex-1 flex flex-col">


                    <!--Seller-->
                    <a href="seller-profile.php?id=1" class="relative z-20 text-xs text-blue-600 hover:text-blue-700
                      font-medium mb-1.5 line-clamp-1 w-fit">Sahan Perera</a>

                    <!--Title-->
                    <h3 class="font-bold text-gray-900 text-sm leading-sung line-clamp-2 mb-2 group-hover:text-blue-600
                       transition-colors">UI/UX Design Mastery</h3>

                    <!--Status Row-->
                    <div class="flex items-center justify-between text-xs mb-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-semibold text-gray-900">5</span>
                            <span class="text-gray-400">(100)</span>
                        </div>
                    </div>

                    <!--Price & Arrow -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="font-bold text-base text-blue-600">Rs.69999.99</span>
                        <div class="px-2.5 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg
                          group-hover:bg-blue-600 group-hover:text-white transition-colors">></div>

                    </div>
                </div>

            </div>

            <!--Product card 2-->
            <div class="relative bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300
               overflow-hidden flex flex-col border border-gray-100 group">

                <a href="product-view.php?id=1" class="absolute inset-0 z-10"></a>

                <!--Image-->
                <div class="relative w-full h-48 bg-gray-100 overflow-hidden flex-shrink-0">
                    <img src="./assets/images/cover2.jpg"
                        class="w-full h-full object-cover group-hover:scale-105 transform duration-300" />
                    <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold
                      rounded-full">Beginner</span>
                </div>

                <!--Content-->
                <div class="p-4 flex-1 flex flex-col">


                    <!--Seller-->
                    <a href="seller-profile.php?id=1" class="relative z-20 text-xs text-blue-600 hover:text-blue-700
                      font-medium mb-1.5 line-clamp-1 w-fit">Sahan Perera</a>

                    <!--Title-->
                    <h3 class="font-bold text-gray-900 text-sm leading-sung line-clamp-2 mb-2 group-hover:text-blue-600
                       transition-colors">UI/UX Design Mastery</h3>

                    <!--Status Row-->
                    <div class="flex items-center justify-between text-xs mb-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-semibold text-gray-900">5</span>
                            <span class="text-gray-400">(100)</span>
                        </div>
                    </div>

                    <!--Price & Arrow -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="font-bold text-base text-blue-600">Rs.69999.99</span>
                        <div class="px-2.5 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg
                          group-hover:bg-blue-600 group-hover:text-white transition-colors">></div>

                    </div>
                </div>

            </div>

            <!--Product card 3-->
            <div class="relative bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300
               overflow-hidden flex flex-col border border-gray-100 group">

                <a href="product-view.php?id=1" class="absolute inset-0 z-10"></a>

                <!--Image-->
                <div class="relative w-full h-48 bg-gray-100 overflow-hidden flex-shrink-0">
                    <img src="./assets/images/cover3.jpg"
                        class="w-full h-full object-cover group-hover:scale-105 transform duration-300" />
                    <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold
                      rounded-full">Beginner</span>
                </div>

                <!--Content-->
                <div class="p-4 flex-1 flex flex-col">


                    <!--Seller-->
                    <a href="seller-profile.php?id=1" class="relative z-20 text-xs text-blue-600 hover:text-blue-700
                      font-medium mb-1.5 line-clamp-1 w-fit">Sahan Perera</a>

                    <!--Title-->
                    <h3 class="font-bold text-gray-900 text-sm leading-sung line-clamp-2 mb-2 group-hover:text-blue-600
                       transition-colors">UI/UX Design Mastery</h3>

                    <!--Status Row-->
                    <div class="flex items-center justify-between text-xs mb-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-semibold text-gray-900">5</span>
                            <span class="text-gray-400">(100)</span>
                        </div>
                    </div>

                    <!--Price & Arrow -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="font-bold text-base text-blue-600">Rs.69999.99</span>
                        <div class="px-2.5 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg
                          group-hover:bg-blue-600 group-hover:text-white transition-colors">></div>

                    </div>
                </div>

            </div>

            <!--Product card 4-->
            <div class="relative bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300
               overflow-hidden flex flex-col border border-gray-100 group">

                <a href="product-view.php?id=1" class="absolute inset-0 z-10"></a>

                <!--Image-->
                <div class="relative w-full h-48 bg-gray-100 overflow-hidden flex-shrink-0">
                    <img src="./assets/images/cover2.jpg"
                        class="w-full h-full object-cover group-hover:scale-105 transform duration-300" />
                    <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold
                      rounded-full">Beginner</span>
                </div>

                <!--Content-->
                <div class="p-4 flex-1 flex flex-col">


                    <!--Seller-->
                    <a href="seller-profile.php?id=1" class="relative z-20 text-xs text-blue-600 hover:text-blue-700
                      font-medium mb-1.5 line-clamp-1 w-fit">Sahan Perera</a>

                    <!--Title-->
                    <h3 class="font-bold text-gray-900 text-sm leading-sung line-clamp-2 mb-2 group-hover:text-blue-600
                       transition-colors">UI/UX Design Mastery</h3>

                    <!--Status Row-->
                    <div class="flex items-center justify-between text-xs mb-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-semibold text-gray-900">5</span>
                            <span class="text-gray-400">(100)</span>
                        </div>
                    </div>

                    <!--Price & Arrow -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="font-bold text-base text-blue-600">Rs.69999.99</span>
                        <div class="px-2.5 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg
                          group-hover:bg-blue-600 group-hover:text-white transition-colors">></div>

                    </div>
                </div>

            </div>

            <!--Product card 5-->
            <div class="relative bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300
               overflow-hidden flex flex-col border border-gray-100 group">

                <a href="product-view.php?id=1" class="absolute inset-0 z-10"></a>

                <!--Image-->
                <div class="relative w-full h-48 bg-gray-100 overflow-hidden flex-shrink-0">
                    <img src="./assets/images/cover3.jpg"
                        class="w-full h-full object-cover group-hover:scale-105 transform duration-300" />
                    <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold
                      rounded-full">Beginner</span>
                </div>

                <!--Content-->
                <div class="p-4 flex-1 flex flex-col">


                    <!--Seller-->
                    <a href="seller-profile.php?id=1" class="relative z-20 text-xs text-blue-600 hover:text-blue-700
                      font-medium mb-1.5 line-clamp-1 w-fit">Sahan Perera</a>

                    <!--Title-->
                    <h3 class="font-bold text-gray-900 text-sm leading-sung line-clamp-2 mb-2 group-hover:text-blue-600
                       transition-colors">UI/UX Design Mastery</h3>

                    <!--Status Row-->
                    <div class="flex items-center justify-between text-xs mb-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-semibold text-gray-900">5</span>
                            <span class="text-gray-400">(100)</span>
                        </div>
                    </div>

                    <!--Price & Arrow -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="font-bold text-base text-blue-600">Rs.69999.99</span>
                        <div class="px-2.5 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg
                          group-hover:bg-blue-600 group-hover:text-white transition-colors">></div>

                    </div>
                </div>

            </div>

            <!--Product card 6-->
            <div class="relative bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300
               overflow-hidden flex flex-col border border-gray-100 group">

                <a href="product-view.php?id=1" class="absolute inset-0 z-10"></a>

                <!--Image-->
                <div class="relative w-full h-48 bg-gray-100 overflow-hidden flex-shrink-0">
                    <img src="./assets/images/cover1.jpg"
                        class="w-full h-full object-cover group-hover:scale-105 transform duration-300" />
                    <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold
                      rounded-full">Beginner</span>
                </div>

                <!--Content-->
                <div class="p-4 flex-1 flex flex-col">


                    <!--Seller-->
                    <a href="seller-profile.php?id=1" class="relative z-20 text-xs text-blue-600 hover:text-blue-700
                      font-medium mb-1.5 line-clamp-1 w-fit">Sahan Perera</a>

                    <!--Title-->
                    <h3 class="font-bold text-gray-900 text-sm leading-sung line-clamp-2 mb-2 group-hover:text-blue-600
                       transition-colors">UI/UX Design Mastery</h3>

                    <!--Status Row-->
                    <div class="flex items-center justify-between text-xs mb-3 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-400">⭐</span>
                            <span class="font-semibold text-gray-900">5</span>
                            <span class="text-gray-400">(100)</span>
                        </div>
                    </div>

                    <!--Price & Arrow -->
                    <div class="flex items-center justify-between mt-auto">
                        <span class="font-bold text-base text-blue-600">Rs.69999.99</span>
                        <div class="px-2.5 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg
                          group-hover:bg-blue-600 group-hover:text-white transition-colors">></div>

                    </div>
                </div>

            </div>

        </div>

        <!--Pagination-->
        <nav class="flex justify-center items-center gap-1 mt-12 mb-8">

            <a href="?q=test&page=1" class="p-2 text-gray-600 hover:bg-blue-50 rounded-lg transition-colors" title="First"><<</a>
            <a href="?q=test&page=2" class="p-2 text-gray-600 hover:bg-blue-50 rounded-lg transition-colors" title="previous"><< </a>

            <a href="?q=test&page=3" class="p-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">1</a>

            <a href="?q=test&page=4" class="p-2 text-sm font-medium bg-blue-600 text-white hover:text-gray-700 hover:bg-blue-50
                rounded-lg transition-colors">2</a>

            <a href="?q=test&page=3" class="p-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">3</a>

            <a href="?q=test&page=1" class="p-2 text-gray-600 hover:bg-blue-50 rounded-lg transition-colors" title="First">>></a>
            <a href="?q=test&page=2" class="p-2 text-gray-600 hover:bg-blue-50 rounded-lg transition-colors" title="previous">></a>



        </nav>
    </section>

    <!--feature section-->
    <section class="bg-white border-t border-gary-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Why Chooses Skillshop</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="group text-center p-6 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4
                        group-hover:bg-blue-200 transition-colors">
                       <span class="text-blue-600 text-2xl font-bold">📚</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Learn at Your Pace</h3>
                    <p class="text-sm text-gray-600">Access courses anytime, anywhere on any device</p>
                </div>

                <div class="group text-center p-6 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4
                        group-hover:bg-green-200 transition-colors">
                        <span class="text-green-600 text-2xl font-bold">🎓</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Expert Instructors</h3>
                    <p class="text-sm text-gray-600">Learn from experienced professionals in their fields</p>
                </div>

                <div class="group text-center p-6 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="bg-purple-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4
                        group-hover:bg-purple-200 transition-colors">
                       <span class="text-purple-600 text-2xl font-bold">$</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Affortable Pricing</h3>
                    <p class="text-sm text-gray-600">Quality education that fits your budget</p>
                </div>


            </div>

        </div>
    </section>

</div>
<?php require "footer.php";

<?php
// ensure a session is active before reading any session variables
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$loggedIn = isset($_SESSION["logged_in"]) ? $_SESSION["logged_in"] : false;
$userName = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "";
$userRole = isset($_SESSION["active_account_type"]) ? $_SESSION["active_account_type"] : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillShop - Buy and Sell skills</title>
    <link rel="icon" type="images/phg" href="./assets/images/competence.png">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3 flex justify-between items-center gap-6">


            <!-- Logo -->
            <a href="home.php" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent
         hover:opacity-80 transition-opacity flex-shrink-0">SkillShop</a>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-lg">
                <div class="relative w-full">
                    <input type="text" placeholder="Search, skills, instructors..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200
                rounded-lg focus:outline-none focus:ring-2 focus:ring:blue-500 focus:border-transparent text-sm text-gray-900 
                placeholder-gray-500 transition-all" />

                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors">
                        🔎
                    </button>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex gap-1 sm:gap-2 items-center">
                <?php if ($loggedIn): ?>

                    <!-- Notification -->

                    <div class="relative group hidden sm:block">
                        <button class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                            🔔

                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        </button>

                        <div class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0
                        invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">

                            <div class="p-4 border-b border-gray-100">
                                <p class="font-semibold text-sm text-gray-900">Notifications</p>
                            </div>

                            <div class="max-h-80 overflow-y-auto ">
                                <div class="p-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition-colors">
                                    <p class="text-xs font-medium text-gray-900">💬 New Message from Sahan</p>
                                    <p class="text-xs text-gray-500 mt-1">Just Now</p>
                                </div>

                                <div class="p-3 hover:bg-gray-50 cursor-pointer transition-colors">
                                    <p class="text-xs font-medium text-gray-900">✅ Order Completed</p>
                                    <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Messages -->
                    <a href="<?php echo $userRole == "buyer" ?
                                    "buyer-dashboard.php?tab-messages" :
                                    "seller-dashboard.php?tab-messages"; ?>"
                        class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200 hidden sm:block">
                        💬<span class="absolute top-1 right-1 w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    </a>

                    <!-- Cart/Watchlist for buyers -->
                    <?php if ($userRole == "buyer"): ?>
                        <a href="buyer-dashboard.php?tab=cart" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50
                            rounded-lg transition-colors duration-200 hidden sm:block">
                            🛒
                            <span class="absolute top-1 right-1 text-xs bg-blue-600 text-white w-5 h-5 rounded-full 
                            flex items-center justify-center font-bold text-xs">2</span>
                        </a>
                        <a href="buyer-dashboard.php?tab=learning" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50
                            rounded-lg transition-colors duration-200 hidden sm:block">
                            ♥️
                        </a>
                    <?php endif; ?>

                    <!-- Profile Dropdown -->
                    <div class="relative ml-2 sm:ml-4 pl-2 sm:pl-4 border-1 border-gray-200">
                        <button class="flex items-center gap-2 hover:bg-gray-50 px-2 py-1 rounded-lg transition-colors duration-200" id="profileBtn">
                            <img src="assets/images/avatar.png" class="w-8 h-8 rounded-full ring-2 ring-transparent hover:ring-blue-300 transition-all" />
                            <div class="hidden sm:block">
                                <p class="text-sm font-semibold text-gray-900"><?php echo $userName; ?></p>
                                <p class="text-xs text-gray-500 leading-none"><?php echo $userRole; ?></p>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-lg border border-gray-100
                         opacity-0 invisible transition-all duration-200" style="display: none;">
                            <div class="p-4 border-b border-gray-100">
                                <p class="font-semibold text-sm text-gray-900"><?php echo $userName; ?></p>
                                <p class="text-xs text-gray-500 mt-1"><?php echo $userRole; ?></p>
                            </div>

                            <div class="py-2">
                                <a href="<?php echo $userRole == "buyer" ? "buyer-dashboard.php" : "seller-dashboard.php"; ?>"
                                    class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 
                                transition-colors duration-150">📊 Dashboard</a>
                                <a href="user-Profile.php"
                                    class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 
                                transition-colors duration-150">👤 My Profile</a>
                                <a href="process/logoutProcess.php"
                                    class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 
                                transition-colors duration-150">🚪Sign Out</a>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <a href="index.php" class="text-blue-600 px-4 py-2 rounded-lg
                    hover:bg-blue-50 font-medium text-sm transition-colors">Sign In</a>
                    <a href="index.php" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg
                    hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 font-medium transition-all text-sm">Join</a>

                <?php endif; ?>
            </div>

        </div>

    </nav>

    <script>
        // Profile dropdown toggle
        var profileBtn = document.getElementById("profileBtn");
        var profiledropdown = document.getElementById("profileDropdown");

        if (profileBtn && profiledropdown) {
            profileBtn.addEventListener("click", function(e) {
                var isHidden = profiledropdown.style.display == "none";
                profiledropdown.style.display = isHidden ? "block" : "none";
                profiledropdown.classList.toggle("opacity-0");
                profiledropdown.classList.toggle("invisible");
            });

            // Close the dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target) && !profiledropdown.contains(e.target)) {
                    profiledropdown.style.display = 'none';
                    profiledropdown.classList.add('opacity-0');
                    profiledropdown.classList.add('invisible');

                }

            });

            // Close the dropdown when clicking links inside it
            profiledropdown.querySelectorAll("a").forEach(link => {
                link.addEventListener('click', function(e) {
                    profiledropdown.style.display = 'none';
                    profiledropdown.classList.add('opacity-0');
                    profiledropdown.classList.add('invisible');

                });
            });
        }
    </script>

</body>

</html>
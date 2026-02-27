<?php
include "header.php";

if (strtolower($userRole) != "seller") {
    header("Location: home.php");
    exit;
}

require_once "Controlers/sellerController.php";
$controller = new SellerController($userID);
$dashboardData = $controller->getDashboardStats();

$sellerProducts = $dashboardData["products"];
$sellerOrders = $dashboardData["orders"];
$totalEarnings = $dashboardData["totalEarnings"];
$totalBuyers = $dashboardData["totalBuyers"];
$activeProducts = $dashboardData["activeProducts"];
$avgRating = $dashboardData["avgRating"];

$tab = isset($_GET["tab"]) ? $_GET["tab"] : "dashboard";

?>

<div class="min-h-screen bg-gray-50">


    <!-- Tab Navigation -->
    <div class="bg-white border-b sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-8">

            <a href="?tab-dashboard" class="py-4 font-medium border-b-2
            <?php echo $tab == "dashboard" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Dashboard</a>

            <a href="?tab-dashboard" class="py-4 font-medium border-b-2
            <?php echo $tab == "storefront" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Public Store</a>

            <a href="?tab-dashboard" class="py-4 font-medium border-b-2
            <?php echo $tab == "messages" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Messages</a>

        </div>
    </div>

    <!-- Dashbboard tab -->
    <?php if ($tab == "dashboard"): ?>
        <section class="bg-white shadow-sm p-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
                    <p class="text-gray-600">Manage your skills and earnings</p>
                </div>
                <a href="productRegister.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:shadow-lg">+ New Skill</a>
            </div>
        </section>

        <!-- stats -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <p class="text-gray-600 text-sm">Total Earnings</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">Rs. <?php echo number_format($totalEarnings, 2); ?></p>
                    <p class="text-xs text-gray-500 mt-1"><?php echo $totalBuyers; ?> Orders Recieved</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <p class="text-gray-600 text-sm">Total Buyers</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $totalBuyers; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Active Buyers</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <p class="text-gray-600 text-sm">Total Skills</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2"><?php echo $activeProducts; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Available for sale</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <p class="text-gray-600 text-sm">Average Ratings</p>
                    <p class="text-3xl font-bold text-yellow-500 mt-2"><?php echo round($avgRating, 1); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Customer Reviews</p>
                </div>
            </div>
        </section>

        <!-- Your Skills and recent orders -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid md:grid-cols-3 gap-6">

                <!-- Skill List -->
                <div class="md:col-span-2">
                    <h3 class="text-xm font-bold text-gray-900 mb-4">Your Skills</h3>
                    <div class="space-y-3">
                        <?php foreach ($sellerProducts as $product) : ?>
                            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-gray-900"><?php echo $product["title"]; ?></p>
                                    <p class="text-xs text-gray-500">50 customers | <?php echo $product["ratings"]; ?> ⭐</p>
                                </div>

                                <div class="flex gap-2">
                                    <a href="product-edit.php?id=<?php echo $product["id"]; ?>" class="px-3 py-1
                                text-blue-600 text-sm hover:bg-blue-50 rounded">Edit</a>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded font-medium">
                                        <?php echo $product["status"]; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>
    <?php endif; ?>

</div>

<?php include "footer.php"; ?>
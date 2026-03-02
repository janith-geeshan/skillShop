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

//pagaination and sorting
$itemsPerPage = 6;
$currentPage = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
$sortBy =  isset($_GET["sort"]) ? $_GET["sort"] : "newest";

//validation
$allowedsorts = ["newest", "price_low", "price_high", "rating", "customers"];
if (!in_array($sortBy, $allowedsorts)) $sortBy = "newest";

//Build sort query
$sortQuery = match ($sortBy) {
    "price_low" => "ORDER BY p.`price` ASC",
    "price_high" => "ORDER BY p.`price` DESC",
    "rating" => "ORDER BY AVG(COALESCE(f.`rating`,0)) DESC",
    "customers" => "ORDER BY COUNT(o.`id`) DESC",
    default => "ORDER BY p.`created_at` DESC"
};

// get total product count
$countResult = Database::search(
    "SELECT COUNT(p.`id`) AS `total` FROM `product` p WHERE p.`seller_id` =?",
    "i",
    [$userID]
);
$totalProducts = ($countResult && $row = $countResult->fetch_assoc()) ? $row["total"] : 0;
$totalPages = ceil($totalProducts / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;

// fetch product with sorting
$productsQuery = "
   SELECT p.`id`, p.`title`, p.`description`, p.`image_url`,p.`price`, p.`level`, p.`status`, p.`created_at`,
   COUNT(DISTINCT o.`id`) AS `customer_count`,
   AVG(COALESCE(f.`rating`,0)) AS `avg_rating`
   FROM `product` p
   LEFT JOIN `order` o ON p.`id` =o.`product_id`
   LEFT JOIN `feedback` f ON p.`id` =f.`product_id`
   WHERE p.`seller_id` =?
   GROUP BY p.`id` 
   {$sortQuery} 
   LIMIT ? OFFSET ?
";

$productResult = Database::search($productsQuery, "iii", [$userID, $itemsPerPage, $offset]);
$storeFontProducts = [];
if ($productResult && $productResult->num_rows > 0) {
    while ($product = $productResult->fetch_assoc()) {
        $storeFontProducts[] = $product;
    }
}

?>

<div class="min-h-screen bg-gray-50">


    <!-- Tab Navigation -->
    <div class="bg-white border-b sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-8">

            <a href="?tab=dashboard" class="py-4 font-medium border-b-2
            <?php echo $tab == "dashboard" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Dashboard</a>

            <a href="?tab=storefront" class="py-4 font-medium border-b-2
            <?php echo $tab == "storefront" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Public Store</a>

            <a href="?tab=messages" class="py-4 font-medium border-b-2
            <?php echo $tab == "messages" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Messages</a>

        </div>
    </div>

    <!-- Dashboard tab -->
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
                                    <?php if ($product["status"] == "active") {
                                    ?>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded font-medium">
                                            <?php echo $product["status"]; ?>
                                        </span>
                                    <?php
                                    } else {
                                    ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded font-medium">
                                            <?php echo $product["status"]; ?>
                                        </span>
                                    <?php
                                    } ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>

        <!--public Store tab-->
    <?php elseif ($tab == "storefront"): ?>

        <section class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Your Storefront</h2>
                        <P class="text-gray-600">Manage and customize how your skills apper to customers</P>
                    </div>
                    <a href="productRegister.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:shadow-lg">
                        + Add Skill</a>
                </div>
            </div>
        </section>

        <!-- sorting and filtering-->
        <section class="bg-white border-b sticky top-32 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex gap-2 items-center">
                        <label for="sortSelect" class="text-sm font-medium text-gray-700">Short By :</label>
                        <select onchange="updateSort(this.value);" id="sortSelect"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm
                        focus:outline:none focus:ring-2 focus:ring-blue-600 bg-white">
                            <option value="newest" <?php echo $sortBy == "newest" ? "selected" : ""; ?>>
                                Newest First</option>
                            <option value="price_low" <?php echo $sortBy == "price_low" ? "selected" : ""; ?>>
                                Price Loe to High</option>
                            <option value="price_high" <?php echo $sortBy == "price_high" ? "selected" : ""; ?>>
                                Price High to Low</option>
                            <option value="rating" <?php echo $sortBy == "rating" ? "selected" : ""; ?>>
                                Hightest Rating</option>
                            <option value="customers" <?php echo $sortBy == "customers" ? "selected" : ""; ?>>
                                Most Customers</option>
                        </select>
                    </div>
                    <div class="text-sm text-gray-600">
                        Showing <span class="font-bold"><?php echo COUNT($storeFontProducts); ?></span>
                        of <span class="font-bold"><?php echo $totalProducts; ?></span> Skills
                    </div>
                </div>
            </div>
        </section>

        <!-- Storefront view-->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <?php if (count($storeFontProducts) > 0): ?> <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

                    <?php foreach ($storeFontProducts as $product): ?>
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden group">

                            <!-- product image-->
                            <div class="relative h-48 bg-gray-200 overflow-hidden">
                                <?php if (!empty($product["image_url"])): ?>
                                    <img src="<?php echo $product["image_url"]; ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500">
                                        No Image
                                    </div>
                                <?php endif; ?>

                                <!--status badge-->
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 <?php echo $product["status"] == "active" ? "bg-green-100 text-green-800" :
                                                                "bg-red-100 text-red-800"; ?> text-xs font-bold rounded-full">
                                        <?php echo ucfirst($product["status"]); ?> </span>
                                </div>

                                <!--level badge-->
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                        <?php echo $product["level"]; ?>
                                    </span>
                                </div>
                            </div>

                            <!-- product info-->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 text-lg line-clamp-2"><?php echo $product["title"]; ?></h3>
                                <p class="text-gray-600 text-sm mt-1 line-clamp-2">
                                    <?php echo substr($product["description"], 0, 80); ?>...
                                </p>

                                <!--rating and customer-->
                                <div class="flex justify-between items-center mt-3 text-sm text-gray-600">
                                    <span><?php echo intval($product["customer_count"]); ?> Customers </span>
                                    <span class="text-yellow-500 font-medium">
                                        ⭐ <?php echo ($product["avg_rating"] > 0) ? round($product["avg_rating"], 1) : "N/A"; ?>
                                    </span>
                                </div>

                                <!--price-->
                                <div class="text-2xl font-bold text-blue-600 mt-3">
                                    Rs. <?php echo number_format($product["price"], 2); ?>
                                </div>

                                <!--actions-->
                                <div class="flex gap-2 mt-4">

                                    <a href="product-edit.php?id=<?php echo $product["id"]; ?>" class="flex-1 px-3 py-2 bg-blue-600 
                                    text-white text-sm font-medium rounded-lg hover:bg-blue-700 text-center">Edit</a>

                                    <button class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 toggle-btn 
                                <?php echo $product["status"] == "active" ? "bg-red-100 text-red-800 border-red-200" :
                                    "bg-green-100 text-green-800 border-green-200"; ?>"
                                        onclick="toggleProductStatus(<?php echo $product['id']; ?>);">
                                        <?php echo $product["status"] == "active" ? "Deactivate" : "Activate"; ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- pagination-->
                <?php if ($totalPages > 1): ?>

                    <div class="flex justify-center items-center gap-2 mt-8">

                        <?php if ($currentPage > 1): ?>
                            <a href="?tab=storefront&sort=<?php echo $sortBy; ?>&page=1"
                                class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">First</a>

                            <a href="?tab=storefront&sort=<?php echo $sortBy; ?>&page=<?php echo $currentPage - 1; ?>"
                                class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                < Previous</a>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $currentPage - 2);
                                $end = min($totalPages, $currentPage + 2);

                                for ($i = $start; $i <= $end; $i++):
                                ?>
                                    <a href="?tab=storefront&sort=<?php echo $sortBy; ?>&page=<?php echo $i; ?>"
                                        class="px-3 py-2 border 
                                        <?php echo $i == $currentPage ? "bg-blue-600 text-white border-blue-600" :
                                            "border-gray-300 rounded-lg hover:bg-gray-50"; ?> rounded-lg">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages): ?>

                                    <a href="?tab=storefront&sort=<?php echo $sortBy; ?>&page=<?php echo $currentPage + 1; ?>"
                                        class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Next ></a>

                                    <a href="?tab=storefront&sort=<?php echo $sortBy; ?>&page=<?php echo $totalPages; ?>"
                                        class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Last</a>

                                <?php endif; ?>
                    </div>
                <?php endif; ?>


            <?php else: ?>

                <div class="text-center py-16">
                    <div class="text-gray-400 text-6xl mb-4">📦</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Skills Yet</h3>
                    <p class="text-gray-600 mb-6">Start by creating your first skill to build your storefront.</p>
                    <a href="productRegister.php" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg
                   font-bold hover:bg-blue-700">
                        Create Your First Skill
                    </a>
                </div>

            <?php endif; ?>

        </section>

    <?php endif; ?>

</div>

<script>
    function updateSort(sortValue) {
        const sortBy = sortValue;
        window.location.href = `?tab=storefront&sort=${sortBy}&page=1`;
    }

    // function toggleProductStatus(productId) {
    //     const button = document.getElementById.querySelector(`[data-product-id="${productId}"]`);
    //     const originalText = button.textContent;
    //     button.disabled = true;
    //     button.textContent = "Processing....";

    //     const fortData = new FormData();
    //     FormData.append("productId", productId);

    //     fetch("process/processStatusProcess.php", {
    //             method: "POST",
    //             body: FormData
    //         })
    //         .then(Response => Response.json())
    //         .then(data => {
    //             if (data.success) {

    //                 const newStatus = data.newStatus;

    //                 //change button color and text
    //                 if (newStatus == "inactive") {
    //                     button.classList.remove("bg-red-100", "text-red-800", "border-red-300");
    //                     button.classList.add("bg-green-100", "text-green-800", "border-green-300");
    //                     button.textContent = "Activate";
    //                 } else {
    //                     button.classList.remove("bg-green-100", "text-green-800", "border-green-300");
    //                     button.classList.add("bg-red-100", "text-red-800", "border-red-300");
    //                     button.textContent = "Deactivate";
    //                 }

    //                 // change status badge
    //                 const statusBadge = button.closet(".bg-white").querySelector("span.px-3.py-1");
    //                 if (statusBadge) {
    //                     statusBadge.classList.remove("bg-green-100", "text-green-800", "bg-red-100", "text-red-800");
    //                     if (newStatus == "active") {
    //                         statusBadge.classList.add("bg-red-100", "text-red-800");
    //                         statusBadge.textContent = "Active";
    //                     } else {
    //                         statusBadge.classList.add("bg-red-100", "text-red-800");
    //                         statusBadge.textContent = "Inactive";
    //                     }
    //                 }

    //                 //show success message
    //                 const message = document.createElement("div");
    //                 message.className = "fixed top-24 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50";
    //                 message.textContent = `product ${newStatus == "active" ? "activated" : "deactivated"} successfully! `;
    //                 document.body.appendChild(message);
    //                 setTimeout(() => message.remove(), 3000);

    //             } else {
    //                 alert("Error:" + data.message);
    //                 button.textContent = originalText;
    //             }

    //             button.disabled = false;
    //         })
    //         .catch(error => {
    //             console.error("Error :", error);
    //             alert("An Error occurred while updating the product status");
    //             button.textContent = originalText;
    //             button.disabled = false;
    //         });
    // }

    function toggleProductStatus(productId) {
        const button = event.target; // Get the button that was clicked
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = "Processing....";

        const formData = new FormData();
        formData.append("productId", productId);

        fetch("process/productStatusProcess.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    const newStatus = data.newStatus;

                    //change button color and text
                    if (newStatus == "inactive") {
                        button.classList.remove("bg-red-100", "text-red-800", "border-red-200");
                        button.classList.add("bg-green-100", "text-green-800", "border-green-200");
                        button.textContent = "Activate";
                    } else {
                        button.classList.remove("bg-green-100", "text-green-800", "border-green-200");
                        button.classList.add("bg-red-100", "text-red-800", "border-red-200");
                        button.textContent = "Deactivate";
                    }

                    // change status badge
                    const cardContainer = button.closest(".bg-white.rounded-lg");
                    if (cardContainer) {
                        const statusBadge = cardContainer.querySelector(".absolute.top-3.right-3 span");
                        if (statusBadge) {
                            statusBadge.className = `px-3 py-1 ${newStatus == "active" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800"} text-xs font-bold rounded-full`;
                            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        }
                    }

                    //show success message
                    const message = document.createElement("div");
                    message.className = "fixed top-24 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50";
                    message.textContent = `Product ${newStatus == "active" ? "activated" : "deactivated"} successfully!`;
                    document.body.appendChild(message);
                    setTimeout(() => message.remove(), 3000);

                } else {
                    alert("Error: " + data.message);
                    button.textContent = originalText;
                }

                button.disabled = false;
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while updating the product status");
                button.textContent = originalText;
                button.disabled = false;
            });
    }
</script>

<?php include "footer.php"; ?>
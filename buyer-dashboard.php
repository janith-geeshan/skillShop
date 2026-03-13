<?php include "header.php";

if (strtolower($userRole) != "buyer") {
}

$tab = isset($_GET["tab"]) ? $_GET["tab"] : "dashboard";

// cart data
$cartItems = [];
$subTotal = 0;
$totalDeliveryFee = 0;

if ($tab == "cart") {

    // delivery fee calculation (buyer city_id)
    $buyerCityQ = Database::search(
        "SELECT a.`city_id` FROM `user_profile` up JOIN `address` a
            ON up.`address_id` = a.`id` WHERE up.`user_id`=?",
        "i",
        [$userID]
    );

    $buyerCityId = ($buyerCityQ && $buyerCityQ->num_rows > 0) ? $buyerCityQ->fetch_assoc()["city_id"] : 0;

    // Fetch cart items
    $cartItemsQ = Database::search(
        "SELECT c.`id` AS `cart_item_id`, p.*, u.`fname` AS `seller_fname`, u.`lname` AS `seller_lname`,
                sa.`city_id` AS `seller_city_id`, sa.`id` AS `seller_id`
            FROM `cart` c
            JOIN `product` p ON c.`product_id`=p.`id`
            JOIN `user` u ON p.`seller_id`=u.`id`
            LEFT JOIN `user_profile` up ON u.`id`=up.`user_id`
            LEFT JOIN `address` sa ON up.`address_id`=sa.`id`
            WHERE c.`user_id`=?
            ORDER BY c.`created_at` DESC",
        "i",
        [$userID]
    );

    $sellersInCart = [];

    while ($item = $cartItemsQ?->fetch_assoc()) {
        $cartItems[] = $item;
        $subTotal += floatval($item["price"]);

        $sellerId = $item["seller_id"];

        if (!isset($sellersInCart[$sellerId])) {
            $deliveryFee = ($item["seller_city_id"] == $buyerCityId && $buyerCityId != 0) ? 200 : 500;
            $totalDeliveryFee += $deliveryFee;
            $sellersInCart[$sellerId] = $deliveryFee;
        }
    }

    $total = $subTotal + $totalDeliveryFee;
}

?>

<div class="min-h-screen bg-gray-50">

    <!-- Tab Navigation -->
    <div class="bg-white border-b sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex gap-8">

            <a href="?tab=dashboard" class="py-4 font-medium border-b-2
            <?php echo $tab == "dashboard" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Dashboard</a>

            <a href="?tab=cart" class="py-4 font-medium border-b-2
            <?php echo $tab == "cart" ? "border-blue-600 text-blue-600" : "border-transparent text-gray-600
            hover:text-gray-900"; ?>">Cart</a>
        </div>
    </div>

    <!-- Dashboard tab -->
    <?php if ($tab == "dashboard"): ?>
        <section class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h2 class="text-3xl font-bold text-gray-900">Buyer Dashboard</h2>
                <p class="text-gray-600">Manage your learning journey.</p>
            </div>
        </section>
    <?php elseif ($tab == "cart"): ?>
        <section class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h2 class="text-3xl font-bold text-gray-900">Shopping Cart</h2>
                <p class="text-gray-600">Review your items before checkout.</p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 ">
            <?php if (empty($cartItems)): ?>
                <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center shadow-sm">
                    <div class="text-6xl mb-6">🛒</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Your Cart is Empty.</h2>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto">Explore our wide range of skils & Start your learning journey today</p>
                    <a href="search-products.php" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-transform shadow-lg active:scale-95">Browse Skills</a>
                </div>
            <?php else: ?>
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="flex-1 space-y-4">

                        <?php foreach ($cartItems as $item):
                            $sellerName = $item["seller_fname"] . " " . $item["seller_lname"];
                        ?>
                            <!-- Cart item -->
                            <a href="product-view.php?id=<?= $item["id"]; ?>" id="cart-item-<?= $item["cart_item_id"] ?>" class="bg-white rounded-2xl border border-slate-100 p-4 flex gap-4 shadow-sm hover:shadow-md transition-shadow group">
                                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100">
                                    <?php if ($item["image_url"]): ?>
                                        <img src="<?= $item["image_url"] ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-3xl">📚</div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors line-clamp-1"><?= $item["title"] ?></h3>
                                            <p class="text-sm text-slate-500 mt-0.5"><?= $sellerName ?></p>
                                        </div>
                                        <button onclick="removeItem(<?= $item['cart_item_id'] ?>, event);" class="text-slate-300 hover:text-rose-500 p-1 transition-colors" title="Remove">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex items-center gap-3 mt-4">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-yellow-300 text-slate-600"><?= $item["level"] ?></span>
                                        <span class="text-lg font-extrabold text-blue-600 ml-auto">Rs.<?= number_format($item["price"], 2) ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>

                    </div>

                    <!-- Summery Column -->

                    <aside class="lg:w-96 flex-shrink-0">
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xl sticky top-24">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summery</h2>

                            <div class="space-y-4 pb-6 border-b border-slate-100">
                                <div class="flex justify-between text-slate-600">
                                    <span>Sub Total</span>
                                    <span class="font-bold text-gray-900">Rs.
                                        <span id="subtotal"><?= number_format($subTotal, 2) ?></span>
                                    </span>
                                </div>
                                <div class="flex justify-between text-slate-600">
                                    <div class="flex items-center gap-1.5">
                                        <span>Course Documents Delivery Fee</span>
                                        <div class="group relative">
                                            <span class="text-xs cursor-help bg-slate-100 w-4 h-4 rounded-full flex items-center justify-center font-bold ">?</span>
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-slate-900 text-white text-[10px] rounded shadow-xl opacity-0 invisible group-hover:visible transition-all group-hover:opacity-100">
                                                Rs. 200 within same city || Rs.500 within cities. Charges may change per seller.
                                            </div>
                                        </div>
                                    </div>

                                    <span class="font-bold text-gray-900">Rs. <span id="delivery"><?= number_format($deliveryFee, 2) ?></span></span>
                                </div>
                            </div>

                            <div class="pt-6">
                                <div class="flex justify-between items-center mb-8">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-black text-blue-600 font-mono">Rs. <span id="total"><?= number_format($total, 2) ?></span></span>
                                </div>

                                <button class="block w-full py-4 text-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all active:scale-95 mb-2">Proceed to Checkout</button>
                                <p class="text-center text-xs text-slate-400">Secure Checkout powered by Payhere.</p>
                            </div>

                        </div>
                    </aside>

                </div>
            <?php endif; ?>
        </section>

        <!-- Toast for notification -->
        <div id="toast" class="fixed top-5 right-5 z-50 transform translate-y-[-100px] transition-transform duration-300 pointer-events-none">
            <div class="bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 font-semibold">
                <span id="toast-icon">✔</span>
                <span id="toast-msg">Removed from cart</span>
            </div>
        </div>

        <!-- Cart JS -->
        <?php if (!empty($cartItems)): ?>
            <script>
                let tid;

                function showToast(msg, icon = "✔") {
                    clearTimeout(tid);
                    const toast = document.getElementById("toast");
                    document.getElementById("toast-msg").innerText = msg;
                    document.getElementById("toast-icon").innerText = icon;
                    toast.style.transform = "translateY(0)";
                    tid = setTimeout(() => {
                        toast.style.transform = "translateY(-100px)";
                    }, 3000);
                }

                async function removeItem(cartItemId, e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!confirm("Remove this item from your cart ?")) return;

                    const itemEl = document.getElementById(`cart-item-${cartItemId}`);
                    itemEl.style.opacity = '0.5';
                    itemEl.style.pointerEvents = 'none';

                    const formData = new FormData();
                    formData.append('cart_item_id', cartItemId);

                    try {
                        const res = await fetch("process/removeFromCart.php", {
                            method: "POST",
                            body: formData
                        });

                        const data = await res.json();

                        if (data.success) {

                            itemEl.remove();
                            document.getElementById('subtotal').innerText = parseFloat(data.subtotal).toLocaleString(undefined, {
                                minimumFractionDigits: 2
                            });
                            document.getElementById('delivery').innerText = parseFloat(data.delivery).toLocaleString(undefined, {
                                minimumFractionDigits: 2
                            });
                            document.getElementById('total').innerText = parseFloat(data.total).toLocaleString(undefined, {
                                minimumFractionDigits: 2
                            });

                            const cc = document.getElementById("cart-count");
                            if (cc) {
                                cc.textContent = data.itemCount;
                            }

                            showToast('Item removed successfully');

                            // If empty, page reload
                            if (parseFloat(data.itemCount) == 0) window.location.reload();

                        } else {
                            itemEl.style.opacity = '1';
                            itemEl.style.pointerEvents = 'auto';
                            alert(data.message || 'Error Removal! Please try again');
                        }

                    } catch (e) {
                        itemEl.style.opacity = '1';
                        itemEl.style.pointerEvents = 'auto';
                        alert("Something went wrong! Try again..!");
                    }
                }
            </script>
        <?php endif; ?>

    <?php endif; ?>
</div>

<?php include "footer.php"; ?>
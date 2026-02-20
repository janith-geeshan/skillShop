<?php include "header.php"; ?>

<div class="min-h-screen bg-gray-50">

    <?php $tab = isset($GET["tab"]) ? $_GET["tab"] : "dashboard"; ?>

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

</div>

<?php include "footer.php"; ?>
<?php include "header.php"; ?>
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-16 md:py-24">
    <div class="max-w-7x1 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Learn & Earn Skill Today</h1>
                <p class="text-blue-100 text-lg mb-6">
                    Connect with experet skill sellers and buyers in our thriving community.
                </p>
            </div>

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
</section>
<?php include "footer.php"; ?>
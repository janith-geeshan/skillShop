<?php require "header.php"; ?>

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-7">

        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-600 mt-2">Update your profile information</p>
        </div>

        <form id="profileHome" class="space-y-8">

            <!-- Avatar section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Profile Picture</h2>

                <div class="flex items-center space-x-6">
                    <img src="assets/images/avatar.png" class="w-24 h-24 rounded-full object-cover border-gray-200">
                    <div>
                        <label for="avatarFile" class="block mb-2">
                            <span class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-colors 
                            inline block">
                                Choose Photo
                                <input type="file" id="avatarFile" name="avatarFile" accept="image/*" class="hidden" />
                            </span>
                        </label>
                        <p class="text-sm text-red-500 mt-4">Recommended: .jpg/.png (under 5mb)</p>
                        <input type="hidden" id="avatarURL" name="avatarURL" value="" />
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Basic Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- First Name -->
                    <div>
                        <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                        <input type="text" name="fname" id="fname" value="" placeholder="Lionel" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent
                        outline-none transition" />
                        <span class="error text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="lname" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                        <input type="text" name="lname" id="lname" value="" placeholder="Messi" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent
                        outline-none transition" />
                        <span class="error text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="" placeholder="someone@gmail.com" disabled
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent
                        outline-none transition" />
                        <span class="error text-red-500 text-sm hidden"></span>
                    </div>

                </div>
            </div>

            <!-- Profile Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Profile Information</h2>
                <div class="space-y-6">

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                        <textarea name="bio" id="bio" rows="4" placeholder="Tell more about yourself..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 
                            focus:border-transparent outline-none transition"></textarea>
                        <p class="text-sm text-red-500 mt-1">Max 500 characters</p>
                        <span class="error text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <!-- gender -->
                        <div>
                            <label for="genderID" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="genderID" id="genderID" class="w-full px-4 py-2 border border-gray-300 rounded-lg
                         focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="0">Select Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Other</option>
                            </select>
                            <span class="error text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                            <input type="tel" id="mobile" name="mobile" placeholder="10 digits" value="" pattern="[0-9]{10}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg
                         focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">

                            <p class="text-sm text-red-500 mt-1">Enter 10 digits only</p>
                            <span class="error text-red-500 text-sm hidden"></span>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Address Information</h2>
                <div class="space-y-6">

                    <!-- Address line 01 -->
                    <div>
                        <label for="line1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 01</label>
                        <input type="text" id="line01" name="line01" value="" placeholder="Street name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Address line 02 -->
                    <div>
                        <label for="line2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 02</label>
                        <input type="text" id="line02" name="line02" value="" placeholder="Apartment/ suite etc."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <!-- Country -->
                        <div>
                            <label for="countryID" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select name="countryID" id="countryID" class="w-full px-4 py-2 border border-gray-300 rounded-lg
                         focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="0">Select Country</option>
                                <option value="1">Sri Lanka</option>
                                <option value="2">USA</option>
                                <option value="3">Russia</option>
                            </select>
                        </div>

                        <!-- City -->
                        <div>
                            <label for="cityID" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <select name="cityID" id="cityID" class="w-full px-4 py-2 border border-gray-300 rounded-lg
                         focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="0">Select City</option>
                                <option value="1">Kurunegala</option>
                                <option value="2">Callifornia</option>
                                <option value="3">Moscow</option>
                            </select>
                            <span class="error text-red-500 text-sm hidden"></span>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Form actions -->
            <div class="flex gap-4 justify-end">
                <a href="<?php echo $userRole == "buyer" ? "buyer-dashboard.php" : "seller-dashboard.php" ?>" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button id="saveBtn" class="px-6 py-2 bg-blue-600 rounded-lg text-white hover:bg-blue-700 transition-colors">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</div>

<?php require "footer.php"; ?>
<?php
$email = isset($_COOKIE["skillshop__user_email"]) ? $_COOKIE["skillshop__user_email"] : "";
$rememberMe = isset($_COOKIE["skillshop_remember"]) ? true : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Shop</title>
    <link rel="icon" type="images/phg" href="./assets/images/competence.png">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-10 text-center text-white">
                <h1 class="text-4xl font-bold mb-2">SkillShop</h1>
                <p class="text-blue-100">Buy and Sell Skills with Confidence</p>
            </div>
            <!-- Form Container -->
            <div class="px-8 py-8">
                <!-- Sign In Form  -->
                <div id="signin-form" class="form-container active">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                    <p class="text-gray-600 mb-6">Sign in to your account to continue</p>

                    <form id="signin" class="space-y-4" method="post">
                        <input type="hidden" name="active" value="signin">
                        <!-- error -->
                        <div class="hidden mt-4 p-3 rounded-lg text-sm text-center text-red-500 font-bold"
                            id="signin_error"></div>

                        <!-- email -->
                        <label for="signin-email" class="block text-gray-700 text-sm font-semibold mb-2">
                            Email Address
                        </label>
                        <input type="email" name="email" id="signin-email" placeholder="you@example.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            value="  <?php echo $email; ?>" />
                        <!-- Password input -->
                        <div>
                            <label for="signin-password" class="block text-gray-700 text-sm font-semibold mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="signin-password" placeholder="**********"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                    aria-describedby="signin-password-error" />

                                <button onclick="togglePassword('signin-password',this)" type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1"
                                    aria-label="Toggle password visibility" aria-pressed="false">
                                    👀
                                </button>
                            </div>
                            <span class="text-red-500 text-sm hidden" id="signin-password-error"></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="rememberMe" class="flex items-center">
                                <input type="checkbox" name="rememberMe" id="rememberMe"
                                    class="w-4 h-4 text-blue-600 rounded"
                                    <?php if ($rememberMe) echo "checked"; ?> />
                                <span class="ml-2 text-sm text-gray-600">Remember Me</span>
                            </label>
                            <button type="button" onclick="Fogetpassword()"
                                class="text-sm text-blue-600 hover:text-blue-700 font-medium">Foget password?</button>
                        </div>

                        <button onclick="login();" type="button"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 transform hover:scale-105 mt-6">
                            Sign In
                        </button>
                    </form>

                    <p class="text-center text-gray-600 mt-6">
                        Don't have an account
                        <button class="text-blue-600 hover:text-blue-700 font-bold cursor-pointer" onclick="sUp()">
                            Sign Up
                        </button>
                    </p>

                </div>

                <div class="form-container hidden" id="Fogetpassword">
                    <h2 class=" text-2xl font-bold text-gray-800 mb-2">Foget password</h2>
                    <p class="text-gray-600 mb-6">You should remember this password too.😁</p>

                    <div class="hidden mt-4 p-3 rounded-lg text-sm text-center text-red-500 font-bold" id="otp_error">
                    </div>

                    <!-- otp -->
                    <label for="otp" class="block text-gray-700 text-sm font-semibold mb-2">
                        Enter your OTP
                    </label>
                    <input type="text" name="otp" id="otp" placeholder="OTP"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 mb-2" />

                    <!-- Password input -->
                    <div class="relative mb-2">
                        <label for="otp_password" class="block text-gray-700 text-sm font-semibold mb-2">
                            Password
                        </label>
                        <input type="password" name="password" id="otp_password" placeholder="**********"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            aria-describedby="otp_password-error" />

                        <button onclick="togglePassword('otp_password',this)" type="button"
                            class="absolute right-3 top-1/2 -translate-y-2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1"
                            aria-label="Toggle password visibility" aria-pressed="false">👀</button>
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <!-- re-Password input -->
                    <div class="relative">
                        <label for="otp_password_confirm" class="block text-gray-700 text-sm font-semibold mb-2">
                            Confirm Password
                        </label>
                        <input type="password" name="confirm_password" id="otp_password_confirm"
                            placeholder="**********"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            aria-describedby="otp-password-error" />

                        <button onclick="togglePassword('otp_password_confirm',this)" type="button"
                            class="absolute right-3 top-1/2 -translate-y-2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1"
                            aria-label="Toggle password visibility" aria-pressed="false">👀</button>
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <button onclick="ChangePassword()" type="button"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 transform hover:scale-105 mt-6">
                        Change Password
                    </button>

                </div>
                <!-- Sign up Form  -->
                <div id="signup-form" class="form-container hidden">
                    <h2 class=" text-2xl font-bold text-gray-800 mb-2">Create Account</h2>
                    <p class="text-gray-600 mb-6">Sign Up to your account to continue</p>

                    <form id="signup" class="space-y-4">
                        <input type="hidden" name="active" value="signup">

                        <!-- error -->
                        <div class="hidden mt-4 p-3 rounded-lg text-sm text-center text-red-500 font-bold"
                            id="singup-error-Message"></div>

                        <div class="flex justify-between">
                            <div class="mr-2">
                                <!-- fist name -->
                                <label for="signup-fistname" class="block text-gray-700 text-sm font-semibold mb-2">
                                    Fist Name
                                </label>
                                <input type="text" name="fistname" id="signup-fistname" placeholder="Dilsha"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                                <!-- <span class="text-red-500 text-sm hidden font-bold" id="fname_error"></span> -->
                            </div>
                            <div class="">

                                <!-- last name -->
                                <label for="signup-lastname" class="block text-gray-700 text-sm font-semibold mb-2">
                                    Last Name
                                </label>
                                <input type="text" name="lastname" id="signup-lastname" placeholder="Dinuja"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                                <!-- <span class="text-red-500 text-sm hidden font-bold" id="lastname_error"></span> -->
                            </div>
                        </div>

                        <!-- email -->
                        <label for="signup-email" class="block text-gray-700 text-sm font-semibold mb-2">
                            Email Address
                        </label>
                        <input type="email" name="email" id="signup-email" placeholder="you@example.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                        <!-- <span class="text-red-500 text-sm hidden font-bold" id="email_error"></span> -->

                        <!-- Password input -->
                        <div class="relative">
                            <label for="signup-password" class="block text-gray-700 text-sm font-semibold mb-2">
                                Password
                            </label>
                            <input type="password" name="password" id="signup-password" placeholder="**********"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                aria-describedby="signup-password-error" />

                            <button onclick="togglePassword('signup-password',this)" type="button"
                                class="absolute right-3 top-1/2 -translate-y-2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1"
                                aria-label="Toggle password visibility" aria-pressed="false">👀</button>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                            <!-- <span class="text-red-500 text-sm hidden font-bold" id="password_error"></span> -->
                        </div>
                        <!-- re-Password input -->
                        <div class="relative">
                            <label for="signup-confirm" class="block text-gray-700 text-sm font-semibold mb-2">
                                Confirm Password
                            </label>
                            <input type="password" name="confirm_password" id="signup-password-confirm"
                                placeholder="**********"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                aria-describedby="signup-password-error" />

                            <button onclick="togglePassword('signup-password-confirm',this)" type="button"
                                class="absolute right-3 top-1/2 -translate-y-2 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1"
                                aria-label="Toggle password visibility" aria-pressed="false">👀</button>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                            <!-- <span class="text-red-500 text-sm hidden font-bold" id="confirm_error"></span> -->
                        </div>

                        <!-- Account type selection -->
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-3">I am a </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label for="account_type_seller" class="relative flex items-center cursor-pointer">
                                    <input type="radio" name="account_type" value="seller" class="w-4 h-4 text-blue-600"
                                        id="account_type_seller" />
                                    <span class="ml-2 text-sm text-gray-700">Skill Seller</span>
                                </label>
                                <label for="account_type_buyer" class="relative flex items-center cursor-pointer">
                                    <input type="radio" name="account_type" value="buyer" class="w-4 h-4 text-blue-600"
                                        id="account_type_buyer" />
                                    <span class="ml-2 text-sm text-gray-700">Skill Buyer</span>
                                </label>
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <label for="terms_conditions" class="flex items-center">
                            <input type="checkbox" name="terms" value="terms" id="terms_conditions"
                                class="w-4 h-4 text-gray-600 rounded">
                            <span class="ml-2 text-sm text-gray-600">
                                I agree to the
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">
                                    Terms & Conditions
                                </a>
                            </span>

                        </label>

                        <button onclick="createAccount()" type="button"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 transform hover:scale-105 mt-6">
                            Create Account
                        </button>


                    </form>

                    <p class="text-center text-gray-600 mt-6">
                        I have an account
                        <button class="text-blue-600 hover:text-blue-700 font-bold cursor-pointer" onclick="sUp()">
                            Sign In
                        </button>
                    </p>

                </div>
            </div>

            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 text-center text-gray-600 text-sm">
                <p>&copy; 2026 SkillShop. All Rights Reserved. |
                    <a href="#" class="text-blue-600 hover:text-blue-700">Privacy Policy</a>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Terms of Service</a>
                </p>
            </div>


            <!-- Forgot password modal -->
            <div id="forgot-password-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4 rounded-xl">
                <div class="bg-white rounded-xl shadow-xl max-w-md w-full">

                    <!-- modal header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white flex justify-between items-center">
                        <h3 class="text-xl font-bold">Forgot Password?</h3>
                        <button type="button" onclick="closeForgotPasswordModal();" class="text-white hover:text-gray-200">❌</button>
                    </div>

                    <!-- Step 01 : Email Entry -->
                    <div class="p-6 " id="forgot-step-1">
                        <p class="text-gray-600 mb-4">Enter your email to recieve the verification code.</p>
                        <div id="forgot-message" class="hidden mt-2 p-3 rounded-lg text-sm text-center text-red-500 font-bold"></div>
                        <div class="mb-2">
                            <label for="forgot-email" class="block text-gray-700 text-sm font-semibold mb-2">
                                Email Address
                            </label>
                            <input type="email" name="email" id="forgot-email" placeholder="you@example.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 mb-3" />
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="forgotPassword();" id="forgot-password-send-code-btn" class="flex-1 bg-gradient-to-r from-green-700 to-lime-700 text-white font-semibold py-2 rounded-lg
                             hover:from-green-600 hover:to-lime-600">Send Code</button>
                            <button type="button" onclick="closeForgotPasswordModal();" class="flex-1 bg-gradient-to-r from-rose-700 to-red-700 text-white font-semibold py-2 rounded-lg
                             hover:from-rose-600 hover:to-red-600">Cancel</button>
                        </div>
                    </div>

                    <!-- Step 02: verification code -->
                    <div class="p-6 hidden" id="forgot-step-2">
                        <p class="text-gray-600 mb-4">Enter the 6-digit code sent to your email.</p>
                        <div id="verify-message" class="hidden mt-2 p-3 rounded-lg text-sm text-center text-red-500 font-bold"></div>
                        <div class="mb-2">
                            <label for="verify-code" class="block text-gray-700 text-sm font-semibold mb-2">Verification Code</label>
                            <input type="text" id="verify-code" placeholder="000000" maxlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center text-2xl tracking-widest">
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="verifyCode();" class="flex-1 bg-gradient-to-r from-green-700 to-lime-700 text-white font-semibold py-2 rounded-lg
                             hover:from-green-600 hover:to-lime-600">Send Code</button>
                            <button type="button" onclick="backToEmail();" class="flex-1 bg-gradient-to-r from-rose-700 to-red-700 text-white font-semibold py-2 rounded-lg
                             hover:from-rose-600 hover:to-red-600">Cancel</button>
                        </div>
                    </div>

                    <!--Step 3 : Rest Password -->
                    <div class="p-6 hidden" id="forgot-step-3">
                        <p class="text-gray-600 mb-4">Enter you new password.</p>
                        <div id="reset-message" class="hidden mt-2 p-3 rounded-lg text-sm text-center text-red-500 font-bold"></div>
                        <div class="mb-2">
                            <label for="reset-password" class="block text-gray-700 text-sm font-semibold mb-2">New Password</label>
                            <input type="password" id="reset-password" placeholder="********"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="reset-password-confirm" class="block text-gray-700 text-sm font-semibold mb-2">Confirm Password</label>
                            <input type="password" id="reset-password-confirm" placeholder="********"
                                class=" w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="resetPassword();" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 ">Reset Password</button>
                            <button type="button" onclick="closeForgotPasswordModal();" class="flex-1 text-gray-700 bg-gray-300 font-semibold py-2 rounded-1g hover:bg-gray-400">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="./js/auth.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
<?php
    session_start();
	$page_title = "เข้าสู่ระบบ";
	include('includes/head.php');
	include("includes/navbar.php");
?>

<link rel="stylesheet" href="static/error.css">

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="md:mx-auto md:w-full md:max-w-md">
        <img class="mx-auto h-10 w-auto" src="picture/logo.png" alt="Your Company">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">สมัครสมาชิก</h2>
    </div>

    <div class="mt-10 md:mx-auto md:w-full md:max-w-md">
        <?php if (isset($_SESSION['status'])) {?>
				<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
					<h5><?php echo $_SESSION['status']; ?></h5>
				</div>
		<?php unset($_SESSION['status']);}?>
        <form class="space-y-6" action="register_code.php" method="POST" id="registration-form" novalidate>
            <div>
                <label for="firstname" class="block text-md font-medium leading-6 text-gray-900">ชื่อจริง</label>
                <div class="mt-2">
                    <input id="firstname" name="firstname" type="text" autocomplete="given-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="firstname-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="lastname" class="block text-md font-medium leading-6 text-gray-900">นามสกุล</label>
                <div class="mt-2">
                    <input id="lastname" name="lastname" type="text" autocomplete="family-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="lastname-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="firstname_eng" class="block text-md font-medium leading-6 text-gray-900">ชื่อจริงภาษาอังกฤษ</label>
                <div class="mt-2">
                    <input id="firstname_eng" name="firstname_eng" type="text" autocomplete="given-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="firstname_eng-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="lastname_eng" class="block text-md font-medium leading-6 text-gray-900">นามสกุลภาษาอังกฤษ</label>
                <div class="mt-2">
                    <input id="lastname_eng" name="lastname_eng" type="text" autocomplete="family-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="lastname_eng-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="email" class="block text-md font-medium leading-6 text-gray-900">อีเมล</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="email-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

			<div>
                <label for="password" class="block text-md font-medium leading-6 text-gray-900">รหัสผ่าน</label>
                <div class="mt-2">
                    <input id="password" name="password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="password-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="confirm-password" class="block text-md font-medium leading-6 text-gray-900">ยืนยันรหัสผ่าน</label>
                <div class="mt-2">
                    <input id="confirm-password" name="confirm-password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="confirm-password-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="phone" class="block text-md font-medium leading-6 text-gray-900">โทรศัพท์</label>
                <div class="mt-2">
                    <input id="phone" name="phone" type="tel" autocomplete="tel" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
                    <p id="phone-error" class="text-red-600 text-xs mt-1"></p>
                </div>
            </div>

            <div>
                <label for="dob" class="block text-md font-medium leading-6 text-gray-900">วันเกิด</label>
                <div class="mt-2">
					<input type="date" id="DOB" name="DOB" class="w-full h-10 rounded-md focus:outline-none hover:bg-gray-200 px-3">
                        <p id="DOB-error" class="text-red-600 text-xs mt-1"></p>
                    </div>
            </div>

            <div>
                <button type="submit" name="send" class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-md font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">สมัครสมาชิก</button>
            </div>
        </form>

        <p class="mt-10 text-center text-md text-gray-500">
            หากเป็นสมาชิกแล้ว
            <a href="login.php" class="font-semibold leading-6 text-red-600 hover:text-red-500">เข้าสู่ระบบที่นี่</a>
        </p>
    </div>
</div>

<script src="static/register_validation.js"></script>

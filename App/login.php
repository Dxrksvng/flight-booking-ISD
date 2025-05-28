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
		<h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">เข้าสู่ระบบ</h2>
	</div>

	<div class="mt-10 md:mx-auto md:w-full md:max-w-md">
		<?php
			if (isset($_SESSION['status'])) {
				?>
				<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative mb-5" role="alert">
					<h5><?php echo $_SESSION['status']; ?></h5>
				</div>
				<?php unset($_SESSION['status']);
			}
		?>
		<form class="space-y-6" id="login_form" action="login_code.php" method="POST" novalidate>
			<div>
				<label for="email" class="block text-md font-medium leading-6 text-gray-900">อีเมล</label>
				<div class="mt-2">
				<input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
				</div>
			</div>

			<div>
				<div class="flex items-center justify-between">
				<label for="password" class="block text-md font-medium leading-6 text-gray-900">รหัสผ่าน</label>
				</div>
				<div class="mt-2">
				<input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-950 sm:text-sm sm:leading-6">
				</div>
			</div>

			<div>
				<button name="send" type="submit" class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-md font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">เข้าสู่ระบบ</button>
			</div>
		</form>

		<p class="mt-10 text-center text-md text-gray-500">
			หากยังไม่เป็นสมาชิก
		<a href="register.php" class="font-semibold leading-6 text-red-600 hover:text-red-500">สมัครสมาชิกที่นี่</a>
		</p>
	</div>
</div>

<script src="static/login.js"></script>

<nav class="flex w-full flex-wrap items-center justify-between bg-gray-50 py-2 text-neutral-500 shadow-lg hover:text-neutral-700 focus:text-neutral-700 lg:py-4">
    <div class="flex w-full flex-wrap items-center justify-between px-3">
        <div>
            <p class="mx-2 my-1 flex items-center text-neutral-900 hover:text-neutral-900 focus:text-neutral-900 lg:mb-0 lg:mt-0">
                <img class="mr-1" src="picture/logo.png" style="height: 28px" alt="TE Logo" loading="lazy" />
            </p>
        </div>
        <!-- Collapsible navbar container -->
        <div class="flex items-center sm:flex-row flex-col"> <!-- Responsive flex layout -->
            <?php if(!isset($_SESSION['role'])){?>
                <a href="index.php" class="mb-2 lg:mb-0 mr-3 inline-block rounded px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-red-700 transition duration-150 ease-in-out hover:bg-neutral-200 hover:text-red-800 focus:text-red-800 focus:bg-neutral-300 focus:ring-0 active:text-red-800 motion-reduce:transition-none">
                    ค้นหาเที่ยวบิน
                </a>
            <?php
                }
                if(isset($_SESSION['role']))
                {?>
                    <?php if($_SESSION['role'] == 'customer' or $_SESSION['role'] == 'counter') : ?>
                        <a href="index.php" class="mb-2 lg:mb-0 mr-3 inline-block rounded px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-red-700 transition duration-150 ease-in-out hover:bg-neutral-200 hover:text-red-800 focus:text-red-800 focus:bg-neutral-300 focus:ring-0 active:text-red-800 motion-reduce:transition-none">
                            ค้นหาเที่ยวบิน
                        </a>
                    <?php endif?>
                    <?php if($_SESSION['role'] == 'admin' or $_SESSION['role'] == 'counter') : ?>
                        <a href="flight_list.php" class="mb-2 lg:mb-0 mr-3 inline-block rounded px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-red-700 transition duration-150 ease-in-out hover:bg-neutral-200 hover:text-red-800 focus:text-red-800 focus:bg-neutral-300 focus:ring-0 active:text-red-800 motion-reduce:transition-none">
                            รายการเที่ยวบิน
                        </a>
                    <?php endif?>
                    <?php if($_SESSION['role'] == 'admin'):?>
                        <a href="manager.php" class="mb-2 lg:mb-0 mr-3 inline-block rounded px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-red-700 transition duration-150 ease-in-out hover:bg-neutral-200 hover:text-red-800 focus:text-red-800 focus:bg-neutral-300 focus:ring-0 active:text-red-800 motion-reduce:transition-none">
                            จัดการเที่ยวบิน
                        </a>
                    <?php endif?>

            <?php
                }
                ?>
            <?php if(!isset($_SESSION['authenticated'])) : ?>
            <a href="login.php" class="mb-2 lg:mb-0 mr-3 inline-block rounded px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-red-700 transition duration-150 ease-in-out hover:bg-neutral-200 hover:text-red-800 focus:text-red-800 focus:bg-neutral-300 focus:ring-0 active:text-red-800 motion-reduce:transition-none">
                เข้าสู่ระบบ
            </a>
            <a href="register.php" class="inline-block rounded bg-red-700 px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-red-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-red-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-red-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                สมัครสมาชิก
            </a>
            <?php endif?>

            <?php if(isset($_SESSION['authenticated'])) : ?>
            <a href="logout.php" class="inline-block rounded bg-red-700 px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-red-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-red-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-red-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                ออกจากระบบ
            </a>
            <?php endif?>

        </div>
    </div>
</nav>

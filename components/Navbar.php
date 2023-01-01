<?php
$db = import('./Database/db');

function checkPath($path)
{
    if ($path == parse_url($_SERVER['REQUEST_URI'], 5)) {
        echo " bg-blue-200";
    }
}
?>


<nav class="bg-white border-gray-200 px-2 py-2 sm:py-0 sm:px-4 rounded dark:bg-gray-900 sticky top-0">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="/" class="flex items-center">
            <span class="text-blue-500 font-normal text-2xl">a<span class="font-bold">den</span></span>
        </a>
        <?php if(!isset($_SESSION['usr'])): ?>
        <div class="items-center md:order-2">
            <a class="hover:underline hover:text-blue-700" href="/login">เข้าสู่ระบบ</a>
        </div>
        <?php else:
        require('./components/MenuProfile.php');
         endif; ?>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
            <ul class="flex flex-col p-2 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="/" data-title="หน้าหลัก" class="<?php checkPath('/'); ?> nav-item">
                        <img class="w-5 sm:w-10 inline-block" src="/public/icons/home.svg" alt="home">
                        <span class="sm:hidden">หน้าหลัก</span>
                    </a>
                </li>
                <li>
                    <a href="/poll" data-title="แบบประเมิน" class="<?php checkPath('/poll'); ?> nav-item">
                        <img class="w-5 sm:w-10 inline-block" src="/public/icons/poll.svg" alt="home">
                        <span class="sm:hidden">แบบประเมิน</span>

                    </a>
                </li>
                <li>
                    <a href="/board" data-title="กระดานสนทนา" class="<?php checkPath('/board'); ?> nav-item">
                        <img class="w-5 sm:w-10 inline-block" src="/public/icons/question.svg" alt="home">
                        <span class="sm:hidden">กระดานสนทนา</span>
                    </a>
                </li>
                <li>
                    <a href="/people" data-title="ผู้คน" class="<?php checkPath('/people'); ?> block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-zinc-300 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        <img class="w-10" src="/public/icons/group.svg" alt="home">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
if (isset($_SESSION['usr'])) {
    $usr_nav = fetch($db->query("SELECT * FROM usr WHERE usr_id = " . $_SESSION['usr']));
}
?>

<div data-title="เมนู" class="flex items-center md:order-2">
    <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <img class="w-10 h-10 shadow shadow-zinc-500 rounded-full object-cover" src="/public/profile/<?php echo $usr_nav['usr_img'] ?? ""; ?>" alt="user photo">
    </button>
    <!-- Dropdown menu -->
    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
        <div class="px-4 py-3">
            <span class="block text-sm text-gray-900 dark:text-white"><?php echo $usr_nav['usr_name'] ?? ""; ?></span>
            <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400"><?php echo $usr_nav['usr_email'] ?? ""; ?></span>
        </div>
        <ul class="py-1" aria-labelledby="user-menu-button">
            <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'admin'): ?>
            <li>
                <a href="/admin/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
            </li>
            <?php endif; ?>
            <li>
                <a href="/create-post" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">สร้างโพสต์</a>
            </li>
            <li>
                <a href="/<?php echo $usr_nav['usr_username']; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">โปรไฟล์</a>
            </li>
            <li>
                <a href="/login?logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">ออกจากระบบ</a>
            </li>
        </ul>
    </div>
    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>
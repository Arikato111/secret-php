<?php
function checkPath($path)
{
  if ($path == parse_url($_SERVER['REQUEST_URI'], 5)) {
    echo " bg-zinc-200";
  }
}
?>

<nav class=" sticky top-0 bg-base-100 py-1 shadow-md shadow-zinc-200">
  <div class="grid grid-cols-3 justify-items-center">

    <div class="flex">
      <a href="/" class="btn btn-ghost normal-case text-xl hidden sm:flex">
        <span class="text-blue-500 font-normal text-2xl">a<b class="font-bold">den</b></span>
      </a>
       <!-- search -->
        <!-- <form action="/search">
          <input type="text" placeholder="ค้นหา" name="q" value="<?php echo $_GET['q'] ?? ""; ?>" class="input  p-1 hidden sm:block" />
        </form> -->
    </div>

    <ul class="menu menu-horizontal px-1">
      <li><a class=" <?php checkPath('/'); ?>" href="/" data-title="หน้าหลัก"><img src="/public/icons/home.png" class="w-7" alt=""></a></li>
      <li class="mx-1">
        <a data-title="แบบประเมิน" class="<?php checkPath('/polls'); ?>" href="/polls"><img class="w-7" src="/public/icons/poll.svg" alt=""></a>
      </li>
      <li class="mr-1">
        <a data-title="กระดานสนทนา" class="<?php checkPath('/board'); ?>" href="/board"><img class="w-7" src="/public/icons/question.svg" alt=""></a>
      </li>
      <li class="sm:hidden">
        <a href="/login">เข้าสู่ระบบ</a>
      </li>
      <!-- <li class="sm:hidden">
        <a class="<?php checkPath("/login");
                  checkPath('/register'); ?>">
          <img class="w-7" src="/public/icons/group.svg" alt="">
        </a>
        <ul class="p-2 bg-base-100">
          <li><a href="/register">สมัครสมาชิก</a></li>
          <li><a href="/login">เข้าสู่ระบบ</a></li>
        </ul>
      </li> -->
    </ul>

    <div>
      <ul class="hidden sm:flex menu menu-horizontal px-1">
        <?php if (isset($_SESSION['usr'])) : ?>
        <?php else : ?>
          <li><a class="<?php checkPath('/login'); ?>" href="/login">เข้าสู่ระบบ</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
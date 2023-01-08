<?php
$db = new Database;
?>

<div class="form-control">
    <h3 class="text-lg text-center">รายงานสมาชิก</h3>

    <div class="relative overflow-x-auto border mx-3 mt-5 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        หัวข้อ
                    </th>
                    <th scope="col" class="px-6 py-3">
                        รายละเอียด
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        สมาชิกทั้งหมด
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $db->reportUser_Count(); ?>
                        คน
                    </td>
                </tr>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        สมาชิกใหม่วันนี้
                    </td>
                    <td class="px-6 py-4">
                        <?php 
                        $date = date('Y-m-d');
                        echo $db->reportUserRegisToday(); ?>
                        คน
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
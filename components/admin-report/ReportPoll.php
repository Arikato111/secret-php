<?php
$db = new Database;
$Allpoll = $db->getAllPoll();
?>

<div class="form-control">
    <h3 class="text-lg text-center">รายงานแบบสอบถาม</h3>

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
                        แบบสอบถามทั้งหมด
                    </td>
                    <td class="px-6 py-4">
                        <?php echo sizeof($Allpoll); ?>
                        คำถาม
                    </td>
                </tr>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        จำนวนครั้งเข้าชมทั้งหมด
                    </td>
                    <td class="px-6 py-4">
                        <?php
                        $total_view = 0;
                        foreach ($Allpoll as $poll) {
                            $total_view += (int) $poll['poll_view'];
                        }
                        echo $total_view;
                        ?>
                        ครั้ง
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
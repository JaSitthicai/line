<?php

$channelToken='bhiZ2IDh21XqkjupJZCbW/yfaZ5EoH8aisZCzLj6kLWkOy0ydO9E8vdM9Wz1TBcVxMCwuUikLa2LIOnqrDIphbzFpVRZm/LPnS/Jt3tFh5TKltYOWugRTTvkLLniMbRQQZ75wjQYjpxZoPNBjjBVTAdB04t89/1O/w1cDnyilFU=';
$userId = 'Ce62421bae012eba889d1d0c8bc0429fa';

//$message = 'สวัสดีจาก PHP LINE API!';

$url = 'https://api.line.me/v2/bot/message/push';

// ข้อความที่ต้องการส่ง
$text_message = [
    'type' => 'text',
    'text' => 'สวัสดี! นี่คือข้อความพร้อม รูปภาพ'
];
// รูปภาพที่ต้องการส่ง (ต้องเป็นลิงก์ URL ที่เปิดได้)
$image_message = [
    'type' => 'image',
    'originalContentUrl' => 'https://gbkey.kesug.com/line/uploads/food_1748539971_2.png', // ลิงก์รูปเต็ม
    'previewImageUrl' => 'https://gbkey.kesug.com/line/uploads/food_1748539971_2.png' // ลิงก์รูปพรีวิว
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $food_name = $_POST['food_name'] ?? 'ไม่ระบุชื่อ';
    $food_desc = $_POST['food_desc'] ?? '';
    $images = json_decode($_POST['images'], true);
    $saved = 0;
	
    // สร้างโฟลเดอร์ uploads ถ้ายังไม่มี
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    echo "<h2>🍽 รายการอาหารที่บันทึก</h2>";
    echo "<strong>ชื่อ:</strong> " . htmlspecialchars($food_name) . "<br>";
    echo "<strong>รายละเอียด:</strong> " . nl2br(htmlspecialchars($food_desc)) . "<br><br>";

    echo "<h3>📷 รูปภาพที่บันทึก:</h3>";
	//$message = $food_name.' '. $food_desc;
    foreach ($images as $index => $dataUrl)
	{
        if (preg_match('/^data:image\/jpeg;base64,/', $dataUrl)) {
            $data = base64_decode(str_replace('data:image/jpeg;base64,', '', $dataUrl));
            $filename = 'uploads/food_' . time() . "_$index.jpg";
            file_put_contents($filename, $data);
       		$img = "<img src='$filename' width='150'><br>";
			
			echo $img;
			$data = [
			    'to' => $userId,
			    'messages' => [$text_message, $image_message]
			];
			
			$post = json_encode($data);
			
			$headers = [
			    'Content-Type: application/json',
			    'Authorization: Bearer ' . $channelToken
			];
			
			$ch = curl_init('https://api.line.me/v2/bot/message/push');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);	
			$saved++;
						
		}
	}
	echo "<p>✅ บันทึก $saved  รูปเรียบร้อยแล้ว</p>";
} else {
    echo "❌ ไม่มีข้อมูลที่ส่งมา";
}
?>

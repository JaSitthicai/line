<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เพิ่มเมนูอาหาร</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    video, img { max-width: 100%; }
    #preview img { width: 100px; margin: 5px; border: 1px solid #ccc; }
  </style>
</head>
<body>
  <h2>📋 เพิ่มรายการอาหารใหม่</h2>

  <form method="POST" action="upload.php" onsubmit="return prepareForm();">
    <label>ชื่ออาหาร:</label><br>
    <input type="text" name="food_name" required><br><br>

    <label>รายละเอียดอาหาร:</label><br>
    <textarea name="food_desc" rows="4" cols="40" required></textarea><br><br>

    <h3>📸 รูปภาพอาหาร (สูงสุด 3 รูป)</h3>
    <video id="video" autoplay playsinline></video><br>
    <button type="button" onclick="capture()">➕ เพิ่มรูป</button>

    <div id="preview"></div>

    <input type="hidden" name="images" id="imagesInput">
    <br><br>
    <button type="submit">✅ บันทึกรายการอาหาร</button>
  </form>

  <script>
    const video = document.getElementById('video');
    const preview = document.getElementById('preview');
    const imagesInput = document.getElementById('imagesInput');
    const images = [];

    // เปิดกล้องหลัง
    navigator.mediaDevices.getUserMedia({
      video: { facingMode: { exact: "environment" } }
    })
    .then(stream => {
      video.srcObject = stream;
    })
    .catch(err => {
      alert("ไม่สามารถเปิดกล้องหลังได้: " + err.message);
    });

    function capture() {
      if (images.length >= 3) {
        alert("ถ่ายได้ไม่เกิน 3 รูป");
        return;
      }
 
      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

      const dataURL = canvas.toDataURL('image/jpeg');
      images.push(dataURL);

      const img = document.createElement('img');
      img.src = dataURL;
      preview.appendChild(img);
    }

    function prepareForm() {
      if (images.length === 0) {
        alert("กรุณาถ่ายภาพอาหารอย่างน้อย 1 รูป");
        return false;
      }
      imagesInput.value = JSON.stringify(images);
      return true;
    }
  </script>
</body>
</html>

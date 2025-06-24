<?php
// Fungsi untuk mendapatkan IP address user
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Variabel untuk menyimpan data user
$userInfo = null;

// Jika tombol cari diklik
if (isset($_POST['cari'])) {
    $userInfo = [
        'ip_address' => getUserIP(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'browser' => $_SERVER['HTTP_SEC_CH_UA'] ?? 'Tidak diketahui',
        'platform' => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? 'Tidak diketahui',
        'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Tidak diketahui',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct access',
        'timestamp' => date('Y-m-d H:i:s'),
        'server_name' => $_SERVER['SERVER_NAME'],
        'request_method' => $_SERVER['REQUEST_METHOD'],
        'connection_type' => $_SERVER['HTTP_CONNECTION'] ?? 'Tidak diketahui'
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info Finder</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            text-align: center;
            padding: 30px;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .content {
            padding: 40px;
        }
        
        .search-section {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .btn-cari {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.2em;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-cari:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #667eea;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
        }
        
        .info-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 1.1em;
        }
        
        .info-value {
            color: #666;
            word-break: break-all;
            line-height: 1.5;
        }
        
        .location-section {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }
        
        .coordinates {
            font-size: 1.5em;
            margin: 15px 0;
        }
        
        .get-location-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px;
        }
        
        .get-location-btn:hover {
            background: white;
            color: #667eea;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
        
        .loading {
            display: none;
            text-align: center;
            margin: 20px 0;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            
            .content {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 User Info Finder</h1>
            <p>Klik tombol di bawah untuk mendapatkan informasi detail tentang browser dan lokasi Anda</p>
        </div>
        
        <div class="content">
            <div class="search-section">
                <form method="POST">
                    <button type="submit" name="cari" class="btn-cari">
                        🔎 Cari Info Saya
                    </button>
                </form>
            </div>
            
            <?php if ($userInfo): ?>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-title">🌐 IP Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['ip_address']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">🖥️ User Agent</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['user_agent']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">🌍 Browser</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['browser']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">💻 Platform</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['platform']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">🗣️ Bahasa</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['accept_language']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">🔗 Referer</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['referer']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">⏰ Timestamp</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['timestamp']); ?></div>
                </div>
                
                <div class="info-card">
                    <div class="info-title">🏠 Server</div>
                    <div class="info-value"><?php echo htmlspecialchars($userInfo['server_name']); ?></div>
                </div>
            </div>
            
            <div class="location-section">
                <h3>📍 Informasi Lokasi</h3>
                <div class="alert alert-info">
                    Klik tombol di bawah untuk mendapatkan koordinat latitude dan longitude Anda
                </div>
                
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Mendapatkan lokasi...</p>
                </div>
                
                <div class="coordinates" id="coordinates" style="display: none;">
                    <p><strong>Latitude:</strong> <span id="latitude">-</span></p>
                    <p><strong>Longitude:</strong> <span id="longitude">-</span></p>
                    <p><strong>Akurasi:</strong> <span id="accuracy">-</span> meter</p>
                </div>
                
                <button class="get-location-btn" onclick="getLocation()">
                    📍 Dapatkan Koordinat Saya
                </button>
                
                <button class="get-location-btn" onclick="openMap()" id="mapBtn" style="display: none;">
                    🗺️ Buka di Google Maps
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        let currentLat = null;
        let currentLng = null;
        
        function getLocation() {
            if (navigator.geolocation) {
                document.getElementById('loading').style.display = 'block';
                document.getElementById('coordinates').style.display = 'none';
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        currentLat = position.coords.latitude;
                        currentLng = position.coords.longitude;
                        
                        document.getElementById('latitude').textContent = currentLat.toFixed(6);
                        document.getElementById('longitude').textContent = currentLng.toFixed(6);
                        document.getElementById('accuracy').textContent = Math.round(position.coords.accuracy);
                        
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('coordinates').style.display = 'block';
                        document.getElementById('mapBtn').style.display = 'inline-block';
                    },
                    function(error) {
                        document.getElementById('loading').style.display = 'none';
                        let errorMsg = '';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMsg = "Akses lokasi ditolak oleh user.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMsg = "Informasi lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                errorMsg = "Permintaan lokasi timeout.";
                                break;
                            default:
                                errorMsg = "Error tidak dikenal.";
                                break;
                        }
                        alert("Error mendapatkan lokasi: " + errorMsg);
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }
        
        function openMap() {
            if (currentLat && currentLng) {
                const url = `https://www.google.com/maps?q=${currentLat},${currentLng}`;
                window.open(url, '_blank');
            }
        }
    </script>
</body>
</html>
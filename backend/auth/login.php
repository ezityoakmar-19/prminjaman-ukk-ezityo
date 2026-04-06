<?php
session_start();

require_once "../app.php";

$error = "";

if (isset($_POST['login'])) {
    $username = escapeString($koneksi, $_POST['username']);
    $password = escapeString($koneksi, $_POST['password']);
    $role     = escapeString($koneksi, $_POST['role']);

    $query = mysqli_query(
        $koneksi,
        "SELECT u.*, r.nama_role
         FROM users u
         JOIN roles r ON u.id_role = r.id_role
         WHERE u.username='$username'"
    );

    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

       if ($password === $user['password']) {

            $_SESSION['login']   = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['nama_role'];

            // LOGIKA PENGALIHAN BERDASARKAN ROLE
            if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas') {
                // Admin & Petugas masuk ke Dashboard
                header("Location: ../pages/dashboard/index.php");
            } else {
                // User/Peminjam langsung ke halaman depan (Index Utama)
                header("Location: /ukk/index.php");
            }
            exit;
            
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username atau role tidak sesuai!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | Peminjaman Proyektor - Rental Proyektor Profesional</title>
    <link rel="stylesheet" href="../template/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #60a5fa;
            --dark-blue: #1e293b;
            --light-bg: #f8fafc;
        }
        
        body {
            background: linear-gradient(135deg, #0b1120 0%, #1e293b 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            overflow-x: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.08) 0%, transparent 20%),
                radial-gradient(circle at 90% 70%, rgba(96, 165, 250, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 30% 80%, rgba(37, 99, 235, 0.08) 0%, transparent 30%);
            pointer-events: none;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
            position: relative;
            z-index: 10;
        }
        
        .card-login {
            border-radius: 32px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            z-index: 10;
            position: relative;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            animation: slideUp 0.5s ease-out;
            border: 1px solid rgba(37, 99, 235, 0.2);
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-login::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary-color), transparent, var(--accent-color));
            border-radius: 34px;
            z-index: -1;
            animation: borderGlow 4s infinite linear;
            opacity: 0.5;
        }
        
        @keyframes borderGlow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }
        
        .card-header-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px 25px;
            text-align: center;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }
        
        .card-header-login::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .card-header-login h3 {
            margin: 15px 0 5px;
            font-weight: 800;
            letter-spacing: 0.5px;
            font-size: 1.6rem;
            position: relative;
            z-index: 1;
        }
        
        .card-header-login i {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .card-header-login p {
            margin: 5px 0 0;
            font-size: 0.9rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .card-body {
            padding: 35px 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 8px;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }
        
        .form-control {
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            padding: 14px 18px;
            transition: all 0.3s;
            font-size: 0.95rem;
            background: #f8fafc;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
            background: white;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 16px;
            padding: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            color: white;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 30px -10px rgba(37, 99, 235, 0.5);
            color: white;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .login-title {
            color: var(--dark-blue);
            font-weight: 800;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }
        
        .login-title i {
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .footer-login {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .footer-login i {
            color: var(--primary-color);
        }
        
        .rebana-icon {
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            border-left: 5px solid #ef4444;
            border-radius: 16px;
            color: #991b1b;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: none;
        }
        
        .pulse {
            animation: cardPulse 2s infinite;
        }
        
        @keyframes cardPulse {
            0% { box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.25); }
            50% { box-shadow: 0 25px 60px -8px rgba(37, 99, 235, 0.4); }
            100% { box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.25); }
        }
        
        /* Efek dekoratif mengambang dengan ikon proyektor */
        .floating-projector {
            position: absolute;
            opacity: 0.1;
            z-index: 1;
            color: var(--primary-color);
        }
        
        .proj-1 {
            font-size: 120px;
            top: 10%;
            left: 5%;
            animation: float 15s infinite ease-in-out;
        }
        
        .proj-2 {
            font-size: 80px;
            top: 70%;
            right: 8%;
            animation: float 12s infinite ease-in-out reverse;
        }
        
        .proj-3 {
            font-size: 100px;
            bottom: 15%;
            left: 10%;
            animation: float 18s infinite ease-in-out;
        }
        
        .proj-4 {
            font-size: 60px;
            top: 15%;
            right: 12%;
            animation: float 10s infinite ease-in-out reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(10px) rotate(-5deg); }
        }
        
        /* Efek sinar proyektor */
        .light-beam {
            position: absolute;
            top: 20%;
            right: 5%;
            width: 300px;
            height: 200px;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.1), transparent);
            transform: skewX(-20deg);
            animation: beamMove 8s infinite ease-in-out;
            pointer-events: none;
            z-index: 1;
        }
        
        @keyframes beamMove {
            0%, 100% { opacity: 0.2; transform: skewX(-20deg) translateX(0); }
            50% { opacity: 0.4; transform: skewX(-20deg) translateX(30px); }
        }
        
        @media (max-width: 768px) {
            .floating-projector, .light-beam { display: none; }
            .card-login { margin: 20px; }
            .card-body { padding: 25px 20px; }
        }

        /* Tambahan CSS untuk canvas 3D - diletakkan di belakang */
        #projector-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            display: block;
        }
        
        /* Memastikan konten di atas canvas */
        .login-container {
            position: relative;
            z-index: 10;
        }
        
        body {
            background: transparent;
        }

        /* Efek tambahan dari halaman register */
        .card-login {
            transition: transform 0.3s ease;
        }

        .card-login:hover {
            transform: translateY(-5px);
        }

        .text-link {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
        }

        .text-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .alert {
            border-radius: 16px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: none;
        }
    </style>
</head>

<body>
    <!-- Canvas untuk proyektor 3D bergerak (diletakkan di belakang) -->
    <canvas id="projector-canvas"></canvas>

    <!-- Elemen dekoratif mengambang (ikon proyektor) -->
    <div class="floating-projector proj-1">
        <i class="fas fa-video"></i>
    </div>
    <div class="floating-projector proj-2">
        <i class="fas fa-film"></i>
    </div>
    <div class="floating-projector proj-3">
        <i class="fas fa-clapperboard"></i>
    </div>
    <div class="floating-projector proj-4">
        <i class="fas fa-projector"></i>
    </div>
    
    <!-- Efek sinar proyektor -->
    <div class="light-beam"></div>
    
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="card card-login pulse">
                        <div class="card-header-login">
                            <i class="fas fa-video"></i>
                            <h3>Peminjaman Proyektor</h3>
                            <p>Rental Proyektor Profesional</p>
                        </div>
                        <div class="card-body">
                            <h4 class="login-title"><i class="fas fa-sign-in-alt"></i> LOGIN</h4>
                            <p class="text-center text-muted mb-4">Masukkan username dan password untuk mengakses sistem</p>

                            <?php if ($error != ""): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i> <?= $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-user me-2" style="color: var(--primary-color);"></i> Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Contoh: ahmadfauzi" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-lock me-2" style="color: var(--primary-color);"></i> Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-user-tag me-2" style="color: var(--primary-color);"></i> Login Sebagai</label>
                                    <select name="role" class="form-control" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin">Admin</option>
                                        <option value="petugas">Petugas</option>
                                        <option value="peminjaman">User</option>
                                    </select>
                                </div>

                                <button type="submit" name="login" class="btn btn-login mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </form>

                            <div class="text-center mt-3">
                                <p class="text-muted mb-0">Belum punya akun?</p>
                                <a href="register.php" class="text-link">
                                    <i class="fas fa-user-plus me-1"></i> Daftar Akun Sekarang
                                </a>
                            </div>

                            <div class="footer-login">
                                <p class="mb-0"><i class="fas fa-video me-1"></i> Peminjaman Proyektor - Rental Proyektor Profesional &copy; <?= date('Y'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../template/assets/js/bootstrap.bundle.min.js"></script>
    
    <!-- Three.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    
    <script>
        (function() {
            // Inisialisasi scene, camera, renderer
            const canvas = document.getElementById('projector-canvas');
            const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            
            const scene = new THREE.Scene();
            scene.background = null; // transparan
            
            const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 2, 14);
            camera.lookAt(0, 1, 0);
            
            // Pencahayaan
            const ambientLight = new THREE.AmbientLight(0x404080);
            scene.add(ambientLight);
            
            const dirLight = new THREE.DirectionalLight(0xffffff, 1.2);
            dirLight.position.set(2, 5, 5);
            scene.add(dirLight);
            
            const backLight = new THREE.PointLight(0x3366cc, 1.5, 20);
            backLight.position.set(-3, 2, -4);
            scene.add(backLight);
            
            // Lampu proyektor
            const projectorLight = new THREE.PointLight(0x2a7fff, 2.5, 20);
            projectorLight.position.set(1.8, 2.2, 2.5);
            scene.add(projectorLight);
            
            // Lampu tambahan
            const extraLight = new THREE.PointLight(0x8844cc, 1.2, 25);
            extraLight.position.set(-2, 1, 4);
            scene.add(extraLight);
            
            // ===== MEMBUAT MODEL PROYEKTOR 3D =====
            const proyektorGroup = new THREE.Group();
            
            // Badan utama
            const bodyGeo = new THREE.BoxGeometry(2.4, 1.3, 3.0);
            const bodyMat = new THREE.MeshStandardMaterial({ 
                color: 0x2a3f5a, 
                emissive: 0x102030, 
                roughness: 0.3, 
                metalness: 0.8,
                emissiveIntensity: 0.2
            });
            const body = new THREE.Mesh(bodyGeo, bodyMat);
            body.position.set(0, 0.65, 0);
            proyektorGroup.add(body);
            
            // Lensa utama (tabung)
            const lensGeo = new THREE.CylinderGeometry(0.9, 0.9, 0.7, 32);
            const lensMat = new THREE.MeshStandardMaterial({ 
                color: 0xaaccff, 
                emissive: 0x1a3f77,
                transparent: true, 
                opacity: 0.9,
                emissiveIntensity: 0.5
            });
            const lens = new THREE.Mesh(lensGeo, lensMat);
            lens.rotation.x = Math.PI / 2;
            lens.position.set(0, 0.65, 1.6);
            proyektorGroup.add(lens);
            
            // Lensa depan (kaca)
            const glassGeo = new THREE.SphereGeometry(0.75, 32, 16);
            const glassMat = new THREE.MeshStandardMaterial({ 
                color: 0xccddff, 
                emissive: 0x224488, 
                transparent: true, 
                opacity: 0.3,
                emissiveIntensity: 0.3
            });
            const glass = new THREE.Mesh(glassGeo, glassMat);
            glass.position.set(0, 0.65, 2.0);
            glass.scale.set(0.9, 0.9, 0.3);
            proyektorGroup.add(glass);
            
            // Detail atas
            const topGeo = new THREE.BoxGeometry(1.5, 0.2, 1.8);
            const topMat = new THREE.MeshStandardMaterial({ color: 0x3a4f6a });
            const topPiece = new THREE.Mesh(topGeo, topMat);
            topPiece.position.set(0, 1.2, -0.2);
            proyektorGroup.add(topPiece);
            
            // Tombol-tombol
            const btnGeo = new THREE.SphereGeometry(0.16, 16);
            const btnMat = new THREE.MeshStandardMaterial({ color: 0xff5533, emissive: 0x441100 });
            const btn1 = new THREE.Mesh(btnGeo, btnMat);
            btn1.position.set(-0.7, 1.0, -1.1);
            proyektorGroup.add(btn1);
            
            const btn2 = new THREE.Mesh(btnGeo, btnMat);
            btn2.position.set(0.7, 1.0, -1.1);
            proyektorGroup.add(btn2);
            
            const btnGeoSmall = new THREE.SphereGeometry(0.1, 8);
            const btnMatSmall = new THREE.MeshStandardMaterial({ color: 0x33cc99, emissive: 0x113322 });
            const btn3 = new THREE.Mesh(btnGeoSmall, btnMatSmall);
            btn3.position.set(0, 1.0, -1.3);
            proyektorGroup.add(btn3);
            
            // Dudukan
            const standGeo = new THREE.BoxGeometry(2.0, 0.2, 2.4);
            const standMat = new THREE.MeshStandardMaterial({ color: 0x1a2533 });
            const stand = new THREE.Mesh(standGeo, standMat);
            stand.position.set(0, 0.1, 0);
            proyektorGroup.add(stand);
            
            // Kabel
            const cableGeo = new THREE.TorusGeometry(0.35, 0.08, 16, 32, Math.PI);
            const cableMat = new THREE.MeshStandardMaterial({ color: 0x332211 });
            const cable = new THREE.Mesh(cableGeo, cableMat);
            cable.rotation.z = Math.PI / 2;
            cable.rotation.y = 0.5;
            cable.position.set(-1.2, 0.35, -1.1);
            proyektorGroup.add(cable);
            
            // Ventilasi
            const ventGeo = new THREE.BoxGeometry(1.0, 0.1, 0.1);
            const ventMat = new THREE.MeshStandardMaterial({ color: 0x445566 });
            for (let i = 0; i < 3; i++) {
                const vent = new THREE.Mesh(ventGeo, ventMat);
                vent.position.set(0, 0.3 + i*0.2, -1.3);
                proyektorGroup.add(vent);
            }
            
            // Tambahkan grup ke scene
            proyektorGroup.position.set(0, 0.8, -2.0);
            proyektorGroup.rotation.y = 0.3;
            scene.add(proyektorGroup);
            
            // ===== KERUCUT CAHAYA (BEAM) =====
            const beamGroup = new THREE.Group();
            
            const beamConeGeo = new THREE.ConeGeometry(2.2, 4.5, 32);
            const beamMat = new THREE.MeshStandardMaterial({
                color: 0x3377ff,
                emissive: 0x113388,
                transparent: true,
                opacity: 0.2,
                side: THREE.DoubleSide
            });
            const beam = new THREE.Mesh(beamConeGeo, beamMat);
            beam.rotation.x = Math.PI / 2;
            beam.position.set(0, -0.9, 2.2);
            beamGroup.add(beam);
            
            const beam2Geo = new THREE.ConeGeometry(1.6, 5.0, 32);
            const beam2Mat = new THREE.MeshStandardMaterial({ 
                color: 0x5599ff, 
                emissive: 0x2244aa, 
                transparent: true, 
                opacity: 0.15,
                side: THREE.DoubleSide
            });
            const beam2 = new THREE.Mesh(beam2Geo, beam2Mat);
            beam2.rotation.x = Math.PI / 2;
            beam2.position.set(0, -0.9, 2.4);
            beamGroup.add(beam2);
            
            beamGroup.position.set(0, 1.3, 0.5);
            scene.add(beamGroup);
            
            // ===== PARTIKEL (DEBU CAHAYA) =====
            const particleCount = 1000;
            const particleGeo = new THREE.BufferGeometry();
            const particlePositions = new Float32Array(particleCount * 3);
            const particleColors = new Float32Array(particleCount * 3);
            
            for (let i = 0; i < particleCount; i++) {
                // Sebar partikel di sekitar proyektor
                particlePositions[i*3] = (Math.random() - 0.5) * 18;
                particlePositions[i*3+1] = Math.random() * 7;
                particlePositions[i*3+2] = (Math.random() - 0.5) * 16 - 2;
                
                // Warna biru keputihan
                particleColors[i*3] = 0.7 + 0.3 * Math.random();
                particleColors[i*3+1] = 0.8 + 0.2 * Math.random();
                particleColors[i*3+2] = 1.0;
            }
            
            particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
            particleGeo.setAttribute('color', new THREE.BufferAttribute(particleColors, 3));
            
            const particleMat = new THREE.PointsMaterial({ 
                size: 0.1, 
                vertexColors: true,
                transparent: true, 
                opacity: 0.5,
                blending: THREE.AdditiveBlending
            });
            const particles = new THREE.Points(particleGeo, particleMat);
            scene.add(particles);
            
            // ===== GRID LANTAI =====
            const gridHelper = new THREE.GridHelper(24, 24, 0x3377ff, 0x224488);
            gridHelper.position.y = -0.2;
            scene.add(gridHelper);
            
            // ===== BINTANG JAUH =====
            const starsGeo = new THREE.BufferGeometry();
            const starsPos = new Float32Array(400 * 3);
            for (let i = 0; i < 400; i++) {
                starsPos[i*3] = (Math.random() - 0.5) * 50;
                starsPos[i*3+1] = (Math.random() - 0.5) * 40;
                starsPos[i*3+2] = (Math.random() - 40) * 2 - 15;
            }
            starsGeo.setAttribute('position', new THREE.BufferAttribute(starsPos, 3));
            const starsMat = new THREE.PointsMaterial({ color: 0xaaccff, size: 0.12, transparent: true, blending: THREE.AdditiveBlending });
            const stars = new THREE.Points(starsGeo, starsMat);
            scene.add(stars);
            
            // ===== ANIMASI =====
            let clock = new THREE.Clock();
            
            function animate() {
                requestAnimationFrame(animate);
                
                const delta = clock.getDelta();
                const elapsedTime = performance.now() / 1000;
                
                // Animasi proyektor bergerak (rotasi dan floating)
                proyektorGroup.rotation.y = 0.3 + Math.sin(elapsedTime * 0.2) * 0.2;
                proyektorGroup.position.y = 0.8 + Math.sin(elapsedTime * 0.6) * 0.15;
                proyektorGroup.rotation.x = Math.sin(elapsedTime * 0.3) * 0.05;
                
                // Animasi beam (intensitas cahaya)
                const pulse = Math.sin(elapsedTime * 3) * 0.5 + 0.5;
                beam.material.opacity = 0.2 + pulse * 0.2;
                beam2.material.opacity = 0.15 + pulse * 0.15;
                
                // Animasi partikel berputar
                particles.rotation.y += 0.0004;
                particles.rotation.x += 0.0002;
                
                // Animasi lampu bergerak
                projectorLight.position.x = 1.8 + Math.sin(elapsedTime * 0.7) * 0.4;
                projectorLight.position.y = 2.2 + Math.sin(elapsedTime * 1.1) * 0.3;
                projectorLight.intensity = 2.5 + Math.sin(elapsedTime * 4) * 1.0;
                
                // Animasi bintang berputar lambat
                stars.rotation.y += 0.0002;
                
                renderer.render(scene, camera);
            }
            
            animate();
            
            // Resize handler
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        })();
    </script>
</body>
</html>
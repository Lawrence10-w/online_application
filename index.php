<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Application System</title>
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Hero Section */
        .enhanced-hero {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 80px;
            position: relative;
            overflow: hidden;
        }
        
        .enhanced-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,197.3C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: center bottom;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-align: center;
            min-width: 150px;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: #ff6b6b;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background-color: white;
            color: #6a11cb;
        }
        
        /* Features Section */
        .enhanced-features {
            display: flex;
            gap: 40px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 80px;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            flex: 1;
            min-width: 300px;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 25px;
            border: 3px solid #f0f0f0;
            padding: 5px;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        
        .feature-card h3 {
            font-size: 1.75rem;
            margin-bottom: 15px;
            color: #333;
        }
        
        .feature-card p {
            color: #666;
            font-size: 1.1rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
            
            .enhanced-features {
                flex-direction: column;
                align-items: center;
            }
            
            .feature-card {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .enhanced-hero {
                padding: 60px 0;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .feature-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="hero-section enhanced-hero">
            <div class="hero-content">
                <h1>Welcome to the Online Application System</h1>
                <p>Your gateway to applying for courses, managing students, and simplifying academic workflows.</p>
                <div class="cta-buttons">
                    <a href="login.php" class="btn btn-primary">Login</a>
                    <a href="register.php" class="btn btn-secondary">Apply Now</a>
                </div>
            </div>
        </section>

        <section class="features enhanced-features">
            <div class="feature-card">
                <img src="https://i.pinimg.com/originals/48/a3/54/48a354314bb3517dabc705eb3ee8b968.jpg" alt="Student Icon" class="feature-icon">
                <h3>For Students</h3>
                <p>Apply for your desired courses, upload documents, and track your application progress easily.</p>
            </div>
            <div class="feature-card">
                <img src="https://i.pinimg.com/originals/48/a3/54/48a354314bb3517dabc705eb3ee8b968.jpg" alt="Staff Icon" class="feature-icon">
                <h3>For Staff</h3>
                <p>Streamline student management, review applications, and oversee academic operations effortlessly.</p>
            </div>
        </section>
    </div>
</body>
</html>

<?php
require_once 'utils.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EduAfrica</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #ffffff;
            line-height: 1.6;
        }

        /* Navigation styles */
        nav {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background-color: rgba(18, 18, 18, 0.9);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        nav ul {
            list-style: none;
        }

        nav li {
            margin: 10px 0;
        }

        .nav-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 8px 16px;
            display: block;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #4CAF50;
            transform: translateX(5px);
        }

        /* Section styles */
        section {
            min-height: 100vh;
            padding: 80px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            scroll-snap-align: start;
        }

        section:nth-child(odd) {
            background-color: #1a1a1a;
        }

        section:nth-child(even) {
            background-color: #212121;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Typography */
        h1 {
            font-size: 3.5rem;
            margin-bottom: 30px;
            color: #4CAF50;
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 25px;
            color: #4CAF50;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #e0e0e0;
            max-width: 800px;
        }

        /* List styles */
        ul {
            list-style-position: inside;
            margin-bottom: 20px;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: #e0e0e0;
        }

        /* Button styles */
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Footer styles */
        footer {
            background-color: #121212;
            color: #999999;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            nav {
                background-color: #121212;
                width: 100%;
                top: 0;
                left: 0;
                border-radius: 0;
            }

            nav ul {
                display: flex;
                justify-content: space-around;
            }

            section {
                padding: 100px 20px;
            }

            h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="#hero" class="nav-link">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
            <li><a href="#get-started" class="nav-link">Get Started</a></li>
        </ul>
    </nav>

    <section id="hero" class="section">
        <div class="container">
            <h1>Welcome to EduAfrica</h1>
            <p>Empowering African education through accessible opportunities and resources.</p>
        </div>
    </section>

    <section id="about" class="section">
        <div class="container">
            <h2>About EduAfrica</h2>
            <p>EduAfrica aims to bridge the educational gap in Africa by providing a centralized platform that caters to the diverse needs of students, and organizations. We offer access to scholarships, and support for educational initiatives, empowering individuals and communities to achieve their educational goals.</p>
        </div>
    </section>

    <section id="services" class="section">
        <div class="container">
            <h2>Our Services</h2>
            <ul>
                <li>Browse available scholarships</li>
                <li>Apply for scholarships online</li>
                <li>Track your application status</li>
            </ul>
        </div>
    </section>

    <section id="contact" class="section">
        <div class="container">
            <h2>Contact Us</h2>
            <p>If you have any questions or need support, feel free to reach out to us.</p>
            <p>Email: info@eduafrica.org</p>
            <p>Phone: +254 123 456 789</p>
        </div>
    </section>

    <section id="get-started" class="section">
        <div class="container">
            <h2>Get Started</h2>
            <?php if (isLoggedIn()): ?>
                <a href="dashboard.php" class="button">Go to Dashboard</a>
            <?php else: ?>
                <a href="login.php" class="button">Login</a>
                <a href="signup.php" class="button">Sign Up</a>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 EduAfrica</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.nav-link');
            
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

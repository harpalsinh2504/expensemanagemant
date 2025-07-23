<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExpensePro - Professional Expense Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --secondary: #60a5fa;
            --accent: #10b981;
            --background: #f8fafc;
            --text: #1f2937;
            --muted: #6b7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .navbar {
            background: #fff;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            color: var(--primary);
        }

        .navbar-logo {
            width: 40px;
            height: 40px;
            margin-right: 12px;
            transition: transform 0.3s ease;
        }

        .navbar-logo:hover {
            transform: rotate(360deg);
        }

        .nav-link {
            font-weight: 500;
            color: var(--text);
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .hero-section {
            padding: 120px 0 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .hero-bg-illustration {
            position: absolute;
            right: -50px;
            bottom: -50px;
            width: 500px;
            opacity: 0.1;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-desc {
            font-size: 1.25rem;
            font-weight: 300;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .btn-primary {
            background: var(--accent);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat {
            text-align: center;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
        }

        .stat-label {
            font-size: 1rem;
            color: rgba(255,255,255,0.8);
            font-weight: 400;
        }

        .testimonial {
            background: rgba(255,255,255,0.2);
            border-radius: 16px;
            padding: 2rem;
            max-width: 700px;
            margin: 3rem auto 0;
            font-style: italic;
            font-weight: 300;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .section-divider {
            width: 120px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
            margin: 3rem auto;
        }

        .card {
            border: none;
            border-radius: 16px;
            padding: 2rem;
            background: #fff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .pricing-card {
            border-radius: 16px;
            padding: 2rem;
            background: #fff;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .pricing-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            transform: translateY(-10px);
        }

        .pricing-card.popular {
            border-color: var(--accent);
            position: relative;
        }

        .pricing-card.popular::after {
            content: 'Most Popular';
            position: absolute;
            top: -15px;
            right: 20px;
            background: var(--accent);
            color: #fff;
            padding: 5px 15px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30,64,175,0.1);
        }

        .footer {
            background: #fff;
            padding: 3rem 0;
            border-top: 1px solid #e5e7eb;
            color: var(--muted);
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer a:hover {
            color: var(--secondary);
        }

        .social-icon {
            font-size: 1.5rem;
            margin: 0 0.5rem;
            transition: transform 0.3s ease;
        }

        .social-icon:hover {
            transform: scale(1.2);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-desc {
                font-size: 1rem;
            }
            .stats {
                flex-direction: column;
                gap: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo" class="navbar-logo">
                ExpensePro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary px-4" href="dashboard.php">Get Started</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center position-relative">
        <img src="https://www.transparenttextures.com/patterns/cubes.png" class="hero-bg-illustration" alt="bg-illustration">
        <div class="container hero-content">
            <h1 class="hero-title">Master Your Finances with Ease</h1>
            <p class="hero-desc">ExpensePro is your all-in-one solution for tracking, analyzing, and optimizing your expenses with a secure, intuitive, and powerful platform.</p>
            <a href="dashboard.php" class="btn btn-primary btn-lg">Start for Free</a>
            <div class="stats flex-wrap">
                <div class="stat">
                    <div class="stat-value">15K+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat">
                    <div class="stat-value">$10M+</div>
                    <div class="stat-label">Expenses Tracked</div>
                </div>
                <div class="stat">
                    <div class="stat-value">99.99%</div>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
            <div class="testimonial mx-auto">
                <i class="bi bi-quote fs-3 me-2"></i> "ExpensePro transformed how I manage my business finances. The insights and ease of use are unmatched!"<br>
                <span class="fw-bold mt-2 d-block">— Sarah J., Entrepreneur</span>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Powerful Features for Financial Control</h2>
                <p class="text-muted">Discover the tools that make expense management effortless and insightful.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h5 class="fw-bold">Smart Expense Tracking</h5>
                        <p class="text-muted">Effortlessly log, categorize, and manage expenses with real-time insights and receipt uploads.</p>
                        <ul class="list-unstyled text-start small mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Automated categorization</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Recurring expense tracking</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cloud-based receipt storage</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multi-currency support</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="feature-icon">
                            <i class="bi bi-pie-chart"></i>
                        </div>
                        <h5 class="fw-bold">Advanced Analytics</h5>
                        <p class="text-muted">Gain deep insights with customizable dashboards, detailed reports, and predictive trends.</p>
                        <ul class="list-unstyled text-start small mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Interactive charts</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Export to PDF/Excel/CSV</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Spending forecasts</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Budget tracking</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h5 class="fw-bold">Enterprise-Grade Security</h5>
                        <p class="text-muted">Your data is safe with industry-leading encryption and compliance standards.</p>
                        <ul class="list-unstyled text-start small mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>256-bit AES encryption</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>GDPR & CCPA compliant</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Multi-factor authentication</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Regular security audits</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Flexible Pricing Plans</h2>
                <p class="text-muted">Choose the plan that best suits your financial management needs.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="pricing-card h-100 text-center">
                        <h5 class="fw-bold">Starter</h5>
                        <div class="display-5 fw-bold my-3">Free</div>
                        <p class="text-muted">Perfect for individuals starting out.</p>
                        <ul class="list-unstyled mb-4">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Basic expense tracking</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Standard analytics</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Email support</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Single user</li>
                        </ul>
                        <a href="dashboard.php" class="btn btn-outline-primary w-100">Get Started</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-card h-100 text-center popular">
                        <h5 class="fw-bold text-primary">Pro</h5>
                        <div class="display-5 fw-bold my-3">$9<span class="fs-5">/mo</span></div>
                        <p class="text-muted">Ideal for freelancers and small businesses.</p>
                        <ul class="list-unstyled mb-4">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>All Starter features</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Receipt uploads</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Advanced reports</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Priority support</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Up to 3 users</li>
                        </ul>
                        <a href="dashboard.php" class="btn btn-primary w-100">Try Pro</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-card h-100 text-center">
                        <h5 class="fw-bold">Enterprise</h5>
                        <div class="display-5 fw-bold my-3">Custom</div>
                        <p class="text-muted">Tailored for large organizations.</p>
                        <ul class="list-unstyled mb-4">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>All Pro features</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Custom integrations</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Dedicated account manager</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited users</li>
                        </ul>
                        <a href="#contact" class="btn btn-outline-primary w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="fw-bold mb-3">Get in Touch</h2>
                    <p class="text-muted mb-4">We're here to answer your questions and provide support.</p>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary px-4">Send Message</button>
                    </form>
                </div>
                <div class="col-md-5 offset-md-1 d-flex flex-column justify-content-center">
                    <div class="mb-3">
                        <i class="bi bi-envelope-fill me-2 text-primary"></i> 
                        <a href="mailto:support@expensepro.com">support@expensepro.com</a>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i> 
                        123 Finance Ave, Suite 100, New York, NY 10001
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i> 
                        +1 (555) 123-4567
                    </div>
                    <div class="mt-4">
                        <span class="fw-bold">Follow us:</span>
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    © 2025 ExpensePro. All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#features" class="me-3">Features</a>
                    <a href="#pricing" class="me-3">Pricing</a>
                    <a href="#contact">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TodoDo - Task Management</title>
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
      rel="stylesheet"
    />
    <style>
      :root {
        --primary-color: #4154f1;
        --secondary-color: #012970;
        --light-background: #f6f9ff;
      }

      body {
        font-family: system-ui, -apple-system, "Segoe UI", Roboto,
          "Helvetica Neue", Arial, sans-serif;
      }

      .navbar {
        background: rgba(255, 255, 255, 0.95);
        padding: 15px 0;
        box-shadow: 0 2px 20px rgba(1, 41, 112, 0.1);
      }

      .navbar-brand {
        font-size: 24px;
        font-weight: 700;
        color: var(--secondary-color);
      }

      .nav-link {
        color: var(--secondary-color);
        font-weight: 500;
        padding: 10px 15px;
      }

      .btn-primary {
        background: var(--primary-color);
        border: none;
        padding: 8px 20px;
        border-radius: 4px;
        transition: 0.3s;
      }

      .btn-primary:hover {
        background: #5969f3;
      }

      .hero {
        background: var(--light-background);
        padding: 100px 0;
        text-align: center;
      }

      .hero h1 {
        font-size: 48px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 20px;
      }

      .hero p {
        color: #444444;
        margin-bottom: 30px;
      }

      .features {
        padding: 80px 0;
      }

      .feature-box {
        padding: 30px;
        box-shadow: 0 0 30px rgba(1, 41, 112, 0.08);
        border-radius: 8px;
        transition: 0.3s;
        height: 100%;
        cursor: pointer;
      }

      .feature-box:hover {
        transform: translateY(-10px);
      }

      .feature-icon {
        font-size: 38px;
        color: var(--primary-color);
        margin-bottom: 20px;
      }

      .feature-box h4 {
        font-size: 20px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 15px;
      }

      .about {
        background: var(--light-background);
        padding: 80px 0;
      }

      .section-title {
        text-align: center;
        margin-bottom: 50px;
      }

      .section-title h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 20px;
      }

      .auth-form {
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        box-shadow: 0 0 30px rgba(1, 41, 112, 0.08);
        border-radius: 8px;
      }

      .dashboard-stats {
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(1, 41, 112, 0.1);
        margin-bottom: 20px;
      }

      .stat-card {
        padding: 20px;
        border-radius: 8px;
        background: var(--light-background);
        margin-bottom: 15px;
      }

      .detail-section {
        padding: 40px 0;
      }

      .detail-image {
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(1, 41, 112, 0.1);
      }

      @media (max-width: 768px) {
        .hero h1 {
          font-size: 36px;
        }

        .feature-box {
          margin-bottom: 20px;
        }

        .auth-form {
          margin: 40px auto;
          padding: 15px;
        }
      }

      footer {
        background-color: #012970;
        font-size: 14px;
        color: #f6f9ff;
        position: relative;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <a class="navbar-brand" href="index.html">TodoDo</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="#home">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features">Features</a>
            </li>
          </ul>
          <a href="public/login.php" class="btn btn-primary">Login</a>
        </div>
      </div>
    </nav>

    <section class="hero" id="home">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h1>TodoDo</h1>
            <p class="lead">
              Manage your tasks, events, and notes efficiently in one organized
              platform
            </p>
            <a href="public/signup.html" class="btn btn-primary btn-lg"
              >Get Started</a
            >
          </div>
        </div>
      </div>
    </section>

    <section class="features" id="features">
      <div class="container">
        <div class="section-title">
          <h2>Features</h2>
          <p>
            Discover the tools that will help you stay organized and productive
          </p>
        </div>
        <div class="row g-4">
          <div class="col-lg-4">
            <div
              class="feature-box"
              onclick="location.href='feature-details.html#organized'"
            >
              <i class="bi bi-list-check feature-icon"></i>
              <h4>Organized Structure</h4>
              <p>
                Keep all your tasks and notes organized efficiently in one
                platform. No more switching between different apps.
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div
              class="feature-box"
              onclick="location.href='feature-details.html#priority'"
            >
              <i class="bi bi-alarm feature-icon"></i>
              <h4>Priority Management</h4>
              <p>
                Set priorities for your tasks and manage your time more
                effectively with our intuitive priority system.
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div
              class="feature-box"
              onclick="location.href='feature-details.html#calendar'"
            >
              <i class="bi bi-calendar-check feature-icon"></i>
              <h4>Integrated Calendar</h4>
              <p>
                View all your tasks and events in an integrated calendar to stay
                on top of your schedule.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="text-center p-3">
      <span>Copyright by </span>
      22552011038_Ezra Ben Hanschel_TIF RP 22 CID
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

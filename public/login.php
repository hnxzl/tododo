<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tododo | Login</title>
    <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>
  <body
    class="d-flex align-items-center"
    style="min-height: 100vh; background-color: #f8f9fa"
  >
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <h3 class="text-center mb-4">Login to Tododo</h3>
          <form action="../actions/login.php" method="POST">
            <div class="form-group">
              <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Email"
                required
              />
            </div>
            <div class="form-group">
              <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required
              />
            </div>
              <button type="submit" class="btn btn-primary btn-block">
                Login
              </button>
          </form>
          <p class="text-center mt-3">
            <a href="signup.html">Create an Account</a> |
            <a href="forgot_password.html">Forgot Password?</a>
          </p>
        </div>
      </div>
    </div>
  </body>
</html>

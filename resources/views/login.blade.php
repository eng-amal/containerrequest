<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="author" content="Muhamad Nauval Azhar" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta
      name="description"
      content="This is a login page template based on Bootstrap 5"
    />
    <title>Login Page</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
      crossorigin="anonymous"
    />
  </head>

  <body>
    <div
      class="bg-image"
      style="
        background-image: url('https://www.icontainers.com/static/bbe85adac67b66cb3d1792904539b726/3de61/Header_2_fd7a8e19ab.jpg');
        height: 100vh;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      "
    >
      <section class="h-100">
        <div class="container h-100">
          <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
              <div class="text-center my-5">
                <img
                  src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg"
                  alt="logo"
                  width="100"
                />
              </div>
              <div
                class="card shadow-lg"
                style="background-color: rgba(245, 245, 245, 0.13)"
              >
                <div class="card-body p-5">
                  <h1
                    class="fs-4 card-title text-light text-center fw-bold mb-4"
                  >
                    LOGIN
                  </h1>
                  <form
                  action="{{ route('login') }}"
                    method="POST"
                    class="needs-validation"
                    novalidate=""
                    autocomplete="off"
                  >
                  @csrf
                    <div class="mb-3">
                      <label class="mb-2 text-light" for="username"
                        >username</label
                      >
                      <input
                        id="username"
                        type="text"
                        class="form-control"
                        name="username"
                        value=""
                        required
                        autofocus
                      />
                    </div>

                    <div class="mb-3">
                      <div class="mb-2 w-100">
                        <label class="text-light" for="password"
                          >Password</label
                        >
                      </div>
                      <input
                        id="password"
                        type="password"
                        class="form-control"
                        name="password"
                        required
                        autocomplete="current-password"
                      />
                    </div>

                    <div class="d-flex align-items-center">
                      <button type="submit" class="btn btn-primary ms-auto">
                        Login
                      </button>
                    </div>
                  </form>
                  @if ($errors->any())
                <div class="alert alert-danger mt-3">
                 <ul>
                 @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                 @endforeach
                </ul>
                </div>
               @endif
                </div>
              </div>
              <div class="text-center mt-5 text-muted">
                Copyright &copy; 2024-2025 &mdash; Your Company
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
  </body>
</html>

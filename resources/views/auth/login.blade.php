@extends('layouts.app')

@section('content')
    <!DOCTYPE html>

    <!-- =========================================================
    * Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
    ==============================================================

    * Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
    * Created by: ThemeSelection
    * License: You must have a valid license purchased in order to legally use the theme for your project.
    * Copyright ThemeSelection (https://themeselection.com)

    =========================================================
     -->
    <!-- beautify ignore:start -->
    <html
      lang="en"
      class="light-style customizer-hide"
      dir="ltr"
      data-theme="theme-default"
      data-assets-path="../assets/"
      data-template="vertical-menu-template-free"
    >
      <head>
        <meta charset="utf-8" />
        <meta
          name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
        />

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet"
        />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/vendor/fonts/boxicons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/vendor/css/pages/page-auth.css" />
        <!-- Helpers -->
        <script src="{{ asset('backend') }}/assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('backend') }}/assets/js/config.js"></script>
      </head>

      <body>

       
        <!-- Content -->

        <div class="container-xxl">
          <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
              <!-- Register -->
              <div class="card">
                <div class="card-body">
                  <!-- Logo -->
                  
                  <!-- /Logo -->
                   <span class="app-brand-logo">
                    <img class="mx-auto mb-3" src="{{ asset('backend/assets/img/logo/logo.png') }}" alt="Logo" width="50%">
                  </span>

                   <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class=" mb-3">
                      <label for="login" class="form-label">Email or Number</label>
                      <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autofocus placeholder="Email or Phone">
                       @error('login')
        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
    @enderror
                    </div>


                    <div class="form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label">Password</label>
                            
                        </div>

                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                            >
                            <span class="input-group-text cursor-pointer">
                                <i class="bx bx-hide"></i> <!-- Optional icon for toggle -->
                            </span>
                        </div>

                        @error('password')
        <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
    @enderror
                    </div>




                      
        </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input
                            class="form-check-input ms-1"
                            type="checkbox"
                            id="remember"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                            >
                            <label class="form-check-label ms-1" for="remember">
                            Remember Me
                            </label>
                        </div>
                        </div>


                    <div class="mb-3 d-flex justify-content-center">
                      <button class="btn btn-primary" style="width:350px;" type="submit">{{ __('Login') }}</button>
                    </div>
                  </form>

                  
                </div>
              </div>
              <!-- /Register -->
            </div>
          </div>
        </div>

        <!-- / Content -->


        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ asset('backend') }}/assets/vendor/libs/jquery/jquery.js"></script>
        <script src="{{ asset('backend') }}/assets/vendor/libs/popper/popper.js"></script>
        <script src="{{ asset('backend') }}/assets/vendor/js/bootstrap.js"></script>
        <script src="{{ asset('backend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="{{ asset('backend') }}/assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->

        <!-- Main JS -->
        <script src="{{ asset('backend') }}/assets/js/main.js"></script>

        <!-- Page JS -->

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
      </body>
    </html>
@endsection

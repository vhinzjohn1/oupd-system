<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- login-header style -->
    <link rel="stylesheet" href="{{ asset('css/login_header.css') }}">
    <!-- login style -->
    <link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}">


    <!----- AOS Animations ---->
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">

    <script src="{{ asset('js/aos.js') }}"></script>


    <script src="../../plugins/jquery/jquery.min.js"></script>

    <style>
        .login-card {
            position: relative;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border-radius: 30px;
            /* background: #e0e0e0; */
            box-shadow: 15px 15px 30px #bebebe, -15px -15px 30px #ffffff;
        }

        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <header data-aos="fade-down">
        <a href="#" class="logo"><img src="{{ asset('img/cmulogo.png') }}" alt="cmu logo"><span>Central Mindanao
                University</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
            <li><a href="#home">Home</a></li>
            {{-- <li><a href="#appointment">Projects</a></li>
            <li><a href="#achievements">Achievements</a></li> --}}
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </header>
    <section class="home" id="home">
        <div data-aos="fade-right" data-aos-mirror="true" class="home-text">
            <span>Welcome to</span>
            <h1>Office of the University Planning and Development</h1>
            <h2>Construction Cost Estimate System</h2>

        </div>
        <div data-aos="flip-left" data-aos-mirror="true" data-aos-duration="1100" class="login-card"
            style="width: 450px;">
            <img src="{{ asset('img/oupd logo.png') }}" alt="OUPD logo" class="img-responsive centered-logo"
                style="display:inline-block; width: 60%; height: auto; margin: auto; margin-top:30px;">
            <div class="login-card-body" style="margin-top: 30px;">
                @yield('content')
            </div>
        </div>
    </section>
    {{-- <div class="achievement-overlay">
        <section class="achievements" id="appointment">
            <div class="achievements-heading">
                <span>Department's</span>
                <h1>ACHIEVEMENTS</h1>
            </div>
            <div class="achievements-container">
                <div class="box">
                    <div class="box-img" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/outpatient.jpg"
                            alt="" style="width: 100%; height: auto;">
                    </div>


                    <h2>Outpatient Services</h2>
                    <p>Convenient and efficient medical care for non-emergency situations.</p>

                    <a href="out_patient_services" class="btn btn-primary">Set Appontment</a>
                </div>
                <div class="box">
                    <div class="box-img" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/dental.jpg" alt=""
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>


                    <h2>Dental Services</h2>
                    <p>Your smile, our priority. From cleanings to treatments.</p>
                    <a href="dental_services" class="btn btn-primary">Set Appontment</a>
                </div>
                <div class="box">
                    <div class="box-img" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/laboratory.png"
                            alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>


                    <h2>Laboratory</h2>
                    <p>Fast, accurate results for your health needs.</p>
                    <a href="laboratory_services" class="btn btn-primary">Set Appontment</a>
                </div>
                <div class="box">
                    <div class="box-img" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/radiology.jpg" alt=""
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>


                    <h2>Radiology</h2>
                    <p>Advanced technology for clearer diagnoses.</p>
                    <a href="radiology_services" class="btn btn-primary">Set Appontment</a>
                </div>
            </div>
        </section>
    </div> --}}

    {{-- <div class="achievement-overlay">
        <section class="achievements" id="achievements">
            <div class="achievements-heading">
                <span>Department's</span>
                <h1>ACHIEVEMENTS</h1>
            </div>
            <div class="achievements-container">
                <div class="box">
                    <div class="box-img">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/cmu_ohs.png" alt="">
                    </div>

                    <h2>ISO 9001:2015 Certified</h2>

                    <a href="#" class="btn">Order Now</a>
                </div>
                <div class="box">
                    <div class="box-img">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/cmu_ohs.png" alt="">
                    </div>

                    <h2>ISO 9001:2015 Certified</h2>

                    <a href="#" class="btn">Order Now</a>
                </div>
                <div class="box">
                    <div class="box-img">
                        <img src="http://172.16.0.69/weljoLaravel/assets/adminlte/dist/img/cmu_ohs.png" alt="">
                    </div>

                    <h2>ISO 9001:2015 Certified</h2>

                    <a href="#" class="btn">Order Now</a>
                </div>
            </div>
        </section>
    </div> --}}

    <section class="about" id="about">
        <div class="about-heading" data-aos="fade-down" data-aos-duration="1200">
            <span>Department's</span>
            <h1>Mission and Vision</h1>
        </div>
        <div class="container" data-aos="zoom-in-right" data-aos-duration="1000">
            <div class="about-img">
                <img src="{{ asset('img/cmuadmin.png') }}" alt="cmu admin">
            </div>
            <div class="about-text">
                <h2>MISSION</h2>
                <p>To advance the frontier of knowledge through internationalization of education and equitable access
                    to quality instruction, research, extension and production for economic prosperity, moral integrity,
                    social and cultural sensitivity and environmental consciousness.</p>

            </div>
        </div>
        <div class="container" data-aos="zoom-in-left" data-aos-duration="1000">
            <div class="about-text">
                <h2>VISION</h2>
                <p>A leading ASEAN university actively committed to the total development of people for a globally
                    sustainable environment and a humane society.</p>


            </div>
            <div class="about-img">
                <img src="{{ asset('img/main_gate.png') }}" alt="cmu maingate">
            </div>

        </div>
    </section>

    <section class="contact" id="contact">
        {{-- <div class="social">
            <a href="#"><i class="bx bxl-twitter"></i></a>
            <a href="#"><i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-instagram"> </i></a>
        </div>
        <div class="links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Use</a>
            <a href="#">Our Company</a>
        </div> --}}
        <p>
            &#169; Software Development Department 2024. All Rights Reserved.
        </p>
    </section>
    @vite('resources/js/app.js')

    <script>
        AOS.init();
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>

</html>

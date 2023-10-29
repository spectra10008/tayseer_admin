<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>تي جوينت - طلب تمويل</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" href="{{ asset('/img/1.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/1.png') }}">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('frontend/form_request/css/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/form_request/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/form_request/css/owl.theme.default.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('frontend/form_request/css/main.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body dir="rtl">
    <!-- End Loading Section -->
    <header class="abstract-grey" style="background-color: #f4f4f7;">
        <!-- Start Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light pt-4 pb-4">
            <div class="container" dir="ltr">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('frontend/form_request/images/s.png') }}" alt=""
                        class="d-inline-block align-text-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <section>
        <div class="hero_section mb-5">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('frontend/form_request/images/banner_1.png') }}" class="d-block"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('frontend/form_request/images/banner_2.jpg') }}" class="d-block"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('frontend/form_request/images/banner_3.jpg') }}" class="d-block"
                            alt="...">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @yield('content')
    <!-- End Contact US From -->
    <!-- Start Footer -->

    <!-- End Footer -->
    <!-- Start Copyright -->
    <div class="copyright text-center p-3 mt-5">
        2023 © تي جوينت ، كل الحقوق محفوظة
    </div>
    <!-- End Copyright -->
    <!-- Javascript files -->
    <script src="{{ asset('frontend/form_request/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/form_request/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/form_request/js/all.min.js') }}"></script>
    <script src="{{ asset('frontend/form_request/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/form_request/js/main.js') }}"></script>
    <script src="{{ asset('frontend/form_request/js/carousel-rtl.js') }}"></script>
    <script>
        //your javascript goes here
        var currentTab = 0;
        document.addEventListener("DOMContentLoaded", function(event) {


            showTab(currentTab);

        });

        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "ارسال";
                document.getElementById("nextBtn").prop("type", "button");
            } else {
                document.getElementById("nextBtn").innerHTML = "التالي";
            }
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) return false;
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                document.getElementById('regForm').submit();
                // document.getElementById("regForm").submit();
                // return false;
                //alert("sdf");
                // document.getElementById("nextprevious").style.display = "none";
                // document.getElementById("all-steps").style.display = "none";
                // document.getElementById("register").style.display = "none";
                // document.getElementById("text-message").style.display = "block";
            }
            showTab(currentTab);
        }

        function validateForm() {
            var x, y, z, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByClassName("required");
            // z = x[currentTab].getElementsByTagName("select");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " invalid is-invalid";
                    valid = false;
                }
            }
            // for (i = 0; i < z.length; i++) {
            //     if (z[i].value == "") {
            //         z[i].className += " invalid is-invalid";
            //         valid = false;
            //     }
            // }
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid;
        }

        function fixStepIndicator(n) {
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            x[n].className += " active";
        }
    </script>

    <?php $old_is_bank = old('is_bank_account'); ?>
    <script>
        $(document).ready(function() {
            if (@json($old_is_bank) == 1) {
                $('.bank_id').removeClass('d-none');
                $('.branch_name').removeClass('d-none');
                $('.account_no').removeClass('d-none');
            }
            $("select[name='is_bank_account']").change(function() {
                var select_id = this.value;
                if (select_id == 1) {
                    $('.bank_id').removeClass('d-none');
                    $('.branch_name').removeClass('d-none');
                    $('.account_no').removeClass('d-none');

                    $('select[name="bank_id"]').addClass('required');
                    $('input[name="account_no"]').addClass('required');
                    $('input[name="branch_name"]').addClass('required');

                } else {
                    $('.bank_id').addClass('d-none');
                    $('.branch_name').addClass('d-none');
                    $('.account_no').addClass('d-none');

                    $('select[name="bank_id"]').removeClass('required');
                    $('input[name="account_no"]').removeClass('required');
                    $('input[name="branch_name"]').removeClass('required');
                }
            });
        });
    </script>
</body>

</html>

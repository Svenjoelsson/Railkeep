<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.css"
        integrity="sha512-EzrsULyNzUc4xnMaqTrB4EpGvudqpetxG/WNjCpG6ZyyAGxeB6OBF9o246+mwx3l/9Cn838iLIcrxpPHTiygAA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
        integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
        integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        integrity="sha512-aEe/ZxePawj0+G2R+AaIxgrQuKT68I28qh+wgLrcAJOz3rxCP+TwrK5SPN+E5I+1IQjNtcfvb96HDagwrKRdBw=="
        crossorigin="anonymous" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single  {
            height: 38px !important;
            border: #cfd4d9 thin solid;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

        .btn-secondary {
            background-color: white;
            color: #000;
        }

        .btn-secondary:hover {
            background-color: white;
            color: #000;
            text-decoration: underline;
        }


        #loader {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #444444;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }
          
        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
          
        .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }
    </style>
    

    @stack('third_party_stylesheets')

    @stack('page_css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    
    <div class="wrapper"><div id="loader" class="center"></div>
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                        @if (Auth::user()->photo)
                            <img src="{{ Auth::user()->photo }}" class="user-image img-circle elevation-2"
                                alt="User Image">
                        @else
                            <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                class="user-image img-circle elevation-2" alt="User Image">
                        @endif

                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header">
                            @if (Auth::user()->photo)
                                <img src="{{ Auth::user()->photo }}" class="user-image img-circle elevation-2"
                                    alt="User Image">
                            @else
                                <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                    class="user-image img-circle elevation-2" alt="User Image">
                            @endif
                            <p>
                                {{ Auth::user()->name }}
                                <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                            </p>
                            @if(Auth::user()->is_admin == '1')
                            <p>
                                <small>Administrator</<small>
                            </p>
                            @endif
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="profile" class="btn btn-default btn-flat">Profile</a>
                            <a href="#" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"
        integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"
        integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg=="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.3/bootstrapSwitch.min.js"
        integrity="sha512-DAc/LqVY2liDbikmJwUS1MSE3pIH0DFprKHZKPcJC7e3TtAOzT55gEMTleegwyuIWgCfOPOM8eLbbvFaG9F/cA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        
    




        
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>

    <script>

document.onreadystatechange = function() {
    if (document.readyState !== "complete") {
        document.querySelector("body").style.visibility = "hidden";
        document.querySelector("#loader").style.visibility = "visible";
    } else {
        document.querySelector("#loader").style.display = "none";
        document.querySelector("body").style.visibility = "visible";
    }
};

        
        $(function() {
            bsCustomFileInput.init();
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });



        $('.serviceSelect').val(null).trigger('change');

            $('.js-example-basic-single').select2({
                //dropdownParent: $('#newinventory'),
                placeholder: 'Select an option',
                width: '100%',
            });

            $('.js-example-basic-single-modal').select2({
                dropdownParent: $('#newinventory'),
                placeholder: 'Select an option',
                width: '100%',
            });

            $('.serviceSelect').select2({
                placeholder: 'Select an option',
                allowClear: true,

            });


            // Change active
            var activeTabs = window.localStorage.getItem('activeTab');
            if (activeTabs) {
                var activeTabs = (window.localStorage.getItem('activeTab') ? window.localStorage.getItem(
                    'activeTab').split(',') : []);
                $.each(activeTabs, function(index, element) {
                    console.log(element);
                    $('[data-toggle="tab"][href="' + element + '"]').tab('show');
                });
            }

        $('.testselect').change(function() {
            var email = $('.testselect').val();
            $('#vendorEmail').val(email);
        });

        // Store activeTab 
        $('.nav-link').click(function(e) {
            window.localStorage.setItem('activeTab', $(e.target).attr('href'));

        });

        $('.unitSelect').change(function() {
            $('.serviceSelect').empty();
            var unitId = $('.unitSelect').val();
            var data = {
                id: 1,
                text: 'Barn owl'
            };
            $.get("{{ url('api/units/') }}",
                function(data2) {
                    $.each(data2.data, function(index, element2) {
                        if ($('.unitSelect').val() === element2.unit) {
                            $('.customerSelect').val(element2.customer);
                            $('.customerSelect').trigger('change.select2');
                            $('.customerSelectDisable').prop("disabled", true);

                            //console.log(element2.make);

                            // Load service types based on unit
                            $.get("{{ url('api/make_lists/') }}", function(data3) {
                                var arr = [];
                                $.each(data3.data, function(index3, element3) {
                                    //console.log(element3);
                                    
                                    if (element2.make == element3.make) {
                                        
                                        //arr.push(element3.serviceName);
                                        var newOption = new Option(element3.serviceName, element3.serviceName, false, false);
                                        $('.serviceSelect').append(newOption).trigger('change');    
                                        //arr[element3.serviceName] = element3.serviceName;
                                        //console.log(element3.serviceName);
                                        /*$('.contactpersons').append($('<option>', {
                                            value: element1.name,
                                            text: element1.name

                                        }));*/
                                    }
                                    
                                });
                                var newOption1 = new Option('Reparation', 'Reparation', false, false);
                                $('.serviceSelect').append(newOption1).trigger('change');   
                                var newOption2 = new Option('Övrigt', 'Övrigt', false, false);
                                $('.serviceSelect').append(newOption1).trigger('change');   
                                //console.log(arr);
                                //$('.serviceSelect').val(arr).trigger('change');
                                //$('.serviceSelect').val(arr);
                                //var newOption = new Option(data.text, data.id, false, false);
                                //$('.serviceSelect').append(newOption).trigger('change');        

                                //$('.serviceSelect').trigger('change');
                                
                                
                            });




                            // Load contacts connected to this customer.
                            $.get("{{ url('api/contacts/') }}", function(data1) {
                                $('.contactpersons').empty();
                                $.each(data1.data, function(index1, element1) {
                                    if (element1.customer == element2.customer) {
                                    
                                        $('.contactpersons').append($('<option>', {
                                            value: element1.name,
                                            text: element1.name
                                        }));
                                    }
                                });
                            });

                        }
                    });
                });
        });

        <?php 
        if (isset($_GET["unit"])) { ?>
            $('.unitSelect').val(<?php echo $_GET["unit"] ?>).trigger('change').trigger('select2:select');
        <?php } ?>

        $('.vendorSelect').change(function() {
            var vendor = $('.vendorSelect').val();
            $.get("{{ url('api/vendors/') }}",
                function(data) {
                    $.each(data.data, function(index, element) {
                        if ($('.vendorSelect').val() === element.name) {
                            $('#vendorEmail').val(element.contact_email);
                        }
                    });
                });
        });


        /*$('.serviceSelect').change(function() {
            $('.descSelect').empty();
            var select = $('.serviceSelect').val();
            var unit = $('.unitSelect').val();
            $.each(select, function(index, x) {
                $.get("{{ url('api/service_types/') }}",
                    function(data) {

                        $.each(data.data, function(index, element) {

                            if (x === element.service_type) {
                                $('.descSelect').append(element.service_desc + '\n');
                            }
                        });
                    });
            });
        });*/

        $('.clearField').click(function() {
            $('.descSelect').empty();
            $('.serviceSelect').val(null).trigger('change');

        });

        $('.makeBlur').blur(function() {
            
            $.get("{{ url('api/make_lists/') }}",
                function(makelist) {
                    var thislist = $('.makeBlur').val();

                    $.each(makelist.data, function(index, element) {
                        if (thislist === element.make) {
                            $('.counterType').val(element.counterType).trigger('change');
                        }
                    });
                });
        });

        
        $('.makeSelect').change(function() {
            var select = $('.makeSelect').val();
            $.get("{{ url('api/make_lists/') }}",
                function(data) {
                    $.each(data.data, function(index, element) {
                        //console.log(element.make);
                        if (select === element.make) {
                            $('.maintenanceType').val(element.counterType).trigger('change');
                        }
                    });
            });
        });

        $("#updatePeriod").click(function(){
            var url = $('#url').val();
            var period = $('#period1').val();
            window.location.href = "/"+url+"/"+period;
        });


    </script>

    @stack('third_party_scripts')

    @stack('page_scripts')
</body>

</html>

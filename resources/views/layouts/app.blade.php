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

    <!--<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>-->

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
        .custom-select {
            min-width: 50px;
            background-color: white !important;
        }
        .form-control {
            background-color: white !important;
        }

        .activeNav {
            background: #0f2027; /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #0f2027, #203a43, #2c5364); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color: white !important;
        }
        .solidRK {
            background-color: #2c5364 !important;
        }
        .brand-link {
            border: #2c5364 solid 1px !important;
        }
        .btn-primary, .btn-outline-primary {
            background-color: #2c5364 !important;
            border: #2c5364 solid 1px !important;

        }
        .showprofile {
            margin-top:10px;
        }
        .mac-style{
            width: 300px;
            -webkit-transition: width 1s ease-in-out;
            -moz-transition:width 1s ease-in-out;
            -o-transition: width 1s ease-in-out;
            transition: width 1s ease-in-out;
            background-color:
            float:right;
            background-color: #2c5364 !important;
            border: none;

        }

        .mac-style:focus{
            width: 500px;
            background-color: white !important;
        }

        .year {
        font-weight: bold;
        color:white !important;
        background-color:gray !important; 
    }

    .ganttWrapper {
    position: relative;
    overflow: auto;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 150px;
    min-width: 150px;
    max-width: 150px;
    left: 0px;
    background-color: white !important;
    }
    .cell {
        height: 60px;
        min-height: 60px;
        max-height: 60px;
        text-align: center;
        vertical-align: middle !important;
    }

    .second-col {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    left: 150px;
    background-color: white !important;
    }
    input::placeholder {
        color: #a4b1b8 !important;
    }
    .train_icon {
        width: 200px !important;
        height: 200px !important;
        margin-left:-15px !important;
        margin-top:-30px !important;
        background-image:url('/images/train_icon.png');
        background-repeat: no-repeat;
    }
    .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background-color: #355262 !important;
        margin-top:-58px !important; 
        border: none !important;
        color: white !important;
    }
    .leaflet-popup-close-button {
        margin-top:-58px !important; 
    }
    .datepicker {
      z-index: 9999 !important; /* has to be larger than 1050 */
    }
    .card {
        overflow: auto !important;
    }
    .content {
        overflow: auto !important;
    }
    </style>
    

    @stack('third_party_stylesheets')

    @stack('page_css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    
    <div class="wrapper"><div id="loader" class="center"></div>
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand solidRK navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            @if (auth()->user()->hasPermissionTo('use search')) 
            <form action="{{ route('globalSearch') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" class="form-control mac-style" autocomplete="off" list="searchresult" name="search" id='globalSearch' placeholder="Search...">

            </form>
            @endif
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                        @if (Auth::user()->photo)
                            <img src="/{{ Auth::user()->photo }}" class="user-image img-circle elevation-2"
                                alt="User Image">
                        @else
                            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                class="user-image img-circle elevation-2" alt="User Image">
                        @endif

                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right showprofile">
                        <!-- User image -->
                        <li class="user-header">
                            @if (Auth::user()->photo)
                                <img src="/{{ Auth::user()->photo }}" class="user-image img-circle elevation-2"
                                    alt="User Image">
                            @else
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
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
    <script src="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"></script>

    
    


    
        
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>

    <script>
        $('#globalSearch').on('change', function() {
            $(this).closest('form').submit();
        });
        $('.nav-link').on('click',function() {
            $('.navbar-collapse').collapse('hide');
        });



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
                sorter: function(data) {
                    return data.sort(function (a, b) {
                        if (a.text > b.text) {
                            return 1;
                        }
                        if (a.text < b.text) {
                            return -1;
                        }
                        return 0;
                    });
                },
                placeholder: 'Select an option',
                width: '100%',
            });

            $('.js-example-basic-service-type').select2({
                //dropdownParent: $('#newinventory'),
                sorter: function(data) {
                    return data.sort(function (a, b) {
                        if (a.text > b.text) {
                            return 1;
                        }
                        if (a.text < b.text) {
                            return -1;
                        }
                        return 0;
                    });
                },
                placeholder: 'Select an option',
                width: '100%',
            });

            
            $('.js-example-basic-single-modal').select2({
                dropdownParent: $('#newinventory'),
                placeholder: 'Select an option',
                width: '100%',
                sorter: function(data) {
                    return data.sort(function (a, b) {
                        if (a.text > b.text) {
                            return 1;
                        }
                        if (a.text < b.text) {
                            return -1;
                        }
                        return 0;
                    });
                }
            });

            $('.js-example-basic-single-modal-workshop').select2({
                dropdownParent: $('#workshop'),
                placeholder: 'Select an option',
                width: '100%',
                sorter: function(data) {
                    return data.sort(function (a, b) {
                        if (a.text > b.text) {
                            return 1;
                        }
                        if (a.text < b.text) {
                            return -1;
                        }
                        return 0;
                    });
                }
            });

            $('.serviceSelect').select2({
                placeholder: 'Select an option',
                allowClear: true,
                sorter: function(data) {
                    return data.sort(function (a, b) {
                        if (a.text > b.text) {
                            return 1;
                        }
                        if (a.text < b.text) {
                            return -1;
                        }
                        return 0;
                    });
                }
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
                            if (element2.customer) {
                                $('.customerSelect').val(element2.customer);
                                $('.customerSelect').val(element2.customer);
                                $('.customerSelect').trigger('change.select2');
                                $('.customerSelectDisable').prop("disabled", true);
                            }


                            // Load service types based on unit
                            $.get("{{ url('api/make_lists/') }}", function(data3) {
                                var arr = [];
                                $.each(data3.data, function(index3, element3) {
                                    
                                    if (element2.make == element3.make) {
                                        var newOption = new Option(element3.serviceName, element3.serviceName, false, false);
                                        $('.serviceSelect').append(newOption).trigger('change');    
                                    }
                                    
                                });
                                var newOption1 = new Option('Repair', 'Repair', false, false);
                                $('.serviceSelect').append(newOption1).trigger('change');   
                                var newOption2 = new Option('Report', 'Report', false, false);
                                $('.serviceSelect').append(newOption2).trigger('change');   
                                
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

                            var data = {
                                "_token": "{{ csrf_token() }}",
                            };
                            $.post('/serviceLookup/'+unitId, data, function(data, textStatus, xhr) {
                                $('#openreportsBody').empty();
                                /*optional stuff to do after success */
                                $.each(data, function(index1, element1) {
                                    console.log(element1.id);
                                    if (element1.critical === '1') {
                                        var critical = 'Yes';
                                    } else {
                                        var critical = 'No';
                                    }
                                    $('.openreports').append('<tr><td>'+element1.id+'</td><td>'+critical+'</td><td>'+element1.service_desc+'</td><td>'+moment(element1.created_at).format('YYYY-MM-DD HH:MM')+'</td></tr>');

                                });
                            });
                        }
                    });
                });
        });




        $('.customerSelect').change(function() {
            $('.customerSelect').val($('.customerSelect').val());
            $.get("{{ url('api/contacts/') }}",
                function(data2) {
                    console.log(data2);
                    $.each(data2.data, function(index, element2) {
                        if ($('.customerSelect').val() === element2.customer) {
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



        $('.inventoryUnit').change(function() {
            
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


        $('.clearField').click(function() {
            $('.descSelect').empty();
            $('.serviceSelect').val(null).trigger('change');

        });

        $('.serviceSelect').on('select2:select', function (e) {
            var data = e.params.data.id;
            if (data === 'Repair' || data === 'Report') {
                $('.hide').hide();
            }
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

        $(function () {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        });

        $('#gantt .cell').each(function() {
            var cellVal = $(this).html();
            console.log(cellVal);
            if (cellVal !== '') {
                $(this).css("background-color","#ccc");
            }
            if (cellVal.includes("Continuous")) {
                $(this).css("background-color","yellow");
            }
        });


    </script>

    @stack('third_party_scripts')

    @stack('page_scripts')
</body>

</html>

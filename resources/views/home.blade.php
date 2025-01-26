@extends('layouts.app')

@section('content')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
      });
      calendar.render();
    });

</script>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">App</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    {{-- <div class="col-xl-3 col-md-6">

        <div class="card card-animate bg-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p
                            class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                            Clientes</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-white fs-14 mb-0">
                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                            +16.24 %
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">$<span
                                class="counter-value" data-target="559.25">0</span>k
                        </h4>
                        <a href="">Ver mas</a>

                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-light rounded fs-3">
                            <i class="bx bx-dollar-circle text-white"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-xl-3 col-md-6">

        <div class="card card-animate bg-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p
                            class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                            Personal</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-white fs-14 mb-0">
                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                            -3.57 %
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4"><span
                            class="counter-value" data-target="36894">0</span></h4>
                        <a href="">Ver mas</a>


                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-light rounded fs-3">
                            <i class="bx bx-shopping-bag text-white"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-xl-3 col-md-6">

        <div class="card card-animate bg-dark">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p
                            class="text-uppercase fw-bold text-white-50 text-truncate mb-0">
                            Reportes</p>
                    </div>
                    <div class="flex-shrink-0">
                        <h5 class="text-white fs-14 mb-0">
                            +0.00 %
                        </h5>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-bold ff-secondary text-white mb-4">$<span
                                class="counter-value" data-target="165.89">0</span>k
                        </h4>
                        <a href="#" class="text-decoration-underline text-white-50">Ver Mas</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-light rounded fs-3">
                            <i class="bx bx-wallet text-white"></i>
                        </span>
                    </div>
                </div>
            </div>>
        </div>
    </div> --}}

    <div id='calendar'></div>
</div> <!-- end row-->

@endsection


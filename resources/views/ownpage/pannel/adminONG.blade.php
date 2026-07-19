<div class="container-fluid py-4">

    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-3">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="mb-3 fw-bold">
                        <i class="bi bi-grid-1x2-fill"></i>
                        Menu Admin ONG
                    </h5>

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">
                                📊 Dashboard
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">
                                🏢 Organization
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="{{ route('indexProgram') }}" class="text-decoration-none">
                                📚 Programs
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="{{ route('indexProject') }}" class="text-decoration-none">
                                🧩 Projects
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="{{ route('indexActivity') }}" class="text-decoration-none">
                                📋 Activities
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="{{ route('indexIndicator') }}" class="text-decoration-none">
                                📈 Indicators
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none">
                                👥 Users
                            </a>
                        </li>

                    </ul>

                </div>
            </div>

        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- CONTENT WILL BE INJECTED HERE --}}
                    @yield('admin-content')

                </div>
            </div>

        </div>

    </div>

</div>

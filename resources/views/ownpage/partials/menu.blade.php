<div class="col-md-3">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h5 class="mb-3 fw-bold">
                            <a href="{{ route('dashboard') }}" class="btn rounded-3 border-light text-dark d-left">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Menu Admin ONG
                            </a>

                        </h5>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <a href="{{ route('indexDash') }}" class="text-decoration-none">
                                    📊 Dashboard
                                </a>
                            </li>

                            {{-- <li class="list-group-item">
                                <a href="#" class="text-decoration-none">
                                    🏢 Organization
                                </a>
                            </li> --}}

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
                            <a href="{{ route('indexUserOrg') }}" class="text-decoration-none">
                                👥 Users
                            </a>
                        </li>

                        </ul>

                    </div>
                </div>

            </div>

@extends('sample')

@section('title')
    Visualiser l'Activité - {{ $activity->name }}
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <!-- Injection forcée de Tailwind CSS et de sa configuration directement dans la section de contenu -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        saas: {
                            primary: '#4f46e5',
                            /* Indigo modern */
                            secondary: '#0f172a',
                            /* Dark slate */
                            success: '#10b981',
                            /* Emerald */
                            warning: '#f59e0b',
                            /* Amber */
                            danger: '#ef4444',
                            /* Rose */
                            bg: '#f8fafc' /* Slate background */
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Transitions fluides et configurations pour éviter les conflits de styles globaux */
        .transition-all-200 {
            transition: all 0.2s ease-in-out;
        }

        /* Correction pour s'assurer que Tailwind ne casse pas les polices système existantes */
        .saas-container {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
    </style>

    <div class="saas-container min-h-screen bg-slate-50/50 p-6 md:p-8 text-slate-800">

        <!-- BARRE D'ACTIONS SUPÉRIEURE (Breadcrumbs & Boutons) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-2">
                <a href="{{ route('indexActivity') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Retour aux activités</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('editActivity', ['id' => $activity->id]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl shadow-sm hover:bg-slate-50 hover:border-slate-300 transition-all-200">
                    <i class="fa-solid fa-pen-to-square text-slate-500"></i>
                    Modifier
                </a>
                <button data-id="{{ $activity->id }}"
                    class="deleteBtn inline-flex items-center gap-2 px-4 py-2 bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold rounded-xl shadow-sm hover:bg-rose-100 transition-all-200">
                    <i class="fa-solid fa-trash"></i>
                    Supprimer
                </button>
            </div>
        </div>

        <!-- CARTE EN-TÊTE PRINCIPALE (Header de la fiche d'activité) -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 md:p-8 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mt-2">
                <div>
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                        @if ($activity->status == 'Ongoing' || $activity->status == 'En cours') bg-emerald-50 text-emerald-700 border border-emerald-200
                        @elseif($activity->status == 'Completed' || $activity->status == 'Terminé')
                            bg-blue-50 text-blue-700 border border-blue-200
                        @else
                            bg-amber-50 text-amber-700 border border-amber-200 @endif">
                            <span
                                class="w-2 h-2 rounded-full @if ($activity->status == 'Ongoing' || $activity->status == 'En cours') bg-emerald-500 @elseif($activity->status == 'Completed' || $activity->status == 'Terminé') bg-blue-500 @else bg-amber-500 @endif animate-pulse"></span>
                            {{ $activity->status ?? 'Ongoing' }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">ID de l'activité: #{{ $activity->id }}</span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4 flex items-center gap-2.5">
                        <span class="text-3xl">📋</span>
                        <span>{{ $activity->name }}</span>
                    </h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-slate-400">Projet :</span>
                            <span
                                class="font-medium text-slate-800">{{ $activity->project->name ?? 'Digital Skills Program' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-slate-400">Programme :</span>
                            <span
                                class="font-medium text-slate-800">{{ $activity->project->program->name ?? 'Education' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Jauge de progression stylisée -->
                <div class="lg:w-80 w-full bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col justify-center">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Progression
                            globale</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $activity->completion_rate ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-full rounded-full transition-all duration-500"
                            style="width: {{ $activity->completion_rate ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRILLE D'INFORMATIONS & DESCRIPTION (2 colonnes) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">

            <!-- Colonne Gauche : Fiche Technique -->
            <div class="lg:col-span-5 bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span>📌</span> Informations Générales
                </h2>

                <div class="space-y-4">
                    <!-- Ligne Budget -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100/50">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">💰</span>
                            <span class="text-sm font-medium text-slate-500">Budget</span>
                        </div>
                        <span
                            class="text-sm font-bold text-slate-800">{{ number_format($activity->budget ?? 0, 0, ',', ' ') }}
                            {{ $activity->project->program->currency }}</span>
                    </div>

                    <!-- Ligne Responsable -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100/50">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">👤</span>
                            <span class="text-sm font-medium text-slate-500">Responsable</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-slate-800">{{ $activity->assignee->name ?? 'Non assigné' }}</span>
                    </div>

                    <!-- Ligne Créé par -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100/50">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">👨‍💼</span>
                            <span class="text-sm font-medium text-slate-500">Créé par</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-800">
                            {{ $activity->creator->name ?? 'N/A' }}</span>
                    </div>

                    <!-- Ligne Date de Début -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100/50">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📅</span>
                            <span class="text-sm font-medium text-slate-500">Date de début</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-slate-800">{{ $activity->start_date ? date('d/m/Y', strtotime($activity->start_date)) : 'Non définie' }}</span>
                    </div>

                    <!-- Ligne Date de Fin -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100/50">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📅</span>
                            <span class="text-sm font-medium text-slate-500">Date de fin</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-rose-600">{{ $activity->end_date ? date('d/m/Y', strtotime($activity->end_date)) : 'Non définie' }}</span>
                    </div>

                    <!-- Ligne Activité Parente -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100/50">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🏢</span>
                            <span class="text-sm font-medium text-slate-500">Activité Parente</span>
                        </div>
                        <span
                            class="text-sm font-semibold text-slate-800">{{ $activity->parent_activity_id ? 'ID #' . $activity->parent_activity_id : 'Aucune' }}</span>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Description -->
            <div class="lg:col-span-7 bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col">
                <h2 class="text-lg font-bold text-slate-900 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span>📝</span> Description de l'activité
                </h2>
                <div
                    class="flex-grow bg-slate-50 border border-slate-100 rounded-xl p-5 text-slate-600 leading-relaxed text-sm whitespace-pre-line">
                    {{ $activity->description ?? "Aucune description fournie pour le moment pour cette activité. Veuillez cliquer sur modifier pour ajouter des détails ou des directives spécifiques à l'intention de l'équipe." }}
                </div>
            </div>
        </div>

        <!-- SECTION SOUS-ACTIVITÉS -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 mb-8">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🧩</span>
                    @if($activity->children->count() > 0)
                    <h2 class="text-lg font-bold text-slate-900">Sous-activités rattachées</h2>
                    @else
                    <h2 class="text-lg font-bold text-slate-900">Activité Parente</h2>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <!-- Dropdown pour la sélection dynamique des colonnes -->
                    <div class="dropdown inline-block relative">
                        <button
                            class="btn btn-sm btn-outline-secondary dropdown-toggle px-3 py-1.5 text-xs font-semibold border border-slate-200 rounded-lg inline-flex items-center gap-1 hover:bg-slate-50"
                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-table-columns"></i> Colonnes
                        </button>
                        <ul class="dropdown-menu absolute right-0 mt-1 hidden bg-white border border-slate-200 rounded-lg shadow-lg py-1 z-10 w-48 text-xs"
                            id="columnSelector" aria-labelledby="dropdownMenuButton">
                            <!-- Généré dynamiquement en JS -->
                        </ul>
                    </div>

                    <a href="{{ route('createActivity') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="créer une nouvelle activité"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-plus"></i>
                        <span>Ajouter une sous-activité</span>
                    </a>
                </div>
            </div>
            <!--Si l'activité comprend des sous-activités -->
            @if ($activity->children->count() > 0)
                <div class="table-responsive overflow-x-auto rounded-xl border border-slate-100">
                    <table class="table min-w-full divide-y divide-slate-100" id="Activity">
                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Intitulé</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Progression</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach ($activity->children as $child)
                                <!-- Exemple de ligne 1 -->
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" name="collect_data" data-id="1"
                                                class="form-check-input w-4.5 h-4.5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                            <span class="text-sm font-semibold text-slate-800">{{ $child->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-slate-100 rounded-full h-2">
                                                <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $child->completion_rate }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-slate-600">{{ $child->completion_rate }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded-full">{{ $child->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                        <a href="{{route('showActivity',  $child->id ) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-bold">Ouvrir</a>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!--Activité parente de la sous activité-->

            @if ($activity->parent)
                <table class="table min-w-full divide-y divide-slate-100" id="Activity">
                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Intitulé</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Progression</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                                <!-- Exemple de ligne 1 -->
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" name="collect_data" data-id="1"
                                                class="form-check-input w-4.5 h-4.5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                            <span class="text-sm font-semibold text-slate-800">{{ $activity->parent->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-slate-100 rounded-full h-2">
                                                <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $activity->parent->completion_rate }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-slate-600">{{ $activity->parent->completion_rate }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded-full">{{ $activity->parent->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                        <a href="{{route('showActivity',  $activity->parent->id ) }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-bold">Ouvrir</a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
            @endif
            {{-- @if (is_null($activity->parent_activity_id))
                <div class="table-responsive overflow-x-auto rounded-xl border border-slate-100">
                    <span>Aucune sous activité rattaché </span>
                </div>

                @foreach ($activity->children as $child)
                    <p>{{ $child->name }}</p>
                @endforeach
            @else
                <!-- Tableau Responsive (avec ID 'Activity' pour conserver la logique de tri/filtres de votre script) -->
                <div class="table-responsive overflow-x-auto rounded-xl border border-slate-100">
                    <table class="table min-w-full divide-y divide-slate-100" id="Activity">
                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Intitulé</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Progression</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:bg-slate-100">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">

                            <!-- Exemple de ligne 1 -->
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="collect_data" data-id="1"
                                            class="form-check-input w-4.5 h-4.5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                        <span class="text-sm font-semibold text-slate-800">Collect Data</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-100 rounded-full h-2">
                                            <div class="bg-indigo-600 h-full rounded-full" style="width: 20%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-600">20%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded-full">Open</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 font-bold">Ouvrir</a>
                                </td>
                            </tr>
                            <!-- Exemple de ligne 2 -->
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="training" data-id="2"
                                            class="form-check-input w-4.5 h-4.5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                        <span class="text-sm font-semibold text-slate-800">Training</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-100 rounded-full h-2">
                                            <div class="bg-indigo-600 h-full rounded-full" style="width: 70%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-600">70%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded-full">Open</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 font-bold">Ouvrir</a>
                                </td>
                            </tr>
                            <!-- Exemple de ligne 3 -->
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="validation_workshop" data-id="3" checked
                                            class="form-check-input w-4.5 h-4.5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                                        <span
                                            class="text-sm font-semibold text-slate-800 line-through text-slate-400">Validation
                                            Workshop</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-100 rounded-full h-2">
                                            <div class="bg-emerald-500 h-full rounded-full" style="width: 100%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-emerald-600">100%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">Completed</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 font-bold">Ouvrir</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif --}}

        </div>

        <!-- Indicator Assigned -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 mb-8">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📈</span>
                    <h2 class="text-lg font-bold text-slate-900">Indicateurs liés à l'activité</h2>

                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <!-- Dropdown pour la sélection dynamique des colonnes -->
                    <div class="dropdown inline-block relative">
                        <button
                            class="btn btn-sm btn-outline-secondary dropdown-toggle px-3 py-1.5 text-xs font-semibold border border-slate-200 rounded-lg inline-flex items-center gap-1 hover:bg-slate-50"
                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-table-columns"></i> Colonnes
                        </button>
                        <ul class="dropdown-menu absolute right-0 mt-1 hidden bg-white border border-slate-200 rounded-lg shadow-lg py-1 z-10 w-48 text-xs"
                            id="columnSelector" aria-labelledby="dropdownMenuButton">
                            <!-- Généré dynamiquement en JS -->
                        </ul>
                    </div>

                    <a href="{{ route('assignedIndicator', $activity->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lier l'activité à un indicateur"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-plus"></i>
                        <span>Lier l'activité à un indicateur</span>
                    </a>
                </div>
            </div>

        <!-- TRIPTYQUE DES INDICATEURS DE PERFORMANCE -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Carte Outputs -->
            <div
                class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl">📊</span>
                        <span
                            class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-lg">Produit</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Outputs</h3>
                    <div class="text-2xl font-black text-slate-900 mb-2">{{ $outputIndicator }} Indicateur(s)</div>
                </div>
                <a href="#"
                    class="mt-4 inline-flex items-center justify-center gap-1 w-full py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-100 hover:border-slate-200 transition-all-200">
                    Visualiser
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Carte Outcomes -->
            <div
                class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl">📈</span>
                        <span
                            class="text-xs font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2.5 py-1 rounded-lg">Effets</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Outcomes</h3>
                    <div class="text-2xl font-black text-slate-900 mb-2">{{ $outcomeIndicator }} Indicateurs</div>
                </div>
                <a href="#"
                    class="mt-4 inline-flex items-center justify-center gap-1 w-full py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-100 hover:border-slate-200 transition-all-200">
                    Visualiser
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Carte Impacts -->
            <div
                class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl">🌍</span>
                        <span
                            class="text-xs font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2.5 py-1 rounded-lg">Impacts</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Impacts</h3>
                    <div class="text-2xl font-black text-slate-900 mb-2">{{ $impactIndicator }} Indicateurs</div>
                </div>
                <a href="#"
                    class="mt-4 inline-flex items-center justify-center gap-1 w-full py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-100 hover:border-slate-200 transition-all-200">
                    Visualiser
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- SECTION TIMELINE -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                <span class="text-xl">📜</span>
                <h2 class="text-lg font-bold text-slate-900">Activité Timeline (Version 2)</h2>
            </div>

            <div class="relative pl-6 border-l-2 border-indigo-100 ml-4 space-y-8">
                <!-- Étape 1 -->
                <div class="relative">
                    <span
                        class="absolute -left-[31px] top-1.5 bg-indigo-600 w-4 h-4 rounded-full border-4 border-white shadow-sm"></span>
                    <div class="flex items-center justify-between gap-4">
                        <h4 class="text-sm font-bold text-slate-800">Planification validée</h4>
                        <span class="text-xs text-slate-400">01 Janvier 2026</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Structure de l'activité approuvée par la direction du projet.
                    </p>
                </div>

                <!-- Étape 2 -->
                <div class="relative">
                    <span
                        class="absolute -left-[31px] top-1.5 bg-indigo-600 w-4 h-4 rounded-full border-4 border-white shadow-sm"></span>
                    <div class="flex items-center justify-between gap-4">
                        <h4 class="text-sm font-bold text-slate-800">Début de l'implémentation</h4>
                        <span class="text-xs text-slate-400">12 Février 2026</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Attribution des ressources humaines et démarrage des ateliers.
                    </p>
                </div>

                <!-- Étape 3 -->
                <div class="relative">
                    <span
                        class="absolute -left-[31px] top-1.5 bg-slate-300 w-4 h-4 rounded-full border-4 border-white shadow-sm"></span>
                    <div class="flex items-center justify-between gap-4">
                        <h4 class="text-sm font-bold text-slate-800">Audit de mi-parcours</h4>
                        <span class="text-xs text-slate-400">En cours</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Vérification de l'atteinte des KPI préliminaires.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    {{-- <div class="modal fade fixed inset-0 z-50 hidden overflow-y-auto" id="confirmModal" tabindex="-1"
        aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" data-bs-dismiss="modal"></div>

            <div
                class="relative bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-rose-50 flex items-center justify-center text-rose-600">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900" id="confirmModalLabel">Confirmer la suppression</h3>
                    </div>
                    <div class="modal-body text-sm text-slate-500 leading-relaxed mb-6">
                        Êtes-vous sûr de vouloir supprimer définitivement cette activité ? Cette action est irréversible.
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button"
                            class="px-4 py-2 text-sm font-semibold text-slate-500 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="button"
                            class="confirmDeleteAction px-4 py-2 text-sm font-semibold text-white bg-rose-600 rounded-xl hover:bg-rose-700 shadow-sm shadow-rose-200 transition-colors">Supprimer
                            l'activité</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="confirmModalLabel">Delete confirm</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary confirmDeleteAction">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Logique Ajax inchangée pour le traitement des inputs en base de données
        const checkboxs = document.querySelectorAll('input[type="checkbox"]')

        checkboxs.forEach((checkbox) => {
            checkbox.onchange = async (event) => {
                const {
                    checked,
                    name,
                    dataset
                } = event.target;
                const {
                    id
                } = dataset;
                console.log({
                    checked,
                    name,
                    id
                });
                const data = {
                    [name]: checked.toString()
                };
                const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch('/activities/speed/' + id, {
                    method: 'PUT',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            };
        })

        // Logique d'affichage et suppression via Modal
        const deleteButtons = document.querySelectorAll('.deleteBtn')
        deleteButtons.forEach(deleteButton => {
            deleteButton.addEventListener('click', (event) => {
                event.preventDefault();
                const {
                    id,
                    title
                } = deleteButton.dataset
                const modalBody = document.querySelector('.modal-body')
                modalBody.innerHTML =
                    `Voulez-vous vraiment supprimer cette activité ? Cette action est irréversible.<strong>`
                console.log({
                    id,
                    title
                });
                const modal = new bootstrap.Modal(document.querySelector('#confirmModal'))
                modal.show()
                const confirmDeleteBtn = document.querySelector('.confirmDeleteAction')

                confirmDeleteBtn.addEventListener('click', async () => {
                    const csrfToken = document.head.querySelector('meta[name="csrf-token"]')
                        .content;
                    const response = await fetch('/activities/delete/' + id, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })

                    const result = await response.json()

                    if (result && result.isSuccess) {
                        window.location.href = window.location.href;
                    }

                    modal.hide()
                })
            })
        });

        // Génération et gestion dynamique des colonnes de la table
        document.addEventListener('DOMContentLoaded', function() {
            const tableHeaders = document.querySelectorAll('#Activity th');
            const columnSelector = document.getElementById('columnSelector');

            tableHeaders.forEach(function(header, index) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                const div = document.createElement('div');
                a.className = 'dropdown-item p-2 block hover:bg-slate-50 cursor-pointer';
                div.className = 'form-check form-switch flex items-center justify-between gap-2';
                const label = document.createElement('label');
                label.className = 'cursor-pointer font-medium text-slate-700';
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.role = "switch"
                checkbox.className =
                    'columnSelector form-check-input w-4.5 h-4.5 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500';
                checkbox.dataset.column = index;
                const savedSelection = localStorage.getItem('selectedColumns#Activity');
                checkbox.checked = !!!savedSelection; // Sélectionner par défaut
                checkbox.addEventListener('change', function() {
                    const columnIndex = parseInt(checkbox.dataset.column);
                    toggleColumn(columnIndex, checkbox.checked);
                    saveSelection();
                });

                label.appendChild(document.createTextNode(header.textContent));
                div.appendChild(label)
                div.appendChild(checkbox)
                a.appendChild(div);
                li.appendChild(a);
                columnSelector.appendChild(li);

                header.addEventListener('click', function() {
                    sortTable(index);
                });

                if (savedSelection) {
                    const selectedColumns = JSON.parse(savedSelection);
                    toggleColumn(parseInt(index), selectedColumns.includes(index));
                }
            });

            const checkboxes = document.querySelectorAll('.columnSelector');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const columnIndex = parseInt(checkbox.dataset.column);
                    toggleColumn(columnIndex, checkbox.checked);
                    saveSelection();
                });
            });

            loadSavedSelection();
        });

        function toggleColumn(columnIndex, show) {
            const dataTable = document.getElementById('Activity');
            const cells = dataTable.querySelectorAll(
                `tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`);

            cells.forEach(function(cell) {
                if (show) {
                    cell.style.display = ''; // Affiche la colonne
                } else {
                    cell.style.display = 'none'; // Masque la colonne
                }
            });
        }

        function saveSelection() {
            const selectedColumns = Array.from(document.querySelectorAll('.columnSelector'))
                .filter(c => c.checked)
                .map(c => c.dataset.column);
            localStorage.setItem('selectedColumns#Activity', JSON.stringify(selectedColumns));
        }

        function loadSavedSelection() {
            const savedSelection = localStorage.getItem('selectedColumns#Activity');
            if (savedSelection) {
                const selectedColumns = JSON.parse(savedSelection);
                selectedColumns.forEach(function(columnIndex) {
                    const checkbox = document.querySelector(`.columnSelector[data-column="${columnIndex}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                        toggleColumn(parseInt(columnIndex), true);
                    }
                });
            }
        }

        function sortTable(columnIndex) {
            const table = document.getElementById('Activity');
            const rows = Array.from(table.querySelectorAll('tbody tr'));

            rows.sort((a, b) => {
                const cellA = a.querySelectorAll('td')[columnIndex].textContent;
                const cellB = b.querySelectorAll('td')[columnIndex].textContent;

                return cellA.localeCompare(cellB, undefined, {
                    numeric: true,
                    sensitivity: 'base'
                });
            });

            table.querySelector('tbody').innerHTML = '';
            rows.forEach(row => table.querySelector('tbody').appendChild(row));
        }
    </script>
@endsection

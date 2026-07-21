    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <!-- Card Header -->
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold m-0 text-dark">
                            <i class="bi bi-kanban text-primary me-2"></i>
                            {{ isset($project) ? 'Modifier le Projet' : 'Nouveau Projet' }}
                        </h5>
                        <small class="text-muted">Renseignez les détails et rattachez le projet à un programme
                            existant</small>
                    </div>
                    <a href="{{ route('indexProject') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Annuler
                    </a>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <form
                        action="{{ isset($project) ? route('updateProject', ['project' => $project->id]) : route('storeProject') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif

                        <!-- SECTION 1: RATTACHEMENT ET IDENTIFICATION -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-diagram-3 me-1"></i> 1. Rattachement & Identification
                            </h6>
                            <div class="row g-3">
                                <!-- Programme Parent -->
                                <div class="col-md-8">
                                    <label for="program_id" class="form-label fw-semibold">Programme Rattaché <span
                                            class="text-danger">*</span></label>
                                    <select name="program_id" id="program_id"
                                        class="form-select @error('program_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionner un Programme --</option>
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->id }}"
                                                {{ old('program_id', $project->program_id ?? '') == $program->id ? 'selected' : '' }}>
                                                {{ $program->name }} @if ($program->code)
                                                    ({{ $program->code }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('program_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Code Projet -->
                                {{-- <div class="col-md-4">
                                    <label for="code" class="form-label fw-semibold">Code / Référence Projet</label>
                                    <input type="text" name="code" id="code"
                                        value="{{ old('code', $project->code ?? '') }}"
                                        class="form-control @error('code') is-invalid @enderror"
                                        placeholder="Ex: PRJ-2026-A">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <!-- Nom du Projet -->
                                <div class="col-12">
                                    <label for="name" class="form-label fw-semibold">Nom du Projet <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $project->name ?? '') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Ex: Construction de 3 centres de santé de proximité" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: DESCRIPTION ET BUDGET -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-card-heading me-1"></i> 2. Détails & Budget
                            </h6>
                            <div class="row g-3">
                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">Description du Projet <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="3"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Résumez les activités clés et les objectifs spécifiques de ce projet..." required>{{ old('description', $project->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Budget Allocated -->
                                <div class="col-md-6">
                                    <label for="budget" class="form-label fw-semibold">Budget Alloué au Projet <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="any" min="0" name="budget"
                                            id="budget" value="{{ old('budget', $project->budget ?? '') }}"
                                            class="form-control @error('budget') is-invalid @enderror"
                                            placeholder="Ex: 15000000" required>
                                        @error('budget')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Statut -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold">Statut <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">-- Choisir le statut --</option>
                                        <option value="draft"
                                            {{ old('status', $project->status ?? '') == 'draft' ? 'selected' : '' }}>
                                            Brouillon</option>
                                        <option value="active"
                                            {{ old('status', $project->status ?? 'active') == 'active' ? 'selected' : '' }}>
                                            En cours / Actif</option>
                                        <option value="completed"
                                            {{ old('status', $project->status ?? '') == 'completed' ? 'selected' : '' }}>
                                            Terminé</option>
                                        <option value="suspended"
                                            {{ old('status', $project->status ?? '') == 'suspended' ? 'selected' : '' }}>
                                            Suspendu</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: PLANNING -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-calendar-week me-1"></i> 3. Planning d'Exécution
                            </h6>
                            <div class="row g-3">
                                <!-- Date Début -->
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label fw-semibold">Date de Début <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="start_date" id="start_date"
                                        value="{{ old('start_date', $project->start_date ?? '') }}"
                                        class="form-control @error('start_date') is-invalid @enderror" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date Fin -->
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label fw-semibold">Date de Fin Prévue <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="end_date" id="end_date"
                                        value="{{ old('end_date', $project->end_date ?? '') }}"
                                        class="form-control @error('end_date') is-invalid @enderror" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('indexProject') }}" class="btn btn-light border px-4 rounded-pill">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ isset($project) ? 'Mettre à jour le projet' : 'Créer le projet' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

        <script>
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach((textarea) => {
                ClassicEditor
                    .create(textarea)
                    .catch(error => {
                        console.error(error);
                    });
            });

            $(document).ready(function() {
                $('select').select2();
            });

            function triggerFileInput(fieldId) {
                const fileInput = document.getElementById(fieldId);
                if (fileInput) {
                    fileInput.click();
                }
            }

            const imageUploads = document.querySelectorAll('.imageUpload');
            imageUploads.forEach(function(imageUpload) {
                imageUpload.addEventListener('change', function(event) {
                    event.preventDefault()
                    const files = this.files; // Récupérer tous les fichiers sélectionnés
                    console.log(files)
                    if (files && files.length > 0) {
                        const previewContainer = document.getElementById('preview_' + this.id);
                        previewContainer.innerHTML = ''; // Effacer le contenu précédent

                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            if (file) {
                                const reader = new FileReader();
                                const img = document.createElement(
                                    'img'); // Créer un élément img pour chaque image

                                reader.onload = function(event) {
                                    img.src = event.target.result;
                                    img.alt = "Prévisualisation de l'image"
                                    img.style.maxWidth = '100px';
                                    img.style.display = 'block';
                                }

                                reader.readAsDataURL(file);
                                previewContainer.appendChild(img); // Ajouter l'image à la prévisualisation
                                console.log({
                                    img
                                })
                                console.log({
                                    previewContainer
                                })
                            }
                        }
                        console.log({
                            previewContainer
                        })
                    }
                });
            });
        </script>
    @endsection

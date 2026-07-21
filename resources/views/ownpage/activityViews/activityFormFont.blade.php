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
                        <i class="bi bi-list-check text-primary me-2"></i>
                        {{ isset($activity) ? 'Modifier l\'Activité' : 'Nouvelle Activité' }}
                    </h5>
                    <small class="text-muted">Définissez les paramètres, l'attribution et le calendrier de réalisation</small>
                </div>
                <a href="{{ route('indexActivity') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Annuler
                </a>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form action="{{ isset($activity) ? route('updateActivity', ['activity' => $activity->id]) : route('storeActivity') }}" method="POST">
                    @csrf
                    @if(isset($activity))
                        @method('PUT')
                    @endif

                    <!-- Alert Globale d'Erreurs (Optionnelle) -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                                <div>
                                    <strong>Des erreurs sont survenues :</strong> Veuillez vérifier les champs du formulaire.
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- SECTION 1: CONTEXTE & ATTRIBUTION -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-diagram-2 me-1"></i> 1. Contexte & Attribution
                        </h6>
                        <div class="row g-3">
                            <!-- Projet Rattaché -->
                            <div class="col-md-4">
                                <label for="project_id" class="form-label fw-semibold">Projet Rattaché <span class="text-danger">*</span></label>
                                <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                    <option value="">-- Choisir un Projet --</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id', $activity->project_id ?? '') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Activité Parent (Sous-activité) -->
                            <div class="col-md-4">
                                <label for="parent_activity_id" class="form-label fw-semibold">Sous-activité de</label>
                                <select name="parent_activity_id" id="parent_activity_id" class="form-select @error('parent_activity_id') is-invalid @enderror">
                                    <option value="">-- Activité Principale (Aucune) --</option>
                                    @foreach($activities as $act)
                                        {{-- Éviter qu'une activité soit sa propre sous-activité --}}
                                        @if(!isset($activity) || $act->id !== $activity->id)
                                            <option value="{{ $act->id }}"
                                                {{ old('parent_activity_id', $activity->parent_activity_id ?? '') == $act->id ? 'selected' : '' }}>
                                                {{ $act->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_activity_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Assigné à (Responsable) -->
                            <div class="col-md-4">
                                <label for="assigned_to" class="form-label fw-semibold">Responsable / Assigné à</label>
                                <select name="assigned_to" id="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                                    <option value="">-- Aucun Responsable --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('assigned_to', $activity->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: DÉTAILS DE L'ACTIVITÉ -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-card-text me-1"></i> 2. Intitulé & Description
                        </h6>
                        <div class="row g-3">
                            <!-- Nom / Intitulé -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">Intitulé de l'Activité <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $activity->name ?? '') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ex: Organisation de l'atelier de formation des agents de santé" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description / Tâches prévues <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Détaillez les résultats attendus et le déroulement de cette activité..." required>{{ old('description', $activity->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: SUIVI, BUDGET ET CHRONOGRAMME -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-clock-history me-1"></i> 3. Suivi, Budget & Calendrier
                        </h6>
                        <div class="row g-3">
                            <!-- Budget -->
                            <div class="col-md-4">
                                <label for="budget" class="form-label fw-semibold">Budget Estimé <span class="text-danger">*</span></label>
                                <input type="number" step="any" min="0" name="budget" id="budget"
                                    value="{{ old('budget', $activity->budget ?? '') }}"
                                    class="form-control @error('budget') is-invalid @enderror"
                                    placeholder="Ex: 500000" required>
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">-- Choisir le statut --</option>
                                    <option value="planned" {{ old('status', $activity->status ?? 'planned') == 'planned' ? 'selected' : '' }}>Planifié</option>
                                    <option value="ongoing" {{ old('status', $activity->status ?? '') == 'ongoing' ? 'selected' : '' }}>En cours</option>
                                    <option value="completed" {{ old('status', $activity->status ?? '') == 'completed' ? 'selected' : '' }}>Terminé</option>
                                    <option value="cancelled" {{ old('status', $activity->status ?? '') == 'cancelled' ? 'selected' : '' }}>Annulé / Suspendu</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Taux de réalisation (%) -->
                            <div class="col-md-4">
                                <label for="completion_rate" class="form-label fw-semibold">Progression</label>
                                <div class="input-group">
                                    <input type="number" min="0" max="100" step="1" name="completion_rate" id="completion_rate"
                                        value="{{ old('completion_rate', $activity->completion_rate ?? 0) }}"
                                        class="form-control @error('completion_rate') is-invalid @enderror"
                                        placeholder="0">
                                    @error('completion_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date Début -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-semibold">Date de Début <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $activity->start_date ?? '') }}"
                                    class="form-control @error('start_date') is-invalid @enderror" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date Fin -->
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-semibold">Date de Fin Prévue <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $activity->end_date ?? '') }}"
                                    class="form-control @error('end_date') is-invalid @enderror" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- BOUTONS D'ACTION -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('indexActivity') }}" class="btn btn-light border px-4 rounded-pill">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ isset($activity) ? 'Mettre à jour l\'activité' : 'Enregistrer l\'activité' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
                            const img = document.createElement('img'); // Créer un élément img pour chaque image

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

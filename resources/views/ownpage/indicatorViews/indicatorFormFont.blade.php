    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold m-0 text-dark">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>
                        {{ isset($indicator) ? 'Modifier l\'Indicateur' : 'Nouveau Indicateur' }}
                    </h5>
                    <small class="text-muted">Renseignez les paramètres de suivi et de mesure du projet</small>
                </div>
                <a href="{{ route('indexIndicator') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Annuler
                </a>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form action="{{ isset($indicator) ? route('updateIndicator', ['indicator' => $indicator->id]) : route('storeIndicator') }}" method="POST">
                    @csrf
                    @if (isset($indicator))
                        @method('PUT')
                    @endif

                    <!-- SECTION 1: INFORMATIONS GÉNÉRALES -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-info-circle me-1"></i> 1. Informations Générales
                        </h6>
                        <div class="row g-3">
                            <!-- Projet -->
                            <div class="col-md-6">
                                <label for="project_id" class="form-label fw-semibold">Projet Associé <span class="text-danger">*</span></label>
                                <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner le Projet --</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id', $indicator->project_id ?? request('project_id')) == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            {{-- <div class="col-md-6">
                                <label for="code" class="form-label fw-semibold">Code / Référence</label>
                                <input type="text" name="code" id="code"
                                    value="{{ old('code', $indicator->code ?? '') }}"
                                    class="form-control @error('code') is-invalid @enderror"
                                    placeholder="Ex: IND-01, OUT-02...">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <!-- Nom -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">Intitulé de l'Indicateur <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $indicator->name ?? '') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ex: Nombre de personnes formées aux bonnes pratiques..." required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description & Méthodologie <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Précisez ce que mesure cet indicateur et comment les données sont collectées..." required>{{ old('description', $indicator->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: CLASSIFICATION ET FRÉQUENCE -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-sliders me-1"></i> 2. Classification & Fréquence
                        </h6>
                        <div class="row g-3">
                            <!-- Niveau de résultat -->
                            <div class="col-md-4">
                                <label for="result_level" class="form-label fw-semibold">Niveau de Résultat <span class="text-danger">*</span></label>
                                <select name="result_level" id="result_level" class="form-select @error('result_level') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="output" {{ old('result_level', $indicator->result_level ?? '') == 'output' ? 'selected' : '' }}>Output (Extrant)</option>
                                    <option value="outcome" {{ old('result_level', $indicator->result_level ?? '') == 'outcome' ? 'selected' : '' }}>Outcome (Effet)</option>
                                    <option value="impact" {{ old('result_level', $indicator->result_level ?? '') == 'impact' ? 'selected' : '' }}>Impact</option>
                                </select>
                                @error('result_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type de données -->
                            <div class="col-md-4">
                                <label for="data_type" class="form-label fw-semibold">Type de Données <span class="text-danger">*</span></label>
                                <select name="data_type" id="data_type" class="form-select @error('data_type') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="quantitatif" {{ old('data_type', $indicator->data_type ?? '') == 'quantitatif' ? 'selected' : '' }}>Quantitatif</option>
                                    <option value="qualitatif" {{ old('data_type', $indicator->data_type ?? '') == 'qualitatif' ? 'selected' : '' }}>Qualitatif</option>
                                </select>
                                @error('data_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fréquence -->
                            <div class="col-md-4">
                                <label for="frequency" class="form-label fw-semibold">Fréquence de Collecte <span class="text-danger">*</span></label>
                                <select name="frequency" id="frequency" class="form-select @error('frequency') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="daily" {{ old('frequency', $indicator->frequency ?? '') == 'daily' ? 'selected' : '' }}>Quotidien</option>
                                    <option value="monthly" {{ old('frequency', $indicator->frequency ?? '') == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                                    <option value="quaterly" {{ old('frequency', $indicator->frequency ?? '') == 'quaterly' ? 'selected' : '' }}>Trimestriel</option>
                                    <option value="annually" {{ old('frequency', $indicator->frequency ?? '') == 'annually' ? 'selected' : '' }}>Annuel</option>
                                </select>
                                @error('frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: UNITÉ ET OBJECTIFS CHIFFRÉS -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-calculator me-1"></i> 3. Valeurs Chiffrées & Cibles
                        </h6>
                        <div class="row g-3">
                            <!-- Unité -->
                            <div class="col-md-3">
                                <label for="unit" class="form-label fw-semibold">Unité de Mesure <span class="text-danger">*</span></label>
                                <input type="text" name="unit" id="unit"
                                    value="{{ old('unit', $indicator->unit ?? '') }}"
                                    class="form-control @error('unit') is-invalid @enderror"
                                    placeholder="Ex: Personnes, %, FCFA..." required>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Baseline -->
                            <div class="col-md-3">
                                <label for="baseline" class="form-label fw-semibold">Référence (Baseline) <span class="text-danger">*</span></label>
                                <input type="number" step="any" name="baseline" id="baseline"
                                    value="{{ old('baseline', $indicator->baseline ?? 0) }}"
                                    class="form-control @error('baseline') is-invalid @enderror"
                                    placeholder="0" required>
                                @error('baseline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Target -->
                            <div class="col-md-3">
                                <label for="target" class="form-label fw-semibold">Cible (Target) <span class="text-danger">*</span></label>
                                <input type="number" step="any" name="target" id="target"
                                    value="{{ old('target', $indicator->target ?? '') }}"
                                    class="form-control @error('target') is-invalid @enderror"
                                    placeholder="Objectif final" required>
                                @error('target')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Value -->
                            <div class="col-md-3">
                                <label for="current_value" class="form-label fw-semibold">Valeur Actuelle <span class="text-danger">*</span></label>
                                <input type="number" step="any" name="current_value" id="current_value"
                                    value="{{ old('current_value', $indicator->current_value ?? 0) }}"
                                    class="form-control @error('current_value') is-invalid @enderror"
                                    placeholder="Valeur atteinte" required>
                                @error('current_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: STATUT & VALIDATION -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-gear me-1"></i> 4. Statut
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Statut de l'indicateur <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner le Statut --</option>
                                    <option value="draft" {{ old('status', $indicator->status ?? '') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                    <option value="active" {{ old('status', $indicator->status ?? 'active') == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="archived" {{ old('status', $indicator->status ?? '') == 'archived' ? 'selected' : '' }}>Archivé</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- BOUTONS D'ACTION -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('indexIndicator') }}" class="btn btn-light border px-4 rounded-pill">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ isset($indicator) ? 'Mettre à jour' : 'Enregistrer l\'indicateur' }}
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

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
                        <i class="bi bi-folder2-open text-primary me-2"></i>
                        {{ isset($program) ? 'Modifier le Programme' : 'Nouveau Programme' }}
                    </h5>
                    <small class="text-muted">Définissez les paramètres globaux et le cadrage du programme</small>
                </div>
                <a href="{{ route('indexProgram') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Annuler
                </a>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form action="{{ isset($program) ? route('updateProgram', ['program' => $program->id]) : route('storeProgram') }}" method="POST">
                    @csrf
                    @if(isset($program))
                        @method('PUT')
                    @endif

                    <!-- SECTION 1: INFORMATIONS GÉNÉRALES -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-info-circle me-1"></i> 1. Informations Générales
                        </h6>
                        <div class="row g-3">
                            <!-- Code / Référence -->
                            {{-- <div class="col-md-4">
                                <label for="code" class="form-label fw-semibold">Code / Référence</label>
                                <input type="text" name="code" id="code"
                                    value="{{ old('code', $program->code ?? '') }}"
                                    class="form-control @error('code') is-invalid @enderror"
                                    placeholder="Ex: PRG-2026-01">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <!-- Nom du Programme -->
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-semibold">Nom du Programme <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $program->name ?? '') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ex: Programme d'Appui à la Santé Communautaire" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description du Programme <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Présentez brièvement les objectifs stratégiques et le champ d'action..." required>{{ old('description', $program->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: FINANCEMENT ET BUDGET -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-cash-stack me-1"></i> 2. Financement & Partenaires
                        </h6>
                        <div class="row g-3">
                            <!-- Donor / Bailleur -->
                            <div class="col-md-6">
                                <label for="donor" class="form-label fw-semibold">Bailleur de Fonds (Donor) <span class="text-danger">*</span></label>
                                <input type="text" name="donor" id="donor"
                                    value="{{ old('donor', $program->donor ?? '') }}"
                                    class="form-control @error('donor') is-invalid @enderror"
                                    placeholder="Ex: Union Européenne, USAID, BAD..." required>
                                @error('donor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Funding Partner -->
                            <div class="col-md-6">
                                <label for="funding_partner" class="form-label fw-semibold">Partenaire de Mise en Œuvre / Financement <span class="text-danger">*</span></label>
                                <input type="text" name="funding_partner" id="funding_partner"
                                    value="{{ old('funding_partner', $program->funding_partner ?? '') }}"
                                    class="form-control @error('funding_partner') is-invalid @enderror"
                                    placeholder="Ex: Ministère de la Santé, Consortium ONG..." required>
                                @error('funding_partner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Budget -->
                            <div class="col-md-8">
                                <label for="budget" class="form-label fw-semibold">Budget Total Alloué <span class="text-danger">*</span></label>
                                <input type="number" step="any" min="0" name="budget" id="budget"
                                    value="{{ old('budget', $program->budget ?? '') }}"
                                    class="form-control @error('budget') is-invalid @enderror"
                                    placeholder="Ex: 50000000" required>
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div class="col-md-4">
                                <label for="currency" class="form-label fw-semibold">Devise <span class="text-danger">*</span></label>
                                <select name="currency" id="currency" class="form-select @error('currency') is-invalid @enderror" required>
                                    <option value="">-- Choisir la devise --</option>
                                    <option value="FCFA" {{ old('currency', $program->currency ?? '') == 'FCFA' ? 'selected' : '' }}>FCFA (XOF/XAF)</option>
                                    <option value="Euro" {{ old('currency', $program->currency ?? '') == 'Euro' ? 'selected' : '' }}>Euro (€)</option>
                                    <option value="Dollar" {{ old('currency', $program->currency ?? '') == 'Dollar' ? 'selected' : '' }}>Dollar ($)</option>
                                </select>
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: PLANNING ET STATUT -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-calendar-range me-1"></i> 3. Calendrier & Statut
                        </h6>
                        <div class="row g-3">
                            <!-- Start Date -->
                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-semibold">Date de Début <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $program->start_date ?? '') }}"
                                    class="form-control @error('start_date') is-invalid @enderror" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="col-md-4">
                                <label for="end_date" class="form-label fw-semibold">Date de Fin <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $program->end_date ?? '') }}"
                                    class="form-control @error('end_date') is-invalid @enderror" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Statut du Programme <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner le Statut --</option>
                                    <option value="draft" {{ old('status', $program->status ?? '') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                    <option value="active" {{ old('status', $program->status ?? 'active') == 'active' ? 'selected' : '' }}>En cours / Actif</option>
                                    <option value="completed" {{ old('status', $program->status ?? '') == 'completed' ? 'selected' : '' }}>Clôturé / Terminé</option>
                                    <option value="suspended" {{ old('status', $program->status ?? '') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- BOUTONS D'ACTION -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('indexProgram') }}" class="btn btn-light border px-4 rounded-pill">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ isset($program) ? 'Mettre à jour' : 'Enregistrer le programme' }}
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

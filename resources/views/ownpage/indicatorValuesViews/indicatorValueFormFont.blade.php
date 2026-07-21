    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <!-- Entête de la carte -->
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        {{ isset($indicatorvalue) ? 'Modifier la valeur' : 'Ajouter une valeur' }}
                    </h5>
                    <a href="{{ route('showIndicator', $indicator->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Annuler
                    </a>
                </div>

                <!-- Corps du formulaire -->
                <div class="card-body p-4">
                    <form
                        action="{{ isset($indicatorvalue) ? route('updateIndicatorValue', ['indicatorvalue' => $indicatorvalue->id]) : route('storeIndicatorValue') }}"
                        method="POST">
                        @csrf
                        @if (isset($indicatorvalue))
                            @method('PUT')
                        @endif

                        <!-- 1. ID envoyé en arrière-plan (sans espaces parasites) -->
                        <input type="hidden" name="indicator_id"
                            value="{{ old('indicator_id', $indicatorvalue->indicator_id ?? $indicator->id) }}">

                        <!-- 2. Affichage en lecture seule de l'indicateur concerné -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Indicateur sélectionné</label>
                            <input type="text" class="form-control bg-light"
                                value="[{{ $indicator->code }}] {{ $indicator->name }}" readonly disabled>
                            @error('indicator_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <!-- Date de rapport -->
                            <div class="col-md-6">
                                <label for="reporting_date" class="form-label fw-semibold">Date de suivi / rapport <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="reporting_date" id="reporting_date"
                                    value="{{ old('reporting_date', isset($indicatorvalue->reporting_date) ? \Carbon\Carbon::parse($indicatorvalue->reporting_date)->format('Y-m-d') : date('Y-m-d')) }}"
                                    class="form-control @error('reporting_date') is-invalid @enderror" required />
                                @error('reporting_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Valeur Numérique -->
                            @if ($indicator->data_type == 'quantitatif')
                                <div class="col-md-6">
                                    <label for="value_numeric" class="form-label fw-semibold">Valeur numérique</label>
                                    <input type="number" step="any" placeholder="Ex: 150" name="value_numeric"
                                        id="value_numeric"
                                        value="{{ old('value_numeric', $indicatorvalue->value_numeric ?? '') }}"
                                        class="form-control @error('value_numeric') is-invalid @enderror" />
                                    @error('value_numeric')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <!-- Valeur Textuelle -->
                            @if ($indicator->data_type == 'qualitatif')
                                <div class="col-12">
                                    <label for="value_text" class="form-label fw-semibold">Valeur textuelle /
                                        qualitative</label>
                                    <input type="text" placeholder="Ex: Objectif atteint, En cours..."
                                        name="value_text" id="value_text"
                                        value="{{ old('value_text', $indicatorvalue->value_text ?? '') }}"
                                        class="form-control @error('value_text') is-invalid @enderror" />
                                    @error('value_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <!-- Commentaire -->
                            <div class="col-12">
                                <label for="comment" class="form-label fw-semibold">Commentaire / Remarques</label>
                                <textarea name="comment" id="comment" rows="3" placeholder="Saisir des remarques ou observations..."
                                    class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $indicatorvalue->comment ?? '') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-2 pt-4 mt-3 border-top">
                            <a href="{{ route('showIndicator', $indicator->id) }}" class="btn btn-light border px-4">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                {{ isset($indicatorvalue) ? 'Mettre à jour' : 'Enregistrer' }}
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

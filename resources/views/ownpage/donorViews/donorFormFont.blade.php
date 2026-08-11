@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .image-preview-wrapper {
            width: 100%;
            min-height: 160px;
            border: 2px dashed #cbd5e1;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f8fafc;
            cursor: pointer;
            transition: border-color 0.2s ease-in-out;
        }
        .image-preview-wrapper:hover {
            border-color: #0d6efd;
            background-color: #f1f5f9;
        }
        .image-preview-wrapper img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-hand-holding-dollar text-primary me-2"></i>
                {{ isset($donor) ? 'Modifier le Bailleur' : 'Nouveau Bailleur' }}
            </h3>
            <p class="text-muted mb-0">
                {{ isset($donor) ? 'Mettez à jour les informations du partenaire financier.' : 'Renseignez les champs ci-dessous pour ajouter un nouveau bailleur.' }}
            </p>
        </div>
        <div>
            <a href="{{ route('indexDonor') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire principal -->
    <form action="{{ isset($donor) ? route('updateDonor', ['donor' => $donor->id]) : route('storeDonor') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($donor))
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Colonne Gauche : Informations Générales -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="card-title fw-bold mb-0 text-dark">Informations Générales</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-3">

                            <!-- Code -->
                            <div class="col-md-6">
                                <label for="code" class="form-label fw-semibold">Code / Sigle <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="code"
                                       id="code"
                                       class="form-control @error('code') is-invalid @enderror"
                                       placeholder="Ex: USAID, BAD, EU..."
                                       value="{{ old('code', $donor->code ?? '') }}"
                                       required />
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nom du Bailleur <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nom complet de l'organisation"
                                       value="{{ old('name', $donor->name ?? '') }}"
                                       required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold">Type de Bailleur</label>
                                <input type="text"
                                       name="type"
                                       id="type"
                                       class="form-control @error('type') is-invalid @enderror"
                                       placeholder="Ex: Multilatéral, Bilatéral, ONG..."
                                       value="{{ old('type', $donor->type ?? '') }}" />
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Adresse Email</label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="contact@organisation.org"
                                       value="{{ old('email', $donor->email ?? '') }}" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Téléphone</label>
                                <input type="text"
                                       name="phone"
                                       id="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="+229 01 02 03 04"
                                       value="{{ old('phone', $donor->phone ?? '') }}" />
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Site Web -->
                            <div class="col-md-6">
                                <label for="website" class="form-label fw-semibold">Site Web</label>
                                <input type="url"
                                       name="website"
                                       id="website"
                                       class="form-control @error('website') is-invalid @enderror"
                                       placeholder="https://www.exemple.org"
                                       value="{{ old('website', $donor->website ?? '') }}" />
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold">Adresse physique / Siège</label>
                                <textarea name="address"
                                          id="address"
                                          rows="3"
                                          class="form-control @error('address') is-invalid @enderror"
                                          placeholder="Adresse complète du siège ou bureau local...">{{ old('address', $donor->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Logo & Statut -->
            <div class="col-lg-4">

                <!-- Carte Logo -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="card-title fw-bold mb-0 text-dark">Logo du Bailleur</h5>
                    </div>
                    <div class="card-body text-center pt-0">

                        <div class="image-preview-wrapper mb-3" onclick="triggerFileInput('logo')">
                            <div id="preview_logo" class="w-100 p-2">
                                @if(isset($donor) && $donor->logo)
                                    <img src="{{ asset($donor->logo) }}" style="width: 30%" alt="Logo {{ $donor->name }}">
                                @else
                                    <div class="text-muted p-3">
                                        <i class="fa-solid fa-cloud-arrow-up fs-1 text-primary mb-2 d-block"></i>
                                        <span class="fw-semibold small d-block">Cliquez pour charger un logo</span>
                                        <span class="extra-small text-secondary">PNG, JPG, SVG (Max. 2 Mo)</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Input File caché -->
                        <input type="file"
                               name="logo"
                               id="logo"
                               class="d-none imageUpload"
                               accept="image/*" />

                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Carte Statut & Publication -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="card-title fw-bold mb-0 text-dark">Statut & Actions</h5>
                    </div>
                    <div class="card-body pt-0">

                        <!-- Toggle Statut -->
                        <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between mb-4 border">
                            <div>
                                <label for="isActive" class="form-check-label fw-bold d-block text-dark">Statut Actif</label>
                                <small class="text-muted">Rendre ce bailleur visible dans l'application</small>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input type="hidden" name="isActive" value="false">
                                <input name="isActive"
                                       id="isActive"
                                       value="true"
                                       class="form-check-input fs-5"
                                       type="checkbox"
                                       role="switch"
                                       {{ old('isActive', (isset($donor) && ($donor->isActive == 'true' || $donor->isActive === true || $donor->isActive == 1)) ? 'true' : '') == 'true' ? 'checked' : '' }} />
                            </div>
                        </div>

                        @error('isActive')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                        @enderror

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                {{ isset($donor) ? 'Mettre à jour' : 'Enregistrer le Bailleur' }}
                            </button>
                            <a href="{{ route('indexDonor') }}" class="btn btn-outline-danger">
                                Annuler
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

    <script>
        // Initialisation de Select2
        $(document).ready(function() {
            $('select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });

        // Initialisation optionnelle de CKEditor sur les textareas si nécessaire
        const textareas = document.querySelectorAll('textarea.ckeditor');
        textareas.forEach((textarea) => {
            ClassicEditor.create(textarea).catch(error => console.error(error));
        });

        // Déclencheur du clic sur l'input file caché
        function triggerFileInput(fieldId) {
            const fileInput = document.getElementById(fieldId);
            if (fileInput) {
                fileInput.click();
            }
        }

        // Aperçu dynamique du Logo téléchargé
        document.querySelectorAll('.imageUpload').forEach(function(imageUpload) {
            imageUpload.addEventListener('change', function() {
                const files = this.files;
                if (files && files.length > 0) {
                    const previewContainer = document.getElementById('preview_' + this.id);
                    previewContainer.innerHTML = '';

                    const reader = new FileReader();
                    const img = document.createElement('img');

                    reader.onload = function(event) {
                        img.src = event.target.result;
                        img.alt = "Prévisualisation du logo";
                        img.className = "img-fluid rounded";
                    };

                    reader.readAsDataURL(files[0]);
                    previewContainer.appendChild(img);
                }
            });
        });
    </script>
@endsection




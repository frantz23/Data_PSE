    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-sm rounded-3">

                    <!-- En-tête de la carte -->
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h1 class="h4 fw-bold mb-0 text-dark">
                            {{ isset($organization) ? 'Modifier l\'organisation' : 'Créer une organisation' }}
                        </h1>
                    </div>

                    <!-- Corps du formulaire -->
                    <div class="card-body p-4">
                        <form
                            action="{{ isset($organization) ? route('updateOrganization', ['organization' => $organization->id]) : route('storeOrganization') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($organization))
                                @method('PUT')
                            @endif

                            <!-- Section 1 : Informations Générales -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Nom <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nom de l'organisation"
                                        value="{{ old('name', $organization->name ?? '') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Adresse E-mail <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="contact@organisation.com"
                                        value="{{ old('email', $organization->email ?? '') }}" required />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="3"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Description succincte de l'organisation..." required>{{ old('description', $organization->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section 2 : Contact & Liens -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Téléphone <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="+229 01 .. .. .. .."
                                        value="{{ old('phone', $organization->phone ?? '') }}" required />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="website" class="form-label fw-semibold">Site Web</label>
                                    <input type="url" name="website" id="website"
                                        class="form-control @error('website') is-invalid @enderror"
                                        placeholder="https://exemple.com"
                                        value="{{ old('website', $organization->website ?? '') }}" />
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section 3 : Localisation -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="country" class="form-label fw-semibold">Pays <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="country" id="country"
                                        class="form-control @error('country') is-invalid @enderror" placeholder="France"
                                        value="{{ old('country', $organization->country ?? '') }}" required />
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label fw-semibold">Ville <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city"
                                        class="form-control @error('city') is-invalid @enderror" placeholder="Paris"
                                        value="{{ old('city', $organization->city ?? '') }}" required />
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="address" class="form-label fw-semibold">Adresse <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="12 rue de la Paix"
                                        value="{{ old('address', $organization->address ?? '') }}" required />
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section 4 : Paramètres & Apparence -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-5">
                                    <label for="logo" class="form-label fw-semibold">Logo</label>
                                    <input type="file" name="logo" id="logo"
                                        class="form-control @error('logo') is-invalid @enderror" accept="image/*" />
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="primary_color" class="form-label fw-semibold">Couleur
                                        principale</label>
                                    <input type="color" name="primary_color" id="primary_color"
                                        class="form-control form-control-color w-100 @error('primary_color') is-invalid @enderror"
                                        value="{{ old('primary_color', $organization->primary_color ?? '#0d6efd') }}"
                                        title="Choisir la couleur principale" />
                                    @error('primary_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-semibold">Statut <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">-- Sélectionner un statut --</option>
                                        <option value="active"
                                            {{ old('status', $organization->status ?? '') == 'active' ? 'selected' : '' }}>
                                            Actif</option>
                                        <option value="inactive"
                                            {{ old('status', $organization->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                            Inactif</option>
                                        <option value="suspended"
                                            {{ old('status', $organization->status ?? '') == 'suspended' ? 'selected' : '' }}>
                                            Suspendu</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <a href="{{ route('indexOrganization') }}" class="btn btn-outline-secondary px-4">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ isset($organization) ? 'Mettre à jour' : 'Créer l\'organisation' }}
                                </button>
                            </div>
                        </form>
                    </div>

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

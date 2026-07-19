    @section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
        <div class="col-md-8">
            <form action="{{ isset($program) ? route('updateProgram', ['program' => $program->id]) : route('storeProgram') }}" method="POST">
                @csrf
                @if(isset($program))
                @method('PUT')
                @endif <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" placeholder="Name ..." name="name" value="{{ old('name', isset($program) ? $program->name : '') }}" class="form-control" id="name" aria-describedby="nameHelp" required />

                    @error('name')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                <!-- </div>
                <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" placeholder="Code ..." name="code" value="{{ old('code', isset($program) ? $program->code : '') }}" class="form-control" id="code" aria-describedby="codeHelp" required />

                    @error('code')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div> -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" placeholder="Description ..." name="description" value="{{ old('description', isset($program) ? $program->description : '') }}" class="form-control" id="description" aria-describedby="descriptionHelp" required />

                    @error('description')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="budget" class="form-label">Budget</label>
                    <input type="number" placeholder="Budget ..." name="budget" value="{{ old('budget', isset($program) ? $program->budget : '') }}" class="form-control" id="budget" aria-describedby="budgetHelp" required />

                    @error('budget')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="donor" class="form-label">Donor</label>
                    <input type="text" placeholder="Donor ..." name="donor" value="{{ old('donor', isset($program) ? $program->donor : '') }}" class="form-control" id="donor" aria-describedby="donorHelp" required />

                    @error('donor')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="currency" class="form-label">Currency</label>
                    <select name="currency" id="currency" class="form-control">
                        <option value="">--chose currency--</option>
                        <option value="FCFA"
                            {{ old('currency', $program->currency ?? '') == 'FCFA' ? 'selected' : '' }}>
                            FCFA
                        </option>
                        <option value="Euro"
                            {{ old('currency', $program->currency ?? '') == 'Euro' ? 'selected' : '' }}>
                            Euro
                        </option>
                        <option value="Dollar"
                            {{ old('currency', $program->currency ?? '') == 'Dollar' ? 'selected' : '' }}>
                            Dollar
                        </option>
                    </select>
                    @error('currency')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="funding_partner" class="form-label">Funding_partner</label>
                    <input type="text" placeholder="Funding_partner ..." name="funding_partner" value="{{ old('funding_partner', isset($program) ? $program->funding_partner : '') }}" class="form-control" id="funding_partner" aria-describedby="funding_partnerHelp" required />

                    @error('funding_partner')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start_date</label>
                    <input type="date" placeholder="Start_date ..." name="start_date" value="{{ old('start_date', isset($program) ? $program->start_date : '') }}" class="form-control" id="start_date" aria-describedby="start_dateHelp" required />

                    @error('start_date')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End_date</label>
                    <input type="date" placeholder="End_date ..." name="end_date" value="{{ old('end_date', isset($program) ? $program->end_date : '') }}" class="form-control" id="end_date" aria-describedby="end_dateHelp" required />

                    @error('end_date')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>

                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Select Status --</option>

                        <option value="draft"
                            {{ old('status', $program->status ?? '') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="active"
                            {{ old('status', $program->status ?? '') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed"
                            {{ old('status', $program->status ?? '') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="suspended"
                            {{ old('status', $program->status ?? '') == 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                    </select>

                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <a href="{{ route('admin.program.index') }}" class="btn btn-danger mt-1">
                    Cancel
                </a>
                <button class="btn btn-primary mt-1"> {{ isset($program) ? 'Update' : 'Create' }}</button>
            </form>
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
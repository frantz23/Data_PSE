    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
        <div class="col-md-8">
            <form
                action="{{ isset($indicator) ? route('admin.indicator.update', ['indicator' => $indicator->id]) : route('admin.indicator.store') }}"
                method="POST">
                @csrf
                @if (isset($indicator))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" placeholder="Name ..." name="name"
                        value="{{ old('name', isset($indicator) ? $indicator->name : '') }}" class="form-control"
                        id="name" aria-describedby="nameHelp" required />

                    @error('name')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" placeholder="Code ..." name="code"
                        value="{{ old('code', isset($indicator) ? $indicator->code : '') }}" class="form-control"
                        id="code" aria-describedby="codeHelp" required />

                    @error('code')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div> --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" placeholder="Description ..." name="description"
                        value="{{ old('description', isset($indicator) ? $indicator->description : '') }}"
                        class="form-control" id="description" aria-describedby="descriptionHelp" required />

                    @error('description')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="result_level" class="form-label">Result_level</label>
                    <select name="result_level" id="result_level" class="form-control" required>
                        <option value="">-- Select result level --</option>

                        <option value="output"
                            {{ old('result_level', $indicator->result_level ?? '') == 'output' ? 'selected' : '' }}>
                            Output
                        </option>

                        <option value="outcome"
                            {{ old('result_level', $indicator->result_level ?? '') == 'outcome' ? 'selected' : '' }}>
                            Outcome
                        </option>

                        <option value="impact"
                            {{ old('result_level', $indicator->result_level ?? '') == 'impact' ? 'selected' : '' }}>
                            Impact
                        </option>
                    </select>

                    @error('result_level')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="data_type" class="form-label">Data_type</label>
                    <select name="data_type" id="data_type" class="form-control" required>
                        <option value="">-- Select data type --</option>

                        <option value="qualitatif"
                            {{ old('data_type', $indicator->data_type ?? '') == 'qualitatif' ? 'selected' : '' }}>
                            qualitatif
                        </option>

                        <option value="quantitatif"
                            {{ old('data_type', $indicator->data_type ?? '') == 'quantitatif' ? 'selected' : '' }}>
                            quantitatif
                        </option>
                    </select>

                    @error('data_type')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" placeholder="Unit ..." name="unit"
                        value="{{ old('unit', isset($indicator) ? $indicator->unit : '') }}" class="form-control"
                        id="unit" aria-describedby="unitHelp" required />

                    @error('unit')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="baseline" class="form-label">Baseline</label>
                    <input type="number" placeholder="Baseline ..." name="baseline"
                        value="{{ old('baseline', isset($indicator) ? $indicator->baseline : '') }}"
                        class="form-control" id="baseline" aria-describedby="baselineHelp" required />

                    @error('baseline')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="target" class="form-label">Target</label>
                    <input type="number" placeholder="Target ..." name="target"
                        value="{{ old('target', isset($indicator) ? $indicator->target : '') }}" class="form-control"
                        id="target" aria-describedby="targetHelp" required />

                    @error('target')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="current_value" class="form-label">Current_value</label>
                    <input type="number" placeholder="Current_value ..." name="current_value"
                        value="{{ old('current_value', isset($indicator) ? $indicator->current_value : '') }}"
                        class="form-control" id="current_value" aria-describedby="current_valueHelp" required />

                    @error('current_value')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="frequency" class="form-label">Frequency</label>
                    <select name="frequency" id="frequency" class="form-control" required>
                        <option value="">-- Select frequency --</option>

                        <option value="daily"
                            {{ old('frequency', $indicator->frequency ?? '') == 'daily' ? 'selected' : '' }}>
                            Daily
                        </option>

                        <option value="monthly"
                            {{ old('frequency', $indicator->frequency ?? '') == 'monthly' ? 'selected' : '' }}>
                            Monthly
                        </option>

                        <option value="quaterly"
                            {{ old('frequency', $indicator->frequency ?? '') == 'quaterly' ? 'selected' : '' }}>
                            Quaterly
                        </option>

                        <option value="annually"
                            {{ old('frequency', $indicator->frequency ?? '') == 'annually' ? 'selected' : '' }}>
                            Annually
                        </option>
                    </select>
                    @error('frequency')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Projet</label>

                    <select name="project_id" class="form-control">
                        <option value="">-- Projet --</option>

                        @foreach($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ old('project_id', $activity->project_id ?? '') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                        @endforeach
                    </select>

                    @error('project_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Select Status --</option>

                        <option value="draft"
                            {{ old('status', $indicator->status ?? '') == 'draft' ? 'selected' : '' }}>
                            Brouillon
                        </option>

                        <option value="active"
                            {{ old('status', $indicator->status ?? '') == 'active' ? 'selected' : '' }}>
                            Actif
                        </option>

                        <option value="archived"
                            {{ old('status', $activity->status ?? '') == 'archived' ? 'selected' : '' }}>
                            Archivé
                        </option>
                    </select>

                    @error('status')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <a href="{{ route('admin.indicator.index') }}" class="btn btn-danger mt-1">
                    Cancel
                </a>
                <button class="btn btn-primary mt-1"> {{ isset($indicator) ? 'Update' : 'Create' }}</button>
            </form>
        </div>
        <div class="col-md-4">
            <a class="btn btn-danger mt-1" href="{{ route('admin.indicator.index') }}">
                Cancel
            </a>
            <button class="btn btn-primary mt-1"> {{ isset($indicator) ? 'Update' : 'Create' }}</button>
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

    @section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
        <div class="col-md-8">
            <form action="{{ isset($project) ? route('admin.project.update', ['project' => $project->id]) : route('admin.project.store') }}" method="POST">
                @csrf
                @if(isset($project))
                @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="program_id" class="form-label">
                        Program
                    </label>

                    <select name="program_id" id="program_id" class="form-control" required>
                        <option value="">-- Select Program --</option>

                        @foreach($programs as $program)
                        <option value="{{ $program->id }}"
                            {{ old('program_id', $project->program_id ?? '') == $program->id ? 'selected' : '' }}>

                            {{ $program->name }} ({{ $program->code }})
                        </option>
                        @endforeach

                    </select>

                    @error('program_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" placeholder="Name ..." name="name" value="{{ old('name', isset($project) ? $project->name : '') }}" class="form-control" id="name" aria-describedby="nameHelp" required />

                    @error('name')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!-- <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" placeholder="Code ..." name="code" value="{{ old('code', isset($project) ? $project->code : '') }}" class="form-control" id="code" aria-describedby="codeHelp" required />

                    @error('code')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div> -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" placeholder="Description ..." name="description" value="{{ old('description', isset($project) ? $project->description : '') }}" class="form-control" id="description" aria-describedby="descriptionHelp" required />

                    @error('description')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="budget" class="form-label">Budget</label>
                    <input type="number" placeholder="Budget ..." name="budget" value="{{ old('budget', isset($project) ? $project->budget : '') }}" class="form-control" id="budget" aria-describedby="budgetHelp" required />

                    @error('budget')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start_date</label>
                    <input type="date" placeholder="Start_date ..." name="start_date" value="{{ old('start_date', isset($project) ? $project->start_date : '') }}" class="form-control" id="start_date" aria-describedby="start_dateHelp" required />

                    @error('start_date')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End_date</label>
                    <input type="date" placeholder="End_date ..." name="end_date" value="{{ old('end_date', isset($project) ? $project->end_date : '') }}" class="form-control" id="end_date" aria-describedby="end_dateHelp" required />

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
                <a href="{{ route('admin.project.index') }}" class="btn btn-danger mt-1">
                    Cancel
                </a>
                <button class="btn btn-primary mt-1"> {{ isset($project) ? 'Update' : 'Create' }}</button>
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
    @section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
        <div class="col-md-8">
            <form action="{{ isset($activity) ? route('updateActivity', ['activity' => $activity->id]) : route('storeActivity') }}" method="POST">
                @csrf
                @if(isset($activity))
                @method('PUT')
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" placeholder="Name ..." name="name" value="{{ old('name', isset($activity) ? $activity->name : '') }}" class="form-control" id="name" aria-describedby="nameHelp" required />

                    @error('name')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" placeholder="Description ..." name="description" value="{{ old('description', isset($activity) ? $activity->description : '') }}" class="form-control" id="description" aria-describedby="descriptionHelp" required />

                    @error('description')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="budget" class="form-label">Budget</label>
                    <input type="number" placeholder="Budget ..." name="budget" value="{{ old('budget', isset($activity) ? $activity->budget : '') }}" class="form-control" id="budget" aria-describedby="budgetHelp" required />

                    @error('budget')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start_date</label>
                    <input type="date" placeholder="Start_date ..." name="start_date" value="{{ old('start_date', isset($activity) ? $activity->start_date : '') }}" class="form-control" id="start_date" aria-describedby="start_dateHelp" required />

                    @error('start_date')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End_date</label>
                    <input type="date" placeholder="End_date ..." name="end_date" value="{{ old('end_date', isset($activity) ? $activity->end_date : '') }}" class="form-control" id="end_date" aria-describedby="end_dateHelp" required />

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

                        <option value="planned"
                            {{ old('status', $activity->status ?? '') == 'planned' ? 'selected' : '' }}>
                            Planifié
                        </option>

                        <option value="ongoing"
                            {{ old('status', $activity->status ?? '') == 'ongoing' ? 'selected' : '' }}>
                            En cours
                        </option>

                        <option value="completed"
                            {{ old('status', $activity->status ?? '') == 'completed' ? 'selected' : '' }}>
                            Terminé
                        </option>

                        <option value="cancelled"
                            {{ old('status', $activity->status ?? '') == 'cancelled' ? 'selected' : '' }}>
                            Suspendu
                        </option>

                    </select>

                    @error('status')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="completion_rate" class="form-label">Completion_rate</label>
                    <input type="number" placeholder="Completion_rate ..." name="completion_rate" value="{{ old('completion_rate', isset($activity) ? $activity->completion_rate : '') }}" class="form-control" id="completion_rate" aria-describedby="completion_rateHelp" />

                    @error('completion_rate')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!-- <div class="mb-3">
                    <label for="user_id" class="form-label">User_id</label>
                    <input type="text" placeholder="User_id ..." name="user_id" value="{{ old('user_id', isset($activity) ? $activity->user_id : '') }}" class="form-control" id="user_id" aria-describedby="user_idHelp" required />

                    @error('user_id')
                    <div class="error text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div> -->
                <div class="mb-3">
                    <label class="form-label">Assigné à</label>

                    <select name="assigned_to" class="form-control">
                        <option value="">-- Aucun --</option>

                        @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('assigned_to', $activity->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>

                    @error('assigned_to')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Sous-activité de</label>

                    <select name="parent_activity_id" class="form-control">
                        <option value="">-- Activité principale --</option>

                        @foreach($activities as $act)
                        <option value="{{ $act->id }}"
                            {{ old('parent_activity_id', $activity->parent_activity_id ?? '') == $act->id ? 'selected' : '' }}>
                            {{ $act->name }}
                        </option>
                        @endforeach
                    </select>

                    @error('parent_activity_id')
                    <div class="text-danger">{{ $message }}</div>
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
                <a href="{{ route('indexActivity') }}" class="btn btn-danger mt-1">
                    Cancel
                </a>
                <button class="btn btn-primary mt-1"> {{ isset($activity) ? 'Update' : 'Create' }}</button>
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
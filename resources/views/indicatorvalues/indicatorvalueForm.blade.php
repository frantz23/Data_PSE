    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
        <div class="col-md-8">
            <form
                action="{{ isset($indicatorvalue) ? route('admin.indicatorvalue.update', ['indicatorvalue' => $indicatorvalue->id]) : route('admin.indicatorvalue.store') }}"
                method="POST">
                @csrf
                @if (isset($indicatorvalue))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="indicator_id" class="form-label">Indicateur</label>
                    <select name="indicator_id" class="form-select form-select-sm" required>
                        <option value="" selected disabled>Choisir l'indicateur</option>
                        @foreach ($indicators as $indicator)
                            <option value="{{ $indicator->id }}">
                                [{{ $indicator->code }}] {{ $indicator->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('indicator_id')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="value_numeric" class="form-label">Value_numeric</label>
                    <input type="number" placeholder="Value_numeric ..." name="value_numeric"
                        value="{{ old('value_numeric', isset($indicatorvalue) ? $indicatorvalue->value_numeric : '') }}"
                        class="form-control" id="value_numeric" aria-describedby="value_numericHelp" required />

                    @error('value_numeric')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if ($indicator->data_type == 'qualitatif')
                    <div class="mb-3">
                    <label for="value_text" class="form-label">Value_text</label>
                    <input type="text" placeholder="Value_text ..." name="value_text"
                        value="{{ old('value_text', isset($indicatorvalue) ? $indicatorvalue->value_text : '') }}"
                        class="form-control" id="value_text" aria-describedby="value_textHelp" required />

                    @error('value_text')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @endif


                <div class="mb-3">
                    <label for="reporting_date" class="form-label">Reporting_date</label>
                    <input type="date" placeholder="Reporting_date ..." name="reporting_date"
                        value="{{ old('reporting_date', isset($indicatorvalue) ? $indicatorvalue->reporting_date : '') }}"
                        class="form-control" id="reporting_date" aria-describedby="reporting_dateHelp" required />

                    @error('reporting_date')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <input type="text" placeholder="Comment ..." name="comment"
                        value="{{ old('comment', isset($indicatorvalue) ? $indicatorvalue->comment : '') }}"
                        class="form-control" id="comment" aria-describedby="commentHelp" required />

                    @error('comment')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="validated" class="form-label">Validated</label>
                    <input type="text" placeholder="Validated ..." name="validated"
                        value="{{ old('validated', isset($indicatorvalue) ? $indicatorvalue->validated : '') }}"
                        class="form-control" id="validated" aria-describedby="validatedHelp" required />

                    @error('validated')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>  --}}
                <a href="{{ route('admin.indicatorvalue.index') }}" class="btn btn-danger mt-1">
                    Cancel
                </a>
                <button class="btn btn-primary mt-1"> {{ isset($indicatorvalue) ? 'Update' : 'Create' }}</button>
            </form>
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

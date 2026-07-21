    {{-- @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
        <div class="col-md-8">
            <form
                action="{{ isset($indicatorvaluefile) ? route('admin.indicatorvaluefile.update', ['indicatorvaluefile' => $indicatorvaluefile->id]) : route('admin.indicatorvaluefile.store') }}"
                method="POST">
                @csrf
                @if (isset($indicatorvaluefile))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="file_name" class="form-label">File_name</label>
                    <input type="text" placeholder="File_name ..." name="file_name"
                        value="{{ old('file_name', isset($indicatorvaluefile) ? $indicatorvaluefile->file_name : '') }}"
                        class="form-control" id="file_name" aria-describedby="file_nameHelp" required />

                    @error('file_name')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="file_path" class="form-label">File_path</label>
                    <input type="text" placeholder="File_path ..." name="file_path"
                        value="{{ old('file_path', isset($indicatorvaluefile) ? $indicatorvaluefile->file_path : '') }}"
                        class="form-control" id="file_path" aria-describedby="file_pathHelp" required />

                    @error('file_path')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="mime_type" class="form-label">Mime_type</label>
                    <input type="text" placeholder="Mime_type ..." name="mime_type"
                        value="{{ old('mime_type', isset($indicatorvaluefile) ? $indicatorvaluefile->mime_type : '') }}"
                        class="form-control" id="mime_type" aria-describedby="mime_typeHelp" required />

                    @error('mime_type')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="file_size" class="form-label">File_size</label>
                    <input type="text" placeholder="File_size ..." name="file_size"
                        value="{{ old('file_size', isset($indicatorvaluefile) ? $indicatorvaluefile->file_size : '') }}"
                        class="form-control" id="file_size" aria-describedby="file_sizeHelp" required />

                    @error('file_size')
                        <div class="error text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div> <a href="{{ route('admin.indicatorvaluefile.index') }}" class="btn btn-danger mt-1">
                    Cancel
                </a>
                <button class="btn btn-primary mt-1"> {{ isset($indicatorvaluefile) ? 'Update' : 'Create' }}</button>
            </form>
        </div>
        <div class="col-md-4">
            <a class="btn btn-danger mt-1" href="{{ route('admin.indicatorvaluefile.index') }}">
                Cancel
            </a>
            <button class="btn btn-primary mt-1"> {{ isset($indicatorvaluefile) ? 'Update' : 'Create' }}</button>
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
    @endsection --}}

    @section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

<div class="row">
    <div class="col-lg-8">

        <form action="{{ isset($indicatorvaluefile)
                ? route('admin.indicatorvaluefile.update',$indicatorvaluefile)
                : route('storeIVFile') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            @isset($indicatorvaluefile)
                @method('PUT')
            @endisset

            {{-- Indicator Value --}}
            <input type="hidden"
                   name="indicator_value_id"
                   value="{{ $indicatorValue->id }}">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Ajouter des pièces justificatives
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Documents justificatifs
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            name="files[]"
                            id="files"
                            multiple
                            required>

                        <small class="text-muted">

                            Formats autorisés :
                            PDF, Word, Excel, Images, ZIP

                        </small>

                        @error('files')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                        @error('files.*')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    <div id="preview" class="row"></div>

                </div>

                <div class="card-footer text-end">

                    <a href="{{ route('showIndicatorValue', $indicatorValue->id) }}"
                       class="btn btn-secondary">

                        Annuler

                    </a>

                    <button class="btn btn-primary">

                        <i class="bi bi-upload"></i>

                        Téléverser

                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

@section('scripts')

<script>

document.getElementById('files').addEventListener('change', function(){

    const preview = document.getElementById('preview');

    preview.innerHTML='';

    Array.from(this.files).forEach(file=>{

        let icon="📄";

        if(file.type.startsWith("image/"))
            icon="🖼️";

        if(file.type=="application/pdf")
            icon="📕";

        if(file.type.includes("excel") || file.type.includes("spreadsheet"))
            icon="📊";

        if(file.type.includes("word"))
            icon="📝";

        preview.innerHTML += `
            <div class="col-md-6 mb-2">
                <div class="border rounded p-2">
                    ${icon}
                    <strong>${file.name}</strong><br>
                    <small>${(file.size/1024).toFixed(2)} KB</small>
                </div>
            </div>
        `;

    });

});

</script>

@endsection

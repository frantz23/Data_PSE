    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
    <div class="col-md-8">
        <form action="{{ isset($donor) ? route('admin.donor.update', ['donor' => $donor->id]) : route('admin.donor.store') }}" method="POST" >
        @csrf
        @if(isset($donor))
            @method('PUT')
        @endif    <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text"  placeholder="Code ..."  name="code" value="{{ old('code', isset($donor) ? $donor->code : '') }}" class="form-control" id="code" aria-describedby="codeHelp" required/>

        @error('code')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text"  placeholder="Name ..."  name="name" value="{{ old('name', isset($donor) ? $donor->name : '') }}" class="form-control" id="name" aria-describedby="nameHelp" required/>

        @error('name')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <input type="text"  placeholder="Type ..."  name="type" value="{{ old('type', isset($donor) ? $donor->type : '') }}" class="form-control" id="type" aria-describedby="typeHelp" required/>

        @error('type')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text"  placeholder="Email ..."  name="email" value="{{ old('email', isset($donor) ? $donor->email : '') }}" class="form-control" id="email" aria-describedby="emailHelp" required/>

        @error('email')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text"  placeholder="Phone ..."  name="phone" value="{{ old('phone', isset($donor) ? $donor->phone : '') }}" class="form-control" id="phone" aria-describedby="phoneHelp" required/>

        @error('phone')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="website" class="form-label">Website</label>
        <input type="text"  placeholder="Website ..."  name="website" value="{{ old('website', isset($donor) ? $donor->website : '') }}" class="form-control" id="website" aria-describedby="websiteHelp" required/>

        @error('website')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text"  placeholder="Address ..."  name="address" value="{{ old('address', isset($donor) ? $donor->address : '') }}" class="form-control" id="address" aria-describedby="addressHelp" required/>

        @error('address')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="logo" class="form-label">Logo</label>
        <input type="text"  placeholder="Logo ..."  name="logo" value="{{ old('logo', isset($donor) ? $donor->logo : '') }}" class="form-control" id="logo" aria-describedby="logoHelp" required/>

        @error('logo')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3 d-flex gap-2">
        <label for="isActive" class="form-label">IsActive</label>
        <div class="form-check form-switch">
            <input name="isActive" id="isActive" value="true" data-bs-toggle="toggle"  {{ old('isActive', isset($donor) && $donor->isActive == 'true' ? 'checked' : '') }} class="form-check-input" type="checkbox" role="switch" />
        </div>
        {{-- <select class="form-control" name="isActive" id="isActive">
            <option value="true" {{ old('isActive', isset($donor) && $donor->isActive == 'true' ? 'selected' : '') }}>Yes</option>
            <option value="false" {{ old('isActive', isset($donor) && $donor->isActive == 'false' ? 'selected' : '') }}>No</option>
        </select> --}}

        @error('isActive')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <a href="{{ route('admin.donor.index') }}" class="btn btn-danger mt-1">
        Cancel
    </a>
    <button class="btn btn-primary mt-1"> {{ isset($donor) ? 'Update' : 'Create' }}</button>
 </form>
    </div>
    <div class="col-md-4">
    <a  class="btn btn-danger mt-1" href="{{ route('admin.donor.index') }}">
    Cancel
</a>
<button class="btn btn-primary mt-1"> {{ isset($donor) ? 'Update' : 'Create' }}</button>
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
                            console.log({img})
                            console.log({previewContainer})
                        }
                    }
                    console.log({previewContainer})
                }
            });
        });
    </script>
    @endsection
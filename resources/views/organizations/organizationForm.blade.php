    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
    <div class="col-md-8">
        <form action="{{ isset($organization) ? route('admin.organization.update', ['organization' => $organization->id]) : route('admin.organization.store') }}" method="POST" >
        @csrf
        @if(isset($organization))
            @method('PUT')
        @endif    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text"  placeholder="Name ..."  name="name" value="{{ old('name', isset($organization) ? $organization->name : '') }}" class="form-control" id="name" aria-describedby="nameHelp" required/>

        @error('name')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text"  placeholder="Description ..."  name="description" value="{{ old('description', isset($organization) ? $organization->description : '') }}" class="form-control" id="description" aria-describedby="descriptionHelp" required/>

        @error('description')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text"  placeholder="Email ..."  name="email" value="{{ old('email', isset($organization) ? $organization->email : '') }}" class="form-control" id="email" aria-describedby="emailHelp" required/>

        @error('email')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text"  placeholder="Phone ..."  name="phone" value="{{ old('phone', isset($organization) ? $organization->phone : '') }}" class="form-control" id="phone" aria-describedby="phoneHelp" required/>

        @error('phone')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="website" class="form-label">Website</label>
        <input type="text"  placeholder="Website ..."  name="website" value="{{ old('website', isset($organization) ? $organization->website : '') }}" class="form-control" id="website" aria-describedby="websiteHelp" required/>

        @error('website')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="country" class="form-label">Country</label>
        <input type="text"  placeholder="Country ..."  name="country" value="{{ old('country', isset($organization) ? $organization->country : '') }}" class="form-control" id="country" aria-describedby="countryHelp" required/>

        @error('country')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text"  placeholder="City ..."  name="city" value="{{ old('city', isset($organization) ? $organization->city : '') }}" class="form-control" id="city" aria-describedby="cityHelp" required/>

        @error('city')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text"  placeholder="Address ..."  name="address" value="{{ old('address', isset($organization) ? $organization->address : '') }}" class="form-control" id="address" aria-describedby="addressHelp" required/>

        @error('address')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="logo" class="form-label">Logo</label>
        <input type="text"  placeholder="Logo ..."  name="logo" value="{{ old('logo', isset($organization) ? $organization->logo : '') }}" class="form-control" id="logo" aria-describedby="logoHelp" required/>

        @error('logo')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="primary_color" class="form-label">Primary_color</label>
        <input type="text"  placeholder="Primary_color ..."  name="primary_color" value="{{ old('primary_color', isset($organization) ? $organization->primary_color : '') }}" class="form-control" id="primary_color" aria-describedby="primary_colorHelp" required/>

        @error('primary_color')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <input type="text"  placeholder="Status ..."  name="status" value="{{ old('status', isset($organization) ? $organization->status : '') }}" class="form-control" id="status" aria-describedby="statusHelp" required/>

        @error('status')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <a href="{{ route('admin.organization.index') }}" class="btn btn-danger mt-1">
        Cancel
    </a>
    <button class="btn btn-primary mt-1"> {{ isset($organization) ? 'Update' : 'Create' }}</button>
 </form>
    </div>
    <div class="col-md-4">
    <a  class="btn btn-danger mt-1" href="{{ route('admin.organization.index') }}">
    Cancel
</a>
<button class="btn btn-primary mt-1"> {{ isset($organization) ? 'Update' : 'Create' }}</button>
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
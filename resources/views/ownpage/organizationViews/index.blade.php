@extends('sample')

@section('title')
Gestion Organisation
@endsection

@push('styles')
@vite('resources/css/organization.css')
@endpush

@section('content')
<div class="row">
    <div class="container">
        <a href="{{ route('ownpage.pannel') }}" class="btn btn-danger rounded-3">Retour</a>
        <a href="{{ route('createOrganization') }}" class="btn btn-success my-1">
            Créer une nouvelle organisation
        </a>
        <hr>
        <div class="row">
            @foreach($organizations as $organization)
        <div class="card" style="width: 18rem;margin:5px">

            <img src="/storage/org.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$organization->name}}</h5>
                <p class="card-text">{{ $organization->description }}</p>
                <a href="{{ route('showOrganization', $organization->id) }}" class="btn btn-primary">Plus d'informations</a>
                <a href="#" data-id="{{ $organization->id }}" class="btn btn-danger  btn-sm deleteBtn">
                    <i class="bi bi-trash3"> || Supprimer cette organisation</i>
                </a>
            </div>
            <hr>
           Administrateur de l'organisation <p class=" text-success fw-bold" style="text-align: right;">{{ $organization->users->first()->name ?? 'No admin' }}</p>
        </div>
        @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $organizations->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="confirmModalLabel">Delete confirm</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary confirmDeleteAction">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    const checkboxs = document.querySelectorAll('input[type="checkbox"]')

    checkboxs.forEach((checkbox) => {

        checkbox.onchange = async (event) => {
            const {
                checked,
                name,
                dataset
            } = event.target;
            const {
                id
            } = dataset;
            console.log({
                checked,
                name,
                id
            });
            const data = {
                [name]: checked.toString()
            };
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch('/organizations/speed/' + id, {
                method: 'PUT',
                body: JSON.stringify(data), // Utilisation de JSON.stringify au lieu de JSON.stringfy
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        };
    })

    const deleteButtons = document.querySelectorAll('.deleteBtn')
    deleteButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', (event) => {
            event.preventDefault();
            const {
                id,
                title
            } = deleteButton.dataset
            const modalBody = document.querySelector('.modal-body')
            modalBody.innerHTML = `Are you sure you want to delete this data ?</strong> `
            console.log({
                id,
                title
            });
            const modal = new bootstrap.Modal(document.querySelector('#confirmModal'))
            modal.show()
            const confirmDeleteBtn = document.querySelector('.confirmDeleteAction')

            confirmDeleteBtn.addEventListener('click', async () => {
                const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch('/organizations/delete/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })

                const result = await response.json()

                if (result && result.isSuccess) {
                    window.location.href = window.location.href;
                }


                modal.hide()
            })
        })

    });
    document.addEventListener('DOMContentLoaded', function() {
        const tableHeaders = document.querySelectorAll('#Organization th');
        const columnSelector = document.getElementById('columnSelector');

        tableHeaders.forEach(function(header, index) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            const div = document.createElement('div');
            a.className = 'dropdown-item';
            div.className = 'form-check form-switch';
            const label = document.createElement('label');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.role = "switch"
            checkbox.className = 'columnSelector form-check-input';
            checkbox.dataset.column = index;
            const savedSelection = localStorage.getItem('selectedColumns#Organization');
            checkbox.checked = !!!savedSelection; // Sélectionner par défaut
            checkbox.addEventListener('change', function() {
                const columnIndex = parseInt(checkbox.dataset.column);
                toggleColumn(columnIndex, checkbox.checked);
                saveSelection();
            });

            label.appendChild(document.createTextNode(header.textContent));
            div.appendChild(label)
            div.appendChild(checkbox)
            a.appendChild(div);
            li.appendChild(a);
            columnSelector.appendChild(li);

            header.addEventListener('click', function() {
                sortTable(index);
            });

            if (savedSelection) {
                const selectedColumns = JSON.parse(savedSelection);
                toggleColumn(parseInt(index), selectedColumns.includes(index));
            }
        });


        const checkboxes = document.querySelectorAll('.columnSelector');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const columnIndex = parseInt(checkbox.dataset.column);
                toggleColumn(columnIndex, checkbox.checked);

                // Sauvegarde la sélection dans le localStorage
                saveSelection();
            });
        });

        // Chargement des valeurs sauvegardées dans le localStorage
        loadSavedSelection();
    });

    function toggleColumn(columnIndex, show) {
        const dataTable = document.getElementById('Organization');
        const cells = dataTable.querySelectorAll(
            `tr td:nth-child(${columnIndex + 1}), th:nth-child(${columnIndex + 1})`);

        cells.forEach(function(cell) {
            if (show) {
                cell.style.display = ''; // Affiche la colonne
            } else {
                cell.style.display = 'none'; // Masque la colonne
            }
        });
    }

    function saveSelection() {
        const selectedColumns = Array.from(document.querySelectorAll('.columnSelector'))
            .filter(c => c.checked)
            .map(c => c.dataset.column);
        localStorage.setItem('selectedColumns#Organization', JSON.stringify(selectedColumns));
    }

    function loadSavedSelection() {
        const savedSelection = localStorage.getItem('selectedColumns#Organization');
        if (savedSelection) {
            const selectedColumns = JSON.parse(savedSelection);
            selectedColumns.forEach(function(columnIndex) {
                const checkbox = document.querySelector(`.columnSelector[data-column="${columnIndex}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                    toggleColumn(parseInt(columnIndex), true);
                }
            });
        }
    }

    function sortTable(columnIndex) {
        const table = document.getElementById('Organization');
        const rows = Array.from(table.querySelectorAll('tbody tr'));

        console.log({
            rows
        });

        rows.sort((a, b) => {
            const cellA = a.querySelectorAll('td')[columnIndex].textContent;
            const cellB = b.querySelectorAll('td')[columnIndex].textContent;

            return cellA.localeCompare(cellB, undefined, {
                numeric: true,
                sensitivity: 'base'
            });
        });

        table.querySelector('tbody').innerHTML = '';
        rows.forEach(row => table.querySelector('tbody').appendChild(row));
    }
</script>
@endsection
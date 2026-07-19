@extends('sample')

@section('title')
Voir Projet
@endsection

@section('content')
<div class="p-5">
    <h3>Show Program</h3>

    <a href="{{ route('indexProgram') }}" class="btn btn-primary my-1">
        Retour
    </a>
    <a href="#" data-id="{{ $program->id }}" class="btn btn-danger btn-sm deleteBtn">
                        <i class="bi bi-trash"></i> || Delete Program
                    </a>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $program->name }}</td>
                </tr>
                <tr>
                    <th>Code</th>
                    <td>{{ $program->code }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $program->description }}</td>
                </tr>
                <tr>
                    <th>Budget</th>
                    <td>{{ $program->budget }}</td>
                </tr>
                <tr>
                    <th>Donor</th>
                    <td>{{ $program->donor }}</td>
                </tr>
                <tr>
                    <th>Currency</th>
                    <td>{{ $program->currency }}</td>
                </tr>
                <tr>
                    <th>Funding_partner</th>
                    <td>{{ $program->funding_partner }}</td>
                </tr>
                <tr>
                    <th>Start_date</th>
                    <td>{{ $program->start_date }}</td>
                </tr>
                <tr>
                    <th>End_date</th>
                    <td>{{ $program->end_date }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $program->status }}</td>
                </tr>

            </tbody>
        </table>

        <div>
            <a href="{{ route('editProgram', ['id' => $program->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
        </div>
    </div>

     <!-- Modal -->
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
                            const response = await fetch('programs/speed/' + id, {
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
                                const response = await fetch('programs/delete/' + id, {
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
                        const tableHeaders = document.querySelectorAll('#Program th');
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
                            const savedSelection = localStorage.getItem('selectedColumns#Program');
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
                        const dataTable = document.getElementById('Program');
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
                        localStorage.setItem('selectedColumns#Program', JSON.stringify(selectedColumns));
                    }

                    function loadSavedSelection() {
                        const savedSelection = localStorage.getItem('selectedColumns#Program');
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
                        const table = document.getElementById('Program');
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import JSON Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Import JSON Data</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form id="import-form" action="{{ route('import.importDatafromfolder') }}" method="POST">
        @csrf
        <!-- Hidden field for the fixed database name -->
        <input type="hidden" name="database_name" value="heightcomparison">

        <!-- Select Table -->
        <div class="form-group">
            <label for="table_name">Select Table</label>
            <select name="table_name" id="table_name" class="form-control" required>
                <option value="">Loading tables...</option>
            </select>
            <small class="text-danger d-none" id="table-error">Failed to load tables.</small>
        </div>

        <!-- Folder Name Input -->
        <div class="form-group">
            <label for="folder_name">Enter Folder Path (e.g., C:/json-data)</label>
            <input type="text" name="folder_name" id="folder_name" class="form-control" required>
            <small class="text-danger d-none" id="folder-error">Folder path is required.</small>
        </div>
        

        <button type="submit" class="btn btn-primary">Import Data</button>
    </form>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        let tableSelect = $('#table_name');
        let tableError = $('#table-error');
        let folderInput = $('#folder_name');
        let folderError = $('#folder-error');

        // Fetch tables dynamically
        fetch("{{ url('/get-tables/heightcomparison') }}")
            .then(response => response.json())
            .then(data => {
                tableSelect.empty();
                if (data.length === 0) {
                    tableSelect.append('<option value="">No tables found</option>');
                } else {
                    tableSelect.append('<option value="">Select Table</option>');
                    data.forEach(table => {
                        tableSelect.append(`<option value="${table}">${table}</option>`);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching tables:', error);
                tableSelect.empty().append('<option value="">Error loading tables</option>');
                tableError.removeClass('d-none');
            });

        // Validate folder input
        $('#import-form').on('submit', function (e) {
            if (!folderInput.val().trim()) {
                folderError.removeClass('d-none');
                e.preventDefault();
            } else {
                folderError.addClass('d-none');
            }
        });
    });
</script>
</body>
</html>

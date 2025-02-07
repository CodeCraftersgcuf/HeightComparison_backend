<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Celebrity or Fictional Data</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 10px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .results {
            margin-top: 20px;
        }
        .result-item {
            padding: 10px;
            background-color: #f9f9f9;
            margin: 5px 0;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Search Celebrity or Fictional Data</h1>

    <input type="text" name="query" id="searchQuery" placeholder="Enter name (e.g., Johnny, Naruto)">
    <button onclick="searchData()">Search</button>

    <div class="results" id="results"></div>

    <script>
        function searchData() {
            const query = document.getElementById('searchQuery').value;
            if (!query) {
                alert("Please enter a search query.");
                return;
            }

            axios.get(`/api/search?query=${query}`)
                .then(response => {
                    const resultsContainer = document.getElementById('results');
                    resultsContainer.innerHTML = ''; // Clear previous results

                    const data = response.data;
                    console.log(data);
                    // if (data.celebrities.length === 0 && data.fictional.length === 0) {
                    //     resultsContainer.innerHTML = '<p>No results found.</p>';
                    //     return;
                    // }

                    // if (data.celebrities.length > 0) {
                    //     resultsContainer.innerHTML += '<h2>Celebrity Results:</h2>';
                    //     data.celebrities.forEach(item => {
                    //         resultsContainer.innerHTML += `<div class="result-item">Name: ${item.name}</div>`;
                    //     });
                    // }

                    // if (data.fictional.length > 0) {
                    //     resultsContainer.innerHTML += '<h2>Fictional Results:</h2>';
                    //     data.fictional.forEach(item => {
                    //         resultsContainer.innerHTML += `<div class="result-item">Name: ${item.name}</div>`;
                    //     });
                    // }
                })
                .catch(error => {
                    console.error(error);
                    alert('Error fetching search results.');
                });
        }
    </script>
</body>
</html>

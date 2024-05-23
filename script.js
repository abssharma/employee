// document.getElementById('employeeForm').addEventListener('submit', function(event) {
//     handleFormSubmit(event, '/addEmployee', 'employeeResult');
// });

// document.getElementById('trainingSessionForm').addEventListener('submit', function(event) {
//     handleFormSubmit(event, '/trainingSession', 'trainingSessionResult');
// });

// document.getElementById('roleForm').addEventListener('submit', function(event) {
//     handleFormSubmit(event, '/role', 'roleResult');
// });

// document.getElementById('countryForm').addEventListener('submit', function(event) {
//     handleFormSubmit(event, '/country', 'countryResult');
// });

// function handleFormSubmit(event, url, resultDivId) {
//     event.preventDefault();
//     const formData = new FormData(event.target);
//     const data = Object.fromEntries(formData.entries());

//     // Parse role_id, experience, and country_id as integers
//     if (data.role_id) data.role_id = parseInt(data.role_id);
//     if (data.experience) data.experience = parseInt(data.experience);
//     if (data.country_id) data.country_id = parseInt(data.country_id);

//     postData(url, data, resultDivId);
// }

// function postData(url, data, resultDivId) {
//     // Convert data object to URLSearchParams to handle x-www-form-urlencoded content type
//     const searchParams = new URLSearchParams();
//     for (const [key, value] of Object.entries(data)) {
//         searchParams.append(key, value);
//     }

//     fetch(url, {
//         method: 'POST',
//         body: searchParams,
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded'
//         },
//     })
//     .then(response => response.json())
//     .then(data => {
//         displayResult(data, resultDivId);
//     })
//     .catch((error) => {
//         console.error('Error:', error);
//         displayResult({ error: error.message }, resultDivId);
//     });
// }

// function displayResult(data, resultDivId) {
//     const resultDiv = document.getElementById(resultDivId);
//     resultDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
// }

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('employeeForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const searchParams = new URLSearchParams();

        for (const pair of formData) {
            searchParams.append(pair[0], pair[1]);
        }

        fetch('/addEmployee', {
            method: 'POST',
            body: searchParams,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});

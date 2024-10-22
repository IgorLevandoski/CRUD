document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            fetch('/crud-php/app/controllers/UserController.php', { // Atualizado para UserController
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username, password })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.token) {
                    // Armazenar o token no localStorage
                    localStorage.setItem('authToken', data.token);
                    console.log('Token saved:', data.token); // Verifica se o token foi salvo
                    alert('Login successful!');

                    // Agora, faça a requisição ao controlador protegido
                    fetchProtectedResource(data.token);
                } else {
                    alert('Login failed: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});

// Função para buscar um recurso protegido
function fetchProtectedResource(token) {
    fetch('/crud-php/app/controllers/SomeProtectedController.php', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error('Error:', error));
}

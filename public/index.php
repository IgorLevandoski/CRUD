<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/crud-php/assets/css/styles.css">
</head>
<body>
    <div id="app">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input type="text" v-model="username" placeholder="Username" required>
            <input type="password" v-model="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="/crud-php/assets/js/login.js"></script>
</body>
</html>

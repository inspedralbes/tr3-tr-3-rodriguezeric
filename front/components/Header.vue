<template>
    <header class="header">
        <div class="logo">
            <!-- Add your cinema logo here -->
            <h1>LOGO</h1>
        </div>
        <div class="actions">
            <button class="login-register-button">Login/Register</button>
        </div>
    </header>
</template>

<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f2f2f2;
}

.logo img {
    width: 100px;
    height: auto;
}

.actions button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
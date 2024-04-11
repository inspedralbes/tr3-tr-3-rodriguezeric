<template>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h2>Contacte</h2>
                <p>Adreça: Carrer del Cinema, 123</p>
                <p>Telèfon: 123-456-789</p>
                <p>Correu electrònic: info@cineblockbuster.com</p>
            </div>
            <div class="footer-section">
                <h2>Horari</h2>
                <p>Dilluns a Divendres: 10:00 - 22:00</p>
                <p>Dissabtes i Diumenges: 12:00 - 00:00</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Cine Blockbuster - Tots els drets reservats</p>
        </div>
    </footer>
</template>

<style scoped>
.footer {
    background-color: #00319c;
    color: white;
    padding: 40px 20px;
    margin-top: 200px;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.footer-section {
    margin-bottom: 20px;
}

.footer-section h2 {
    margin-bottom: 10px;
}

.social-icons {
    display: flex;
}

.social-icons a {
    color: white;
    font-size: 1.5rem;
    margin-right: 10px;
}

.footer-bottom {
    text-align: center;
    margin-top: 20px;
}
</style>

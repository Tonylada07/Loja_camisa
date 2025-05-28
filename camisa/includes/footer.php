    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Camisas de Times</h5>
                    <p class="text-muted">Sua loja especializada em camisas de times nacionais e internacionais. Produtos oficiais com a melhor qualidade e preço justo.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Links Rápidos</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="carrinho.php">Carrinho</a></li>
                        <li><a href="admin/login.php">Área Administrativa</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Categorias</h5>
                    <ul>
                        <?php foreach (array_slice($categorias_menu, 0, 4) as $cat): ?>
                        <li><a href="categoria.php?id=<?php echo $cat['id']; ?>"><?php echo $cat['nome']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Contato</h5>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Rua Exemplo, 123 - São Paulo</li>
                        <li><i class="fas fa-phone me-2"></i> (11) 1234-5678</li>
                        <li><i class="fas fa-envelope me-2"></i> contato@camisasdetimes.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Todos os direitos reservados.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

<?php
$usuarioLogado = isset($_SESSION['usuario']);
?>
<!-- Slider Hero -->
<div class="slider-hero">
    <div class="slider-container">
        <!-- Slide 1 -->
        <div class="slide active">
            <div class="slide-background" style="background-image: url('img/img-slider/1-Eua-Rouge.png');"></div>
            <div class="slide-content">
                <h1>Últimas Noticias do Motorsport</h1>
                <div class="botoes-slider">
                    <a href="../noticias.php" class="botao-slider">Explorar Notícias</a>
                </div>
                <div class="area-colaboradores">
                    <p>Deseja contribuir com nosso conteúdo?</p>
                    <div class="botoes-slider">
                        <?php if ($usuarioLogado): ?>
                            <a href="login.php" class="botao-slider">Mudar seus Dados</a>
                            <a href="escrever-noticia.php" class="botao-slider">Publique seu Artigo</a>
                        <?php else: ?>
                            <a href="login.php" class="botao-slider">Login/Criar Conta</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="slide">
            <div class="slide-background" style="background-image: url('img/img-slider/1-Piloto.png');"></div>
            <div class="slide-content">
                <h1>Modalidades em Destaque</h1>
                <div class="botoes-slider">
                    <a href="../historia.php" class="botao-slider">Descubra a História das Modalidades</a>
                </div>
                <div class="area-colaboradores">
                    <p>Junte-se à nossa equipe de colaboradores</p>
                    <div class="botoes-slider">
                        <?php if ($usuarioLogado): ?>
                            <a href="login.php" class="botao-slider">Mudar seus Dados</a>
                            <a href="escrever-noticia.php" class="botao-slider">Publique sua Análise</a>
                        <?php else: ?>
                            <a href="login.php" class="botao-slider">Login/Criar Conta</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="slide">
            <div class="slide-background" style="background-image: url('img/img-slider/1-Senna.png');"></div>
            <div class="slide-content">
                <h1>Ayrton Senna: O Legado de um Ícone</h1>
                <div class="botoes-slider">
                    <a href="senna.php" class="botao-slider">Descubra a Trajetória de Senna</a>
                </div>
                <div class="area-colaboradores">
                    <p>Compartilhe sua memória sobre Senna</p>
                    <div class="botoes-slider">
                        <?php if ($usuarioLogado): ?>
                            <a href="login.php" class="botao-slider">Mudar seus Dados</a>
                            <a href="escrever-noticia.php" class="botao-slider">Publique sua Homenagem</a>
                        <?php else: ?>
                            <a href="login.php" class="botao-slider">Login/Criar Conta</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Botões de navegação -->
    <button class="slider-nav slider-prev" onclick="changeSlide(-1)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <button class="slider-nav slider-next" onclick="changeSlide(1)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <!-- Indicadores (bolinhas) -->
    <div class="slider-indicators">
        <span class="indicator active" onclick="goToSlide(0)"></span>
        <span class="indicator" onclick="goToSlide(1)"></span>
        <span class="indicator" onclick="goToSlide(2)"></span>
    </div>
</div>

<script>
    let currentSlide      = 0;
    let slides            = [];
    let indicators        = [];
    let totalSlides       = 0;
    let autoSlideInterval;
    let sliderInitialized = false;

    function initSlider() {
        if (sliderInitialized) stopAutoSlide();

        slides      = document.querySelectorAll('.slide');
        indicators  = document.querySelectorAll('.indicator');
        totalSlides = slides.length;

        if (totalSlides === 0) return;

        currentSlide      = 0;
        sliderInitialized = true;

        showSlide(0);
        startAutoSlide();

        const sliderHero = document.querySelector('.slider-hero');
        if (sliderHero) {
            sliderHero.addEventListener('mouseenter', stopAutoSlide);
            sliderHero.addEventListener('mouseleave', startAutoSlide);

            let touchStartX = 0;
            let touchEndX   = 0;

            sliderHero.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            });
            sliderHero.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchEndX < touchStartX - 50) changeSlide(1);
                if (touchEndX > touchStartX + 50) changeSlide(-1);
            });
        }
    }

    function showSlide(index) {
        if (slides.length === 0) return;

        slides.forEach(s => s.classList.remove('active'));
        indicators.forEach(i => i.classList.remove('active'));

        if (index >= totalSlides) currentSlide = 0;
        else if (index < 0)       currentSlide = totalSlides - 1;
        else                      currentSlide = index;

        slides[currentSlide].classList.add('active');
        if (indicators[currentSlide]) indicators[currentSlide].classList.add('active');
    }

    function changeSlide(direction) {
        showSlide(currentSlide + direction);
        resetAutoSlide();
    }

    function goToSlide(index) {
        showSlide(index);
        resetAutoSlide();
    }

    function startAutoSlide() {
        if (!sliderInitialized) return;
        stopAutoSlide();
        
        // Tempo de mudança das fotos em ms (10000 = 10 segundos)
        autoSlideInterval = setInterval(() => changeSlide(1), 7000); 
    }

    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }

    function resetAutoSlide() {
        stopAutoSlide();
        startAutoSlide();
    }

    // Navegação por teclado
    document.addEventListener('keydown', e => {
        if (!sliderInitialized) return;
        if (e.key === 'ArrowLeft')  changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
    });

    // Pausar quando página fica oculta
    document.addEventListener('visibilitychange', () => {
        if (!sliderInitialized) return;
        document.hidden ? stopAutoSlide() : startAutoSlide();
    });

    // ============================================================
    // INICIALIZAÇÃO AUTOMÁTICA NO CARREGAMENTO DA PÁGINA
    // ============================================================
    document.addEventListener('DOMContentLoaded', initSlider);
</script>
<?php $this->layout('_theme', ['title' => $game->titulo ]) ?>
<?php $this->start('conteudo') ?>

<div class="pagina-jogo-container">
  
  <div class="pagina-jogo-esquerda">
    <div class="pagina-jogo-detalhes">
      <img class="jogo-imagem"
           src="<?= site() ?>/<?= $this->e($game->imagem) ?>"
           alt="<?= $this->e($game->titulo) ?>">

      <h1 class="jogo-titulo"><?= $this->e($game->titulo) ?></h1>
      <p class="jogo-descricao"><?= nl2br($this->e($game->descricao)) ?></p>

      <div class="compra">
        <h2>Comprar</h2>
        <div class="jogo-preco">R$ <?= number_format($game->preco,2,',','.') ?></div>

        
        <form id="payment-form">
          <fieldset>
            <legend>Forma de pagamento</legend>
            <label><input type="radio" name="pagamento" value="pix"> PIX</label><br>
            <label><input type="radio" name="pagamento" value="debito"> Débito</label><br>
            <label><input type="radio" name="pagamento" value="credito"> Crédito</label>
          </fieldset>
        </form>

        
        <div class="botoes-compra">
          <button id="add-cart" class="btn" data-game-id="<?= $this->e($game->id) ?>">
            Adicionar ao Carrinho
          </button>
          <button id="buy-now" class="btn">
            Comprar Agora
          </button>
        </div>
      </div>
    </div>
  </div>

  
  <div class="pagina-jogo-comentarios">
    <div class="comentarios-stardew">
      <div class="comentarios-coluna">
        <h2>Deixe seu comentário</h2>
        <form method="POST">
          <input type="hidden" name="submit_comentario" value="1">
          <label>
            Seu nome:<br>
            <input type="text" name="autor" required>
          </label><br><br>

          <label>
            Comentário:<br>
            <textarea name="mensagem" rows="4" required></textarea>
          </label><br><br>

          <label>Avaliação:</label><br>
          <div class="estrelas">
            <?php for ($i = 5; $i >= 1; $i--): ?>
              <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
              <label for="star<?= $i ?>">★</label>
            <?php endfor; ?>
          </div><br>

          <button type="submit" class="btn">Enviar Comentário</button>
        </form>
      </div>

     
      <div class="comentarios-prontos">
        <h2>Comentários</h2>
        <?php if (!empty($comments)): ?>
          <?php foreach ($comments as $c): ?>
            <div class="comentario">
              <div class="avaliacao">
                <?= str_repeat('★', (int)$c->avaliacao) . str_repeat('☆', 5 - (int)$c->avaliacao) ?>
              </div>
              <strong><?= $this->e($c->autor) ?>:</strong>
              <p><?= nl2br($this->e($c->mensagem)) ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Nenhum comentário ainda.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
  
  document.getElementById('add-cart').addEventListener('click', function(e) {
    e.preventDefault();
    <?php if (empty($_SESSION['user'])): ?>
      alert("Você precisa se logar ou se cadastrar para adicionar ao carrinho.");
      window.location = "<?= site() ?>/login";
    <?php else: ?>
      window.location = "<?= site() ?>/carrinho?add=" + this.dataset.gameId;
    <?php endif; ?>
  });

  
  document.getElementById('buy-now').addEventListener('click', function(e) {
    e.preventDefault();
    <?php if (empty($_SESSION['user'])): ?>
      alert("Você precisa se logar ou se cadastrar para comprar.");
      window.location = "<?= site() ?>/login";
    <?php else: ?>
      
      const form = document.getElementById('payment-form');
      const chosen = form.querySelector('input[name="pagamento"]:checked');
      if (!chosen) {
        alert('Selecione uma forma de pagamento antes de comprar.');
        return;
      }
      alert("Obrigado pela compra! Volte sempre.");
    <?php endif; ?>
  });
</script>

<?php $this->end() ?>

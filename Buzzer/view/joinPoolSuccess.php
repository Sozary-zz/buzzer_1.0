<div class="jumbotron">
  <div class="join-form">
    <fieldset>
      <legend>Rejoindre une salle de buzz</legend>
      <small class="text-danger" id="empty">Des champs n'ont pas été remplis.</small>
      <div class="form-group">
        <label>Nom du professeur</label>
        <input class="form-control" id="name" name="name" placeholder="Entrez le nom du professeur" type="text" required>
        <small class="text-danger" id="nope">Impossible de trouver cet utilisateur.</small>
      </div>
      <div class="form-group">
        <label>Identifiant</label>
        <input class="form-control" id="pseudo" name="pseudo" placeholder="Entrez votre identifiant" type="text" required>
        <small class="text-muted">Cet identifiant sera utilisé pour l'affichage des résultats.</small>
      </div>
      <button type="button" id="sub" class="btn btn-primary" onclick="find(this)">Rejoindre une salle</button>
    </fieldset>
  </div>
  <div class="buzz">
    <div class="loader">
      <p style="text-align:center;"> En attente de la question du professeur <span class="prof"></span>.</p>
      <div class="load">
      </div>
    </div>
    <div class="buzzer">
      <p style="text-align:center;"> À vous de jouer <span class="student"></span>!</p>
      <img src="images/buzz.jpg" class="buzz-pic" alt="buzzer" onclick="buzz()">
    </div>
    <div class="cant-buzz">
      <p style="text-align:center;"> Vous avez déjà joué, attendez la prochaine question.</p>
    </div>
    <div class="surdelay">
      <p style="text-align:center;"> Le délai est dépassé, attendez la prochaine question.</p>
    </div>
    <div class="buzzed">
      <p class="end-buzz" style="text-align:center;">Merci pour votre participation!</p>
      <img src="images/tks.jpg" class="tks-pic" width="220" height="420" alt="thanks">
    </div>
  </div>
</div>
<script src="js/pool.js">
</script>

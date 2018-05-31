<div class="jumbotron">
  <?php if(isset($_COOKIE["name"],$_COOKIE["pass"])) :?>
  <h1 class="display-3">Bienvenue <?php echo $_COOKIE["name"] ?></h1>
  <p class="lead">Vous êtes sur le point de commencer une enquête.</p>
  <p class="lead">Veuillez tout d'abord choisir la durée de l'épreuve.</p>
  <div class="form-group" id="asktime">
    <input class="form-control" id="time" placeholder="Temps de la question en minute" type="number" required>
    <small class="text-danger" id="empty">Valeur incorrect.</small>
  </div>
  <p class="lead">Posez la question à l'oral et attendez que tous les étudiants aient bien compris la question, puis cliquez sur "Commencer".</p>
  <button type="button" id="startbtn" class="btn btn-primary btn-lg btn-block" onclick="start()">Commencer</button>
  <button type="button" id="results" class="btn btn-primary btn-lg btn-block" onclick="showResults()">Voir les résultats</button>
  <button type="button" id="endResults" class="btn btn-primary btn-lg btn-block" onclick="endResults()">Recommencer une nouvelle session</button>

  <div class="result-field">
    <p style="text-align:center;" class="time-left"></p>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Nom</th>
          <th scope="col">position</th>
        </tr>
      </thead>
      <tbody id="studResult">

      </tbody>
    </table>
  </div>

  <?php else:?>
  <form>
    <fieldset>
      <legend>Espace de connection</legend>
      <small class="text-danger" id="empty">Des champs n'ont pas été remplis.</small>
      <small class="text-danger" id="nope">Mot de passe ou identifiant incorrect.</small>

      <div class="form-group">
        <label>Nom d'utilisateur</label>
        <input class="form-control" id="name" name="name" placeholder="Entrez votre nom d'utilisateur" type="text" required>
        <small class="form-text text-muted">Les étudiants pourons voir votre nom avant d'appuyer sur le buzzer.</small>
        <small class="text-danger" id="same">Un utilisateur avec le même nom existe déjà.</small>
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input class="form-control" id="pass" name="pass" placeholder="Mot de passe" type="password" required>
      </div>
      <button type="button" class="btn btn-primary" onclick="create(this)">Créer son profil</button>
      <button type="button" class="btn btn-primary" onclick="connec(this)">Connection à son profil</button>
    </fieldset>
  </form>

  <?php endif; ?>
</div>
<script src="js/create.js">
</script>
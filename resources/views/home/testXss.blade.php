<form action="/soumettre-formulaire" method="POST">
    @csrf
    <label for="message">Message:</label><br>
    <input type="text" id="message" name="message"><br>
    <input type="submit" value="Soumettre">
</form>

<!-- <form action="/soumettre-formulaire" method="POST">
    @csrf
    <label for="nom">Nom:</label><br>
    <input type="text" id="nom" name="nom"><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br>
    <label for="message">Message:</label><br>
    <textarea id="message" name="message"></textarea><br>
    <input type="submit" value="Envoyer">
</form> -->

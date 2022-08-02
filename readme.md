Mise en place architecture et développement test driven development

Pour consulter les liens : <a href="http://localhost:8000/bookmarks">Liste des liens</a>

Pouer jouer la migration
`php bin/console d:m:m`

Pour créer un marque page : 

```
curl --location --request POST 'http://localhost:8000/bookmarks' \
--form 'url="https://www.flickr.com/photos/tedementa/2087306393"'
```

Pour supprimer un marque page par l'id: 

```
curl --location --request DELETE 'http://localhost:8000/bookmarks/{id}'
```

Pour faire fonctionner les tests d'intégrations il faut executer le bash 

```bash setupIntegrationTest.sh```

Les tests d'intégrations LinkInfoProviderTest font appel aux services externes
qui ne nous appartiennent pas, il sont juste là pour aider au developpement. 
Mais ne peuvent pas etre sur a 100%   
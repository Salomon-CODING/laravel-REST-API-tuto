Hello..

## Notes 

Consommation d'une API :
- On obtient d'abord le token en communiquant avec l'api d'authentification
    // requête de connexion
    $response = Http::post($url, $credentials);
  $url : l'url pour contacter l'api
  $credentials : les infos pour login
- Ensuite on recupere le token :
    if ($response->successful()) {
        $token = $response->json()['le_token']; 
        return $token;
    }
- Après on utilise le token et une requête http en get pour communiquer avec l'api et récupérer les données dont on a besoin
    $response = Http::withToken($token)->get($url, $params);
  $token : le token 
  $url : l'url pour contacter l'api
  $params : les paramètres à envoyer si besoin 

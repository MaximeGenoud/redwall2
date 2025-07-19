<?php
// ========== BACKEND PROXY PHP ==========
if (isset($_GET['api'])) {
    // Ton token d'accès long ici (récupéré depuis Facebook Developer Console)
    $accessToken = "EAAOn4ZCZAbapcBPPUFG8JrINV1Sejo0uXiPRQBLdTaO8idIu07ljdCRUdyhjQH8opzZB1uwoyOx6aUnYpmfx4moPVSAwIhA774rDc79UZAHPqIzCPlvQgVuHi5yNOHzZCwQO97eiS7DkZAChdeWQpGKgED2N8jPgPDfL0vmMOoHrhgXj7ZBtKWPgLH3wU3U7bcZBTrjcgMcMk31tDKO7v1wycHRveWCVKfsKeQZDZD"; // remplace par ton token réel
    $instagramId = "17841475649822567"; // remplace par ton Instagram Business ID

    // Requête API Graph
    $url = "https://graph.facebook.com/v18.0/{$instagramId}/media?fields=id,media_type,media_url,caption,timestamp&access_token={$accessToken}";
    $response = file_get_contents($url);
    header('Content-Type: application/json');
    echo $response;
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>:camera_with_flash: Galerie Instagram – Redwall</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 30px;
      text-align: center;
    }
    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
    }
    .gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .post {
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 300px;
      padding: 10px;
    }
    .post img {
      width: 100%;
      border-radius: 4px;
    }
    .caption {
      margin-top: 10px;
      font-size: 0.9rem;
      color: #333;
      white-space: pre-wrap;
    }
    .timestamp {
      font-size: 0.8rem;
      color: #666;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <h1>:camera_with_flash: Galerie Instagram – Redwall</h1>
  <div id="gallery" class="gallery">Chargement...</div>

  <script>
    fetch('galerie.php?api=1')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById("gallery");
        container.innerHTML = "";

        if (!data.data || !Array.isArray(data.data)) {
          container.textContent = "Aucune image disponible ou erreur dans la réponse API.";
          return;
        }

        data.data.forEach(post => {
          if (post.media_type !== "IMAGE" && post.media_type !== "CAROUSEL_ALBUM") return;
          const div = document.createElement("div");
          div.className = "post";
          div.innerHTML = `
            <img src="${post.media_url}" alt="Image Instagram">
            <div class="caption">${post.caption || ":camera_with_flash:"}</div>
            <div class="timestamp">${new Date(post.timestamp).toLocaleString('fr-FR')}</div>
          `;
          container.appendChild(div);
        });
      })
      .catch(err => {
        console.error("Erreur :", err);
        document.getElementById("gallery").textContent = "Erreur lors du chargement.";
      });
  </script>
</body>
</html>
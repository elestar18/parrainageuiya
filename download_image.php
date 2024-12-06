<?php
if (isset($_GET['filiere']) && !empty($_GET['filiere'])) {
    include('connect.php');
    $selectedFiliere = $_GET['filiere'];

    // Récupérer les données
    $reqt = $pdo->prepare("SELECT * FROM associations WHERE filiere = :filiere");
    $reqt->bindParam(':filiere', $selectedFiliere);
    $reqt->execute();
    $allData = $reqt->fetchAll();

    $columnWidths = [50, 120, 200, 120, 180, 300, 200, 300, 150]; // Largeurs des colonnes
    $columnCount = count($columnWidths);
    $rowHeight = 40; // Hauteur d'une ligne
    $headerHeight = 50; // Hauteur de l'en-tête

    // Calculer la hauteur et la largeur totales du tableau
    $tableWidth = array_sum($columnWidths);
    $tableHeight = $headerHeight + count($allData) * $rowHeight;

    // Début du SVG
    $svgContent = '<svg width="' . ($tableWidth + 40) . '" height="' . ($tableHeight + 60) . '" xmlns="http://www.w3.org/2000/svg" style="font-family: Arial, sans-serif;">';

    // Ajout d'un fond blanc pour le tableau
    $svgContent .= '<rect x="0" y="0" width="' . ($tableWidth + 40) . '" height="' . ($tableHeight + 60) . '" fill="#f9f9f9"/>';

    // En-tête du tableau
    $header = ["#", "ID Étudiant Principal", "ID Étudiant Associé", "Filière", "Nom Étudiant Principal", "Prénom Étudiant Principal", "Nom Parrain", "Prénom Parrain", "Contact Parrain"];
    $y = 40; // Position Y initiale
    $x = 25; // Position X initiale

    // Dessiner l'en-tête avec un style amélioré
    for ($i = 0; $i < $columnCount; $i++) {
        $svgContent .= '<rect x="' . $x . '" y="' . $y . '" width="' . $columnWidths[$i] . '" height="' . $headerHeight . '" fill="#0073e6" stroke="black" stroke-width="1"/>';
        $svgContent .= '<text x="' . ($x + 10) . '" y="' . ($y + 30) . '" font-size="14" fill="#ffffff" font-weight="bold">' . htmlspecialchars($header[$i]) . '</text>';
        $x += $columnWidths[$i];
    }
    $y += $headerHeight; // Passer sous l'en-tête

    // Fonction pour wrapper le texte
    function wrapText($text, $width, $fontSize) {
        $chars = floor($width / ($fontSize * 0.6)); // Estimation approximative du nombre de caractères
        if (strlen($text) > $chars) {
            return wordwrap($text, $chars, "\n", true);
        }
        return $text;
    }

    // Modifier la partie qui gère l'affichage des données
    $rowCount = 1;
    foreach ($allData as $data) {
        $x = 25;
        $rowData = [
            $rowCount++, 
            $data['id_etudiant_principal'], 
            $data['id_etudiant_associe'], 
            $data['filiere'], 
            $data['nom_etudiant_principal'], 
            $data['prenom_etudiant_principal'], 
            $data['nom_parrain'], 
            $data['prenom_parrain'], 
            $data['contact_parrain']
        ];

        $fillColor = $rowCount % 2 == 0 ? "#f2f2f2" : "#ffffff";
        $maxLineHeight = $rowHeight;

        // Premier passage pour calculer la hauteur maximale nécessaire
        for ($i = 0; $i < $columnCount; $i++) {
            $wrappedText = wrapText($rowData[$i], $columnWidths[$i] - 20, 12);
            $lines = substr_count($wrappedText, "\n") + 1;
            $lineHeight = max($rowHeight, $lines * 20); // 20 pixels par ligne
            $maxLineHeight = max($maxLineHeight, $lineHeight);
        }

        // Dessiner la ligne avec la nouvelle hauteur
        for ($i = 0; $i < $columnCount; $i++) {
            $wrappedText = wrapText($rowData[$i], $columnWidths[$i] - 20, 12);
            $svgContent .= '<rect x="' . $x . '" y="' . $y . '" width="' . $columnWidths[$i] . 
                          '" height="' . $maxLineHeight . '" fill="' . $fillColor . '" stroke="black" stroke-width="0.5"/>';
            
            // Afficher le texte ligne par ligne
            $lines = explode("\n", $wrappedText);
            foreach ($lines as $index => $line) {
                $lineY = $y + 20 + ($index * 20); // 20 pixels par ligne
                $svgContent .= '<text x="' . ($x + 10) . '" y="' . $lineY . 
                              '" font-size="12" fill="#000000">' . htmlspecialchars($line) . '</text>';
            }
            $x += $columnWidths[$i];
        }
        $y += $maxLineHeight; // Utiliser la hauteur maximale pour la ligne suivante
    }

    $svgContent .= '</svg>'; // Fermer le SVG

    // Envoyer le fichier SVG au navigateur
    header('Content-Type: image/svg+xml');
    header('Content-Disposition: attachment; filename="tableau_filiere_' . $selectedFiliere . '.svg"');

    echo $svgContent;
    exit();
}
?>

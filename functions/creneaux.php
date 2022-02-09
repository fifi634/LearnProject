<?php
    //CRENEAUX D'OUVERTURE
  function creneaux_html(array $creneaux):string {
    if(empty($creneaux)) {
      return 'fermé';
    }
    $phrase = []; 
    foreach ($creneaux as $creneau) {
      $phrase[] = "de {$creneau[0]}h à {$creneau[1]}h";
      $horaire = implode(' et ', $phrase);
    }
    return $horaire;
  } 

  function in_creneaux(int $heure, array $creneaux): bool {
    foreach ($creneaux as $creneau) {
      $debut = $creneau[0];
      $fin = $creneau[1];
      if ($heure >= $debut && $heure < $fin) {
        return true;
      }
    }
    return false;
  }

  function select(string $name, $value, array $option): string {
    $html_option = [];
    foreach ($option as $k => $option) {
      $attributes = $k == $value ? 'selected' : '';
      $html_option[] = "<option value='$k' $attributes>$option</option>";
    }
    return "<select class='form-control' name='$name'>".implode($html_option).'</select>';
  }
?>
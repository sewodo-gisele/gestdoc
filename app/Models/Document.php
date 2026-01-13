<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model {
    use HasFactory;

    protected $fillable = ['titre', 'chemin_fichier', 'statut', 'user_id', 'categorie_id', 'commentaire_rejet'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categorie() {
    return $this->belongsTo(Categorie::class, 'categorie_id')->withDefault([
        'nom' => 'Non classé' // Valeur affichée si l'ID est nul
    ]);
    }


    public function archives() {
        return $this->hasMany(Archive::class, 'document_id');
    }
}
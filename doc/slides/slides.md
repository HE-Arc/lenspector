---
title: Lenspector
author: Julien M'Poy, Sylvain Ramseyer & Axel Roy
date: 2016
---

### Sommaire

* Introduction
* Première version
* Démonstration
* Nouvelle version

<div class="notes">
    * Entreprise cliente
    * Musée des horreurs
    * Avantages de l'utilisation de Laravel
</div>

---

### Lenspector

* Application web de gestion de stock simple
* Projet web de deuxième année (PHP)
* Développé pour
[Swiss Advanced Vision IntraOcular Lens](http://www.sav-iol.com/) (SAV-IOL), une
startup locale

<div class="notes">
    * SAV-IOL produit des lentilles intraoculaires soignant la cataracte.
</div>

---

### Processus en bref

* Production de la lentille.
* Entrée dans la base de données.
* Entrée en stock (QR code scanner).
* Ouverture d'une commande.
* Sortie du stock puis envoi de la lentille.

<div class="notes">
    * Caractéristiques de la lentille mesurées par une machine puis entrées
    dans la base de données.
    * Chaque lentille a un QR Code contenant pleins d'informations -> seul
    le numéro de série nous est utile.
</div>

---

### Utilisateurs

* Infrastructure Manager
* Sales Manager

<div class="notes">
    * Gère les stocks (envois, retours, entrées).
    * Gères les commandes (réception des demandes, ouverture des commandes).
</div>

---

### Fonctionnalités

* Entréres/sorties des stocks (interne, consignation et ventes)
* Gestion des coordonnées des clients
* Gestion des commandes (ouvertures, complétion, envoi)

<div class="notes">
    * SAV-IOL est content et l'utilise actuellement.
    * Demande de nouvelles fonctionnalités.
        * Compliqué car le code est compliqué à maintenir.
</div>

---

![](http://ljdchost.com/xIkajiS.gif)

<!-- ![](http://ljdchost.com/18dVGUi.gif) -->

---

### Musée des horreurs ou... partir du pire

```php
echo 'Attention, danger!';
```

<div class="notes">
    * Mélange du code métier et de la vue.
    * On a tenté de limiter la casse en mettant la logique métier en-haut
    des scripts.
</div>

---

![](http://ljdchost.com/Lyb8RZa.gif)

---

### ... Pour aller vers le merveilleux

```php
echo "C'est quand qu'on arrive?";
```

---

### Démonstration

* [Version de démonstration](lenspector.srvz-webapp.he-arc.ch)

---

### Nouvelle version

* Code maintenable
* Principe modèle-vue-contrôleur
* URLs as UI (slugs)
* Charte graphique personnalisée
* Accessibilité améliorée
* ![Master branch StyleCI status](https://styleci.io/repos/69327879/shield?style=flat&branch=master)

<div class="notes">
    * Nouvelles fonctionnalités implémentables plus facilement.
    * Meilleure séparation des responsabilités.
    * Meilleures expérience utilisateur.
</div>

---

## Questions?

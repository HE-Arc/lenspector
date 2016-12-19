---
title: Lenspector
author: Julien M'Poy, Sylvain Ramseyer & Axel Roy
date: 2016
---

### Sommaire

* Introduction
* Transition "fait main" - MVC
* Démonstration
* Dépendances, bibliothèques utilisées
* Conclusion

<div class="notes">
    * Entreprise cliente
    * Musée des horreurs
    * Avantages de l'utilisation de Laravel
</div>

---

### Lenspector

* Développé pour
[Swiss Advanced Vision IntraOcular Lens](http://www.sav-iol.com/) (SAV-IOL), une
startup locale
* Aucune idée de l'état des stocks
* Application web de gestion de stock simple (Projet web de deuxième année (PHP))


<div class="notes">
    * SAV-IOL produit des lentilles intraoculaires soignant la cataracte.
</div>

---

### Processus en bref

* Production de la lentille intraoculaires.
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

* Entrées/sorties des stocks (interne, consignation et ventes)
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

### Vues : Code spaghetti VS Twig

```php
$product_type = "";
 foreach ($products as $product_row) {
  if ($product_row['name'] != $product_type) {
?>
            </tbody>
            </table>
            <?php $product_type =  $product_row['name']; ?>
            <h1><?php echo htmlEscape($product_type); ?></h1>
            <p>
                <b>Quantity: </b><?php echo htmlEscape($count_by_product_type[$product_type]); ?> unit(s)
            </p>
            <table class="table-bordered table table-striped">
                <thead>
                    <tr>
                        <?php foreach (array_values($views['general']) as $table_header) { ?>
                            <th>
                                <?php  echo htmlEscape($table_header); ?>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
            <tbody>
<?php
        }
?>
```

<div class="notes">
    * Mélange du code métier et de la vue.
    * On a tenté de limiter la casse en mettant la logique métier en-haut
    des scripts.
    * Imaginez à quoi ressemble la validation avec des if à rallonge
</div>

---

### Vues : Code spaghetti VS Twig

```php
<tr>
    <td>
        <?php echo htmlEscape($product_row['name']); ?>
    </td>
    <td>
        <a href="<?php echo $base_url .
            '&diopter=' .
            urlencode($product_row['sphCorrected']) .
            '&productId=' .
            urlencode($product_row['name']); ?>">
            <?php echo htmlEscape(format_float($product_row['sphCorrected'])); ?>
        </a>
    </td>
    <td>
        <?php  echo htmlEscape($product_row['count']); ?>
    </td>
</tr>
<?php
}
?>
</tbody>
</table>
```

<div class="notes">
    * détection de changement de produit avec un if...
    * htmlEscape = htmlspecialchar
</div>

---

### Vues : Code spaghetti VS Twig

```php
{% extends "base.twig" %}
{% block body %}
    <h1>{{ inventoryStatus.name | capitalize }} inventory</h1>
    {% for t in types %}
        {% set type = t[0] %}
        <h2>
            {{ type.name }} <span class="badge">
            {{ type.product_count }}</span>
        </h2>
        <table class ="table table-striped" >
        <tr>
            <th>Diopter</th> <th>Count</th>
        </tr>
        {% for p in t.products %}
            <tr>
                <td>{{ p.SphCorrected }}</td> <td>{{ p.total }}</td>
            </tr>
        {% endfor %}
        </table>
    {% endfor %}
{{ products.links() | raw }}
{% endblock %}
```

<div class="notes">
    * Echappement automatique
    * On va chercher les type de produits
    * On affiche les produits qui leur sont rattachés.
</div>

---

### Requêtes via PDO en SQL VS ORM

#### PDO

```sql
"SELECT  product.name, sphCorrected,  count(*) AS count
    FROM lense
    LEFT JOIN product
    ON lense.productId = product.id
    WHERE lense.status IN (?, ?)
    AND lense.exclude = 0
    AND sphCorrected >= ? AND sphCorrected <= ?
    GROUP BY product.name, SphCorrected"
```

#### ORM

```php
$products = Product::where('status', $inventoryStatus->id)
    ->select(DB::raw('*, count(*) as total'))
    ->groupBy('productId', 'sphCorrected')
    ->orderBy('productId', 'sphCorrected')
    ->get();
```

<div class="notes">
    * Ici c'est juste la requête
    * Try - catch nombreux dans la première version => réglé dans Laravel
      avec l'explicit route model binding
</div>

---

### URL avec ? VS URL as UI & routes

* [http://1516-appweb.localhost/show_inventory.php?stock=internal&diopter=5.00&productId=InFo](http://1516-appweb.localhost/show_inventory.php?stock=internal&diopter=5.00&productId=InFo)
* [http://lenspector.localhost/product/on-hands/info/5.5](http://lenspector.localhost/product/on-hands/1/5.5)

<div class="notes">
    * Affichage d'un type de produit spécifique et d'une dioptrie dans un stock
</div>

---

### Démonstration

* [Version de démonstration](lenspector.srvz-webapp.he-arc.ch)

---

### Liste des dépendances

* [rcrowe/twigbridge](https://github.com/rcrowe/TwigBridge)
* [cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable)
* [fzaninotto/faker](https://github.com/fzaninotto/Faker)
* [webpatser/laravel-countries](https://github.com/webpatser/laravel-countries)
* [barryvdh/laravel-cors](https://github.com/barryvdh/laravel-cors)
* [typeahead.js et bloodhound-js](https://github.com/twitter/typeahead.js)

<div class="notes">
    * twig: templating, vues
    * sluggable: rendre les modèles sluggable
    * faker: génération des données de test
    * countries: migration pour les pays avec nom ISO-xxx
    * cors: résoudre les problèmes de Cross-Origin Resource Sharing
    * typeahead et bloodhound: suggestions, autocomplétion
</div>

---

<!-- ![](http://ljdchost.com/Lyb8RZa.gif) -->

### Avantages d'un Framework

* Code maintenable
* Principe modèle-vue-contrôleur
* Echappements
* Migrations
* URLs as UI (slugs)
* Charte graphique personnalisée
* Accessibilité améliorée
* ![Master branch StyleCI status](https://styleci.io/repos/69327879/shield?style=flat&branch=master)

<div class="notes">
    * Nouvelles fonctionnalités implémentables plus facilement. grâce à l'explicit
      route model binding, sluggable, getRouteKeyName
    * Meilleure séparation des responsabilités.
    * Avantages de migrations (avant: nombreux scripts numérotés),
        gestion de la DB facilitée
    * Meilleures expérience utilisateur.
</div>

---

## Questions?

<style>
.sourceCode {
    font-size: 80%;
    line-height: 80%;
    margin: 0 auto;
    overflow: hidden;
}
li p {
    margin: 5px
}
</style>

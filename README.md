# spicy-mash
Classe de cryptage et décryptage simplifiée se basant sur OpenSSL

# Installation

```
  composer require fzed51/spicy-mash
```

# Utilisation

```php
<?php
$mash = new \Helper\SpicyMash();
$mashed = $mash->crypt('message', 'spicy');
echo $mash->decrypt($mashed, 'spicy'); // message
```

```php
<?php
$mash = new \Helper\SpicyMash('spicy');
$mashed = $mash->crypt('message', 'more spicy');
echo $mash->decrypt($mashed, 'more spicy'); // message
```

```php
<?php
$mash = new \Helper\SpicyMash('spicy');
$mashed = $mash->crypt('message');
echo $mash->decrypt($mashed); // message
```

en cas d'abscence de clé (principale et spécifique) une exception est levée.

en cas de problème de décryptage une exception est levée

NeilimeCryptBundle
================

##Description

Ce bundle permet la gestion de crypter et décrypter des données sensibles

## Installation

### 1. Recuperation du code source :
récuperer le code source dans le repertoire {packages/} comme ceci :
```
/packages
    /neilime
        /neilime-crypt
            /Neilime
                /Bundle
                    /CryptBundle
```

### 2. Ajout des lignes suivantes dans le composer.json :
```
// composer.json
{
    require: {
        ...
        ""neilime/neilime-crypt": "@dev"
    },
    "repositories": [
        ...
        {
            "type": "path",
            "url": "packages/neilime/neilime-crypt/Neilime/Bundle/CryptBundle",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

### 3. Inclure le bundle dans votre appKernel.php :
```
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Neilime\Bundle\CryptBundle\NeilimeCryptBundle(),
    // ...
);
```

### 3. Ajout du routing dans le routing.yml :
pas de routing pour ce Bundle
### 4. Configuration
Décrypte automatiquement les elements du fichier config.yml si besoin (voir prefix)
```
//config.yml

neilime:
    crypt:
        enabled: false
```

## Fonctionnement

### 1. Creation d'un service crypter

Exemple crypter AES :

## Client
Le client doit implementer l'interface [ClientInterface](Neilime\Bundle\CryptBundle\Client\ClientInterface.php)
avec 2 methodes :
- crypt
- decrypt
```
  neilime.crypt.client_aes:
    class: Neilime\Bundle\CryptBundle\Client\Aes
    arguments: ['%crypter_key%', '%crypter_iv%']
```
## Crypter
Le client doit implementer l'interface [CrypterInterface](Neilime\Bundle\CryptBundle\Crypter\CrypterInterface.php)
####Paramètres :
- 1 : le nom du crypter 
- 2 : le prefix des elements compatibles pour le décryptage
- 3 : le client (voir precedement)

Ex: 

La valeur '***aes***:aBigHashAES==' sera décryptée automatiquement

La valeur 'myPoorPassword' ne sera pas décryptée

###tag :
Le crypter doit être taggué avec ***neilime.crypt.crypter*** pour etre utilisé automatiquement.

Exemple:
```
  neilime.crypt.crypter_aes:
    class: Neilime\Bundle\CryptBundle\Crypt\Crypter
    arguments: ['aes', 'aes:', '@neilime.crypt.client_aes']
    tags:
      - { name: neilime.crypt.crypter}
```

## Commandes

### neilime:crypt
La commande ***neilime:crypt*** permet de crypter ou décrypter des valeurs

Les options sont décrites directement [ici](Command/CryptCommand.php).

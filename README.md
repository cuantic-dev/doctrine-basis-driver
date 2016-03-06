# doctrine-basis-driver #

# Using the basis dbal interface #

# Higly unstable alpha version, be aware! #

### Include the bundle in your composer.json file ###

```
{
	...
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.org:mauroak/doctrine-basis-driver.git"
        },
    ],
    "require": {
        "cuantic/doctrine-basis-driver": "dev-master",
    }
    ...
}
```

### Create the appropiate EntityManager ###

```
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$isSimpleMode = false;
$config = Setup::createAnnotationMetadataConfiguration(
                array(__DIR__."/../src/models"),
                $isDevMode,
                $proxyDir,
                $cache,
                $isSimpleMode
            );

// basis configuration parameters
$conn = array(
    'driverClass' => '\Cuantic\DBAL\BasisDriver',
    'driverOptions' => [
            'username'     => 'xxxxx',
            'password'     => 'xxxxx',
            'host'         => 'xxx.xxx.xxx'
            'database'     => 'xyz'
        ]
);

$entityManager = EntityManager::create($conn, $config);
```

### Declaring entities ###

So far, we only support the ```@Id``` sequence == ```@None```.
This is an example of an entity mapped to the Basis:

```
/**
 * @ORM\Entity
 * @ORM\Table(name="ZOC")
 */
class PurchaseOrder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint", name="NROOC")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @ORM\Column(type="integer", name="CDGOPROV")
     */
    public $zipCode;

    /**
     * @ORM\Column(type="smallint", name="CONDCOMPRA")
     */
    public $paymentTerm;

    /**
     * @ORM\Column(type="string", name="EMITIDOPOR")
     */
    public $user;

    /**
     * @ORM\Column(type="date", name="FECHAENTREGA")
     */
    public $deliveryDate;

    /**
     * @ORM\Column(type="date", name="FECHAPEDIDO")
     */
    public $orderDate;

    /**
     * @ORM\Column(type="string", name="LUGARENTREGA")
     */
    public $deliveryLocation;
}
```

# Developing the basis interface #

### Clone the project ###

```
#!bash

$ git clone git@github.com:mauroak/doctrine-basis-driver.git
```

### Install phpunit globally ###

```
#!bash

$ composer global require "phpunit/phpunit=4.7.*"
$ pico ~/.bash_profile
# Add this line at the end of the file and save it
export PATH=$PATH:/home/vagrant/.composer/vendor/bin
```
### Run the tests ###

```
#!bash

$ vendor/bin/phpunit
```

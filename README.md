# Workstation
(Cloned from @juanwilde github)

This repository contains the basic configuration for a complete local environment for Symfony projects

### Content:
- NGINX 1.19 container to handle HTTP requests
- PHP 8.1.1 container to host your Symfony application
- MySQL 8.0 container to store databases

(feel free to update any version in `Dockerfiles` and ports in `docker-compose.yml`)

### Installation:
- Run `make build` to create all containers
- Enter the PHP container with `make ssh-be`
- Install your favourite Symfony version with `composer create-project symfony/skeleton project [version (e.g. 5.2.*)]`
- Move the content to the root folder with `mv project/* . && mv project/.env .`. This is necessary since Composer won't install the project if the folder already contains data.
- Copy the content from `project/.gitignore` and paste it in the root's folder `.gitignore`
- Remove `project` folder (not needed anymore)
- Navigate to `localhost:1000` so you can see the Symfony welcome page :)

Happy coding!

### For testing
- Insert phpunit testing with composer 'composer require --dev phpunit/phpunit symfony/test-pack'
- Run `sf d:m:m -n --env=test` to apply migrations on test enviroment

If .pem has access problems: 'chmod 644 public.pem private.pem'

#### To php cs-fixer
to install:
    
    composer require --dev friendsofphp/php-cs-fixer
to exec:

    vendor/bin/php-cs-fixer fix src

### SQL Try
https://stackoverflow.com/questions/68380201/booking-system-using-query-builder-and-symfony

```
$subQueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select('prop.id')
            ->from('App:Reservation', 'reservation')
            ->orWhere('reservation.startDate BETWEEN :checkInDate AND :checkOutDate')
            ->orWhere('reservation.endDate BETWEEN :checkInDate AND :checkOutDate')
            ->orWhere('reservation.startDate <= :checkInDate AND reservation.endDate >= :checkOutDate')
            ->andWhere('reservation.confirmedAt IS NOT NULL')
            ->andWhere('reservation.rating IS NULL')
            ->innerJoin('reservation.property', 'prop')
        ;
        
  $properties = $this->createQueryBuilder('p')
        ->select('p')
        ->andWhere('p.approved = 1')
        ->andWhere($properties->expr()->notIn('p.id',  $subQuery->getDQL()))
        ->andWhere('reservations.confirmedAt IS NOT NULL')
        ->andWhere('reservations.rating IS NULL')
        ->setParameter('checkInDate', new \DateTime($checkIn))
        ->setParameter('checkOutDate', new \DateTime($checkOut))
        ->innerJoin('p.reservations', 'reservations')
        ->getQuery();
```


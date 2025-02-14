
## Webinterface en CLI-applicatie

In dit project heb ik zowel een **CLI-applicatie** als een **webinterface** ontwikkeld voor het berekenen van de maximale hypotheek op basis van inkomen of woningwaarde. Beide versies bieden dezelfde functionaliteit, maar de webinterface biedt een meer gebruiksvriendelijke ervaring voor eindgebruikers die geen ervaring hebben met commandline.

### Voordelen:
- **CLI**: Voor snelle tests of als je liever werkt via CLI.
- **Webinterface**: Een grafische interface waarmee gebruikers eenvoudig hun gegevens kunnen invoeren en direct resultaten krijgen.

## CLI
Om een berekening te maken dien je het volgende commando te gebruiken:

    mortgage:calculate-by {type} {value}  


Er kan een parameter per berekening worden gebruikt per type. De keuze voor {type} bestaat uit: "value" of "income"  , bijvoorbeeld

    mortgage:calculate-by income 500000  

Het resultaat zal worden geprint in je CLI.

## Webinterface

De webinterface is gebouwd met behulp van **Laravel** en **Blade templates**. De gebruiker kan de hypotheekcalculator gebruiken door het invullen van twee velden:
1. **Inkomen**
2. **Woningwaarde**

Na het invullen van deze velden kan de gebruiker op de knop 'Bereken Hypotheek' klikken, waarna de maximale hypotheek wordt berekend op basis van de API-aanroepen.

### Componenten:
- **Formulier**: Het formulier bevat invoervelden voor het inkomen en de woningwaarde. Zodra de gebruiker een van deze velden invoert, worden ze naar een route gestuurd die de gegevens verwerkt. Er kan maar een van beide velden gebruikt worden.
- **Resultatenpagina**: Na het berekenen van de hypotheek wordt de gebruiker naar een andere pagina gestuurd waar de maximale hypotheek wordt weergegeven, gebaseerd op hun invoer.

## API-aanroepen

De maximale hypotheek wordt berekend door gebruik te maken van een van de volgende API-endpoints:
- **calculation/v1/mortgage/maximum-by-income**
- **calculation/v1/mortgage/maximum-by-value**

De applicatie stuurt de volgende parameters naar de API:
- **Inkomen**: Het jaarinkomen van de gebruiker wordt berekend aan de hand van een percentage van 1.501%.
- **Woningwaarde**: De waarde van het huis waarvoor de hypotheek wordt berekend.

Een voorbeeld van de API-aanroep:

    $response = $this->apiClient->getMaximumMortgageByIncome($income);  


## Installatie en Gebruik

Welke manier van installatie je ook kiest, zorg ervoor dat de .env variabelen zijn toegevoegd voor de correcte configuratie. De waardes kan je via mij ontvangen.

De waardes die je in je .env moet aanpassen (dit bestand vind je in de root van je project):


    MORTGAGE_API_URL=  
    MORTGAGE_API_KEY=


### Installatie (Laravel)
Clone de repository naar je lokale machine.

    git clone https://github.com/rvelumos/mortgage-calculator.git  

Installeer vereiste pakketten:

    composer install   

Start de Laravel server:

    php artisan serve  

4.  De app is nu bereikbaar via http://localhost:8000/

### Installatie (Docker)

Wil je graag wat meer flexibiliteit, dan kan je kiezen voor een Docker installatie.

### Vereisten
[Docker Desktop](https://www.docker.com/products/docker-desktop) installeren

Clone de repository

    git clone [https://github.com/rvelumos/mortgage-calculator.git](https://github.com/rvelumos/mortgage-calculator.git)

Navigeer naar de root van het project

Start de containers met build

    docker-compose up --build -d

De app is nu bereikbaar via http://localhost:9000

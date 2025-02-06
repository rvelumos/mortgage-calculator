## Webinterface en CLI-applicatie

In dit project heb ik zowel een **CLI-applicatie** als een **webinterface** ontwikkeld voor het berekenen van de maximale hypotheek op basis van inkomen en woningwaarde. Beide versies bieden dezelfde functionaliteit, maar de webinterface biedt een meer gebruiksvriendelijke ervaring voor eindgebruikers die geen ervaring hebben met commandline.

### Voordelen:
- **CLI**: Voor snelle tests of als je liever werkt via CLI.
- **Webinterface**: Een grafische interface waarmee gebruikers eenvoudig hun gegevens kunnen invoeren en direct resultaten krijgen.

## CLI
Om een berekening te maken dien je het volgende commando te gebruiken:
    ```bash
    mortgage:calculate {income} {propertyValue}

Er kan een parameter per berekening worden gebruikt. Gebruik voor een ongebruikte parameter '0', bijvoorbeeld
    ```bash
    mortgage:calculate 0 500000

## Webinterface

De webinterface is gebouwd met behulp van **Laravel** en **Blade templates**. De gebruiker kan de hypotheekcalculator gebruiken door het invullen van twee velden:
1. **Inkomen**
2. **Woningwaarde**

Na het invullen van deze velden kan de gebruiker op de knop 'Bereken Hypotheek' klikken, waarna de maximale hypotheek wordt berekend op basis van de API-aanroepen.

### Componenten:
- **Formulier**: Het formulier bevat invoervelden voor het inkomen en de woningwaarde. Zodra de gebruiker deze invoert, worden ze naar een route gestuurd die de gegevens verwerkt.
- **Resultatenpagina**: Na het berekenen van de hypotheek wordt de gebruiker naar een andere pagina gestuurd waar de maximale hypotheek wordt weergegeven, gebaseerd op hun invoer.

## API-aanroepen

De maximale hypotheek wordt berekend door gebruik te maken van de volgende API-eindpunten:
- **calculation/v1/mortgage/maximum-by-income**
- **calculation/v1/mortgage/maximum-by-value**

De applicatie stuurt de volgende parameters naar de API:
- **Inkomen**: Het maandinkomen van de gebruiker.
- **Woningwaarde**: De waarde van het huis waarvoor de hypotheek wordt berekend.

Een voorbeeld van de API-aanroep:

$response = $this->apiClient->getMaximumMortgageByIncome($income);

## Installatie en Gebruik

### Installatie
1. Clone de repository naar je lokale machine.
   ```bash
   git clone https://github.com/rvelumos/mortgage-calculator.git
   
2. Installeer vereiste pakketten:
    ```bash
    composer install  

3. Start de Laravel server:
    ````bash
   php artisan serve



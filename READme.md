# REST API uvecklat med PHP

Detta api är kopplat till en mysql databas som innehåller en tabell
med uppgifter om de kurser som ungår i Webbutveckling 120 hp.
Det ligger en htaccess-fil som är inställd så att filändelsen inte behöver skrivas 
in i URL:en.

## Funktionaliet
Det är möjligt att hämta, posta, uppdatera och radera data via api:et. 

### GET - Hämta
Antingen kan du hämta alla data, du anger enbart addressen http://localhost/REST_Api/index
och väljer http-metoden GET, för att få fram alla kurser som en JSON-fil.

Du kan också hämta en specifik kurs, ange då id i adressfältet på följande sätt:
exempel: http://localhost/REST_Api/index.php?id=1002

### POST - Skapa ny kurs
Skicka in en JSON-sträng med data över ny kurs som du vill lägga till.
Enligt följande format:
{"Course_name":"Typografi och form för webb", "Code":"GD008G", "Progression": "A", "Course_syllabus": "https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=24399"}
Alla delar måste var med. Felkontroller görs.

### PUT - Uppdatera
Uppdatera data genom att skicka in en JSON-sträng. Course_ID behöver skickas med. 
All data behövs medskickas vid uppdatering.
Exempel:
{"Course_ID": "1003", "Course_name":"Typografi och form för webb", "Code":"GD008G", "Progression": "A", "Course_syllabus": "https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=24399"}

### DELETE - Radera kurs
Skicka in kurs-id nummret i en JSON-sträng för att radera kurs ur databasen. 
Exempel: { "Course_ID": "1008" }

## Background

Repository you see contains an MVP for creating, answering and reporting simple surveys.

## Business rules

* each survey has to have unique name
* initially survey is not live, to be able to answer, survey needs to go live
* every answer has one likert question about quality, which is required
* choosing Poor or Very Poor (-1 or -2) makes comment required as an explanation of choice
* only survey which didn't go live can be edited
* live survey can not be deleted
* once survey is closed, nobody can answer it
* a report is generated as soon as the survey is closed
* email with the information about generated report is being sent to the address provided during survey creation

## Skills in the following aspects were shown

* CQS/CQRS
* SOLID
* Clean Code
* Framework-agnostic
* REST principles
* Tests

## Development environment

Prerequisites:
* docker
* docker compose

To prepare your development environment you need to run these commands:
```
docker compose up -d
docker compose exec php-fpm composer install
docker compose exec php-fpm bin/console doctrine:migrations:migrate -n
```

Other commands:
```
docker compose exec php-fpm	bin/console messenger:setup-transport
docker compose exec php-fpm	bin/console messenger:consume async_events -v
docker compose exec php-fpm bin/console messenger:consume async_commands -v

docker compose exec php-fpm	./vendor/bin/phpunit
```

Application will be available under `http://localhost`, MailCatcher under `http://localhost:81`.

## Existing endpoints

List all surveys:
```
curl -X GET --location "http://localhost/survey" \
    -H "Accept: application/json"
```

Create new survey:
```
curl -X POST --location "http://localhost/survey" \
    -H "Content-Type: application/json" \
    -d "{
            \"name\": \"survey name\",
            \"reportEmail\": \"test@example.com\"
        }"
```

Edit survey:
```
curl -X PUT --location "http://localhost/survey/{surveyId}" \
    -H "Content-Type: application/json" \
    -d "{
            \"name\": \"new name\",
            \"reportEmail\": \"test2@example.com\"
        }"
```

Delete survey:
```
curl -X DELETE --location "http://localhost/survey/{surveyId}" \
    -H "Content-Type: application/json"
```

Send survey live:
```
curl -X PUT --location "http://localhost/survey/{surveyId}/open" \
    -H "Content-Type: application/json" 
```

Close survey:
```
curl -X PUT --location "http://localhost/survey/{surveyId}/close" \
    -H "Content-Type: application/json"
```

Add neutral/positive answer:
```
curl -X POST --location "http://localhost/survey/{surveyId}/answer" \
    -H "Content-Type: application/json" \
    -d "{
            \"quality\": 0,
            \"comment\": null
        }"
```

Add negative answer:
```
curl -X POST --location "http://localhost/survey/{surveyId}/answer" \
    -H "Content-Type: application/json" \
    -d "{
            \"quality\": -2,
            \"comment\": "quality was very poor"
        }"
```

Show report:
```
curl -X GET --location "http://localhost/report/{reportId}" \
    -H "Accept: application/json"
```

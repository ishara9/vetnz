# VetNZ based on PHP 8.5

 Vet project is a NZ Clinic for animals.

## VetApp API

### Base URL

```
http://localhost:8000/api
```

---

### Patient Endpoints

#### Get All Patients
```
GET /api/patients
```

#### Get Patient by ID
```
GET /api/patients/{id}
```

#### Create Patient
```
POST /api/patients
```

Request Body (JSON):
```json
{
  "name": "Lucky",
  "species": "Dog",
  "breed": "Persian",
  "owner_name": "Emma"
}
```

#### Update Patient (Full Update)
```
PUT /api/patients/{id}
```

#### Patch Patient (Partial Update)
```
PATCH /api/patients/{id}
```

#### Delete Patient
```
DELETE /api/patients/{id}
```

#### Get Medical Records for a Patient
```
GET /api/patients/{id}/medical-records
```

---

### Medical Record Endpoints

#### Get All Medical Records
```
GET /api/medical-records
```

#### Get Medical Record by ID
```
GET /api/medical-records/{id}
```

#### Create Medical Record
```
POST /api/medical-records
```

Request Body (JSON):
```json
{
  "patient_id": 1,
  "visit_date": "2026-02-25",
  "diagnosis": "Fever",
  "treatment": "Antibiotics"
}
```

#### Update Medical Record (Full Update)
```
PUT /api/medical-records/{id}
```

#### Patch Medical Record (Partial Update)
```
PATCH /api/medical-records/{id}
```

#### Delete Medical Record
```
DELETE /api/medical-records/{id}
```

## Run project using

    php -S localhost:8000 -t public

## Run Test using

    .\vendor\bin\phpunit tests

## Architecture

    Controller -> Service -> Repository -> Database


## Dependencies
- Production ready style dependency included
- Used Slim for proper routing and middleware
- Added dependency injection with

## Dependencies install with following

    composer require slim/slim

    composer require slim/psr7

    composer require php-di/php-di

## Debugging guide

- Install PHP Debug extention in VSCode
- configure .vscode/launch.json with Xdebug
- install Xdebug from https://xdebug.org/wizard

### Add `php.ini` following config under [opcache]
    
    zend_extension="C:\path\to\xdebug.dll"
    xdebug.mode=debug
    xdebug.start_with_request=yes
    xdebug.client_port=9003 

- Now run vscode debug mode with `Run-> Start Debugging (F5)`
- Start Server normally `php -S localhost:8000 -t public`
- Add breakpoints and debug
